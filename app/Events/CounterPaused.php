<?php

namespace App\Events;

use App\Models\Counter;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CounterPaused implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $counter;
    public $agent;
    public $company;
    public $resumeTime;

    public function __construct(Counter $counter, $agent = null, $resumeTime = null)
    {
        $this->counter = $counter->load(['service', 'user', 'company']);
        $this->agent = $agent;
        $this->company = $counter->company;
        $this->resumeTime = $resumeTime;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('company.' . $this->counter->company_id),
            new Channel('service.' . $this->counter->service_id),
            new Channel('waiting-room.' . $this->counter->service_id),
            new PrivateChannel('counter.' . $this->counter->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'counter.paused';
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
                'paused_at' => $this->counter->paused_at?->format('H:i:s'),
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
            'resume_time' => $this->resumeTime ? $this->resumeTime->format('H:i') : null,
            'message' => "Guichet {$this->counter->name} en pause" . ($this->resumeTime ? " - Reprise à {$this->resumeTime->format('H:i')}" : ''),
            'timestamp' => now()->toISOString(),
            'sound' => 'counter_paused',
        ];
    }
}
