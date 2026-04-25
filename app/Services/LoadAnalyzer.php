<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\Service;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LoadAnalyzer
{
    /**
     * Analyser la charge actuelle et historique
     */
    public function analyzeCurrentLoad(Company $company): array
    {
        $cacheKey = "current_load_{$company->id}";
        
        return Cache::remember($cacheKey, 60, function () use ($company) {
            $now = Carbon::now();
            
            return [
                'real_time' => $this->getRealTimeMetrics($company),
                'hourly' => $this->getHourlyMetrics($company, $now),
                'daily' => $this->getDailyMetrics($company, $now),
                'trends' => $this->getTrends($company),
                'alerts' => $this->generateAlerts($company),
                'recommendations' => $this->generateRecommendations($company)
            ];
        });
    }
    
    /**
     * Métriques en temps réel
     */
    private function getRealTimeMetrics(Company $company): array
    {
        $activeTickets = Ticket::where('company_id', $company->id)
            ->where('status', 'WAITING')
            ->with(['service', 'counter'])
            ->get();
        
        $calledTickets = Ticket::where('company_id', $company->id)
            ->where('status', 'CALLED')
            ->with(['service', 'counter'])
            ->get();
        
        $servingTickets = Ticket::where('company_id', $company->id)
            ->where('status', 'SERVING')
            ->with(['agent', 'service'])
            ->get();
        
        return [
            'waiting' => [
                'count' => $activeTickets->count(),
                'by_service' => $activeTickets->groupBy('service_id')->map->count(),
                'avg_wait_time' => $this->calculateAverageWaitTime($activeTickets),
                'longest_wait' => $this->getLongestWait($activeTickets)
            ],
            'called' => [
                'count' => $calledTickets->count(),
                'by_counter' => $calledTickets->groupBy('counter_id')->map->count(),
                'avg_call_duration' => $this->getAverageCallDuration($calledTickets)
            ],
            'serving' => [
                'count' => $servingTickets->count(),
                'by_agent' => $servingTickets->groupBy('agent_id')->map->count(),
                'avg_service_duration' => $this->getAverageServiceDuration($servingTickets)
            ],
            'agents' => [
                'online' => $this->getOnlineAgents($company),
                'busy' => $this->getBusyAgents($company),
                'available' => $this->getAvailableAgents($company)
            ]
        ];
    }
    
    /**
     * Métriques horaires
     */
    private function getHourlyMetrics(Company $company, Carbon $now): array
    {
        $currentHour = $now->hour;
        $hourlyData = [];
        
        // Données des 24 dernières heures
        for ($i = 0; $i < 24; $i++) {
            $hour = $currentHour - $i;
            $hourTimestamp = $now->copy()->subHours($i);
            
            $tickets = Ticket::where('company_id', $company->id)
                ->whereBetween('created_at', [
                    $hourTimestamp->copy()->startOfHour(),
                    $hourTimestamp->copy()->endOfHour()
                ])
                ->get();
            
            $hourlyData[$hour] = [
                'created' => $tickets->count(),
                'served' => $tickets->where('status', 'SERVED')->count(),
                'cancelled' => $tickets->where('status', 'CANCELLED')->count(),
                'avg_wait_time' => $this->calculateAverageWaitTime($tickets),
                'peak_hour' => $this->isPeakHour($hour)
            ];
        }
        
        return $hourlyData;
    }
    
    /**
     * Métriques quotidiennes
     */
    private function getDailyMetrics(Company $company, Carbon $now): array
    {
        $dailyData = [];
        
        // Données des 30 derniers jours
        for ($i = 0; $i < 30; $i++) {
            $day = $now->copy()->subDays($i);
            
            $tickets = Ticket::where('company_id', $company->id)
                ->whereBetween('created_at', [
                    $day->copy()->startOfDay(),
                    $day->copy()->endOfDay()
                ])
                ->get();
            
            $dailyData[$day->format('Y-m-d')] = [
                'date' => $day->format('d/m/Y'),
                'day_of_week' => $day->format('l'),
                'created' => $tickets->count(),
                'served' => $tickets->where('status', 'SERVED')->count(),
                'cancelled' => $tickets->where('status', 'CANCELLED')->count(),
                'avg_wait_time' => $this->calculateAverageWaitTime($tickets),
                'peak_hours' => $this->getPeakHoursForDay($company, $day),
                'service_distribution' => $tickets->groupBy('service_id')->map->count()
            ];
        }
        
        return $dailyData;
    }
    
    /**
     * Analyser les tendances
     */
    private function getTrends(Company $company): array
    {
        $now = Carbon::now();
        $trends = [];
        
        // Tendance sur 7 jours
        $weekData = Ticket::where('company_id', $company->id)
            ->whereBetween('created_at', [$now->copy()->subDays(7), $now])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->orderBy('date')
            ->get();
        
        $trends['weekly'] = [
            'direction' => $this->calculateTrendDirection($weekData),
            'percentage' => $this->calculateTrendPercentage($weekData),
            'prediction' => $this->predictNextWeek($weekData)
        ];
        
        // Tendance sur 30 jours
        $monthData = Ticket::where('company_id', $company->id)
            ->whereBetween('created_at', [$now->copy()->subDays(30), $now])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->orderBy('date')
            ->get();
        
        $trends['monthly'] = [
            'direction' => $this->calculateTrendDirection($monthData),
            'percentage' => $this->calculateTrendPercentage($monthData),
            'prediction' => $this->predictNextMonth($monthData)
        ];
        
        return $trends;
    }
    
    /**
     * Générer des alertes
     */
    private function generateAlerts(Company $company): array
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
                'recommendation' => 'Ouvrir des guichets supplémentaires'
            ];
        }
        
        // Alertes de charge
        $currentLoad = Ticket::where('company_id', $company->id)
            ->where('status', 'WAITING')
            ->count();
        
        if ($currentLoad > 50) {
            $alerts[] = [
                'type' => 'high_load',
                'severity' => 'critical',
                'message' => "Charge critique: {$currentLoad} clients en attente",
                'recommendation' => 'Activation du plan d\'urgence'
            ];
        }
        
        // Alertes d'agents
        $availableAgents = $this->getAvailableAgents($company);
        if ($availableAgents < 2 && $currentLoad > 20) {
            $alerts[] = [
                'type' => 'agent_shortage',
                'severity' => 'high',
                'message' => "Seulement {$availableAgents} agents disponibles pour {$currentLoad} clients",
                'recommendation' => 'Appeler des agents de réserve'
            ];
        }
        
        return $alerts;
    }
    
    /**
     * Générer des recommandations
     */
    private function generateRecommendations(Company $company): array
    {
        $recommendations = [];
        
        $currentLoad = Ticket::where('company_id', $company->id)
            ->where('status', 'WAITING')
            ->count();
        
        $avgWaitTime = $this->getCompanyAverageWaitTime($company);
        
        // Recommandations de staffing
        if ($currentLoad > 30) {
            $recommendations[] = [
                'type' => 'staffing',
                'priority' => 'high',
                'action' => 'increase_agents',
                'message' => 'Augmenter le nombre d\'agents de 50%',
                'estimated_impact' => 'Réduction du temps d\'attente de 40%'
            ];
        }
        
        // Recommandations d'optimisation
        if ($avgWaitTime > 15) {
            $recommendations[] = [
                'type' => 'optimization',
                'priority' => 'medium',
                'action' => 'optimize_services',
                'message' => 'Optimiser la répartition des services',
                'estimated_impact' => 'Réduction du temps d\'attente de 25%'
            ];
        }
        
        // Recommandations de formation
        $slowAgents = $this->getSlowAgents($company);
        if (count($slowAgents) > 0) {
            $recommendations[] = [
                'type' => 'training',
                'priority' => 'low',
                'action' => 'agent_training',
                'message' => 'Formation des agents moins performants',
                'estimated_impact' => 'Amélioration de la productivité de 15%'
            ];
        }
        
        return $recommendations;
    }
    
    /**
     * Méthodes utilitaires
     */
    private function calculateAverageWaitTime($tickets): float
    {
        $waitTimes = $tickets->map(function ($ticket) {
            if ($ticket->called_at) {
                return $ticket->created_at->diffInMinutes($ticket->called_at);
            }
            return $ticket->created_at->diffInMinutes(now());
        });
        
        return $waitTimes->avg() ?? 0;
    }
    
    private function getLongestWait($tickets): int
    {
        return $tickets->map(function ($ticket) {
            return $ticket->created_at->diffInMinutes(now());
        })->max() ?? 0;
    }
    
    private function getOnlineAgents(Company $company): int
    {
        return $company->users()
            ->wherePivot('role', 'agent')
            ->where('last_login_at', '>', Carbon::now()->subMinutes(30))
            ->count();
    }
    
    private function getBusyAgents(Company $company): int
    {
        return Ticket::where('company_id', $company->id)
            ->where('status', 'SERVING')
            ->distinct('agent_id')
            ->count();
    }
    
    private function getAvailableAgents(Company $company): int
    {
        return $this->getOnlineAgents($company) - $this->getBusyAgents($company);
    }
    
    private function isPeakHour(int $hour): bool
    {
        return in_array($hour, [9, 10, 11, 14, 15, 16, 17, 18]);
    }
    
    private function calculateTrendDirection($data): string
    {
        if ($data->count() < 2) return 'stable';
        
        $firstHalf = $data->take(floor($data->count() / 2))->avg('count');
        $secondHalf = $data->skip(floor($data->count() / 2))->avg('count');
        
        if ($secondHalf > $firstHalf * 1.1) return 'increasing';
        if ($secondHalf < $firstHalf * 0.9) return 'decreasing';
        return 'stable';
    }
    
    private function calculateTrendPercentage($data): float
    {
        if ($data->count() < 2) return 0;
        
        $firstHalf = $data->take(floor($data->count() / 2))->avg('count');
        $secondHalf = $data->skip(floor($data->count() / 2))->avg('count');
        
        if ($firstHalf == 0) return 0;
        
        return round((($secondHalf - $firstHalf) / $firstHalf) * 100, 2);
    }
    
    private function predictNextWeek($data): int
    {
        if ($data->count() < 3) return 0;
        
        $trend = $this->calculateTrendDirection($data);
        $avg = $data->avg('count');
        
        if ($trend === 'increasing') return round($avg * 1.1);
        if ($trend === 'decreasing') return round($avg * 0.9);
        return round($avg);
    }
    
    private function predictNextMonth($data): int
    {
        if ($data->count() < 7) return 0;
        
        $trend = $this->calculateTrendDirection($data);
        $avg = $data->avg('count');
        
        if ($trend === 'increasing') return round($avg * 1.15);
        if ($trend === 'decreasing') return round($avg * 0.85);
        return round($avg);
    }
    
    private function getCompanyAverageWaitTime(Company $company): float
    {
        return Ticket::where('company_id', $company->id)
            ->where('status', 'SERVED')
            ->whereBetween('served_at', [Carbon::now()->subDays(7), Carbon::now()])
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, called_at, served_at)) as avg_wait')
            ->value('avg_wait') ?? 0;
    }
    
    private function getSlowAgents(Company $company): array
    {
        // Implémentation pour identifier les agents moins performants
        return [];
    }
    
    private function getAverageCallDuration($tickets): float
    {
        return 5; // Placeholder
    }
    
    private function getAverageServiceDuration($tickets): float
    {
        return 8; // Placeholder
    }
    
    private function getPeakHoursForDay(Company $company, Carbon $day): array
    {
        return [9, 10, 11, 14, 15, 16]; // Placeholder
    }
}
