<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Service;
use App\Models\User;
use App\Models\Ticket;
use App\Services\WaitTimePredictor;
use App\Services\LoadAnalyzer;
use App\Services\PerformanceScorer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    protected $waitTimePredictor;
    protected $loadAnalyzer;
    protected $performanceScorer;

    public function __construct(
        WaitTimePredictor $waitTimePredictor,
        LoadAnalyzer $loadAnalyzer,
        PerformanceScorer $performanceScorer
    ) {
        $this->waitTimePredictor = $waitTimePredictor;
        $this->loadAnalyzer = $loadAnalyzer;
        $this->performanceScorer = $performanceScorer;
    }

    /**
     * Dashboard principal des analytics
     */
    public function dashboard(Company $company)
    {
        $this->authorizeAccess($company);
        
        $analytics = $this->getComprehensiveAnalytics($company);
        
        return view('analytics.dashboard', compact('company', 'analytics'));
    }

    /**
     * Obtenir les analytics complètes
     */
    public function getComprehensiveAnalytics(Company $company): array
    {
        $cacheKey = "analytics_comprehensive_{$company->id}";
        
        return Cache::remember($cacheKey, 300, function () use ($company) {
            return [
                'overview' => $this->getOverviewMetrics($company),
                'predictions' => $this->waitTimePredictor->getAllServicesPredictions($company),
                'load_analysis' => $this->loadAnalyzer->analyzeCurrentLoad($company),
                'performance' => $this->getPerformanceMetrics($company),
                'trends' => $this->getTrendsData($company),
                'alerts' => $this->getActiveAlerts($company),
                'recommendations' => $this->getSystemRecommendations($company)
            ];
        });
    }

    /**
     * Métriques d'overview
     */
    private function getOverviewMetrics(Company $company): array
    {
        $now = Carbon::now();
        $today = $now->copy()->startOfDay();
        
        return [
            'today' => [
                'tickets_created' => Ticket::where('company_id', $company->id)
                    ->where('created_at', '>=', $today)
                    ->count(),
                'tickets_served' => Ticket::where('company_id', $company->id)
                    ->where('status', 'SERVED')
                    ->where('served_at', '>=', $today)
                    ->count(),
                'avg_wait_time' => $this->getAverageWaitTime($company, $today),
                'current_queue' => Ticket::where('company_id', $company->id)
                    ->where('status', 'WAITING')
                    ->count(),
                'active_agents' => $this->getActiveAgents($company),
                'satisfaction_rate' => $this->getSatisfactionRate($company, $today)
            ],
            'week' => [
                'tickets_created' => Ticket::where('company_id', $company->id)
                    ->where('created_at', '>=', $now->copy()->startOfWeek())
                    ->count(),
                'tickets_served' => Ticket::where('company_id', $company->id)
                    ->where('status', 'SERVED')
                    ->where('served_at', '>=', $now->copy()->startOfWeek())
                    ->count(),
                'avg_wait_time' => $this->getAverageWaitTime($company, $now->copy()->startOfWeek()),
                'peak_hour' => $this->getPeakHour($company),
                'busiest_service' => $this->getBusiestService($company, $now->copy()->startOfWeek())
            ],
            'month' => [
                'tickets_created' => Ticket::where('company_id', $company->id)
                    ->where('created_at', '>=', $now->copy()->startOfMonth())
                    ->count(),
                'tickets_served' => Ticket::where('company_id', $company->id)
                    ->where('status', 'SERVED')
                    ->where('served_at', '>=', $now->copy()->startOfMonth())
                    ->count(),
                'avg_wait_time' => $this->getAverageWaitTime($company, $now->copy()->startOfMonth()),
                'growth_rate' => $this->getGrowthRate($company),
                'efficiency_rate' => $this->getEfficiencyRate($company)
            ]
        ];
    }

    /**
     * Métriques de performance
     */
    private function getPerformanceMetrics(Company $company): array
    {
        $companyScore = $this->performanceScorer->calculateCompanyScore($company);
        
        $agents = $company->users()
            ->wherePivot('role', 'agent')
            ->get();
        
        $agentScores = [];
        foreach ($agents as $agent) {
            $agentScores[$agent->id] = $this->performanceScorer->calculateAgentScore($agent, $company);
        }
        
        $services = $company->services()->where('status', 'active')->get();
        $serviceScores = [];
        foreach ($services as $service) {
            $serviceScores[$service->id] = $this->performanceScorer->calculateServiceScore($service, $company);
        }
        
        return [
            'company' => $companyScore,
            'agents' => $agentScores,
            'services' => $serviceScores,
            'top_performers' => $this->getTopPerformers($agentScores),
            'areas_improvement' => $this->getAreasImprovement($serviceScores)
        ];
    }

    /**
     * Données de tendances
     */
    private function getTrendsData(Company $company): array
    {
        $now = Carbon::now();
        
        return [
            'daily' => $this->getDailyTrends($company, 30),
            'hourly' => $this->getHourlyTrends($company, 7),
            'weekly' => $this->getWeeklyTrends($company, 12),
            'monthly' => $this->getMonthlyTrends($company, 12),
            'predictions' => $this->getTrendPredictions($company)
        ];
    }

    /**
     * Alertes actives
     */
    private function getActiveAlerts(Company $company): array
    {
        $alerts = [];
        
        // Alertes de temps d'attente
        $longWaitTickets = Ticket::where('company_id', $company->id)
            ->where('status', 'WAITING')
            ->where('created_at', '<', Carbon::now()->subMinutes(30))
            ->count();
        
        if ($longWaitTickets > 5) {
            $alerts[] = [
                'type' => 'high_wait_time',
                'severity' => 'high',
                'message' => "{$longWaitTickets} clients attendent depuis plus de 30 minutes",
                'timestamp' => Carbon::now(),
                'action_required' => true
            ];
        }
        
        // Alertes de charge
        $currentLoad = Ticket::where('company_id', $company->id)
            ->where('status', 'WAITING')
            ->count();
        
        if ($currentLoad > 50) {
            $alerts[] = [
                'type' => 'critical_load',
                'severity' => 'critical',
                'message' => "Charge critique: {$currentLoad} clients en attente",
                'timestamp' => Carbon::now(),
                'action_required' => true
            ];
        }
        
        // Alertes de performance
        $companyScore = $this->performanceScorer->calculateCompanyScore($company);
        if ($companyScore['overall_score'] < 70) {
            $alerts[] = [
                'type' => 'performance_decline',
                'severity' => 'medium',
                'message' => "Performance en baisse: {$companyScore['overall_score']}/100",
                'timestamp' => Carbon::now(),
                'action_required' => false
            ];
        }
        
        return $alerts;
    }

    /**
     * Recommandations système
     */
    private function getSystemRecommendations(Company $company): array
    {
        $recommendations = [];
        
        $loadAnalysis = $this->loadAnalyzer->analyzeCurrentLoad($company);
        $companyScore = $this->performanceScorer->calculateCompanyScore($company);
        
        // Recommandations basées sur la charge
        foreach ($loadAnalysis['recommendations'] as $recommendation) {
            $recommendations[] = [
                'category' => 'operations',
                'priority' => $recommendation['priority'],
                'action' => $recommendation['action'],
                'description' => $recommendation['message'],
                'impact' => $recommendation['estimated_impact'] ?? 'Non spécifié'
            ];
        }
        
        // Recommandations basées sur la performance
        foreach ($companyScore['recommendations'] as $recommendation) {
            $recommendations[] = [
                'category' => 'performance',
                'priority' => 'medium',
                'action' => 'improve_performance',
                'description' => $recommendation,
                'impact' => 'Amélioration de la qualité de service'
            ];
        }
        
        return $recommendations;
    }

    /**
     * API pour les données temps réel
     */
    public function realTimeData(Company $company)
    {
        $this->authorizeAccess($company);
        
        return response()->json([
            'timestamp' => Carbon::now()->toISOString(),
            'metrics' => [
                'waiting_tickets' => Ticket::where('company_id', $company->id)
                    ->where('status', 'WAITING')
                    ->count(),
                'called_tickets' => Ticket::where('company_id', $company->id)
                    ->where('status', 'CALLED')
                    ->count(),
                'serving_tickets' => Ticket::where('company_id', $company->id)
                    ->where('status', 'SERVING')
                    ->count(),
                'active_agents' => $this->getActiveAgents($company),
                'avg_wait_time' => $this->getCurrentAverageWaitTime($company)
            ],
            'predictions' => $this->waitTimePredictor->getAllServicesPredictions($company),
            'alerts' => $this->getActiveAlerts($company)
        ]);
    }

    /**
     * Export des rapports
     */
    public function exportReport(Company $company, Request $request)
    {
        $this->authorizeAccess($company);
        
        $type = $request->get('type', 'overview');
        $format = $request->get('format', 'csv');
        $period = $request->get('period', 'month');
        
        $data = $this->getExportData($company, $type, $period);
        
        switch ($format) {
            case 'csv':
                return $this->exportCSV($data, $type);
            case 'pdf':
                return $this->exportPDF($data, $type);
            case 'excel':
                return $this->exportExcel($data, $type);
            default:
                return response()->json(['error' => 'Format non supporté'], 400);
        }
    }

    /**
     * Widget pour dashboard
     */
    public function widget(Company $company, Request $request)
    {
        $this->authorizeAccess($company);
        
        $widgetType = $request->get('type', 'overview');
        
        switch ($widgetType) {
            case 'wait_times':
                return response()->json($this->getWaitTimeWidget($company));
            case 'performance':
                return response()->json($this->getPerformanceWidget($company));
            case 'load':
                return response()->json($this->getLoadWidget($company));
            case 'trends':
                return response()->json($this->getTrendsWidget($company));
            default:
                return response()->json($this->getOverviewWidget($company));
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

    private function getAverageWaitTime(Company $company, Carbon $since): float
    {
        return Ticket::where('company_id', $company->id)
            ->where('status', 'SERVED')
            ->where('served_at', '>=', $since)
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, called_at, served_at)) as avg_wait')
            ->value('avg_wait') ?? 0;
    }

    private function getCurrentAverageWaitTime(Company $company): float
    {
        return Ticket::where('company_id', $company->id)
            ->where('status', 'WAITING')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, NOW())) as avg_wait')
            ->value('avg_wait') ?? 0;
    }

    private function getActiveAgents(Company $company): int
    {
        return $company->users()
            ->wherePivot('role', 'agent')
            ->where('last_login_at', '>', Carbon::now()->subMinutes(30))
            ->count();
    }

    private function getSatisfactionRate(Company $company, Carbon $since): float
    {
        // Placeholder - nécessiterait des données de satisfaction réelles
        return 85.5;
    }

    private function getPeakHour(Company $company): int
    {
        $peakHour = Ticket::where('company_id', $company->id)
            ->where('created_at', '>=', Carbon::now()->copy()->startOfWeek())
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as count')
            ->groupBy('hour')
            ->orderBy('count', 'desc')
            ->value('hour');
        
        return $peakHour ?? 10;
    }

    private function getBusiestService(Company $company, Carbon $since): array
    {
        $service = Ticket::where('company_id', $company->id)
            ->where('created_at', '>=', $since)
            ->with('service')
            ->selectRaw('service_id, COUNT(*) as count')
            ->groupBy('service_id')
            ->orderBy('count', 'desc')
            ->first();
        
        return [
            'name' => $service->service->name ?? 'N/A',
            'tickets' => $service->count ?? 0
        ];
    }

    private function getGrowthRate(Company $company): float
    {
        $currentMonth = Ticket::where('company_id', $company->id)
            ->where('created_at', '>=', Carbon::now()->copy()->startOfMonth())
            ->count();
        
        $lastMonth = Ticket::where('company_id', $company->id)
            ->whereBetween('created_at', [
                Carbon::now()->copy()->subMonth()->startOfMonth(),
                Carbon::now()->copy()->subMonth()->endOfMonth()
            ])
            ->count();
        
        if ($lastMonth === 0) return 0;
        
        return (($currentMonth - $lastMonth) / $lastMonth) * 100;
    }

    private function getEfficiencyRate(Company $company): float
    {
        $served = Ticket::where('company_id', $company->id)
            ->where('status', 'SERVED')
            ->where('created_at', '>=', Carbon::now()->copy()->startOfMonth())
            ->count();
        
        $total = Ticket::where('company_id', $company->id)
            ->where('created_at', '>=', Carbon::now()->copy()->startOfMonth())
            ->count();
        
        if ($total === 0) return 0;
        
        return ($served / $total) * 100;
    }

    private function getTopPerformers(array $agentScores): array
    {
        $sorted = collect($agentScores)
            ->sortByDesc('overall_score')
            ->take(5)
            ->values();
        
        return $sorted->toArray();
    }

    private function getAreasImprovement(array $serviceScores): array
    {
        return collect($serviceScores)
            ->filter(function ($score) {
                return $score['overall_score'] < 70;
            })
            ->sortBy('overall_score')
            ->values()
            ->toArray();
    }

    private function getDailyTrends(Company $company, int $days): array
    {
        // Implémentation pour les tendances quotidiennes
        return [];
    }

    private function getHourlyTrends(Company $company, int $days): array
    {
        // Implémentation pour les tendances horaires
        return [];
    }

    private function getWeeklyTrends(Company $company, int $weeks): array
    {
        // Implémentation pour les tendances hebdomadaires
        return [];
    }

    private function getMonthlyTrends(Company $company, int $months): array
    {
        // Implémentation pour les tendances mensuelles
        return [];
    }

    private function getTrendPredictions(Company $company): array
    {
        // Implémentation pour les prédictions de tendances
        return [];
    }

    private function getExportData(Company $company, string $type, string $period): array
    {
        // Implémentation pour l'export de données
        return [];
    }

    private function exportCSV(array $data, string $type)
    {
        // Implémentation pour l'export CSV
        return response()->download('export.csv');
    }

    private function exportPDF(array $data, string $type)
    {
        // Implémentation pour l'export PDF
        return response()->download('export.pdf');
    }

    private function exportExcel(array $data, string $type)
    {
        // Implémentation pour l'export Excel
        return response()->download('export.xlsx');
    }

    private function getWaitTimeWidget(Company $company): array
    {
        return $this->waitTimePredictor->getAllServicesPredictions($company);
    }

    private function getPerformanceWidget(Company $company): array
    {
        return $this->performanceScorer->calculateCompanyScore($company);
    }

    private function getLoadWidget(Company $company): array
    {
        return $this->loadAnalyzer->analyzeCurrentLoad($company);
    }

    private function getTrendsWidget(Company $company): array
    {
        return $this->getTrendsData($company);
    }

    private function getOverviewWidget(Company $company): array
    {
        return $this->getOverviewMetrics($company);
    }
}
