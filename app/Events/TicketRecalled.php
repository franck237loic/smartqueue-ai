<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketRecalled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;
    public $recallCount;
    public $reason;

    /**
     * Create a new event instance.
     */
    public function __construct(Ticket $ticket, int $recallCount = 1, string $reason = 'recall')
    {
        $this->ticket = $ticket->load(['service', 'counter', 'agent', 'company']);
        $this->recallCount = $recallCount;
        $this->reason = $reason;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('ticket.' . $this->ticket->id),
            new Channel('company.' . $this->ticket->company_id),
            new Channel('service.' . $this->ticket->service_id),
            new PrivateChannel('agent-dashboard.' . $this->ticket->company_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'ticket.recalled';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'ticket' => [
                'id' => $this->ticket->id,
                'number' => $this->ticket->number,
                'client_name' => $this->ticket->client_name,
                'service' => $this->ticket->service->name,
                'counter' => $this->ticket->counter?->name,
                'agent' => $this->ticket->agent?->name,
                'called_at' => $this->ticket->called_at?->format('H:i:s'),
            ],
            'recall' => [
                'count' => $this->recallCount,
                'reason' => $this->reason,
                'is_recall' => true,
            ],
            'sound' => $this->recallCount > 1 ? 'urgent' : 'recall',
            'message' => $this->recallCount > 1 
                ? "Rappel urgent : Ticket {$this->ticket->number} ({$this->recallCount}ème appel)"
                : "Rappel : Votre tour est en cours - Ticket {$this->ticket->number}",
            'urgency' => $this->recallCount > 2 ? 'critical' : ($this->recallCount > 1 ? 'high' : 'medium'),
            'timestamp' => now()->toISOString(),
        ];
    }
}
