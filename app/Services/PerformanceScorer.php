<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Service;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PerformanceScorer
{
    /**
     * Calculer le score de performance d'un agent
     */
    public function calculateAgentScore(User $agent, Company $company, int $days = 30): array
    {
        $cacheKey = "agent_score_{$agent->id}_{$company->id}_{$days}";
        
        return Cache::remember($cacheKey, 3600, function () use ($agent, $company, $days) {
            $tickets = Ticket::where('company_id', $company->id)
                ->where('agent_id', $agent->id)
                ->whereBetween('served_at', [Carbon::now()->subDays($days), Carbon::now()])
                ->with(['service'])
                ->get();
            
            if ($tickets->isEmpty()) {
                return [
                    'overall_score' => 0,
                    'grade' => 'N/A',
                    'metrics' => [],
                    'recommendations' => ['Pas assez de données pour évaluer']
                ];
            }
            
            $metrics = [
                'speed' => $this->calculateSpeedScore($tickets),
                'efficiency' => $this->calculateEfficiencyScore($tickets),
                'quality' => $this->calculateQualityScore($tickets),
                'consistency' => $this->calculateConsistencyScore($tickets),
                'customer_satisfaction' => $this->calculateSatisfactionScore($tickets)
            ];
            
            $weights = [
                'speed' => 0.25,
                'efficiency' => 0.30,
                'quality' => 0.25,
                'consistency' => 0.10,
                'customer_satisfaction' => 0.10
            ];
            
            $overallScore = 0;
            foreach ($metrics as $key => $value) {
                $overallScore += $value * $weights[$key];
            }
            
            return [
                'overall_score' => round($overallScore, 1),
                'grade' => $this->getGrade($overallScore),
                'metrics' => $metrics,
                'tickets_analyzed' => $tickets->count(),
                'period_days' => $days,
                'recommendations' => $this->getAgentRecommendations($metrics, $overallScore),
                'comparison' => $this->compareWithPeers($agent, $company, $overallScore)
            ];
        });
    }
    
    /**
     * Calculer le score de performance d'un service
     */
    public function calculateServiceScore(Service $service, Company $company, int $days = 30): array
    {
        $cacheKey = "service_score_{$service->id}_{$company->id}_{$days}";
        
        return Cache::remember($cacheKey, 3600, function () use ($service, $company, $days) {
            $tickets = Ticket::where('company_id', $company->id)
                ->where('service_id', $service->id)
                ->whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])
                ->get();
            
            if ($tickets->isEmpty()) {
                return [
                    'overall_score' => 0,
                    'grade' => 'N/A',
                    'metrics' => [],
                    'recommendations' => ['Pas assez de données pour évaluer']
                ];
            }
            
            $metrics = [
                'throughput' => $this->calculateThroughputScore($tickets, $days),
                'wait_time' => $this->calculateWaitTimeScore($tickets),
                'service_time' => $this->calculateServiceTimeScore($tickets),
                'customer_flow' => $this->calculateCustomerFlowScore($tickets),
                'efficiency' => $this->calculateServiceEfficiencyScore($tickets)
            ];
            
            $weights = [
                'throughput' => 0.20,
                'wait_time' => 0.30,
                'service_time' => 0.25,
                'customer_flow' => 0.15,
                'efficiency' => 0.10
            ];
            
            $overallScore = 0;
            foreach ($metrics as $key => $value) {
                $overallScore += $value * $weights[$key];
            }
            
            return [
                'overall_score' => round($overallScore, 1),
                'grade' => $this->getGrade($overallScore),
                'metrics' => $metrics,
                'tickets_analyzed' => $tickets->count(),
                'period_days' => $days,
                'recommendations' => $this->getServiceRecommendations($metrics, $overallScore),
                'trends' => $this->getServiceTrends($service, $company)
            ];
        });
    }
    
    /**
     * Calculer le score de performance global de l'entreprise
     */
    public function calculateCompanyScore(Company $company, int $days = 30): array
    {
        $cacheKey = "company_score_{$company->id}_{$days}";
        
        return Cache::remember($cacheKey, 3600, function () use ($company, $days) {
            $tickets = Ticket::where('company_id', $company->id)
                ->whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])
                ->get();
            
            if ($tickets->isEmpty()) {
                return [
                    'overall_score' => 0,
                    'grade' => 'N/A',
                    'metrics' => [],
                    'recommendations' => ['Pas assez de données pour évaluer']
                ];
            }
            
            $metrics = [
                'customer_experience' => $this->calculateCustomerExperienceScore($tickets),
                'operational_efficiency' => $this->calculateOperationalEfficiencyScore($tickets),
                'resource_utilization' => $this->calculateResourceUtilizationScore($company, $tickets),
                'service_quality' => $this->calculateServiceQualityScore($tickets),
                'growth' => $this->calculateGrowthScore($company, $days)
            ];
            
            $weights = [
                'customer_experience' => 0.30,
                'operational_efficiency' => 0.25,
                'resource_utilization' => 0.20,
                'service_quality' => 0.15,
                'growth' => 0.10
            ];
            
            $overallScore = 0;
            foreach ($metrics as $key => $value) {
                $overallScore += $value * $weights[$key];
            }
            
            return [
                'overall_score' => round($overallScore, 1),
                'grade' => $this->getGrade($overallScore),
                'metrics' => $metrics,
                'tickets_analyzed' => $tickets->count(),
                'period_days' => $days,
                'recommendations' => $this->getCompanyRecommendations($metrics, $overallScore),
                'industry_comparison' => $this->getIndustryComparison($overallScore),
                'historical_performance' => $this->getHistoricalPerformance($company, $days)
            ];
        });
    }
    
    /**
     * Métriques pour les agents
     */
    private function calculateSpeedScore($tickets): float
    {
        $avgServiceTime = $tickets->map(function ($ticket) {
            return $ticket->called_at && $ticket->served_at 
                ? $ticket->called_at->diffInMinutes($ticket->served_at) 
                : 10; // Default 10 minutes
        })->avg();
        
        // Score basé sur la rapidité (moins de temps = meilleur score)
        if ($avgServiceTime <= 3) return 100;
        if ($avgServiceTime <= 5) return 90;
        if ($avgServiceTime <= 8) return 75;
        if ($avgServiceTime <= 12) return 60;
        if ($avgServiceTime <= 15) return 45;
        return 30;
    }
    
    private function calculateEfficiencyScore($tickets): float
    {
        $servedTickets = $tickets->where('status', 'SERVED')->count();
        $totalTickets = $tickets->count();
        
        $efficiencyRate = ($servedTickets / $totalTickets) * 100;
        
        if ($efficiencyRate >= 95) return 100;
        if ($efficiencyRate >= 90) return 90;
        if ($efficiencyRate >= 85) return 80;
        if ($efficiencyRate >= 80) return 70;
        if ($efficiencyRate >= 75) return 60;
        return 50;
    }
    
    private function calculateQualityScore($tickets): float
    {
        // Basé sur le taux de satisfaction et les retours clients
        // Pour l'instant, utilisation d'un proxy basé sur les annulations
        $cancelledTickets = $tickets->where('status', 'CANCELLED')->count();
        $totalTickets = $tickets->count();
        
        $cancellationRate = ($cancelledTickets / $totalTickets) * 100;
        
        // Moins d'annulations = meilleure qualité
        if ($cancellationRate <= 2) return 100;
        if ($cancellationRate <= 5) return 90;
        if ($cancellationRate <= 8) return 80;
        if ($cancellationRate <= 12) return 70;
        if ($cancellationRate <= 15) return 60;
        return 50;
    }
    
    private function calculateConsistencyScore($tickets): float
    {
        if ($tickets->count() < 5) return 50;
        
        $serviceTimes = $tickets->map(function ($ticket) {
            return $ticket->called_at && $ticket->served_at 
                ? $ticket->called_at->diffInMinutes($ticket->served_at) 
                : 10;
        });
        
        $standardDeviation = $this->calculateStandardDeviation($serviceTimes);
        $mean = $serviceTimes->avg();
        
        // Coefficient de variation (CV)
        $cv = ($standardDeviation / $mean) * 100;
        
        // Moins de variation = meilleure consistance
        if ($cv <= 10) return 100;
        if ($cv <= 15) return 90;
        if ($cv <= 20) return 80;
        if ($cv <= 25) return 70;
        if ($cv <= 30) return 60;
        return 50;
    }
    
    private function calculateSatisfactionScore($tickets): float
    {
        // Placeholder - nécessiterait des données de satisfaction réelles
        return 85; // Score moyen par défaut
    }
    
    /**
     * Métriques pour les services
     */
    private function calculateThroughputScore($tickets, int $days): float
    {
        $ticketsPerDay = $tickets->count() / $days;
        
        if ($ticketsPerDay >= 100) return 100;
        if ($ticketsPerDay >= 80) return 90;
        if ($ticketsPerDay >= 60) return 80;
        if ($ticketsPerDay >= 40) return 70;
        if ($ticketsPerDay >= 20) return 60;
        return 50;
    }
    
    private function calculateWaitTimeScore($tickets): float
    {
        $avgWaitTime = $tickets->map(function ($ticket) {
            return $ticket->called_at 
                ? $ticket->created_at->diffInMinutes($ticket->called_at) 
                : 5;
        })->avg();
        
        // Moins d'attente = meilleur score
        if ($avgWaitTime <= 5) return 100;
        if ($avgWaitTime <= 8) return 90;
        if ($avgWaitTime <= 12) return 80;
        if ($avgWaitTime <= 15) return 70;
        if ($avgWaitTime <= 20) return 60;
        return 50;
    }
    
    private function calculateServiceTimeScore($tickets): float
    {
        $avgServiceTime = $tickets->map(function ($ticket) {
            return $ticket->called_at && $ticket->served_at 
                ? $ticket->called_at->diffInMinutes($ticket->served_at) 
                : 8;
        })->avg();
        
        if ($avgServiceTime <= 5) return 100;
        if ($avgServiceTime <= 8) return 90;
        if ($avgServiceTime <= 12) return 80;
        if ($avgServiceTime <= 15) return 70;
        if ($avgServiceTime <= 20) return 60;
        return 50;
    }
    
    private function calculateCustomerFlowScore($tickets): float
    {
        $servedTickets = $tickets->where('status', 'SERVED')->count();
        $totalTickets = $tickets->count();
        
        $completionRate = ($servedTickets / $totalTickets) * 100;
        
        if ($completionRate >= 95) return 100;
        if ($completionRate >= 90) return 90;
        if ($completionRate >= 85) return 80;
        if ($completionRate >= 80) return 70;
        if ($completionRate >= 75) return 60;
        return 50;
    }
    
    private function calculateServiceEfficiencyScore($tickets): float
    {
        // Placeholder pour l'efficacité du service
        return 80;
    }
    
    /**
     * Métriques pour l'entreprise
     */
    private function calculateCustomerExperienceScore($tickets): float
    {
        $avgWaitTime = $tickets->map(function ($ticket) {
            return $ticket->called_at 
                ? $ticket->created_at->diffInMinutes($ticket->called_at) 
                : 10;
        })->avg();
        
        $completionRate = ($tickets->where('status', 'SERVED')->count() / $tickets->count()) * 100;
        
        // Score combiné
        $waitScore = max(0, 100 - ($avgWaitTime * 2));
        $completionScore = $completionRate;
        
        return ($waitScore + $completionScore) / 2;
    }
    
    private function calculateOperationalEfficiencyScore($tickets): float
    {
        $servedTickets = $tickets->where('status', 'SERVED')->count();
        $totalTickets = $tickets->count();
        
        return ($servedTickets / $totalTickets) * 100;
    }
    
    private function calculateResourceUtilizationScore(Company $company, $tickets): float
    {
        $activeAgents = $company->users()
            ->wherePivot('role', 'agent')
            ->where('last_login_at', '>', Carbon::now()->subMinutes(30))
            ->count();
        
        if ($activeAgents === 0) return 0;
        
        $ticketsPerAgent = $tickets->count() / $activeAgents;
        
        if ($ticketsPerAgent >= 50) return 100;
        if ($ticketsPerAgent >= 40) return 90;
        if ($ticketsPerAgent >= 30) return 80;
        if ($ticketsPerAgent >= 20) return 70;
        if ($ticketsPerAgent >= 15) return 60;
        return 50;
    }
    
    private function calculateServiceQualityScore($tickets): float
    {
        // Placeholder pour la qualité de service
        return 85;
    }
    
    private function calculateGrowthScore(Company $company, int $days): float
    {
        $currentPeriod = Ticket::where('company_id', $company->id)
            ->whereBetween('created_at', [Carbon::now()->subDays($days), Carbon::now()])
            ->count();
        
        $previousPeriod = Ticket::where('company_id', $company->id)
            ->whereBetween('created_at', [Carbon::now()->subDays($days * 2), Carbon::now()->subDays($days)])
            ->count();
        
        if ($previousPeriod === 0) return 50;
        
        $growthRate = (($currentPeriod - $previousPeriod) / $previousPeriod) * 100;
        
        if ($growthRate >= 20) return 100;
        if ($growthRate >= 10) return 90;
        if ($growthRate >= 5) return 80;
        if ($growthRate >= 0) return 70;
        if ($growthRate >= -5) return 60;
        return 50;
    }
    
    /**
     * Méthodes utilitaires
     */
    private function getGrade(float $score): string
    {
        if ($score >= 95) return 'A+';
        if ($score >= 90) return 'A';
        if ($score >= 85) return 'A-';
        if ($score >= 80) return 'B+';
        if ($score >= 75) return 'B';
        if ($score >= 70) return 'B-';
        if ($score >= 65) return 'C+';
        if ($score >= 60) return 'C';
        if ($score >= 55) return 'C-';
        if ($score >= 50) return 'D';
        return 'F';
    }
    
    private function calculateStandardDeviation($values): float
    {
        $mean = $values->avg();
        $variance = $values->map(function ($value) use ($mean) {
            return pow($value - $mean, 2);
        })->avg();
        
        return sqrt($variance);
    }
    
    private function getAgentRecommendations(array $metrics, float $score): array
    {
        $recommendations = [];
        
        if ($metrics['speed'] < 70) {
            $recommendations[] = 'Formation sur les techniques de service rapide';
        }
        
        if ($metrics['efficiency'] < 80) {
            $recommendations[] = 'Optimiser la gestion du temps';
        }
        
        if ($metrics['quality'] < 75) {
            $recommendations[] = 'Améliorer la qualité du service client';
        }
        
        if ($metrics['consistency'] < 70) {
            $recommendations[] = 'Standardiser les procédures de service';
        }
        
        return $recommendations;
    }
    
    private function getServiceRecommendations(array $metrics, float $score): array
    {
        $recommendations = [];
        
        if ($metrics['wait_time'] < 70) {
            $recommendations[] = 'Optimiser le nombre de guichets';
        }
        
        if ($metrics['throughput'] < 70) {
            $recommendations[] = 'Améliorer l\'efficacité du traitement';
        }
        
        if ($metrics['customer_flow'] < 75) {
            $recommendations[] = 'Réorganiser le flux de clients';
        }
        
        return $recommendations;
    }
    
    private function getCompanyRecommendations(array $metrics, float $score): array
    {
        $recommendations = [];
        
        if ($metrics['customer_experience'] < 75) {
            $recommendations[] = 'Investir dans l\'expérience client';
        }
        
        if ($metrics['operational_efficiency'] < 80) {
            $recommendations[] = 'Optimiser les opérations';
        }
        
        if ($metrics['resource_utilization'] < 70) {
            $recommendations[] = 'Mieux utiliser les ressources';
        }
        
        return $recommendations;
    }
    
    private function compareWithPeers(User $agent, Company $company, float $score): array
    {
        // Placeholder pour la comparaison avec les pairs
        return [
            'percentile' => 75,
            'rank' => 3,
            'total_agents' => 12,
            'above_average' => $score > 75
        ];
    }
    
    private function getServiceTrends(Service $service, Company $company): array
    {
        // Placeholder pour les tendances du service
        return [
            'direction' => 'stable',
            'change_percentage' => 5.2
        ];
    }
    
    private function getIndustryComparison(float $score): array
    {
        return [
            'industry_average' => 78.5,
            'percentile' => 85,
            'benchmark' => 'Top 15%'
        ];
    }
    
    private function getHistoricalPerformance(Company $company, int $days): array
    {
        // Placeholder pour la performance historique
        return [
            'last_month' => 82.3,
            'last_quarter' => 79.8,
            'last_year' => 76.5,
            'trend' => 'improving'
        ];
    }
}
