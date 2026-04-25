<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\Service;
use App\Models\User;
use App\Events\TicketCalled;
use App\Events\TicketUpdated;
use App\Events\PlaySound;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Envoyer la notification quand un ticket est appelé
     */
    public function sendTicketCalledNotification(Ticket $ticket): void
    {
        try {
            // 1. Notification WebSocket immédiate
            broadcast(new TicketUpdated($ticket, [
                'type' => 'ticket_called',
                'message' => "Votre ticket {$ticket->number} est appelé !",
                'urgency' => 'high',
                'sound' => 'ticket-called',
            ]));

            // 2. SMS si numéro disponible
            if ($ticket->guest_phone) {
                $this->sendSMSNotification($ticket->guest_phone, $this->buildCalledMessage($ticket));
            }

            // 3. Email si disponible
            if ($ticket->guest_email) {
                $this->sendEmailNotification($ticket->guest_email, 'Votre ticket est appelé', $this->buildCalledEmailContent($ticket));
            }

            Log::info('Ticket called notification sent', ['ticket_id' => $ticket->id]);

        } catch (\Exception $e) {
            Log::error('Failed to send ticket called notification', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envoyer la pré-notification au prochain client
     */
    public function sendPreparationNotification(Ticket $ticket, array $eta): void
    {
        try {
            $message = $this->buildPreparationMessage($ticket, $eta);
            
            // Notification WebSocket
            broadcast(new TicketUpdated($ticket, [
                'type' => 'preparation_notification',
                'message' => $message,
                'eta' => $eta,
                'urgency' => 'medium',
                'sound' => 'preparation-alert',
            ]));

            // SMS
            if ($ticket->guest_phone) {
                $this->sendSMSNotification($ticket->guest_phone, $message);
            }

            Log::info('Preparation notification sent', ['ticket_id' => $ticket->id]);

        } catch (\Exception $e) {
            Log::error('Failed to send preparation notification', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envoyer la notification de position dans la queue
     */
    public function sendQueuePositionNotification(Ticket $ticket, int $position): void
    {
        try {
            $message = $this->buildPositionMessage($position);
            
            broadcast(new TicketUpdated($ticket, [
                'type' => 'queue_position',
                'position' => $position,
                'message' => $message,
                'urgency' => $this->getPositionUrgency($position),
            ]));

            // SMS pour positions critiques (1-3)
            if ($position <= 3 && $ticket->guest_phone) {
                $this->sendSMSNotification($ticket->guest_phone, $message);
            }

        } catch (\Exception $e) {
            Log::error('Failed to send queue position notification', [
                'ticket_id' => $ticket->id,
                'position' => $position,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envoyer la notification d'absence
     */
    public function sendTicketAbsentNotification(Ticket $ticket, int $missCount): void
    {
        try {
            $message = $this->buildAbsentMessage($ticket, $missCount);
            
            broadcast(new TicketUpdated($ticket, [
                'type' => 'ticket_absent',
                'message' => $message,
                'miss_count' => $missCount,
                'new_status' => 'WAITING',
                'urgency' => 'high',
                'sound' => 'ticket-absent',
            ]));

            // SMS
            if ($ticket->guest_phone) {
                $this->sendSMSNotification($ticket->guest_phone, $message);
            }

            Log::info('Ticket absent notification sent', [
                'ticket_id' => $ticket->id,
                'miss_count' => $missCount
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send ticket absent notification', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envoyer la notification d'absence à l'agent
     */
    public function sendAgentAbsenceNotification(Ticket $ticket, User $agent, int $missCount): void
    {
        try {
            $message = "Client absent pour le ticket {$ticket->number} ({$missCount}ème absence)";
            
            broadcast(new TicketUpdated($ticket, [
                'type' => 'agent_absence_alert',
                'message' => $message,
                'ticket_number' => $ticket->number,
                'miss_count' => $missCount,
                'urgency' => 'medium',
                'sound' => 'agent-alert',
            ]));

            Log::info('Agent absence notification sent', [
                'ticket_id' => $ticket->id,
                'agent_id' => $agent->id,
                'miss_count' => $missCount
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send agent absence notification', [
                'ticket_id' => $ticket->id,
                'agent_id' => $agent->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envoyer la notification d'annulation
     */
    public function sendTicketCancelledNotification(Ticket $ticket, string $reason): void
    {
        try {
            $message = $this->buildCancelledMessage($ticket, $reason);
            
            broadcast(new TicketUpdated($ticket, [
                'type' => 'ticket_cancelled',
                'message' => $message,
                'reason' => $reason,
                'urgency' => 'high',
                'sound' => 'ticket-cancelled',
            ]));

            // SMS
            if ($ticket->guest_phone) {
                $this->sendSMSNotification($ticket->guest_phone, $message);
            }

            Log::info('Ticket cancelled notification sent', [
                'ticket_id' => $ticket->id,
                'reason' => $reason
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send ticket cancelled notification', [
                'ticket_id' => $ticket->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Vérifier et envoyer les notifications intelligentes
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
     * Envoyer un SMS
     */
    private function sendSMSNotification(string $phoneNumber, string $message): void
    {
        try {
            $smsService = app(SMSService::class);
            $cleanPhone = $smsService->validatePhoneNumber($phoneNumber);
            
            $smsService->send($cleanPhone, $message);
            
        } catch (\Exception $e) {
            Log::error('SMS notification failed', [
                'phone' => $phoneNumber,
                'message' => $message,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Envoyer un email
     */
    private function sendEmailNotification(string $email, string $subject, string $content): void
    {
        try {
            Mail::raw($content, function ($message) use ($email, $subject) {
                $message->to($email)
                    ->subject($subject);
            });
        } catch (\Exception $e) {
            Log::error('Failed to send email notification', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Construire le message pour ticket appelé
     */
    private function buildCalledMessage(Ticket $ticket): string
    {
        // Générer un code de réponse si nécessaire
        if (!$ticket->client_response_code) {
            $ticket->update(['client_response_code' => $this->generateResponseCode()]);
        }
        
        $baseUrl = config('app.url', 'http://127.0.0.1:8000');
        $displayUrl = "{$baseUrl}/ticket/{$ticket->id}/display?code={$ticket->client_response_code}";
        $responseUrl = "{$baseUrl}/ticket/{$ticket->id}/respond?code={$ticket->client_response_code}";
        
        return "SmartQueue: 📢 TICKET {$ticket->number} APPELÉ! Service: {$ticket->service->name}. Présentez-vous immédiatement. Voir: {$displayUrl} Répondre: {$responseUrl}";
    }
    
    /**
     * Envoyer la notification de réponse client
     */
    public function sendClientResponseNotification(Ticket $ticket, string $response): void
    {
        try {
            $message = match($response) {
                'COMING' => "Client {$ticket->guest_name} (Ticket {$ticket->number}) confirme sa présence",
                'DELAYED' => "Client {$ticket->guest_name} (Ticket {$ticket->number}) sera en retard",
                'NOT_COMING' => "Client {$ticket->guest_name} (Ticket {$ticket->number}) ne viendra pas",
                'NEED_HELP' => "Client {$ticket->guest_name} (Ticket {$ticket->number}) a besoin d'aide",
                default => "Client {$ticket->guest_name} (Ticket {$ticket->number}) a répondu"
            };
            
            // Notification WebSocket à l'agent
            broadcast(new TicketUpdated($ticket, [
                'type' => 'client_responded',
                'message' => $message,
                'response_type' => $response,
                'urgency' => $response === 'COMING' ? 'low' : 'medium',
            ]));
            
            Log::info('Client response notification sent', [
                'ticket_id' => $ticket->id,
                'response' => $response,
                'message' => $message
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send client response notification', [
                'ticket_id' => $ticket->id,
                'response' => $response,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Générer un code de réponse unique
     */
    private function generateResponseCode(): string
    {
        return 'RESP-' . strtoupper(substr(md5(uniqid()), 0, 8));
    }

    /**
     * Construire l'email pour ticket appelé
     */
    private function buildCalledEmailContent(Ticket $ticket): string
    {
        return "Votre ticket {$ticket->number} est appelé au service {$ticket->service->name}. 
                
Merci de vous présenter immédiatement au guichet.";
    }

    /**
     * Construire le message de préparation
     */
    private function buildPreparationMessage(Ticket $ticket, array $eta): string
    {
        $etaMinutes = $eta['estimated_minutes'] ?? 'inconnu';
        return "SmartQueue: Préparez-vous, vous serez probablement le prochain appelé dans environ {$etaMinutes} minutes. Votre ticket: {$ticket->number}";
    }

    /**
     * Construire le message de position
     */
    private function buildPositionMessage(int $position): string
    {
        return match ($position) {
            1 => "Vous êtes le prochain ! Préparez-vous.",
            2 => "Plus qu'une personne avant vous.",
            3 => "Plus que 2 personnes avant vous.",
            default => "Vous êtes en position {$position}.",
        };
    }

    /**
     * Construire le message d'absence
     */
    private function buildAbsentMessage(Ticket $ticket, int $missCount): string
    {
        $message = $missCount >= 3 
            ? "Votre ticket {$ticket->number} a été annulé pour absence répétée."
            : "Votre ticket {$ticket->number} a été remis en fin de file pour absence ({$missCount}ème fois).";
            
        return "SmartQueue: {$message}";
    }

    /**
     * Construire le message d'annulation
     */
    private function buildCancelledMessage(Ticket $ticket, string $reason): string
    {
        $reasonText = match ($reason) {
            'ABSENCE_REPEATED' => 'absences répétées',
            'CLIENT_REQUEST' => 'demande du client',
            default => 'raison inconnue',
        };
        
        return "SmartQueue: Votre ticket {$ticket->number} a été annulé ({$reasonText}).";
    }

    /**
     * Obtenir le niveau d'urgence selon la position
     */
    private function getPositionUrgency(int $position): string
    {
        if ($position <= 2) return 'critical';
        if ($position <= 5) return 'high';
        if ($position <= 10) return 'medium';
        return 'low';
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
