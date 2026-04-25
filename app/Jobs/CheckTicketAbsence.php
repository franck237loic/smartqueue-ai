<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Services\NotificationService;
use App\Services\WebSocketService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckTicketAbsence implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $ticket;

    /**
     * Create a new job instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     */
    public function handle(NotificationService $notificationService, WebSocketService $webSocketService): void
    {
        try {
            // Recharger le ticket pour obtenir l'état actuel
            $ticket = Ticket::find($this->ticket->id);
            
            if (!$ticket || $ticket->status !== 'CALLED') {
                Log::info('Ticket absence check skipped - ticket not in CALLED status', [
                    'ticket_id' => $this->ticket->id,
                    'status' => $ticket?->status
                ]);
                return;
            }

            // Vérifier si le client est présent (si le statut a changé en PRESENT)
            if ($ticket->status === 'PRESENT') {
                Log::info('Ticket marked as present - absence check cancelled', [
                    'ticket_id' => $ticket->id
                ]);
                return;
            }

            // Marquer comme absent et remettre en fin de queue
            $this->markAsAbsentAndRequeue($ticket, $notificationService, $webSocketService);

        } catch (\Exception $e) {
            Log::error('Failed to check ticket absence', [
                'ticket_id' => $this->ticket->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Marquer le ticket comme absent et le remettre en fin de queue
     */
    private function markAsAbsentAndRequeue(
        Ticket $ticket, 
        NotificationService $notificationService, 
        WebSocketService $webSocketService
    ): void {
        // Incrémenter le compteur d'absences
        $newMissCount = ($ticket->missed_count ?? 0) + 1;
        
        // Vérifier si c'est la 3ème absence
        if ($newMissCount >= 3) {
            $this->handleThirdAbsence($ticket, $notificationService, $webSocketService);
            return;
        }

        // Remettre en fin de queue
        $ticket->update([
            'status' => 'WAITING',
            'missed_count' => $newMissCount,
            'missed_at' => now(),
            'agent_id' => null,
            'counter_id' => null,
            'called_at' => null,
        ]);

        // Réassigner une nouvelle position
        $lastSequence = $ticket->service->tickets()
            ->whereDate('created_at', today())
            ->max('sequence') ?? 0;
        
        $ticket->update(['sequence' => $lastSequence + 1]);

        // Envoyer les notifications
        $this->sendAbsenceNotifications($ticket, $notificationService, $webSocketService, $newMissCount);
    }

    /**
     * Gérer la 3ème absence - suppression du ticket
     */
    private function handleThirdAbsence(
        Ticket $ticket, 
        NotificationService $notificationService, 
        WebSocketService $webSocketService
    ): void {
        // Marquer comme annulé pour absence répétée
        $ticket->update([
            'status' => 'CANCELLED',
            'missed_count' => 3,
            'missed_at' => now(),
            'cancellation_reason' => 'ABSENCE_REPEATED',
            'cancelled_at' => now(),
        ]);

        // Notifications spéciales pour suppression
        $notificationService->sendTicketCancelledNotification($ticket, 'ABSENCE_REPEATED');
        $webSocketService->broadcastTicketCancelled($ticket, 'ABSENCE_REPEATED');

        Log::info('Ticket cancelled after 3 absences', [
            'ticket_id' => $ticket->id,
            'ticket_number' => $ticket->number
        ]);
    }

    /**
     * Envoyer les notifications d'absence
     */
    private function sendAbsenceNotifications(
        Ticket $ticket, 
        NotificationService $notificationService, 
        WebSocketService $webSocketService,
        int $missCount
    ): void {
        // Notification au client
        $notificationService->sendTicketAbsentNotification($ticket, $missCount);

        // Notification à l'agent
        if ($ticket->agent) {
            $notificationService->sendAgentAbsenceNotification($ticket, $ticket->agent, $missCount);
        }

        // Notification WebSocket pour mise à jour en temps réel
        $webSocketService->broadcastTicketAbsent($ticket, $missCount);

        // Sonnerie d'absence
        broadcast(new \App\Events\PlaySound('ticket-absent', $ticket->company_id, $ticket->id));

        Log::info('Ticket marked as absent and requeued', [
            'ticket_id' => $ticket->id,
            'miss_count' => $missCount,
            'new_sequence' => $ticket->sequence
        ]);
    }
}
