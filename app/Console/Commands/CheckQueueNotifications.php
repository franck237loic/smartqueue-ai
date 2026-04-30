<?php

namespace App\Console\Commands;

use App\Services\QueueNotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckQueueNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:check-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifier et envoyer les notifications de position dans la queue';

    /**
     * Execute the console command.
     */
    public function handle(QueueNotificationService $notificationService): int
    {
        $this->info('Vérification des notifications de queue...');
        
        try {
            $notificationService->checkAndSendReminderNotifications();
            $this->info('Notifications de queue vérifiées avec succès.');
            
            Log::info('Commande queue:check-notifications exécutée avec succès');
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('Erreur lors de la vérification des notifications: ' . $e->getMessage());
            Log::error('Erreur dans queue:check-notifications: ' . $e->getMessage());
            
            return Command::FAILURE;
        }
    }
}
