<?php

namespace App\Services;

use App\Models\Queue;
use App\Models\Ticket;
use Carbon\Carbon;

class AIEstimationService
{
    public function estimateWaitTime(Queue $queue, ?Ticket $ticket = null): int
    {
        $waitingCount = $queue->waitingTickets()->count();

        if ($ticket) {
            $position = $ticket->getPosition() ?? $waitingCount;
        } else {
            $position = $waitingCount + 1;
        }

        $baseEstimate = $position * $queue->estimated_service_time;

        $historicalAvg = $this->getHistoricalAverageServiceTime($queue);
        $hourlyFactor = $this->getHourlyFactor($queue);
        $dayOfWeekFactor = $this->getDayOfWeekFactor($queue);

        if ($historicalAvg) {
            $baseEstimate = $position * (($queue->estimated_service_time + $historicalAvg) / 2);
        }

        $adjustedEstimate = $baseEstimate * $hourlyFactor * $dayOfWeekFactor;

        return max(1, ceil($adjustedEstimate));
    }

    public function getHistoricalAverageServiceTime(Queue $queue): ?float
    {
        return Ticket::where('queue_id', $queue->id)
            ->whereNotNull('actual_service_time')
            ->where('created_at', '>=', now()->subDays(30))
            ->avg('actual_service_time');
    }

    public function getHourlyFactor(Queue $queue): float
    {
        $hour = now()->hour;

        $hourlyStats = Ticket::where('queue_id', $queue->id)
            ->whereNotNull('actual_service_time')
            ->whereRaw('HOUR(called_at) = ?', [$hour])
            ->where('created_at', '>=', now()->subDays(14))
            ->avg('actual_service_time');

        if (!$hourlyStats) {
            return 1.0;
        }

        $baseAvg = $this->getHistoricalAverageServiceTime($queue) ?? $queue->estimated_service_time;

        return $hourlyStats / $baseAvg;
    }

    public function getDayOfWeekFactor(Queue $queue): float
    {
        $dayOfWeek = now()->dayOfWeek;

        $dayStats = Ticket::where('queue_id', $queue->id)
            ->whereNotNull('actual_service_time')
            ->whereRaw('DAYOFWEEK(called_at) = ?', [$dayOfWeek + 1])
            ->where('created_at', '>=', now()->subWeeks(4))
            ->avg('actual_service_time');

        if (!$dayStats) {
            return 1.0;
        }

        $baseAvg = $this->getHistoricalAverageServiceTime($queue) ?? $queue->estimated_service_time;

        return $dayStats / $baseAvg;
    }

    public function predictPeakHours(Queue $queue): array
    {
        $predictions = [];

        for ($hour = 8; $hour <= 18; $hour++) {
            $ticketCount = Ticket::where('queue_id', $queue->id)
                ->whereRaw('HOUR(created_at) = ?', [$hour])
                ->where('created_at', '>=', now()->subDays(30))
                ->count();

            $avgServiceTime = Ticket::where('queue_id', $queue->id)
                ->whereNotNull('actual_service_time')
                ->whereRaw('HOUR(called_at) = ?', [$hour])
                ->where('created_at', '>=', now()->subDays(30))
                ->avg('actual_service_time') ?? $queue->estimated_service_time;

            $predictions[$hour] = [
                'hour' => $hour,
                'predicted_tickets' => ceil($ticketCount / 30),
                'predicted_wait_multiplier' => $avgServiceTime / $queue->estimated_service_time,
            ];
        }

        return $predictions;
    }

    public function getQueueAnalytics(Queue $queue): array
    {
        $now = now();
        $weekAgo = $now->copy()->subWeek();
        $monthAgo = $now->copy()->subMonth();

        return [
            'avg_service_time' => $this->getHistoricalAverageServiceTime($queue),
            'peak_hours' => $this->predictPeakHours($queue),
            'tickets_last_week' => Ticket::where('queue_id', $queue->id)
                ->whereBetween('created_at', [$weekAgo, $now])
                ->count(),
            'tickets_last_month' => Ticket::where('queue_id', $queue->id)
                ->whereBetween('created_at', [$monthAgo, $now])
                ->count(),
            'satisfaction_estimate' => $this->estimateSatisfaction($queue),
        ];
    }

    private function estimateSatisfaction(Queue $queue): string
    {
        $avgWait = Ticket::where('queue_id', $queue->id)
            ->whereNotNull('called_at')
            ->where('created_at', '>=', now()->subWeek())
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, called_at)) as wait')
            ->value('wait') ?? 0;

        $avgService = $this->getHistoricalAverageServiceTime($queue) ?? $queue->estimated_service_time;

        $score = 100 - ($avgWait * 2) - ($avgService * 0.5);

        return match (true) {
            $score >= 80 => 'excellent',
            $score >= 60 => 'good',
            $score >= 40 => 'average',
            default => 'needs_improvement',
        };
    }
}
