<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TicketCalled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $ticket;
    public $nextTicket;
    public $estimatedWaitTime;

    /**
     * Create a new event instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket->load(['service', 'counter', 'agent', 'company']);
        
        // Calculer le prochain ticket et l'ETA
        $this->nextTicket = $this->getNextTicket($ticket);
        $this->estimatedWaitTime = $this->calculateETA($this->nextTicket);
    }

    /**
     * Obtenir le prochain ticket
     */
    private function getNextTicket(Ticket $currentTicket): ?Ticket
    {
        return $currentTicket->service->tickets()
            ->where('status', 'WAITING')
            ->where('company_id', $currentTicket->company_id)
            ->orderBy('created_at', 'asc')
            ->first();
    }

    /**
     * Calculer le temps d'attente estimé
     */
    private function calculateETA(?Ticket $ticket): ?int
    {
        if (!$ticket) return null;
        
        // Simple calcul : 5 minutes par ticket en attente
        $waitingCount = $ticket->service->tickets()
            ->where('status', 'WAITING')
            ->where('created_at', '<', $ticket->created_at)
            ->count();
            
        return $waitingCount * 5; // minutes
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
            new PrivateChannel('ticket.' . $this->ticket->id),
            new Channel('service.' . $this->ticket->service_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'ticket.called';
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
            'next_ticket' => $this->nextTicket ? [
                'id' => $this->nextTicket->id,
                'number' => $this->nextTicket->number,
                'eta' => $this->estimatedWaitTime,
            ] : null,
            'estimated_wait_time' => $this->estimatedWaitTime,
            'sound' => 'call',
            'message' => "Ticket {$this->ticket->number} appelé au {$this->ticket->counter?->name}",
            'timestamp' => now()->toISOString(),
        ];
    }
}
