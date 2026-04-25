<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CleanupOldTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smartqueue:cleanup-old-tickets {--days=30 : Number of days to keep old tickets}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old cancelled tickets from the database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $days = $this->option('days');
        $this->info("Cleaning up tickets older than {$days} days...");

        try {
            $cutoffDate = Carbon::now()->subDays($days);
            
            // Supprimer les tickets annulés ou supprimés (soft deletes)
            $deletedCount = Ticket::onlyTrashed()
                ->where('deleted_at', '<', $cutoffDate)
                ->forceDelete();
            
            // Supprimer définitivement les tickets annulés très anciens
            $cancelledCount = Ticket::where('status', 'CANCELLED')
                ->where('cancelled_at', '<', $cutoffDate)
                ->delete();

            $totalCount = $deletedCount + $cancelledCount;

            $this->info("Cleaned up {$totalCount} old tickets ({$deletedCount} deleted, {$cancelledCount} cancelled)");
            Log::info('Old tickets cleaned up', [
                'days' => $days,
                'deleted_count' => $deletedCount,
                'cancelled_count' => $cancelledCount,
                'total_count' => $totalCount
            ]);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Failed to cleanup old tickets: ' . $e->getMessage());
            Log::error('Old tickets cleanup failed', ['error' => $e->getMessage()]);
            
            return Command::FAILURE;
        }
    }
}
