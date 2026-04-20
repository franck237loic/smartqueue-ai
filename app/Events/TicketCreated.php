<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketCreated // implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Ticket $ticket;
    public int $position;

    /**
     * Create a new event instance.
     */
    public function __construct(Ticket $ticket, int $position)
    {
        $this->ticket = $ticket->load(['service']);
        $this->position = $position;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('company.' . $this->ticket->company_id),
            new Channel('service.' . $this->ticket->service_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'ticket.created';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'ticket' => [
                'id' => $this->ticket->id,
                'number' => $this->ticket->number,
                'prefix' => $this->ticket->prefix,
                'sequence' => $this->ticket->sequence,
                'service' => [
                    'id' => $this->ticket->service?->id,
                    'name' => $this->ticket->service?->name,
                ],
                'position' => $this->position,
                'guest_name' => $this->ticket->guest_name,
                'created_at' => $this->ticket->created_at->toIso8601String(),
            ],
            'queue_length' => $this->position,
        ];
    }
}
