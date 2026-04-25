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

class ClientConfirmedPresence implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;
    public $company;

    /**
     * Create a new event instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->company = $ticket->company;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('agent-dashboard.' . $this->company->id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'client.present';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'ticket_number' => $this->ticket->number,
            'ticket_status' => $this->ticket->status,
            'present_at' => $this->ticket->present_at->format('H:i:s'),
            'client_name' => $this->ticket->client_name,
            'service_name' => $this->ticket->service->name,
            'counter_name' => $this->ticket->counter?->name,
            'company_id' => $this->company->id,
            'message' => "Client {$this->ticket->client_name} a confirmé sa présence pour le ticket {$this->ticket->number}",
        ];
    }
}
