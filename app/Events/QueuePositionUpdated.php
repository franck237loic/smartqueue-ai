<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QueuePositionUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;
    public $oldPosition;
    public $newPosition;
    public $estimatedWaitTime;

    /**
     * Create a new event instance.
     */
    public function __construct(Ticket $ticket, int $oldPosition, int $newPosition, ?int $estimatedWaitTime = null)
    {
        $this->ticket = $ticket->load(['service', 'company']);
        $this->oldPosition = $oldPosition;
        $this->newPosition = $newPosition;
        $this->estimatedWaitTime = $estimatedWaitTime ?? $this->calculateETA($ticket);
    }

    /**
     * Calculer le temps d'attente estimé
     */
    private function calculateETA(Ticket $ticket): int
    {
        // 5 minutes par position en attente
        return ($this->newPosition - 1) * 5;
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
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'queue.position.updated';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        $isAdvancing = $this->newPosition < $this->oldPosition;
        
        return [
            'ticket' => [
                'id' => $this->ticket->id,
                'number' => $this->ticket->number,
                'client_name' => $this->ticket->client_name,
                'service' => $this->ticket->service->name,
            ],
            'position' => [
                'old' => $this->oldPosition,
                'new' => $this->newPosition,
                'advancing' => $isAdvancing,
                'difference' => $this->oldPosition - $this->newPosition,
            ],
            'estimated_wait_time' => $this->estimatedWaitTime,
            'sound' => $isAdvancing ? 'notification' : null,
            'message' => $isAdvancing 
                ? "Votre numéro avance! Position: {$this->newPosition}" 
                : "Position mise à jour: {$this->newPosition}",
            'urgency' => $this->newPosition <= 3 ? 'high' : ($this->newPosition <= 5 ? 'medium' : 'low'),
            'timestamp' => now()->toISOString(),
        ];
    }
}
