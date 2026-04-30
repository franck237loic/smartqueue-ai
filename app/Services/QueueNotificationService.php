<?php

namespace App\Services;

use App\Models\Ticket;
use App\Jobs\QueuePositionNotificationJob;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class QueueNotificationService
{
    /**
     * Activer les notifications progressives pour un ticket
     */
    public function enableProgressiveNotifications(Ticket $ticket): void
    {
        if (!$ticket->guest_phone && !$ticket->guest_email) {
            Log::info("Ticket {$ticket->number} n'a pas de contact, notifications progressives désactivées");
            return;
        }

        // Programmer les notifications basées sur la position actuelle
        $this->schedulePositionBasedNotifications($ticket);
    }

    /**
     * Programmer les notifications basées sur la position
     */
    private function schedulePositionBasedNotifications(Ticket $ticket): void
    {
        $currentPosition = $ticket->getPosition();
        
        if ($currentPosition <= 0) {
            return;
        }

        // Estimation du temps moyen par ticket (en minutes)
        $avgServiceTime = $ticket->service->estimated_service_time ?? 5;
        
        // Calculer quand envoyer les notifications
        $this->scheduleSoonNotification($ticket, $currentPosition, $avgServiceTime);
        $this->scheduleNextNotification($ticket, $currentPosition, $avgServiceTime);
    }

    /**
     * Programmer notification "Bientôt votre tour" (3 personnes devant)
     */
    private function scheduleSoonNotification(Ticket $ticket, int $currentPosition, int $avgServiceTime): void
    {
        if ($currentPosition <= 3) {
            // Si déjà à 3 ou moins, envoyer immédiatement
            QueuePositionNotificationJob::dispatch(
                $ticket,
                $currentPosition,
                QueuePositionNotificationJob::NOTIFICATION_SOON
            )->delay(now()->addSeconds(10));
        } else {
            // Programmer pour quand il restera 3 personnes
            $delayMinutes = ($currentPosition - 3) * $avgServiceTime;
            QueuePositionNotificationJob::dispatch(
                $ticket,
                3,
                QueuePositionNotificationJob::NOTIFICATION_SOON
            )->delay(now()->addMinutes($delayMinutes));
        }
    }

    /**
     * Programmer notification "Votre tour approche" (1 personne devant)
     */
    private function scheduleNextNotification(Ticket $ticket, int $currentPosition, int $avgServiceTime): void
    {
        if ($currentPosition <= 1) {
            // Si déjà à 1 ou moins, envoyer immédiatement
            QueuePositionNotificationJob::dispatch(
                $ticket,
                $currentPosition,
                QueuePositionNotificationJob::NOTIFICATION_NEXT
            )->delay(now()->addSeconds(30));
        } else {
            // Programmer pour quand il restera 1 personne
            $delayMinutes = ($currentPosition - 1) * $avgServiceTime;
            QueuePositionNotificationJob::dispatch(
                $ticket,
                1,
                QueuePositionNotificationJob::NOTIFICATION_NEXT
            )->delay(now()->addMinutes($delayMinutes));
        }
    }

    /**
     * Mettre à jour les notifications quand la position change
     */
    public function updateNotificationsOnPositionChange(Ticket $ticket, int $oldPosition, int $newPosition): void
    {
        if (!$ticket->guest_phone && !$ticket->guest_email) {
            return;
        }

        Log::info("Mise à jour des notifications pour ticket {$ticket->number}: position {$oldPosition} → {$newPosition}");

        // Annuler les anciennes notifications programmées
        $this->cancelScheduledNotifications($ticket);

        // Reprogrammer avec la nouvelle position
        $this->schedulePositionBasedNotifications($ticket);
    }

    /**
     * Envoyer notification quand le ticket est appelé
     */
    public function sendCalledNotification(Ticket $ticket): void
    {
        if (!$ticket->guest_phone && !$ticket->guest_email) {
            return;
        }

        QueuePositionNotificationJob::dispatch(
            $ticket,
            0,
            QueuePositionNotificationJob::NOTIFICATION_CALLED
        )->delay(now()->addSeconds(5));
    }

    /**
     * Annuler les notifications programmées pour un ticket
     */
    private function cancelScheduledNotifications(Ticket $ticket): void
    {
        // Utiliser un cache pour suivre les jobs programmés
        $cacheKey = "ticket_notifications_{$ticket->id}";
        $scheduledJobs = Cache::get($cacheKey, []);

        foreach ($scheduledJobs as $jobId) {
            // Logique pour annuler les jobs (dépend de votre queue system)
            Log::info("Annulation du job de notification {$jobId} pour ticket {$ticket->number}");
        }

        // Vider le cache
        Cache::forget($cacheKey);
    }

    /**
     * Vérifier et envoyer des notifications de rappel si nécessaire
     */
    public function checkAndSendReminderNotifications(): void
    {
        $waitingTickets = Ticket::where('status', 'WAITING')
            ->where(function($query) {
                $query->whereNotNull('guest_phone')
                      ->orWhereNotNull('guest_email');
            })
            ->with(['company', 'service'])
            ->get();

        foreach ($waitingTickets as $ticket) {
            $this->checkAndSendPositionReminder($ticket);
        }
    }

    /**
     * Vérifier si un rappel de position est nécessaire
     */
    private function checkAndSendPositionReminder(Ticket $ticket): void
    {
        $currentPosition = $ticket->getPosition();
        $notifications = $ticket->progressive_notifications ?? [];
        
        // Vérifier si une notification "soon" a déjà été envoyée
        $soonNotificationSent = collect($notifications)->contains('type', 'soon');
        
        // Si position <= 3 et pas encore de notification "soon", l'envoyer
        if ($currentPosition <= 3 && !$soonNotificationSent) {
            QueuePositionNotificationJob::dispatch(
                $ticket,
                $currentPosition,
                QueuePositionNotificationJob::NOTIFICATION_SOON
            )->delay(now()->addSeconds(10));
        }
    }
}
