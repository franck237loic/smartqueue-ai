<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class PlaySound implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $soundType;
    public $companyId;
    public $ticketId;

    /**
     * Create a new event instance.
     */
    public function __construct(string $soundType, int $companyId, ?int $ticketId = null)
    {
        $this->soundType = $soundType;
        $this->companyId = $companyId;
        $this->ticketId = $ticketId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('company.' . $this->companyId),
            new Channel('sounds.' . $this->companyId),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'sound.play';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'sound_type' => $this->soundType,
            'company_id' => $this->companyId,
            'ticket_id' => $this->ticketId,
            'timestamp' => now()->toISOString(),
        ];
    }
}
