<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\Service;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class TicketIntelligenceService
{
    /**
     * Obtenir le prochain ticket dans la file
     */
    public function getNextTicket(Ticket $currentTicket): ?Ticket
    {
        return $currentTicket->service->waitingTickets()
            ->where('status', 'WAITING')
            ->where('id', '!=', $currentTicket->id)
            ->orderBy('created_at', 'asc')
            ->first();
    }

    /**
     * Calculer l'ETA (Estimated Time of Arrival) intelligent
     */
    public function calculateETA(?Ticket $ticket): ?array
    {
        if (!$ticket) {
            return null;
        }

        $service = $ticket->service;
        $company = $service->company;

        // Facteurs de calcul
        $historicalAverage = $this->getHistoricalAverageServiceTime($service);
        $currentLoad = $this->getCurrentLoad($service);
        $timeMultiplier = $this->getTimeMultiplier();
        $agentPerformance = $this->getAgentPerformance($service);
        $peakHourFactor = $this->getPeakHourFactor($company);

        // Calcul de base
        $baseTime = $historicalAverage * $currentLoad * $timeMultiplier;
        
        // Ajustements avancés
        $adjustedTime = $baseTime * $agentPerformance * $peakHourFactor;

        // Position dans la queue
        $position = $this->getTicketPosition($ticket);
        
        // Calcul final avec marge d'erreur
        $estimatedMinutes = ($adjustedTime * $position) * 1.1; // 10% de marge

        return [
            'estimated_minutes' => round($estimatedMinutes),
            'confidence_level' => $this->calculateConfidenceLevel($service),
            'factors' => [
                'historical_average' => $historicalAverage,
                'current_load' => $currentLoad,
                'time_multiplier' => $timeMultiplier,
                'agent_performance' => $agentPerformance,
                'peak_hour_factor' => $peakHourFactor,
                'queue_position' => $position,
            ],
            'updated_at' => now()->toISOString(),
        ];
    }

    /**
     * Obtenir le temps moyen de service historique
     */
    private function getHistoricalAverageServiceTime(Service $service): float
    {
        $cacheKey = "service_avg_time_{$service->id}";
        
        return Cache::remember($cacheKey, 300, function () use ($service) {
            return $service->tickets()
                ->where('status', 'SERVED')
                ->where('served_at', '>=', now()->subDays(30))
                ->avg('actual_service_time') ?? 300; // 5 minutes par défaut
        });
    }

    /**
     * Obtenir la charge actuelle du service
     */
    private function getCurrentLoad(Service $service): float
    {
        $waitingCount = $service->waitingTickets()->where('status', 'WAITING')->count();
        $activeAgents = $service->counters()->where('status', 'open')->count() ?: 1;
        
        return ($waitingCount / $activeAgents) ?: 1;
    }

    /**
     * Obtenir le multiplicateur temporel selon l'heure
     */
    private function getTimeMultiplier(): float
    {
        $hour = now()->hour;
        
        // Heures de pointe: 9-11, 14-16
        if (($hour >= 9 && $hour <= 11) || ($hour >= 14 && $hour <= 16)) {
            return 1.3;
        }
        
        // Heures creuses: 12-14, 17-18
        if (($hour >= 12 && $hour <= 14) || ($hour >= 17 && $hour <= 18)) {
            return 0.8;
        }
        
        return 1.0;
    }

    /**
     * Obtenir la performance des agents
     */
    private function getAgentPerformance(Service $service): float
    {
        $cacheKey = "service_performance_{$service->id}";
        
        return Cache::remember($cacheKey, 600, function () use ($service) {
            $today = now()->format('Y-m-d');
            
            $servedToday = $service->tickets()
                ->where('status', 'SERVED')
                ->whereDate('served_at', $today)
                ->count();
                
            $totalToday = $service->tickets()
                ->whereDate('created_at', $today)
                ->count();
            
            if ($totalToday === 0) return 1.0;
            
            $performanceRate = $servedToday / $totalToday;
            
            // Normaliser entre 0.7 et 1.3
            return max(0.7, min(1.3, $performanceRate * 2));
        });
    }

    /**
     * Obtenir le facteur d'heure de pointe pour l'entreprise
     */
    private function getPeakHourFactor(Company $company): float
    {
        $dayOfWeek = now()->dayOfWeek; // 0 = Sunday, 6 = Saturday
        
        // Weekends plus lents
        if ($dayOfWeek >= 5) { // Saturday, Sunday
            return 0.7;
        }
        
        // Lundi plus chargé
        if ($dayOfWeek === 1) {
            return 1.2;
        }
        
        return 1.0;
    }

    /**
     * Obtenir la position du ticket dans la queue
     */
    private function getTicketPosition(Ticket $ticket): int
    {
        return $ticket->service->waitingTickets()
            ->where('status', 'WAITING')
            ->where('created_at', '<=', $ticket->created_at)
            ->count();
    }

    /**
     * Calculer le niveau de confiance de la prédiction
     */
    private function calculateConfidenceLevel(Service $service): float
    {
        $dataPoints = $service->tickets()
            ->where('status', 'SERVED')
            ->where('served_at', '>=', now()->subDays(30))
            ->count();
            
        if ($dataPoints < 10) return 0.5;
        if ($dataPoints < 50) return 0.7;
        if ($dataPoints < 100) return 0.85;
        
        return 0.95;
    }

    /**
     * Obtenir les statistiques de performance de l'entreprise
     */
    public function getCompanyPerformanceStats(Company $company): array
    {
        $today = now()->format('Y-m-d');
        $thisMonth = now()->format('Y-m');
        
        // Statistiques du jour
        $todayStats = $this->getDailyStats($company, $today);
        
        // Statistiques du mois
        $monthlyStats = $this->getMonthlyStats($company, $thisMonth);
        
        // Score global
        $globalScore = $this->calculateGlobalScore($todayStats, $monthlyStats);
        
        return [
            'daily' => $todayStats,
            'monthly' => $monthlyStats,
            'global_score' => $globalScore,
            'recommendations' => $this->generateRecommendations($todayStats, $monthlyStats),
            'updated_at' => now()->toISOString(),
        ];
    }

    /**
     * Obtenir les statistiques quotidiennes
     */
    private function getDailyStats(Company $company, string $date): array
    {
        $tickets = $company->tickets()->whereDate('created_at', $date);
        
        $total = $tickets->count();
        $served = $tickets->where('status', 'SERVED')->count();
        $missed = $tickets->where('status', 'MISSED_TEMP')->count();
        $cancelled = $tickets->where('status', 'CANCELLED')->count();
        
        $avgServiceTime = $tickets->where('status', 'SERVED')->avg('actual_service_time') ?? 0;
        
        return [
            'total_tickets' => $total,
            'served_tickets' => $served,
            'missed_tickets' => $missed,
            'cancelled_tickets' => $cancelled,
            'service_rate' => $total > 0 ? round(($served / $total) * 100, 1) : 0,
            'absence_rate' => $total > 0 ? round(($missed / $total) * 100, 1) : 0,
            'cancellation_rate' => $total > 0 ? round(($cancelled / $total) * 100, 1) : 0,
            'avg_service_time_minutes' => round($avgServiceTime / 60, 1),
            'speed_score' => $this->calculateSpeedScore($avgServiceTime),
            'presence_score' => $total > 0 ? round((($served + $missed) / $total) * 100, 1) : 0,
            'efficiency_score' => $this->calculateEfficiencyScore($served, $total, $avgServiceTime),
        ];
    }

    /**
     * Obtenir les statistiques mensuelles
     */
    private function getMonthlyStats(Company $company, string $month): array
    {
        $tickets = $company->tickets()->whereRaw('DATE_FORMAT(created_at, "%Y-%m") = ?', [$month]);
        
        $total = $tickets->count();
        $served = $tickets->where('status', 'SERVED')->count();
        $avgServiceTime = $tickets->where('status', 'SERVED')->avg('actual_service_time') ?? 0;
        
        return [
            'total_tickets' => $total,
            'served_tickets' => $served,
            'service_rate' => $total > 0 ? round(($served / $total) * 100, 1) : 0,
            'avg_service_time_minutes' => round($avgServiceTime / 60, 1),
            'speed_score' => $this->calculateSpeedScore($avgServiceTime),
            'efficiency_score' => $this->calculateEfficiencyScore($served, $total, $avgServiceTime),
        ];
    }

    /**
     * Calculer le score de rapidité (0-100)
     */
    private function calculateSpeedScore(float $avgServiceTime): float
    {
        // Moins de 3 minutes = 100, plus de 10 minutes = 0
        if ($avgServiceTime <= 180) return 100;
        if ($avgServiceTime >= 600) return 0;
        
        return round(100 - (($avgServiceTime - 180) / 420 * 100), 1);
    }

    /**
     * Calculer le score d'efficacité (0-100)
     */
    private function calculateEfficiencyScore(int $served, int $total, float $avgServiceTime): float
    {
        if ($total === 0) return 0;
        
        $serviceRate = ($served / $total) * 100;
        $speedScore = $this->calculateSpeedScore($avgServiceTime);
        
        // Pondération: 60% service rate, 40% speed
        return round(($serviceRate * 0.6) + ($speedScore * 0.4), 1);
    }

    /**
     * Calculer le score global
     */
    private function calculateGlobalScore(array $dailyStats, array $monthlyStats): array
    {
        return [
            'overall' => round(($dailyStats['efficiency_score'] + $monthlyStats['efficiency_score']) / 2, 1),
            'speed' => round(($dailyStats['speed_score'] + $monthlyStats['speed_score']) / 2, 1),
            'presence' => $dailyStats['presence_score'],
            'efficiency' => round(($dailyStats['efficiency_score'] + $monthlyStats['efficiency_score']) / 2, 1),
            'grade' => $this->getPerformanceGrade(($dailyStats['efficiency_score'] + $monthlyStats['efficiency_score']) / 2),
        ];
    }

    /**
     * Obtenir la note de performance (A, B, C, D, F)
     */
    private function getPerformanceGrade(float $score): string
    {
        if ($score >= 90) return 'A';
        if ($score >= 80) return 'B';
        if ($score >= 70) return 'C';
        if ($score >= 60) return 'D';
        return 'F';
    }

    /**
     * Générer des recommandations basées sur les statistiques
     */
    private function generateRecommendations(array $dailyStats, array $monthlyStats): array
    {
        $recommendations = [];
        
        if ($dailyStats['absence_rate'] > 15) {
            $recommendations[] = "Taux d'absence élevé. Considérez réduire le temps d'attente ou améliorer les notifications.";
        }
        
        if ($dailyStats['avg_service_time_minutes'] > 8) {
            $recommendations[] = "Temps de service élevé. Vérifiez si les agents ont besoin de formation ou de meilleurs outils.";
        }
        
        if ($dailyStats['service_rate'] < 80) {
            $recommendations[] = "Taux de service faible. Analysez les raisons des annulations et absences.";
        }
        
        if ($dailyStats['speed_score'] < 70) {
            $recommendations[] = "Rapidité insuffisante. Optimisez les processus ou ajoutez des agents aux heures de pointe.";
        }
        
        return $recommendations;
    }
}
