<?php

namespace App\Console\Commands;

use App\Services\NotificationService;
use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ProcessQueueNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'smartqueue:process-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process queue notifications for all active services';

    /**
     * Execute the console command.
     */
    public function handle(NotificationService $notificationService): int
    {
        $this->info('Processing queue notifications...');

        try {
            $services = Service::where('status', 'ACTIVE')->get();
            
            $processedCount = 0;
            foreach ($services as $service) {
                $notificationService->processQueueNotifications($service);
                $processedCount++;
                
                $this->line("Processed notifications for service: {$service->name}");
            }

            $this->info("Queue notifications processed for {$processedCount} services");
            Log::info('Queue notifications processed', ['services_count' => $processedCount]);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Failed to process queue notifications: ' . $e->getMessage());
            Log::error('Queue notifications processing failed', ['error' => $e->getMessage()]);
            
            return Command::FAILURE;
        }
    }
}
