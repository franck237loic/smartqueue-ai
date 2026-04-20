<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CompanyStatsService
{
    /**
     * Récupérer toutes les statistiques d'une entreprise
     */
    public function getCompanyStats(Company $company): array
    {
        return [
            'global' => $this->getGlobalStats($company),
            'performance' => $this->getPerformanceStats($company),
            'agents' => $this->getAgentStats($company),
            'services' => $this->getServiceStats($company),
            'tickets_by_day' => $this->getTicketsByDay($company),
            'recent_activity' => $this->getRecentActivity($company),
        ];
    }

    /**
     * Statistiques globales des tickets
     */
    private function getGlobalStats(Company $company): array
    {
        $baseQuery = Ticket::where('company_id', $company->id);

        $total = $baseQuery->count();
        $waiting = (clone $baseQuery)->where('status', 'waiting')->count();
        $served = (clone $baseQuery)->where('status', 'served')->count();
        $cancelled = (clone $baseQuery)->where('status', 'cancelled')->count();
        $missed = (clone $baseQuery)->where('status', 'missed')->count();

        // Taux d'absence (tickets manqués / total servis)
        $servedCount = $served > 0 ? $served : 1;
        $missedRate = $total > 0 ? round(($missed / $total) * 100, 2) : 0;

        return [
            'total' => $total,
            'waiting' => $waiting,
            'served' => $served,
            'cancelled' => $cancelled,
            'missed' => $missed,
            'missed_rate' => $missedRate,
        ];
    }

    /**
     * Statistiques de performance
     */
    private function getPerformanceStats(Company $company): array
    {
        // Temps moyen d'attente (waiting -> called)
        $avgWaitTime = Ticket::where('company_id', $company->id)
            ->whereNotNull('called_at')
            ->whereNotNull('created_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, created_at, called_at)) as avg_wait')
            ->value('avg_wait') ?? 0;

        // Temps moyen de service (called -> served)
        $avgServiceTime = Ticket::where('company_id', $company->id)
            ->where('status', 'served')
            ->whereNotNull('served_at')
            ->whereNotNull('called_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, called_at, served_at)) as avg_service')
            ->value('avg_service') ?? 0;

        return [
            'avg_wait_time' => round($avgWaitTime / 60, 2), // en minutes
            'avg_service_time' => round($avgServiceTime / 60, 2), // en minutes
        ];
    }

    /**
     * Statistiques des agents
     */
    private function getAgentStats(Company $company): array
    {
        $agents = User::whereHas('companies', function ($q) use ($company) {
            $q->where('company_id', $company->id)
              ->where('role', 'agent');
        })->count();

        // Agent le plus actif (plus de tickets servis)
        $topAgent = Ticket::where('company_id', $company->id)
            ->where('status', 'served')
            ->whereNotNull('agent_id')
            ->select('agent_id', DB::raw('COUNT(*) as count'))
            ->groupBy('agent_id')
            ->orderByDesc('count')
            ->with('agent:id,name')
            ->first();

        return [
            'total_agents' => $agents,
            'top_agent' => $topAgent ? [
                'name' => $topAgent->agent?->name ?? 'Inconnu',
                'tickets' => $topAgent->count,
            ] : null,
        ];
    }

    /**
     * Statistiques des services
     */
    private function getServiceStats(Company $company): array
    {
        $servicesCount = $company->services()->count();

        // Service le plus utilisé
        $topService = Ticket::where('company_id', $company->id)
            ->select('service_id', DB::raw('COUNT(*) as count'))
            ->groupBy('service_id')
            ->orderByDesc('count')
            ->with('service:id,name')
            ->first();

        return [
            'total_services' => $servicesCount,
            'top_service' => $topService ? [
                'name' => $topService->service?->name ?? 'Inconnu',
                'tickets' => $topService->count,
            ] : null,
        ];
    }

    /**
     * Tickets créés par jour (7 derniers jours)
     */
    private function getTicketsByDay(Company $company): array
    {
        $days = collect();
        $counts = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days->push($date->format('d/m'));

            $count = Ticket::where('company_id', $company->id)
                ->whereDate('created_at', $date->toDateString())
                ->count();

            $counts->push($count);
        }

        return [
            'labels' => $days->toArray(),
            'data' => $counts->toArray(),
        ];
    }

    /**
     * Activité récente (audit log simplifié)
     */
    private function getRecentActivity(Company $company, int $limit = 20): array
    {
        // Tickets récemment modifiés
        $ticketActivity = Ticket::where('company_id', $company->id)
            ->with(['service:id,name', 'agent:id,name'])
            ->latest('updated_at')
            ->take($limit)
            ->get()
            ->map(function ($ticket) {
                return [
                    'type' => 'ticket',
                    'action' => $this->getTicketAction($ticket),
                    'description' => "Ticket {$ticket->number} - {$ticket->service?->name}",
                    'user' => $ticket->agent?->name ?? 'Système',
                    'date' => $ticket->updated_at,
                ];
            });

        return $ticketActivity->toArray();
    }

    /**
     * Déterminer l'action sur un ticket
     */
    private function getTicketAction(Ticket $ticket): string
    {
        return match($ticket->status) {
            'waiting' => 'Créé',
            'called' => 'Appelé',
            'served' => 'Servi',
            'cancelled' => 'Annulé',
            'missed' => 'Manqué',
            default => 'Mis à jour',
        };
    }
}
