<?php

namespace App\Console\Commands;

use App\Models\Counter;
use App\Models\WorkSchedule;
use App\Events\CounterOpened;
use App\Events\CounterClosed;
use App\Events\CounterPaused;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AutoManageCounters extends Command
{
    protected $signature = 'smartqueue:auto-manage-counters';
    protected $description = 'Automatically manage counters based on work schedules';

    public function handle(): int
    {
        $now = now();
        $managedCounters = 0;
        $errors = 0;

        try {
            // Récupérer tous les plannings actifs
            $schedules = WorkSchedule::active()
                ->with(['counter', 'service', 'company'])
                ->get();

            Log::info('AutoManageCounters: Processing schedules', [
                'schedules_count' => $schedules->count(),
                'timestamp' => $now->toISOString()
            ]);

            foreach ($schedules as $schedule) {
                try {
                    $this->manageCounterSchedule($schedule, $now);
                    $managedCounters++;
                } catch (\Exception $e) {
                    $errors++;
                    Log::error('AutoManageCounters: Error managing counter', [
                        'schedule_id' => $schedule->id,
                        'counter_id' => $schedule->counter_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            // Gérer les guichets sans planning (mettre offline)
            $this->manageOrphanedCounters($now);

            Log::info('AutoManageCounters: Completed', [
                'managed_counters' => $managedCounters,
                'errors' => $errors,
                'timestamp' => $now->toISOString()
            ]);

            return 0;

        } catch (\Exception $e) {
            Log::error('AutoManageCounters: Critical error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }
    }

    private function manageCounterSchedule(WorkSchedule $schedule, Carbon $now): void
    {
        if (!$schedule->counter_id || !$schedule->isActiveToday()) {
            return;
        }

        $counter = $schedule->counter;
        if (!$counter) {
            return;
        }

        // Logique d'ouverture automatique
        if ($schedule->shouldOpenNow() && !$counter->isOpen()) {
            // Vérifier si un ticket est en cours
            $currentTicket = $counter->currentTicket();
            if ($currentTicket) {
                Log::info('AutoManageCounters: Skipping open - ticket in progress', [
                    'counter_id' => $counter->id,
                    'ticket_id' => $currentTicket->id
                ]);
                return;
            }

            $counter->open();
            event(new CounterOpened($counter, null, 'schedule'));
            
            Log::info('AutoManageCounters: Counter opened', [
                'counter_id' => $counter->id,
                'counter_name' => $counter->name,
                'schedule_id' => $schedule->id,
                'time' => $now->format('H:i:s')
            ]);
        }

        // Logique de fermeture automatique (pause déjeuner)
        if ($schedule->shouldCloseNow() && $counter->isOpen()) {
            // Vérifier si un ticket est en cours
            $currentTicket = $counter->currentTicket();
            if ($currentTicket) {
                // Ne pas fermer brutalement, mettre en pause
                $counter->pause();
                $resumeTime = $schedule->getNextOpenTime();
                event(new CounterPaused($counter, null, $resumeTime));
                
                Log::info('AutoManageCounters: Counter paused (ticket in progress)', [
                    'counter_id' => $counter->id,
                    'counter_name' => $counter->name,
                    'ticket_id' => $currentTicket->id,
                    'resume_time' => $resumeTime ? $resumeTime->format('H:i') : null
                ]);
            } else {
                // Fermeture normale
                $counter->close();
                event(new CounterClosed($counter, null, 'schedule'));
                
                Log::info('AutoManageCounters: Counter closed', [
                    'counter_id' => $counter->id,
                    'counter_name' => $counter->name,
                    'schedule_id' => $schedule->id,
                    'time' => $now->format('H:i:s')
                ]);
            }
        }

        // Logique de reprise automatique (après pause déjeuner)
        if ($schedule->isInAfternoonHours() && $counter->isPaused()) {
            $counter->resume();
            event(new CounterOpened($counter, null, 'schedule'));
            
            Log::info('AutoManageCounters: Counter resumed', [
                'counter_id' => $counter->id,
                'counter_name' => $counter->name,
                'schedule_id' => $schedule->id,
                'time' => $now->format('H:i:s')
            ]);
        }

        // Logique de fermeture fin de journée
        if (!$schedule->isInWorkingHours() && $counter->isOpen()) {
            $currentTicket = $counter->currentTicket();
            if ($currentTicket) {
                // Fermeture douce après fin du ticket
                $counter->autoClose();
                event(new CounterClosed($counter, null, 'auto'));
                
                Log::info('AutoManageCounters: Counter auto-closed (end of day)', [
                    'counter_id' => $counter->id,
                    'counter_name' => $counter->name,
                    'ticket_id' => $currentTicket->id,
                    'time' => $now->format('H:i:s')
                ]);
            } else {
                $counter->close();
                event(new CounterClosed($counter, null, 'schedule'));
                
                Log::info('AutoManageCounters: Counter closed (end of day)', [
                    'counter_id' => $counter->id,
                    'counter_name' => $counter->name,
                    'schedule_id' => $schedule->id,
                    'time' => $now->format('H:i:s')
                ]);
            }
        }
    }

    private function manageOrphanedCounters(Carbon $now): void
    {
        // Récupérer les guichets qui n'ont pas de planning actif
        $orphanedCounters = Counter::whereDoesntHave('workSchedules', function ($query) {
            $query->where('is_active', true);
        })->where('status', '!=', 'offline')->get();

        foreach ($orphanedCounters as $counter) {
            // Mettre en offline s'il n'y a pas de planning
            $counter->setOffline();
            
            Log::info('AutoManageCounters: Counter set offline (no schedule)', [
                'counter_id' => $counter->id,
                'counter_name' => $counter->name,
                'time' => $now->format('H:i:s')
            ]);
        }
    }
}
