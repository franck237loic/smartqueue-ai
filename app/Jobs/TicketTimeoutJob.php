<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Events\TicketTimeout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class TicketTimeoutJob implements ShouldQueue
{
    use Queueable;

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
    public function handle(): void
    {
        try {
            // Vérifier que le ticket est toujours appelé
            if ($this->ticket->fresh()->status !== 'CALLED') {
                Log::info('Ticket ' . $this->ticket->id . ' n\'est plus appelé, timeout annulé');
                return;
            }

            // Vérifier que le client n'a pas confirmé sa présence
            if ($this->ticket->fresh()->status === 'PRESENT') {
                Log::info('Ticket ' . $this->ticket->id . ' déjà présent, timeout annulé');
                return;
            }

            // Marquer le ticket comme manqué temporairement
            $this->ticket->status = 'MISSED_TEMP';
            $this->ticket->missed_at = now();
            
            // Incrémenter le compteur d'absences
            $missedCount = $this->ticket->missed_count ?? 0;
            $missedCount++;
            $this->ticket->missed_count = $missedCount;
            
            // Remettre en file ou annuler selon le nombre d'absences
            if ($missedCount >= 3) {
                $this->cancelTicket();
            } else {
                $this->requeueTicket();
            }

            $this->ticket->save();

            // Déclencher l'event timeout
            event(new TicketTimeout($this->ticket, 'no_response'));

            Log::info('Timeout traité pour le ticket ' . $this->ticket->id . ' (absence #' . $missedCount . ')');

        } catch (\Exception $e) {
            Log::error('Erreur lors du timeout du ticket ' . $this->ticket->id . ': ' . $e->getMessage());
        }
    }

    /**
     * Annuler le ticket après 3 absences
     */
    private function cancelTicket(): void
    {
        $this->ticket->status = 'CANCELLED';
        $this->ticket->cancelled_at = now();
        $this->ticket->cancelled_reason = '3 absences consécutives (timeout)';
        
        Log::info('Ticket ' . $this->ticket->id . ' annulé après 3 absences');
    }

    /**
     * Remettre le ticket en file d'attente
     */
    private function requeueTicket(): void
    {
        // Remettre au fond de la file
        $this->ticket->status = 'WAITING';
        $this->ticket->called_at = null;
        $this->ticket->present_at = null;
        $this->ticket->counter_id = null;
        $this->ticket->agent_id = null;
        $this->ticket->recall_count = 0;
        
        // Mettre la date de création à maintenant pour le placer au fond
        $this->ticket->created_at = now();
        
        Log::info('Ticket ' . $this->ticket->id . ' remis en file (absence #' . $this->ticket->missed_count . ')');
    }
}
