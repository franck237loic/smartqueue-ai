<?php

namespace App\Events;

use App\Models\Counter;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CounterOpened implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $counter;
    public $agent;
    public $company;

    public function __construct(Counter $counter, $agent = null)
    {
        $this->counter = $counter->load(['service', 'user', 'company']);
        $this->agent = $agent;
        $this->company = $counter->company;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('company.' . $this->counter->company_id),
            new Channel('service.' . $this->counter->service_id),
            new PrivateChannel('counter.' . $this->counter->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'counter.opened';
    }

    public function broadcastWith(): array
    {
        return [
            'counter' => [
                'id' => $this->counter->id,
                'name' => $this->counter->name,
                'number' => $this->counter->number,
                'service' => $this->counter->service?->name,
                'location' => $this->counter->location,
                'status' => $this->counter->status,
                'opened_at' => $this->counter->opened_at?->format('H:i:s'),
            ],
            'agent' => $this->agent ? [
                'id' => $this->agent->id,
                'name' => $this->agent->name,
                'email' => $this->agent->email,
            ] : null,
            'company' => [
                'id' => $this->company->id,
                'name' => $this->company->name,
            ],
            'message' => "Guichet {$this->counter->name} ouvert",
            'timestamp' => now()->toISOString(),
            'sound' => 'counter_opened',
        ];
    }
}
