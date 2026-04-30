<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Services\NotificationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class QueuePositionNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ticket;
    protected $position;
    protected $notificationType;

    /**
     * Types de notifications progressives
     */
    const NOTIFICATION_SOON = 'soon';        // Bientôt votre tour (3 personnes devant)
    const NOTIFICATION_NEXT = 'next';       // Votre tour approche (1 personne devant)
    const NOTIFICATION_CALLED = 'called';    // Ticket appelé

    /**
     * Create a new job instance.
     */
    public function __construct(Ticket $ticket, int $position, string $notificationType)
    {
        $this->ticket = $ticket;
        $this->position = $position;
        $this->notificationType = $notificationType;
    }

    /**
     * Execute the job.
     */
    public function execute(): void
    {
        try {
            // Vérifier si le ticket est toujours valide
            if ($this->ticket->status !== 'WAITING') {
                Log::info("Ticket {$this->ticket->number} n'est plus en attente, notification annulée");
                return;
            }

            // Obtenir la position actuelle
            $currentPosition = $this->ticket->getPosition();
            
            // Vérifier si la position correspond à la notification attendue
            if (!$this->shouldSendNotification($currentPosition)) {
                Log::info("Position mismatch pour ticket {$this->ticket->number}, notification annulée");
                return;
            }

            // Envoyer la notification
            $notificationService = app(NotificationService::class);
            $message = $this->getNotificationMessage($currentPosition);
            
            // Notification SMS
            if ($this->ticket->guest_phone) {
                $notificationService->sendSMS(
                    $this->ticket->guest_phone,
                    $message
                );
            }

            // Notification Email
            if ($this->ticket->guest_email) {
                $notificationService->sendEmail(
                    $this->ticket->guest_email,
                    $this->getNotificationSubject($currentPosition),
                    $message
                );
            }

            // Marquer la notification comme envoyée
            $this->markNotificationSent();

            Log::info("Notification progressive envoyée pour ticket {$this->ticket->number} - Position: {$currentPosition}");

        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi de notification progressive pour ticket {$this->ticket->number}: " . $e->getMessage());
        }
    }

    /**
     * Vérifier si la notification doit être envoyée
     */
    private function shouldSendNotification(int $currentPosition): bool
    {
        switch ($this->notificationType) {
            case self::NOTIFICATION_SOON:
                return $currentPosition <= 3 && $currentPosition > 1;
            
            case self::NOTIFICATION_NEXT:
                return $currentPosition === 1;
            
            case self::NOTIFICATION_CALLED:
                return $this->ticket->status === 'CALLED';
            
            default:
                return false;
        }
    }

    /**
     * Obtenir le message de notification
     */
    private function getNotificationMessage(int $currentPosition): string
    {
        $companyName = $this->ticket->company->name;
        $ticketNumber = $this->ticket->number;
        $serviceName = $this->ticket->service->name;

        switch ($this->notificationType) {
            case self::NOTIFICATION_SOON:
                return "SmartQueue {$companyName}: Votre ticket {$ticketNumber} pour le service {$serviceName} sera bientôt appelé. Il reste {$currentPosition} personnes devant vous. Préparez-vous !";

            case self::NOTIFICATION_NEXT:
                return "SmartQueue {$companyName}: C'est bientôt votre tour ! Ticket {$ticketNumber} pour le service {$serviceName}. Vous êtes prochain. Restez à proximité !";

            case self::NOTIFICATION_CALLED:
                return "SmartQueue {$companyName}: VOTRE TICKET EST APPELÉ ! Ticket {$ticketNumber} pour le service {$serviceName}. Présentez-vous immédiatement au guichet.";

            default:
                return "SmartQueue {$companyName}: Mise à jour pour votre ticket {$ticketNumber}.";
        }
    }

    /**
     * Obtenir le sujet de l'email
     */
    private function getNotificationSubject(int $currentPosition): string
    {
        $companyName = $this->ticket->company->name;

        switch ($this->notificationType) {
            case self::NOTIFICATION_SOON:
                return "Bientôt votre tour - SmartQueue {$companyName}";

            case self::NOTIFICATION_NEXT:
                return "C'est bientôt votre tour ! - SmartQueue {$companyName}";

            case self::NOTIFICATION_CALLED:
                return "VOTRE TICKET EST APPELÉ - SmartQueue {$companyName}";

            default:
                return "Mise à jour SmartQueue {$companyName}";
        }
    }

    /**
     * Marquer la notification comme envoyée
     */
    private function markNotificationSent(): void
    {
        $notifications = $this->ticket->progressive_notifications ?? [];
        
        $notifications[] = [
            'type' => $this->notificationType,
            'position' => $this->position,
            'sent_at' => now()->toISOString(),
        ];

        $this->ticket->update([
            'progressive_notifications' => $notifications
        ]);
    }
}
