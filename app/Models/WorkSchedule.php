<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class WorkSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'service_id',
        'counter_id',
        'user_id',
        'morning_start',
        'morning_end',
        'afternoon_start',
        'afternoon_end',
        'working_days',
        'is_active',
        'timezone',
        'notes',
    ];

    protected $casts = [
        'working_days' => 'array',
        'is_active' => 'boolean',
        'morning_start' => 'datetime:H:i:s',
        'morning_end' => 'datetime:H:i:s',
        'afternoon_start' => 'datetime:H:i:s',
        'afternoon_end' => 'datetime:H:i:s',
    ];

    // Relations
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function counter(): BelongsTo
    {
        return $this->belongsTo(Counter::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public function isActiveToday(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $today = now()->setTimezone($this->timezone);
        $dayOfWeek = $today->dayOfWeek; // 1 = Monday, 7 = Sunday

        return in_array($dayOfWeek, $this->working_days);
    }

    public function isInMorningHours(): bool
    {
        if (!$this->isActiveToday()) {
            return false;
        }

        $now = now()->setTimezone($this->timezone);
        $morningStart = $now->copy()->setTimeFromTimeString($this->morning_start);
        $morningEnd = $now->copy()->setTimeFromTimeString($this->morning_end);

        return $now->between($morningStart, $morningEnd);
    }

    public function isInAfternoonHours(): bool
    {
        if (!$this->isActiveToday()) {
            return false;
        }

        $now = now()->setTimezone($this->timezone);
        $afternoonStart = $now->copy()->setTimeFromTimeString($this->afternoon_start);
        $afternoonEnd = $now->copy()->setTimeFromTimeString($this->afternoon_end);

        return $now->between($afternoonStart, $afternoonEnd);
    }

    public function isInWorkingHours(): bool
    {
        return $this->isInMorningHours() || $this->isInAfternoonHours();
    }

    public function shouldOpenNow(): bool
    {
        if (!$this->isActiveToday()) {
            return false;
        }

        $now = now()->setTimezone($this->timezone);
        
        // Check if it's exactly opening time
        $morningStart = $now->copy()->setTimeFromTimeString($this->morning_start);
        $afternoonStart = $now->copy()->setTimeFromTimeString($this->afternoon_start);

        return $now->format('H:i') === $morningStart->format('H:i') || 
               $now->format('H:i') === $afternoonStart->format('H:i');
    }

    public function shouldCloseNow(): bool
    {
        if (!$this->isActiveToday()) {
            return false;
        }

        $now = now()->setTimezone($this->timezone);
        
        // Check if it's exactly closing time
        $morningEnd = $now->copy()->setTimeFromTimeString($this->morning_end);
        $afternoonEnd = $now->copy()->setTimeFromTimeString($this->afternoon_end);

        return $now->format('H:i') === $morningEnd->format('H:i') || 
               $now->format('H:i') === $afternoonEnd->format('H:i');
    }

    public function getNextOpenTime(): ?Carbon
    {
        if (!$this->isActiveToday()) {
            return null;
        }

        $now = now()->setTimezone($this->timezone);
        
        // If we're in morning, check afternoon
        if ($this->isInMorningHours()) {
            return $now->copy()->setTimeFromTimeString($this->afternoon_start);
        }
        
        // If we're before morning, return morning start
        if ($now->format('H:i') < $this->morning_start) {
            return $now->copy()->setTimeFromTimeString($this->morning_start);
        }
        
        // If we're between morning and afternoon, return afternoon start
        if ($now->format('H:i') >= $this->morning_end && $now->format('H:i') < $this->afternoon_start) {
            return $now->copy()->setTimeFromTimeString($this->afternoon_start);
        }
        
        return null; // Already past working hours
    }

    public function getNextCloseTime(): ?Carbon
    {
        if (!$this->isActiveToday()) {
            return null;
        }

        $now = now()->setTimezone($this->timezone);
        
        // If we're in morning, return morning end
        if ($this->isInMorningHours()) {
            return $now->copy()->setTimeFromTimeString($this->morning_end);
        }
        
        // If we're in afternoon, return afternoon end
        if ($this->isInAfternoonHours()) {
            return $now->copy()->setTimeFromTimeString($this->afternoon_end);
        }
        
        return null;
    }

    // Méthodes pour lier avec les guichets
    public function getAffectedCounters()
    {
        if ($this->counter_id) {
            return Counter::where('id', $this->counter_id)->get();
        } elseif ($this->service_id) {
            return Counter::where('service_id', $this->service_id)->get();
        } else {
            return Counter::where('company_id', $this->company_id)->get();
        }
    }

    public function openCounters()
    {
        $counters = $this->getAffectedCounters();
        $openedCount = 0;
        
        foreach ($counters as $counter) {
            if ($counter->status !== 'open') {
                $counter->update(['status' => 'open']);
                $openedCount++;
                
                // Log l'action
                \Log::info('Counter Opened by Schedule', [
                    'counter_id' => $counter->id,
                    'schedule_id' => $this->id,
                    'time' => now()->format('H:i:s'),
                    'timezone' => $this->timezone
                ]);
            }
        }
        
        return $openedCount;
    }

    public function closeCounters()
    {
        $counters = $this->getAffectedCounters();
        $closedCount = 0;
        
        foreach ($counters as $counter) {
            if ($counter->status !== 'closed') {
                $counter->update(['status' => 'closed']);
                $closedCount++;
                
                // Log l'action
                \Log::info('Counter Closed by Schedule', [
                    'counter_id' => $counter->id,
                    'schedule_id' => $this->id,
                    'time' => now()->format('H:i:s'),
                    'timezone' => $this->timezone
                ]);
            }
        }
        
        return $closedCount;
    }

    public function getCounterStatus(): string
    {
        if (!$this->isActiveToday()) {
            return 'closed';
        }

        if ($this->isInWorkingHours()) {
            return 'open';
        }

        return 'closed';
    }

    public function getStatusMessage(): string
    {
        if (!$this->is_active) {
            return 'Planning inactif';
        }

        if (!$this->isActiveToday()) {
            return 'Fermé aujourd\'hui';
        }

        if ($this->isInWorkingHours()) {
            return 'Ouvert';
        }

        $nextOpen = $this->getNextOpenTime();
        if ($nextOpen) {
            return "Ouvre à {$nextOpen->format('H:i')}";
        }

        return 'Fermé';
    }

    public function getWorkingDaysFormatted(): string
    {
        $days = [
            1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 
            5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche'
        ];

        $workingDays = array_map(fn($day) => $days[$day] ?? '', $this->working_days);
        
        return implode(', ', array_filter($workingDays));
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeForService($query, $serviceId)
    {
        return $query->where('service_id', $serviceId);
    }

    public function scopeForCounter($query, $counterId)
    {
        return $query->where('counter_id', $counterId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
