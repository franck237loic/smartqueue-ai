<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\Service;
use App\Events\TicketCalled;
use App\Events\TicketUpdated;

class NotificationService
{
    /**
     * Vérifier et envoyer les notifications intelligentes
     * Top 10 → notification immédiate
     * Reste 5/3/1 → alertes
     */
    public function checkQueuePosition(Ticket $ticket): void
    {
        if (!$ticket->isWaiting()) {
            return;
        }

        $position = $ticket->getPosition();

        if ($position === null) {
            return;
        }

        // Top 10 → notification immédiate
        if ($position <= 10 && $position > 5) {
            $this->sendPositionAlert($ticket, $position, 'info');
        }
        // Reste 5 → alerte
        elseif ($position === 5) {
            $this->sendPositionAlert($ticket, $position, 'warning');
        }
        // Reste 3 → alerte
        elseif ($position === 3) {
            $this->sendPositionAlert($ticket, $position, 'urgent');
        }
        // Reste 1 → alerte critique
        elseif ($position === 1) {
            $this->sendPositionAlert($ticket, $position, 'critical');
        }
    }

    /**
     * Envoyer une alerte de position
     */
    private function sendPositionAlert(Ticket $ticket, int $position, string $level): void
    {
        // Broadcast l'événement pour mise à jour temps réel
        broadcast(new TicketUpdated($ticket, [
            'type' => 'position_alert',
            'position' => $position,
            'level' => $level,
            'message' => $this->getAlertMessage($position, $level),
        ]))->toOthers();
    }

    /**
     * Obtenir le message d'alerte selon la position
     */
    private function getAlertMessage(int $position, string $level): string
    {
        return match ($position) {
            1 => "Vous êtes le prochain ! Préparez-vous",
            3 => "Plus que 3 personnes avant vous",
            5 => "Plus que 5 personnes avant vous",
            default => "Vous êtes en position {$position}",
        };
    }

    /**
     * Notifier lors de l'appel d'un ticket
     */
    public function notifyTicketCalled(Ticket $ticket): void
    {
        broadcast(new TicketCalled($ticket))->toOthers();

        // Notification instantanée au client
        if ($ticket->client_phone) {
            // SMS configuré via le service de notification
            // Implémenter selon le fournisseur SMS choisi
        }
    }

    /**
     * Vérifier les files d'attente et envoyer les notifications périodiques
     */
    public function processQueueNotifications(Service $service): void
    {
        $tickets = $service->waitingTickets()
            ->where('created_at', '<=', now()->subMinutes(5))
            ->get();

        foreach ($tickets as $ticket) {
            $this->checkQueuePosition($ticket);
        }
    }
}
