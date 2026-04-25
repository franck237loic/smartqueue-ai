<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\Service;
use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class WaitTimePredictor
{
    /**
     * Prédire le temps d'attente pour un service
     */
    public function predictWaitTime(Service $service, Company $company): array
    {
        $cacheKey = "wait_time_predict_{$company->id}_{$service->id}";
        
        return Cache::remember($cacheKey, 300, function () use ($service, $company) {
            $currentQueue = $this->getCurrentQueue($service, $company);
            $historicalData = $this->getHistoricalData($service, $company);
            $timeOfDay = $this->getTimeOfDayFactor();
            $dayOfWeek = $this->getDayOfWeekFactor();
            
            $baseWaitTime = $this->calculateBaseWaitTime($currentQueue, $historicalData);
            $adjustedWaitTime = $baseWaitTime * $timeOfDay * $dayOfWeek;
            
            return [
                'estimated_minutes' => round($adjustedWaitTime),
                'confidence' => $this->calculateConfidence($historicalData),
                'queue_length' => $currentQueue,
                'factors' => [
                    'base_time' => round($baseWaitTime),
                    'time_factor' => $timeOfDay,
                    'day_factor' => $dayOfWeek,
                    'historical_avg' => $historicalData['avg_wait_time'] ?? 0
                ]
            ];
        });
    }
    
    /**
     * Obtenir la file d'attente actuelle
     */
    private function getCurrentQueue(Service $service, Company $company): int
    {
        return Ticket::where('company_id', $company->id)
            ->where('service_id', $service->id)
            ->where('status', 'WAITING')
            ->count();
    }
    
    /**
     * Obtenir les données historiques
     */
    private function getHistoricalData(Service $service, Company $company): array
    {
        $now = Carbon::now();
        $hour = $now->hour;
        $dayOfWeek = $now->dayOfWeek;
        
        $historical = Ticket::where('company_id', $company->id)
            ->where('service_id', $service->id)
            ->where('status', 'SERVED')
            ->whereBetween('served_at', [$now->copy()->subDays(30), $now])
            ->selectRaw('
                AVG(TIMESTAMPDIFF(MINUTE, called_at, served_at)) as avg_wait_time,
                COUNT(*) as total_tickets,
                AVG(TIMESTAMPDIFF(MINUTE, created_at, called_at)) as avg_queue_time
            ')
            ->first();
        
        return [
            'avg_wait_time' => $historical->avg_wait_time ?? 5,
            'total_tickets' => $historical->total_tickets ?? 0,
            'avg_queue_time' => $historical->avg_queue_time ?? 2
        ];
    }
    
    /**
     * Calculer le temps d'attente de base
     */
    private function calculateBaseWaitTime(int $queueLength, array $historicalData): float
    {
        $avgServiceTime = $historicalData['avg_wait_time'] ?? 5;
        $avgQueueTime = $historicalData['avg_queue_time'] ?? 2;
        
        // Formule: (nombre en file * temps moyen service) + temps moyen d'attente en file
        return ($queueLength * $avgServiceTime) + $avgQueueTime;
    }
    
    /**
     * Facteur selon l'heure de la journée
     */
    private function getTimeOfDayFactor(): float
    {
        $hour = Carbon::now()->hour;
        
        // Heures de pointe: 8-10h, 12-14h, 17-19h
        if (($hour >= 8 && $hour <= 10) || ($hour >= 12 && $hour <= 14) || ($hour >= 17 && $hour <= 19)) {
            return 1.3; // 30% plus lent
        }
        
        // Heures creuses: 14-17h, 19-20h
        if (($hour >= 14 && $hour <= 17) || ($hour >= 19 && $hour <= 20)) {
            return 0.8; // 20% plus rapide
        }
        
        return 1.0; // Normal
    }
    
    /**
     * Facteur selon le jour de la semaine
     */
    private function getDayOfWeekFactor(): float
    {
        $dayOfWeek = Carbon::now()->dayOfWeek;
        
        // Lundi (1) et Vendredi (5) sont plus chargés
        if ($dayOfWeek === 1 || $dayOfWeek === 5) {
            return 1.2; // 20% plus lent
        }
        
        // Mercredi (3) et Jeudi (4) sont modérés
        if ($dayOfWeek === 3 || $dayOfWeek === 4) {
            return 1.1; // 10% plus lent
        }
        
        // Mardi (2) est normal
        if ($dayOfWeek === 2) {
            return 1.0;
        }
        
        // Week-end (0, 6) est plus calme
        return 0.7; // 30% plus rapide
    }
    
    /**
     * Calculer le niveau de confiance
     */
    private function calculateConfidence(array $historicalData): float
    {
        $totalTickets = $historicalData['total_tickets'] ?? 0;
        
        if ($totalTickets >= 100) {
            return 0.95; // Très haute confiance
        } elseif ($totalTickets >= 50) {
            return 0.85; // Haute confiance
        } elseif ($totalTickets >= 20) {
            return 0.70; // Moyenne confiance
        } elseif ($totalTickets >= 10) {
            return 0.50; // Basse confiance
        }
        
        return 0.30; // Très basse confiance
    }
    
    /**
     * Obtenir les prédictions pour tous les services
     */
    public function getAllServicesPredictions(Company $company): array
    {
        $services = $company->services()->where('status', 'active')->get();
        $predictions = [];
        
        foreach ($services as $service) {
            $predictions[$service->id] = $this->predictWaitTime($service, $company);
        }
        
        return $predictions;
    }
    
    /**
     * Prédire la charge future (prochaine heure)
     */
    public function predictFutureLoad(Service $service, Company $company, int $minutesAhead = 60): array
    {
        $cacheKey = "future_load_{$company->id}_{$service->id}_{$minutesAhead}";
        
        return Cache::remember($cacheKey, 600, function () use ($service, $company, $minutesAhead) {
            $futureTime = Carbon::now()->addMinutes($minutesAhead);
            $futureHour = $futureTime->hour;
            $futureDayOfWeek = $futureTime->dayOfWeek;
            
            // Données historiques pour cette période
            $historicalLoad = Ticket::where('company_id', $company->id)
                ->where('service_id', $service->id)
                ->where('status', 'SERVED')
                ->whereRaw('HOUR(served_at) = ?', [$futureHour])
                ->whereRaw('DAYOFWEEK(served_at) = ?', [$futureDayOfWeek === 0 ? 7 : $futureDayOfWeek])
                ->whereBetween('served_at', [Carbon::now()->subDays(60), Carbon::now()])
                ->count();
            
            $avgTicketsPerHour = $historicalLoad / max(1, 60); // 60 jours de données
            
            return [
                'predicted_tickets' => round($avgTicketsPerHour),
                'load_level' => $this->getLoadLevel($avgTicketsPerHour),
                'recommendation' => $this->getRecommendation($avgTicketsPerHour)
            ];
        });
    }
    
    /**
     * Obtenir le niveau de charge
     */
    private function getLoadLevel(float $ticketCount): string
    {
        if ($ticketCount >= 20) return 'high';
        if ($ticketCount >= 10) return 'medium';
        return 'low';
    }
    
    /**
     * Obtenir les recommandations
     */
    private function getRecommendation(float $ticketCount): string
    {
        if ($ticketCount >= 20) {
            return 'high_load - Ouvrir des guichets supplémentaires';
        } elseif ($ticketCount >= 10) {
            return 'medium_load - Surveiller la charge';
        }
        return 'low_load - Maintenir les guichets actuels';
    }
}
