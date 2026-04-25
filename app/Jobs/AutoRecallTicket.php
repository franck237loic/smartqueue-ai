<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Events\TicketRecalled;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class AutoRecallTicket implements ShouldQueue
{
    use Queueable;

    public $ticket;
    public $recallCount;

    /**
     * Create a new job instance.
     */
    public function __construct(Ticket $ticket, int $recallCount = 1)
    {
        $this->ticket = $ticket;
        $this->recallCount = $recallCount;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Vérifier que le ticket est toujours appelé
            if ($this->ticket->status !== 'CALLED') {
                Log::info('Ticket ' . $this->ticket->id . ' n\'est plus appelé, annulation du rappel');
                return;
            }

            // Vérifier que le client n'a pas confirmé sa présence
            if ($this->ticket->status === 'PRESENT') {
                Log::info('Ticket ' . $this->ticket->id . ' déjà présent, annulation du rappel');
                return;
            }

            // Incrémenter le compteur de rappels
            $this->ticket->recall_count = $this->recallCount;
            $this->ticket->save();

            // Déclencher l'event de rappel
            event(new TicketRecalled($this->ticket, $this->recallCount, 'auto-recall'));

            Log::info('Rappel automatique effectué pour le ticket ' . $this->ticket->id . ' (rappel #' . $this->recallCount . ')');

            // Programmer le prochain rappel si nécessaire (max 3 rappels)
            if ($this->recallCount < 3) {
                $nextDelay = $this->recallCount === 1 ? 120 : 180; // 2min puis 3min
                self::dispatch($this->ticket, $this->recallCount + 1)
                    ->delay(now()->addSeconds($nextDelay));
            } else {
                // Après 3 rappels, marquer comme manqué
                $this->ticket->status = 'MISSED_TEMP';
                $this->ticket->missed_at = now();
                $this->ticket->save();

                // Remettre en file ou annuler selon le nombre d'absences
                $this->handleMissedTicket();
            }

        } catch (\Exception $e) {
            Log::error('Erreur lors du rappel automatique du ticket ' . $this->ticket->id . ': ' . $e->getMessage());
        }
    }

    /**
     * Gérer un ticket manqué après 3 rappels
     */
    private function handleMissedTicket(): void
    {
        $missedCount = $this->ticket->missed_count ?? 0;
        $missedCount++;

        if ($missedCount >= 3) {
            // Annuler le ticket après 3 absences
            $this->ticket->status = 'CANCELLED';
            $this->ticket->cancelled_at = now();
            $this->ticket->cancelled_reason = '3 absences consécutives';
            Log::info('Ticket ' . $this->ticket->id . ' annulé après 3 absences');
        } else {
            // Remettre en file d'attente
            $this->ticket->status = 'WAITING';
            $this->ticket->called_at = null;
            $this->ticket->counter_id = null;
            $this->ticket->agent_id = null;
            $this->ticket->missed_count = $missedCount;
            Log::info('Ticket ' . $this->ticket->id . ' remis en file (absence #' . $missedCount . ')');
        }

        $this->ticket->save();
    }
}
