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
        
        // If we're in afternoon, no more opening today
        if ($this->isInAfternoonHours()) {
            return null;
        }
        
        // If we're before morning, open at morning start
        if ($now->format('H:i') < $this->morning_start) {
            return $now->copy()->setTimeFromTimeString($this->morning_start);
        }
        
        // If we're between morning and afternoon, open at afternoon start
        if ($now->format('H:i') > $this->morning_end && $now->format('H:i') < $this->afternoon_start) {
            return $now->copy()->setTimeFromTimeString($this->afternoon_start);
        }
        
        return null;
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
