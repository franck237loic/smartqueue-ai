<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketTimeout implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;
    public $timeoutReason;

    /**
     * Create a new event instance.
     */
    public function __construct(Ticket $ticket, string $timeoutReason = 'no_response')
    {
        $this->ticket = $ticket->load(['service', 'company']);
        $this->timeoutReason = $timeoutReason;
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
            new PrivateChannel('agent-dashboard.' . $this->ticket->company_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'ticket.timeout';
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
            ],
            'timeout' => [
                'reason' => $this->timeoutReason,
                'message' => 'Vous n\'avez pas répondu, votre ticket a été replacé dans la file',
                'new_position' => $this->getNewPosition(),
            ],
            'action' => 'stop_call_sound',
            'timestamp' => now()->toISOString(),
        ];
    }

    /**
     * Obtenir la nouvelle position dans la file
     */
    private function getNewPosition(): int
    {
        return $this->ticket->service->tickets()
            ->where('status', 'WAITING')
            ->where('company_id', $this->ticket->company_id)
            ->where('created_at', '>', $this->ticket->created_at)
            ->count() + 1;
    }
}
