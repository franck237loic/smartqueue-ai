<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Counter;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use App\Events\TicketCalled;
use App\Events\TicketStatusChanged;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketService
{
    /**
     * Créer un nouveau ticket
     */
    public function createTicket(Service $service, array $data = []): Ticket
    {
        return DB::transaction(function () use ($service, $data) {
            $company = $service->company;
            $numberData = $this->generateTicketNumber($service);

            $ticket = Ticket::create([
                'company_id' => $company->id,
                'service_id' => $service->id,
                'agent_id' => $data['agent_id'] ?? null,
                'guest_name' => $data['guest_name'] ?? null,
                'guest_phone' => $data['guest_phone'] ?? null,
                'number' => $numberData['full'],
                'prefix' => $numberData['prefix'],
                'sequence' => $numberData['sequence'],
                'status' => Ticket::STATUS_WAITING,
                'priority' => $data['priority'] ?? 0,
                'notes' => $data['notes'] ?? null,
            ]);

            return $ticket;
        });
    }

    /**
     * Appeler le prochain ticket pour un service (avec verrouillage pessimiste)
     * CRITIQUE: Garantit qu'un seul agent peut appeler un ticket
     */
    public function callNextTicket(Company $company, User $agent, Counter $counter): ?Ticket
    {
        // Vérifier que le guichet est ouvert ou occupé par un appel précédent
        if (!in_array($counter->status, ['open', 'busy'])) {
            return null;
        }

        // Vérifier qu'aucun ticket actif n'est déjà sur ce guichet
        $existingTicket = Ticket::where('counter_id', $counter->id)
            ->whereIn('status', [Ticket::STATUS_CALLED, Ticket::STATUS_SERVING])
            ->first();

        if ($existingTicket) {
            return null;
        }

        return \DB::transaction(function () use ($company, $agent, $counter) {
            // Re-verrouiller le guichet pour éviter les conditions de course
            $counter->refresh();
            
            if ($counter->status !== 'open') {
                return null;
            }

            // Verrouiller le prochain ticket en attente avec FOR UPDATE
            $nextTicket = Ticket::where('service_id', $counter->service_id)
                ->where('company_id', $company->id)
                ->where('status', Ticket::STATUS_WAITING)
                ->orderBy('created_at', 'asc')
                ->lockForUpdate()
                ->first();

            if (!$nextTicket) {
                return null;
            }

            // Double vérification: le statut n'a pas changé pendant le lock
            $freshTicket = Ticket::where('id', $nextTicket->id)
                ->lockForUpdate()
                ->first();

            if (!$freshTicket || $freshTicket->status !== Ticket::STATUS_WAITING) {
                return null;
            }

            // Appeler le ticket
            $freshTicket->call($agent, $counter);

            return $freshTicket;
        });
    }

    /**
     * Appeler un ticket spécifique (avec verrouillage)
     */
    public function callSpecificTicket(Ticket $ticket, User $agent, Counter $counter): ?Ticket
    {
        return \DB::transaction(function () use ($ticket, $agent, $counter) {
            // Recharger avec lock
            $freshTicket = Ticket::where('id', $ticket->id)
                ->lockForUpdate()
                ->first();

            if (!$freshTicket || !$freshTicket->isWaiting()) {
                return null;
            }

            // Vérifier que le guichet est disponible
            $counter->refresh();
            if ($counter->status !== 'open') {
                return null;
            }

            $freshTicket->call($agent, $counter);

            return $freshTicket;
        });
    }

    /**
     * Gérer un ticket manqué (absent) - Logique de réinsertion
     * Retourne true si remis en file, false si annulé (3 absences)
     */
    public function handleMissedTicket(Ticket $ticket): bool
    {
        if (!$ticket->isCalled() && !$ticket->isServing()) {
            return false;
        }

        return \DB::transaction(function () use ($ticket) {
            $freshTicket = Ticket::where('id', $ticket->id)
                ->lockForUpdate()
                ->first();

            if (!$freshTicket) {
                return false;
            }

            $result = $freshTicket->markAsMissed();
            
            return $result; // true = remis en file, false = annulé
        });
    }

    /**
     * Remettre en file les tickets manqués temporairement après délai
     */
    public function requeueMissedTickets(): int
    {
        $count = 0;
        
        Ticket::where('status', Ticket::STATUS_MISSED)
            ->where('missed_at', '<=', now()->subSeconds(30)) // 30 sec avant réinsertion
            ->chunk(100, function ($tickets) use (&$count) {
                foreach ($tickets as $ticket) {
                    \DB::transaction(function () use ($ticket, &$count) {
                        $fresh = Ticket::where('id', $ticket->id)
                            ->lockForUpdate()
                            ->first();

                        if ($fresh && $fresh->isMissedTemp()) {
                            $fresh->requeue();
                            $count++;
                        }
                    });
                }
            });

        return $count;
    }

    /**
     * Servir un ticket
     */
    public function serveTicket(Ticket $ticket): Ticket
    {
        return DB::transaction(function () use ($ticket) {
            $ticket->markAsServed();
            return $ticket;
        });
    }

    /**
     * Marquer un ticket comme manqué manuellement
     */
    public function markAsMissed(Ticket $ticket): bool
    {
        return $this->handleMissedTicket($ticket);
    }

    /**
     * Marquer un ticket comme en cours de service
     */
    public function markAsServing(Ticket $ticket): Ticket
    {
        $ticket->markAsServing();
        return $ticket;
    }

    /**
     * Transférer un ticket vers un autre service
     */
    public function transferTicket(Ticket $ticket, Service $newService, ?string $reason = null): Ticket
    {
        if ($newService->company_id !== $ticket->company_id) {
            throw new \InvalidArgumentException('Le nouveau service doit appartenir à la même entreprise');
        }

        $newNumber = $this->generateTicketNumber($newService);

        $ticket->update([
            'service_id' => $newService->id,
            'number' => $newNumber,
            'status' => 'waiting',
            'called_at' => null,
            'counter_id' => null,
            'agent_id' => null,
            'estimated_wait_time' => $this->calculateEstimatedWaitTime($newService),
            'transfer_reason' => $reason,
        ]);

        return $ticket;
    }

    /**
     * Annuler un ticket
     */
    public function cancelTicket(Ticket $ticket): Ticket
    {
        $ticket->cancel();
        return $ticket;
    }

    /**
     * Vérifier les tickets manqués automatiquement (timer 30-60s)
     * Appelé par une commande scheduler toutes les 30 secondes
     */
    public function checkMissedTimeouts(int $timeoutSeconds = 45): array
    {
        $processed = [];
        
        Ticket::where('status', Ticket::STATUS_CALLED)
            ->whereNotNull('called_at')
            ->where('called_at', '<=', now()->subSeconds($timeoutSeconds))
            ->with('service', 'counter')
            ->chunk(100, function ($tickets) use (&$processed) {
                foreach ($tickets as $ticket) {
                    $result = $this->handleMissedTicket($ticket);
                    $processed[] = [
                        'ticket_id' => $ticket->id,
                        'number' => $ticket->number,
                        'action' => $result ? 'requeued' : 'cancelled',
                    ];
                }
            });

        return $processed;
    }

    /**
     * Calculer le temps d'attente estimé
     */
    public function calculateEstimatedWaitTime(Service $service): int
    {
        $waitingCount = $service->waitingTickets()->count();
        $avgServiceTime = $service->estimated_service_time;

        // Calculer la moyenne historique des 7 derniers jours
        $history = Ticket::where('service_id', $service->id)
            ->whereNotNull('actual_service_time')
            ->where('created_at', '>=', now()->subDays(7))
            ->avg('actual_service_time');

        if ($history) {
            $avgServiceTime = ($avgServiceTime + $history) / 2;
        }

        return ceil($waitingCount * $avgServiceTime);
    }

    /**
     * Générer un numéro de ticket au format A001, B002, etc.
     * Incrément par service et par jour
     */
    public function generateTicketNumber(Service $service): array
    {
        $prefix = strtoupper($service->code ?? substr($service->name, 0, 1));
        
        // Obtenir le dernier numéro du jour pour ce service
        $lastTicket = Ticket::where('service_id', $service->id)
            ->whereDate('created_at', today())
            ->orderBy('sequence', 'desc')
            ->first();

        $sequence = $lastTicket ? $lastTicket->sequence + 1 : 1;
        $number = $prefix . str_pad($sequence, 3, '0', STR_PAD_LEFT);

        return [
            'prefix' => $prefix,
            'sequence' => $sequence,
            'full' => $number,
        ];
    }

    /**
     * Obtenir la position d'un ticket dans la file
     */
    public function getTicketPosition(Ticket $ticket): ?int
    {
        if (!$ticket->isWaiting() && !$ticket->isMissedTemp()) {
            return null;
        }

        return Ticket::where('service_id', $ticket->service_id)
            ->whereIn('status', [Ticket::STATUS_WAITING, Ticket::STATUS_MISSED_TEMP])
            ->where(function ($query) use ($ticket) {
                $query->where('priority', '>', $ticket->priority)
                      ->orWhere(function ($q) use ($ticket) {
                          $q->where('priority', '=', $ticket->priority)
                            ->where('created_at', '<', $ticket->created_at);
                      });
            })
            ->count() + 1;
    }

    /**
     * Obtenir le statut complet d'un ticket pour API
     */
    public function getTicketStatus(Ticket $ticket): array
    {
        $position = $this->getTicketPosition($ticket);
        
        return [
            'id' => $ticket->id,
            'number' => $ticket->number,
            'prefix' => $ticket->prefix,
            'sequence' => $ticket->sequence,
            'status' => $ticket->status,
        ];
    }

    /**
     * Obtenir les statistiques d'un service
     */
    public function getServiceStats(Service $service): array
    {
        $today = now()->startOfDay();

        return [
            'total_created' => $service->tickets()->whereDate('created_at', $today)->count(),
            'waiting' => $service->tickets()->where('status', Ticket::STATUS_WAITING)->count(),
            'called' => $service->tickets()->where('status', Ticket::STATUS_CALLED)->count(),
            'serving' => $service->tickets()->where('status', Ticket::STATUS_SERVING)->count(),
            'served' => $service->tickets()->where('status', Ticket::STATUS_SERVED)->whereDate('served_at', $today)->count(),
            'missed' => $service->tickets()->where('status', Ticket::STATUS_MISSED)->count(),
            'cancelled' => $service->tickets()->where('status', Ticket::STATUS_CANCELLED)->whereDate('cancelled_at', $today)->count(),
            'avg_service_seconds' => $service->tickets()
                ->where('status', Ticket::STATUS_SERVED)
                ->whereDate('served_at', $today)
                ->avg('service_time_seconds') ?? 0,
        ];
    }

    /**
     * Obtenir les statistiques d'une entreprise pour aujourd'hui
     */
    public function getCompanyStats(Company $company): array
    {
        $today = now()->startOfDay();

        return [
            'total_created' => $company->tickets()->whereDate('created_at', $today)->count(),
            'waiting' => $company->tickets()->where('status', Ticket::STATUS_WAITING)->count(),
            'called' => $company->tickets()->where('status', Ticket::STATUS_CALLED)->count(),
            'serving' => $company->tickets()->where('status', Ticket::STATUS_SERVING)->count(),
            'served' => $company->tickets()->where('status', Ticket::STATUS_SERVED)->whereDate('served_at', $today)->count(),
            'missed' => $company->tickets()->where('status', Ticket::STATUS_MISSED)->count(),
            'cancelled' => $company->tickets()->where('status', Ticket::STATUS_CANCELLED)->whereDate('cancelled_at', $today)->count(),
            'avg_wait_seconds' => $company->tickets()
                ->where('status', Ticket::STATUS_SERVED)
                ->whereDate('served_at', $today)
                ->selectRaw('AVG(TIMESTAMPDIFF(SECOND, created_at, called_at)) as avg_wait')
                ->value('avg_wait') ?? 0,
            'avg_service_seconds' => $company->tickets()
                ->where('status', Ticket::STATUS_SERVED)
                ->whereDate('served_at', $today)
                ->avg('service_time_seconds') ?? 0,
        ];
    }

    /**
     * Obtenir la file d'attente actuelle pour un service
     */
    public function getQueue(Service $service): array
    {
        $tickets = Ticket::where('service_id', $service->id)
            ->whereIn('status', [Ticket::STATUS_WAITING, Ticket::STATUS_MISSED])
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();

        return $tickets->map(function ($ticket, $index) {
            return [
                'position' => $index + 1,
                'ticket' => $this->getTicketStatus($ticket),
            ];
        })->toArray();
    }

    /**
     * Rappeler un ticket
     * @param Ticket $ticket
     * @param User $agent
     */
    public function recallTicket(Ticket $ticket, User $agent): void
    {
        \DB::transaction(function () use ($ticket, $agent) {
            // Statuts qui ne peuvent pas être rappelés
            $nonRecallableStatuses = [
                Ticket::STATUS_SERVED,
                Ticket::STATUS_CANCELLED,
                Ticket::STATUS_TRANSFERRED,
            ];
            
            // Vérifier que le ticket peut être rappelé
            if (in_array($ticket->status, $nonRecallableStatuses)) {
                $statusMessages = [
                    Ticket::STATUS_SERVED => 'Les tickets déjà servis ne peuvent pas être rappelés',
                    Ticket::STATUS_CANCELLED => 'Les tickets annulés ne peuvent pas être rappelés',
                    Ticket::STATUS_TRANSFERRED => 'Les tickets transférés ne peuvent pas être rappelés',
                ];
                
                $message = $statusMessages[$ticket->status] ?? 'Ce ticket ne peut pas être rappelé';
                throw new \Exception($message);
            }
            
            // Log du rappel
            \Log::info('Ticket recall attempt', [
                'ticket_id' => $ticket->id,
                'ticket_number' => $ticket->number,
                'current_status' => $ticket->status,
                'agent_id' => $agent->id,
                'agent_name' => $agent->name,
            ]);

            // Vérifier que l'agent a accès au service du ticket
            $hasAccess = $agent->assignedCounters()
                ->where('counters.service_id', $ticket->service_id)
                ->exists();

            if (!$hasAccess) {
                throw new \Exception('Vous n\'avez pas accès à ce service');
            }

            // Trouver un guichet ouvert pour cet agent et ce service
            $counter = $agent->assignedCounters()
                ->where('counters.service_id', $ticket->service_id)
                ->where('counters.status', 'open')
                ->first();

            if (!$counter) {
                throw new \Exception('Aucun guichet ouvert disponible pour ce service');
            }

            // Rappeler le ticket
            $ticket->update([
                'status' => Ticket::STATUS_CALLED,
                'agent_id' => $agent->id,
                'counter_id' => $counter->id,
                'called_at' => now(),
            ]);

            // Mettre le guichet en statut occupé
            $counter->update(['status' => 'busy']);
        });
    }

    /**
     * Marquer un ticket comme manqué
     * @param Ticket $ticket
     * @param User $agent
     * @return bool - true si le ticket est remis en file, false s'il est annulé
     */
    public function markTicketAsMissed(Ticket $ticket, User $agent): bool
    {
        return \DB::transaction(function () use ($ticket, $agent) {
            // Vérifier que le ticket est bien appelé
            if ($ticket->status !== Ticket::STATUS_CALLED) {
                return false;
            }

            // Incrémenter le compteur de manqués
            $ticket->increment('missed_count');

            // Vérifier si le ticket a été manqué plus de 3 fois
            if ($ticket->missed_count >= 3) {
                // Annuler le ticket définitivement
                $ticket->update([
                    'status' => Ticket::STATUS_CANCELLED,
                    'counter_id' => null,
                    'agent_id' => null,
                    'called_at' => null,
                ]);

                // Libérer le guichet
                if ($ticket->counter) {
                    $ticket->counter->update(['status' => 'open']);
                }

                return false; // Ticket annulé
            }

            // Remettre le ticket en file d'attente
            $ticket->update([
                'status' => Ticket::STATUS_WAITING,
                'counter_id' => null,
                'agent_id' => null,
                'called_at' => null,
            ]);

            // Libérer le guichet
            if ($ticket->counter) {
                $ticket->counter->update(['status' => 'open']);
            }

            return true; // Ticket remis en file
        });
    }

    /**
     * Obtenir les tickets actuellement appelés pour affichage public
     */
    public function getCurrentlyCalled(int $companyId): array
    {
        return Ticket::where('company_id', $companyId)
            ->whereIn('status', [Ticket::STATUS_CALLED, Ticket::STATUS_SERVING])
            ->with(['service', 'counter', 'agent'])
            ->orderBy('called_at', 'desc')
            ->get()
            ->map(function ($ticket) {
                return [
                    'number' => $ticket->number,
                    'service' => $ticket->service?->name,
                    'counter' => $ticket->counter?->name,
                    'status' => $ticket->status,
                    'called_at' => $ticket->called_at?->toIso8601String(),
                ];
            })
            ->toArray();
    }
}
