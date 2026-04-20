<?php

namespace App\Services;

use App\Models\Queue;
use App\Models\Ticket;
use App\Models\User;

class QueueService
{
    public function createQueue(User $admin, array $data): Queue
    {
        return Queue::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'prefix' => $data['prefix'] ?? 'A',
            'current_number' => 0,
            'status' => $data['status'] ?? 'active',
            'user_id' => $admin->id,
            'estimated_service_time' => $data['estimated_service_time'] ?? 5,
            'missed_timeout' => $data['missed_timeout'] ?? 3,
        ]);
    }

    public function updateQueue(Queue $queue, array $data): Queue
    {
        $queue->update($data);
        return $queue->fresh();
    }

    public function deleteQueue(Queue $queue): void
    {
        $queue->delete();
    }

    public function activateQueue(Queue $queue): Queue
    {
        $queue->status = 'active';
        $queue->save();
        return $queue;
    }

    public function pauseQueue(Queue $queue): Queue
    {
        $queue->status = 'paused';
        $queue->save();
        return $queue;
    }

    public function closeQueue(Queue $queue): Queue
    {
        $queue->status = 'closed';
        $queue->save();
        return $queue;
    }

    public function getQueueStats(Queue $queue): array
    {
        $today = now()->startOfDay();

        return [
            'id' => $queue->id,
            'name' => $queue->name,
            'status' => $queue->status,
            'waiting' => $queue->waitingTickets()->count(),
            'called' => $queue->calledTickets()->count(),
            'served' => $queue->servedTickets()->whereDate('tickets.created_at', $today)->count(),
            'missed' => $queue->missedTickets()->whereDate('tickets.created_at', $today)->count(),
            'avg_service_time' => $this->calculateAverageServiceTime($queue),
            'total_today' => Ticket::where('queue_id', $queue->id)
                ->whereDate('created_at', $today)
                ->count(),
        ];
    }

    public function getActiveTickets(Queue $queue): array
    {
        return [
            'waiting' => $queue->waitingTickets()->limit(20)->get(),
            'called' => $queue->calledTickets()->with('agent')->get(),
            'current' => $queue->calledTickets()->with('agent')->first(),
        ];
    }

    public function calculateAverageServiceTime(Queue $queue): ?float
    {
        return Ticket::where('queue_id', $queue->id)
            ->whereNotNull('actual_service_time')
            ->where('created_at', '>=', now()->subDays(7))
            ->avg('actual_service_time');
    }

    public function getGlobalStats(): array
    {
        $today = now()->startOfDay();

        return [
            'total_queues' => Queue::count(),
            'active_queues' => Queue::where('status', 'active')->count(),
            'total_tickets_today' => Ticket::whereDate('created_at', $today)->count(),
            'served_today' => Ticket::where('status', 'served')->whereDate('served_at', $today)->count(),
            'waiting_now' => Ticket::where('status', 'waiting')->count(),
            'avg_wait_time' => Ticket::where('status', 'served')
                ->whereDate('served_at', $today)
                ->whereNotNull('called_at')
                ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, tickets.created_at, tickets.called_at)) as avg_wait')
                ->value('avg_wait') ?? 0,
        ];
    }
}
