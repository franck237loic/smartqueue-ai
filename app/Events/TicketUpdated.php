<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketUpdated // implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Ticket $ticket;
    public array $data;

    public function __construct(Ticket $ticket, array $data = [])
    {
        $this->ticket = $ticket;
        $this->data = $data;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('company.' . $this->ticket->company_id),
            new Channel('ticket.' . $this->ticket->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'ticket.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'number' => $this->ticket->number,
            'status' => $this->ticket->status,
            'position' => $this->ticket->getPosition(),
            'data' => $this->data,
        ];
    }
}
