<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Exécuter la gestion des horaires toutes les minutes
        $schedule->command('work:schedule')
                 ->everyMinute()
                 ->withoutOverlapping()
                 ->runInBackground()
                 ->appendOutputTo(storage_path('logs/work-schedule.log'))
                 ->description('Gérer automatiquement l\'ouverture/fermeture des guichets selon les horaires');
        
        // Nettoyer les logs hebdomadairement
        $schedule->command('log:clear --keep=7')
                 ->weekly()
                 ->sundays()
                 ->at('02:00');
        
        // Backup quotidien (optionnel)
        $schedule->command('backup:run')
                 ->daily()
                 ->at('01:00')
                 ->when(function () {
                     return app()->environment('production');
                 });
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
