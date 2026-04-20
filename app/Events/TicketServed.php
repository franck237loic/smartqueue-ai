<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketServed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket->load(['service', 'counter', 'agent']);
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('company.' . $this->ticket->company_id),
            new Channel('public.display.' . $this->ticket->company_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'ticket.served';
    }

    public function broadcastWith(): array
    {
        return [
            'ticket' => [
                'id' => $this->ticket->id,
                'number' => $this->ticket->number,
                'service' => $this->ticket->service?->name,
                'counter' => $this->ticket->counter?->name,
                'served_at' => $this->ticket->served_at?->toIso8601String(),
            ],
        ];
    }
}
