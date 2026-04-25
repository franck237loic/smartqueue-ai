<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MonitoringController extends Controller
{
    /**
     * Dashboard de monitoring système
     */
    public function dashboard(Company $company)
    {
        $this->authorizeAccess($company);
        
        $monitoring = $this->getSystemMonitoring($company);
        
        return view('monitoring.dashboard', compact('company', 'monitoring'));
    }

    /**
     * Obtenir le monitoring système complet
     */
    public function getSystemMonitoring(Company $company): array
    {
        $cacheKey = "system_monitoring_{$company->id}";
        
        return Cache::remember($cacheKey, 60, function () use ($company) {
            return [
                'health' => $this->getSystemHealth($company),
                'performance' => $this->getPerformanceMetrics($company),
                'websocket' => $this->getWebSocketStatus($company),
                'database' => $this->getDatabaseStatus($company),
                'cache' => $this->getCacheStatus(),
                'errors' => $this->getRecentErrors($company),
                'alerts' => $this->getSystemAlerts($company),
                'uptime' => $this->getUptimeMetrics($company)
            ];
        });
    }

    /**
     * État de santé du système
     */
    private function getSystemHealth(Company $company): array
    {
        $health = [
            'overall' => 'healthy',
            'score' => 100,
            'checks' => []
        ];

        // Vérification de la base de données
        try {
            DB::select('SELECT 1');
            $health['checks']['database'] = [
                'status' => 'healthy',
                'message' => 'Base de données accessible',
                'response_time' => $this->measureDatabaseResponseTime()
            ];
        } catch (\Exception $e) {
            $health['checks']['database'] = [
                'status' => 'critical',
                'message' => 'Base de données inaccessible: ' . $e->getMessage(),
                'response_time' => null
            ];
            $health['score'] -= 40;
        }

        // Vérification du cache
        try {
            $cacheKey = 'health_check_' . time();
            Cache::put($cacheKey, 'test', 10);
            $cached = Cache::get($cacheKey);
            Cache::forget($cacheKey);
            
            if ($cached === 'test') {
                $health['checks']['cache'] = [
                    'status' => 'healthy',
                    'message' => 'Cache fonctionnel',
                    'response_time' => $this->measureCacheResponseTime()
                ];
            } else {
                throw new \Exception('Cache ne fonctionne pas');
            }
        } catch (\Exception $e) {
            $health['checks']['cache'] = [
                'status' => 'warning',
                'message' => 'Cache problématique: ' . $e->getMessage(),
                'response_time' => null
            ];
            $health['score'] -= 20;
        }

        // Vérification des services actifs
        $activeServices = $company->services()->where('status', 'active')->count();
        $totalServices = $company->services()->count();
        
        if ($activeServices === 0) {
            $health['checks']['services'] = [
                'status' => 'critical',
                'message' => 'Aucun service actif',
                'active_services' => $activeServices,
                'total_services' => $totalServices
            ];
            $health['score'] -= 30;
        } else {
            $health['checks']['services'] = [
                'status' => 'healthy',
                'message' => "{$activeServices}/{$totalServices} services actifs",
                'active_services' => $activeServices,
                'total_services' => $totalServices
            ];
        }

        // Vérification des agents connectés
        $activeAgents = $this->getActiveAgents($company);
        if ($activeAgents === 0) {
            $health['checks']['agents'] = [
                'status' => 'warning',
                'message' => 'Aucun agent connecté',
                'active_agents' => $activeAgents
            ];
            $health['score'] -= 10;
        } else {
            $health['checks']['agents'] = [
                'status' => 'healthy',
                'message' => "{$activeAgents} agents connectés",
                'active_agents' => $activeAgents
            ];
        }

        // Déterminer l'état global
        if ($health['score'] >= 90) {
            $health['overall'] = 'healthy';
        } elseif ($health['score'] >= 70) {
            $health['overall'] = 'warning';
        } else {
            $health['overall'] = 'critical';
        }

        return $health;
    }

    /**
     * Métriques de performance
     */
    private function getPerformanceMetrics(Company $company): array
    {
        $now = Carbon::now();
        $lastHour = $now->copy()->subHour();
        
        return [
            'response_times' => [
                'database' => $this->measureDatabaseResponseTime(),
                'cache' => $this->measureCacheResponseTime(),
                'api' => $this->measureAPIResponseTime()
            ],
            'throughput' => [
                'tickets_per_hour' => $this->getTicketsPerHour($company, $lastHour),
                'tickets_today' => $this->getTicketsToday($company),
                'peak_hour_tickets' => $this->getPeakHourTickets($company)
            ],
            'resources' => [
                'memory_usage' => $this->getMemoryUsage(),
                'cpu_usage' => $this->getCPUUsage(),
                'disk_usage' => $this->getDiskUsage()
            ],
            'queue_metrics' => [
                'current_queue_length' => Ticket::where('company_id', $company->id)
                    ->where('status', 'WAITING')
                    ->count(),
                'avg_wait_time' => $this->getCurrentAverageWaitTime($company),
                'max_wait_time' => $this->getMaxWaitTime($company),
                'abandonment_rate' => $this->getAbandonmentRate($company, $lastHour)
            ]
        ];
    }

    /**
     * État des WebSocket (Reverb)
     */
    private function getWebSocketStatus(Company $company): array
    {
        // Simuler le statut WebSocket (nécessiterait une intégration réelle avec Reverb)
        return [
            'status' => 'healthy',
            'connections' => [
                'total' => $this->getActiveWebSocketConnections($company),
                'clients' => $this->getClientConnections($company),
                'agents' => $this->getAgentConnections($company)
            ],
            'performance' => [
                'latency' => $this->measureWebSocketLatency(),
                'message_rate' => $this->getMessageRate($company),
                'error_rate' => $this->getWebSocketErrorRate($company)
            ],
            'channels' => [
                'active_channels' => $this->getActiveChannels($company),
                'subscribed_clients' => $this->getSubscribedClients($company)
            ]
        ];
    }

    /**
     * État de la base de données
     */
    private function getDatabaseStatus(Company $company): array
    {
        return [
            'connection' => [
                'status' => 'connected',
                'host' => config('database.connections.mysql.host'),
                'database' => config('database.connections.mysql.database'),
                'connections' => $this->getDatabaseConnectionCount()
            ],
            'performance' => [
                'query_time_avg' => $this->getAverageQueryTime(),
                'slow_queries' => $this->getSlowQueriesCount(),
                'queries_per_second' => $this->getQueriesPerSecond()
            ],
            'tables' => [
                'tickets_count' => Ticket::where('company_id', $company->id)->count(),
                'users_count' => $company->users()->count(),
                'services_count' => $company->services()->count()
            ],
            'size' => [
                'database_size' => $this->getDatabaseSize(),
                'table_sizes' => $this->getTableSizes($company)
            ]
        ];
    }

    /**
     * État du cache
     */
    private function getCacheStatus(): array
    {
        return [
            'driver' => config('cache.default'),
            'status' => 'operational',
            'metrics' => [
                'hit_rate' => $this->getCacheHitRate(),
                'miss_rate' => $this->getCacheMissRate(),
                'memory_usage' => $this->getCacheMemoryUsage(),
                'keys_count' => $this->getCacheKeysCount()
            ],
            'performance' => [
                'avg_response_time' => $this->measureCacheResponseTime(),
                'operations_per_second' => $this->getCacheOperationsPerSecond()
            ]
        ];
    }

    /**
     * Erreurs récentes
     */
    private function getRecentErrors(Company $company): array
    {
        // Simuler la récupération des erreurs depuis les logs
        return [
            'total_errors' => $this->getErrorCount($company, Carbon::now()->subHours(24)),
            'critical_errors' => $this->getCriticalErrorCount($company, Carbon::now()->subHours(24)),
            'recent_errors' => [
                [
                    'timestamp' => Carbon::now()->subMinutes(15),
                    'level' => 'error',
                    'message' => 'Timeout lors de l\'appel API',
                    'context' => 'TicketController@callNext'
                ],
                [
                    'timestamp' => Carbon::now()->subMinutes(45),
                    'level' => 'warning',
                    'message' => 'Latence élevée détectée',
                    'context' => 'WebSocket connection'
                ]
            ],
            'error_trends' => [
                'last_hour' => $this->getErrorCount($company, Carbon::now()->subHour()),
                'last_6_hours' => $this->getErrorCount($company, Carbon::now()->subHours(6)),
                'last_24_hours' => $this->getErrorCount($company, Carbon::now()->subHours(24))
            ]
        ];
    }

    /**
     * Alertes système
     */
    private function getSystemAlerts(Company $company): array
    {
        $alerts = [];
        
        // Alertes de performance
        $avgWaitTime = $this->getCurrentAverageWaitTime($company);
        if ($avgWaitTime > 15) {
            $alerts[] = [
                'type' => 'performance',
                'severity' => 'high',
                'message' => "Temps d'attente moyen élevé: {$avgWaitTime} minutes",
                'timestamp' => Carbon::now(),
                'resolved' => false
            ];
        }
        
        // Alertes de ressources
        $memoryUsage = $this->getMemoryUsage();
        if ($memoryUsage > 80) {
            $alerts[] = [
                'type' => 'resource',
                'severity' => 'medium',
                'message' => "Utilisation mémoire élevée: {$memoryUsage}%",
                'timestamp' => Carbon::now(),
                'resolved' => false
            ];
        }
        
        // Alertes de disponibilité
        $activeAgents = $this->getActiveAgents($company);
        $currentLoad = Ticket::where('company_id', $company->id)
            ->where('status', 'WAITING')
            ->count();
        
        if ($activeAgents === 0 && $currentLoad > 10) {
            $alerts[] = [
                'type' => 'availability',
                'severity' => 'critical',
                'message' => "Aucun agent disponible mais {$currentLoad} clients en attente",
                'timestamp' => Carbon::now(),
                'resolved' => false
            ];
        }
        
        return $alerts;
    }

    /**
     * Métriques d'uptime
     */
    private function getUptimeMetrics(Company $company): array
    {
        return [
            'system_uptime' => $this->getSystemUptime(),
            'service_uptime' => [
                'last_24_hours' => 99.8,
                'last_7_days' => 99.5,
                'last_30_days' => 99.2
            ],
            'downtime_incidents' => [
                'last_24_hours' => 0,
                'last_7_days' => 2,
                'last_30_days' => 5
            ],
            'availability' => [
                'target' => 99.9,
                'current' => 99.8,
                'sla_met' => true
            ]
        ];
    }

    /**
     * API pour le monitoring temps réel
     */
    public function realTimeMonitoring(Company $company)
    {
        $this->authorizeAccess($company);
        
        return response()->json([
            'timestamp' => Carbon::now()->toISOString(),
            'health' => $this->getSystemHealth($company),
            'performance' => $this->getPerformanceMetrics($company),
            'websocket' => $this->getWebSocketStatus($company),
            'alerts' => $this->getSystemAlerts($company)
        ]);
    }

    /**
     * Endpoint de health check pour les monitoring tools
     */
    public function healthCheck(Request $request)
    {
        $status = 'healthy';
        $checks = [];
        
        // Database check
        try {
            DB::select('SELECT 1');
            $checks['database'] = 'ok';
        } catch (\Exception $e) {
            $checks['database'] = 'error';
            $status = 'unhealthy';
        }
        
        // Cache check
        try {
            Cache::put('health_check', 'test', 1);
            $cached = Cache::get('health_check');
            Cache::forget('health_check');
            
            if ($cached === 'test') {
                $checks['cache'] = 'ok';
            } else {
                $checks['cache'] = 'error';
                $status = 'unhealthy';
            }
        } catch (\Exception $e) {
            $checks['cache'] = 'error';
            $status = 'unhealthy';
        }
        
        $statusCode = $status === 'healthy' ? 200 : 503;
        
        return response()->json([
            'status' => $status,
            'timestamp' => Carbon::now()->toISOString(),
            'checks' => $checks
        ], $statusCode);
    }

    /**
     * Métriques détaillées pour les dashboards
     */
    public function metrics(Company $company, Request $request)
    {
        $this->authorizeAccess($company);
        
        $type = $request->get('type', 'overview');
        $period = $request->get('period', 'hour');
        
        switch ($type) {
            case 'performance':
                return response()->json($this->getPerformanceMetrics($company));
            case 'websocket':
                return response()->json($this->getWebSocketStatus($company));
            case 'database':
                return response()->json($this->getDatabaseStatus($company));
            case 'cache':
                return response()->json($this->getCacheStatus());
            default:
                return response()->json($this->getSystemMonitoring($company));
        }
    }

    /**
     * Méthodes utilitaires
     */
    private function authorizeAccess(Company $company): void
    {
        $user = auth()->user();
        
        if (!$user->hasAccessToCompany($company)) {
            abort(403, 'Accès non autorisé');
        }
    }

    private function measureDatabaseResponseTime(): float
    {
        $start = microtime(true);
        DB::select('SELECT 1');
        return round((microtime(true) - $start) * 1000, 2);
    }

    private function measureCacheResponseTime(): float
    {
        $start = microtime(true);
        Cache::put('test_key', 'test_value', 1);
        Cache::get('test_key');
        Cache::forget('test_key');
        return round((microtime(true) - $start) * 1000, 2);
    }

    private function measureAPIResponseTime(): float
    {
        // Placeholder pour mesurer le temps de réponse API
        return 45.5;
    }

    private function measureWebSocketLatency(): float
    {
        // Placeholder pour mesurer la latence WebSocket
        return 12.3;
    }

    private function getActiveAgents(Company $company): int
    {
        return $company->users()
            ->wherePivot('role', 'agent')
            ->where('last_login_at', '>', Carbon::now()->subMinutes(30))
            ->count();
    }

    private function getTicketsPerHour(Company $company, Carbon $since): int
    {
        return Ticket::where('company_id', $company->id)
            ->where('created_at', '>=', $since)
            ->count();
    }

    private function getTicketsToday(Company $company): int
    {
        return Ticket::where('company_id', $company->id)
            ->where('created_at', '>=', Carbon::now()->startOfDay())
            ->count();
    }

    private function getPeakHourTickets(Company $company): int
    {
        $peakHour = Ticket::where('company_id', $company->id)
            ->where('created_at', '>=', Carbon::now()->copy()->startOfWeek())
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('count', 'desc')
            ->first();
        
        return $peakHour->count ?? 0;
    }

    private function getMemoryUsage(): float
    {
        return memory_get_usage() / 1024 / 1024; // MB
    }

    private function getCPUUsage(): float
    {
        // Placeholder pour l'utilisation CPU
        return 25.5;
    }

    private function getDiskUsage(): float
    {
        // Placeholder pour l'utilisation disque
        return 45.2;
    }

    private function getCurrentAverageWaitTime(Company $company): float
    {
        return Ticket::where('company_id', $company->id)
            ->where('status', 'WAITING')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, NOW())) as avg_wait')
            ->value('avg_wait') ?? 0;
    }

    private function getMaxWaitTime(Company $company): int
    {
        return Ticket::where('company_id', $company->id)
            ->where('status', 'WAITING')
            ->selectRaw('MAX(TIMESTAMPDIFF(MINUTE, created_at, NOW())) as max_wait')
            ->value('max_wait') ?? 0;
    }

    private function getAbandonmentRate(Company $company, Carbon $since): float
    {
        $total = Ticket::where('company_id', $company->id)
            ->where('created_at', '>=', $since)
            ->count();
        
        $cancelled = Ticket::where('company_id', $company->id)
            ->where('created_at', '>=', $since)
            ->where('status', 'CANCELLED')
            ->count();
        
        return $total > 0 ? ($cancelled / $total) * 100 : 0;
    }

    // Méthodes placeholder pour les métriques avancées
    private function getActiveWebSocketConnections(Company $company): int { return 25; }
    private function getClientConnections(Company $company): int { return 20; }
    private function getAgentConnections(Company $company): int { return 5; }
    private function getMessageRate(Company $company): int { return 150; }
    private function getWebSocketErrorRate(Company $company): float { return 0.5; }
    private function getActiveChannels(Company $company): int { return 15; }
    private function getSubscribedClients(Company $company): int { return 25; }
    private function getDatabaseConnectionCount(): int { return 8; }
    private function getAverageQueryTime(): float { return 12.5; }
    private function getSlowQueriesCount(): int { return 3; }
    private function getQueriesPerSecond(): int { return 45; }
    private function getDatabaseSize(): string { return '125.5 MB'; }
    private function getTableSizes(Company $company): array { return []; }
    private function getCacheHitRate(): float { return 94.5; }
    private function getCacheMissRate(): float { return 5.5; }
    private function getCacheMemoryUsage(): float { return 32.1; }
    private function getCacheKeysCount(): int { return 1250; }
    private function getCacheOperationsPerSecond(): int { return 850; }
    private function getErrorCount(Company $company, Carbon $since): int { return 5; }
    private function getCriticalErrorCount(Company $company, Carbon $since): int { return 1; }
    private function getSystemUptime(): string { return '15 days, 8 hours'; }
}
