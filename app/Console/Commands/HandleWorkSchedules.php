<?php

namespace App\Console\Commands;

use App\Models\WorkSchedule;
use App\Models\Counter;
use App\Models\Company;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class HandleWorkSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'work:schedule {--force : Force update regardless of current status}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gérer automatiquement l\'ouverture/fermeture des guichets selon les horaires de travail';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Début de la gestion des horaires de travail...');
        
        $now = Carbon::now();
        $currentDay = $now->dayOfWeek; // 1 = Monday, 7 = Sunday
        $currentTime = $now->format('H:i');
        
        $this->info("Heure actuelle: {$currentTime}, Jour: {$currentDay}");
        
        // Récupérer tous les plannings actifs
        $schedules = WorkSchedule::where('is_active', true)
            ->where(function($query) use ($currentDay) {
                $query->whereRaw("FIND_IN_SET(?, working_days) > 0", [$currentDay]);
            })
            ->with(['company', 'service', 'counter', 'user'])
            ->get();
        
        $this->info("{$schedules->count()} plannings trouvés pour aujourd'hui");
        
        $openedCounters = 0;
        $closedCounters = 0;
        
        foreach ($schedules as $schedule) {
            try {
                $result = $this->processSchedule($schedule, $now, $currentTime, $currentDay);
                
                if ($result === 'opened') {
                    $openedCounters++;
                } elseif ($result === 'closed') {
                    $closedCounters++;
                }
            } catch (\Exception $e) {
                $this->error("Erreur avec le planning {$schedule->id}: {$e->getMessage()}");
                Log::error("WorkSchedule Error", [
                    'schedule_id' => $schedule->id,
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        $this->info("Traitement terminé: {$openedCounters} guichets ouverts, {$closedCounters} guichets fermés");
        
        return 0;
    }
    
    /**
     * Traiter un planning individuel
     */
    private function processSchedule(WorkSchedule $schedule, Carbon $now, string $currentTime, int $currentDay): ?string
    {
        // Convertir les heures selon le timezone du planning
        $scheduleTime = $now->copy()->setTimezone($schedule->timezone);
        $currentScheduleTime = $scheduleTime->format('H:i');
        
        $this->line("Traitement planning {$schedule->id} - {$schedule->company->name}");
        
        // Déterminer si on doit ouvrir ou fermer
        $shouldOpen = $this->shouldOpenCounter($schedule, $currentScheduleTime);
        $shouldClose = $this->shouldCloseCounter($schedule, $currentScheduleTime);
        
        if (!$shouldOpen && !$shouldClose) {
            $this->line("  -> Aucune action requise");
            return null;
        }
        
        // Récupérer les guichets concernés
        $counters = $this->getCountersForSchedule($schedule);
        
        foreach ($counters as $counter) {
            if ($shouldOpen && $counter->status !== 'open') {
                $this->openCounter($counter, $schedule);
                return 'opened';
            } elseif ($shouldClose && $counter->status !== 'closed') {
                $this->closeCounter($counter, $schedule);
                return 'closed';
            }
        }
        
        return null;
    }
    
    /**
     * Déterminer si un guichet doit être ouvert
     */
    private function shouldOpenCounter(WorkSchedule $schedule, string $currentTime): bool
    {
        // Ouverture du matin
        if ($currentTime >= $schedule->morning_start && $currentTime < $schedule->morning_end) {
            return true;
        }
        
        // Ouverture de l'après-midi
        if ($currentTime >= $schedule->afternoon_start && $currentTime < $schedule->afternoon_end) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Déterminer si un guichet doit être fermé
     */
    private function shouldCloseCounter(WorkSchedule $schedule, string $currentTime): bool
    {
        // Pause du matin
        if ($currentTime >= $schedule->morning_end && $currentTime < $schedule->afternoon_start) {
            return true;
        }
        
        // Fin de journée
        if ($currentTime >= $schedule->afternoon_end) {
            return true;
        }
        
        // Avant l'ouverture du matin
        if ($currentTime < $schedule->morning_start) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Récupérer les guichets pour un planning
     */
    private function getCountersForSchedule(WorkSchedule $schedule): \Illuminate\Database\Eloquent\Collection
    {
        if ($schedule->counter_id) {
            // Guichet spécifique
            return Counter::where('id', $schedule->counter_id)->get();
        } elseif ($schedule->service_id) {
            // Tous les guichets du service
            return Counter::where('service_id', $schedule->service_id)->get();
        } else {
            // Tous les guichets de l'entreprise
            return Counter::where('company_id', $schedule->company_id)->get();
        }
    }
    
    /**
     * Ouvrir un guichet
     */
    private function openCounter(Counter $counter, WorkSchedule $schedule): void
    {
        $counter->update(['status' => 'open']);
        
        $this->info("  ✅ Guichet '{$counter->name}' ouvert");
        
        // Log l'action
        Log::info('Counter Opened', [
            'counter_id' => $counter->id,
            'schedule_id' => $schedule->id,
            'time' => now()->format('H:i:s'),
            'reason' => 'schedule_auto_open'
        ]);
    }
    
    /**
     * Fermer un guichet
     */
    private function closeCounter(Counter $counter, WorkSchedule $schedule): void
    {
        $counter->update(['status' => 'closed']);
        
        $this->info("  🔒 Guichet '{$counter->name}' fermé");
        
        // Log l'action
        Log::info('Counter Closed', [
            'counter_id' => $counter->id,
            'schedule_id' => $schedule->id,
            'time' => now()->format('H:i:s'),
            'reason' => 'schedule_auto_close'
        ]);
    }
}
