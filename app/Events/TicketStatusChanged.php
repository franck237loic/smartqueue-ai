<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketStatusChanged // implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Ticket $ticket;
    public string $oldStatus;
    public string $newStatus;

    /**
     * Create a new event instance.
     */
    public function __construct(Ticket $ticket, string $oldStatus, string $newStatus)
    {
        $this->ticket = $ticket->load(['service', 'counter', 'agent']);
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
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
            new Channel('ticket.' . $this->ticket->id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'ticket.status.changed';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'number' => $this->ticket->number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'service' => [
                'id' => $this->ticket->service?->id,
                'name' => $this->ticket->service?->name,
            ],
            'counter' => $this->ticket->counter ? [
                'id' => $this->ticket->counter->id,
                'name' => $this->ticket->counter->name,
                'number' => $this->ticket->counter->number,
            ] : null,
            'agent' => $this->ticket->agent ? [
                'id' => $this->ticket->agent->id,
                'name' => $this->ticket->agent->name,
            ] : null,
            'changed_at' => now()->toIso8601String(),
        ];
    }
}
