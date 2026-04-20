<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'service_id',
        'counter_id',
        'agent_id',
        'guest_name',
        'guest_phone',
        'number',
        'sequence',
        'status',
        'missed_count',
        'missed_at',
        'present_at',
        'called_at',
        'served_at',
        'cancelled_at',
        'actual_service_time',
        'priority',
        'notes',
        'cancellation_reason',
    ];

    protected $casts = [
        'called_at' => 'datetime',
        'present_at' => 'datetime',
        'served_at' => 'datetime',
        'missed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'actual_service_time' => 'integer',
        'missed_count' => 'integer',
        'sequence' => 'integer',
        'priority' => 'integer',
        'deleted_at' => 'datetime',
    ];

    // ========== RELATIONS ==========

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

    public function agent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    // ========== STATUTS CONSTANTS ==========
    
    const STATUS_WAITING = 'WAITING';
    const STATUS_CALLED = 'CALLED';
    const STATUS_PRESENT = 'PRESENT';
    const STATUS_SERVING = 'SERVING';
    const STATUS_SERVED = 'SERVED';
    const STATUS_MISSED_TEMP = 'MISSED_TEMP';
    const STATUS_CANCELLED = 'CANCELLED';
    const STATUS_TRANSFERRED = 'TRANSFERRED';

    // ========== SCOPES ==========

    public function scopeWAITING($query)
    {
        return $query->where('status', self::STATUS_WAITING);
    }

    public function scopeCalled($query)
    {
        return $query->where('status', self::STATUS_CALLED);
    }

    public function scopeServing($query)
    {
        return $query->where('status', self::STATUS_SERVING);
    }

    public function scopeServed($query)
    {
        return $query->where('status', self::STATUS_SERVED);
    }

    public function scopeMissed($query)
    {
        return $query->whereIn('status', [self::STATUS_MISSED_TEMP]);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::STATUS_CANCELLED);
    }

    public function scopePresent($query)
    {
        return $query->where('status', self::STATUS_PRESENT);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [
            self::STATUS_WAITING,
            self::STATUS_CALLED,
            self::STATUS_SERVING,
            self::STATUS_MISSED_TEMP,
        ]);
    }

    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeForService($query, int $serviceId)
    {
        return $query->where('service_id', $serviceId);
    }

    public function scopeFifo($query)
    {
        return $query->orderBy('priority', 'desc')
                     ->orderBy('created_at', 'asc');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // ========== STATUTS ==========

    public function isWAITING(): bool
    {
        return $this->status === self::STATUS_WAITING;
    }

    public function isCalled(): bool
    {
        return $this->status === self::STATUS_CALLED;
    }

    public function isServing(): bool
    {
        return $this->status === self::STATUS_SERVING;
    }

    public function isServed(): bool
    {
        return $this->status === self::STATUS_SERVED;
    }

    public function isMissedTemp(): bool
    {
        return $this->status === self::STATUS_MISSED_TEMP;
    }

    public function isCancelled(): bool
    {
        return $this->status === self::STATUS_CANCELLED;
    }

    public function isTransferred(): bool
    {
        return $this->status === self::STATUS_TRANSFERRED;
    }

    public function isPresent(): bool
    {
        return $this->status === self::STATUS_PRESENT;
    }

    public function markPresent(): void
    {
        $this->update([
            'status' => self::STATUS_PRESENT,
            'present_at' => now(),
        ]);
    }

    public function markAsServing(): void
    {
        $this->update([
            'status' => self::STATUS_SERVING,
            'serving_at' => now(),
        ]);
    }

    // ========== ACTIONS ==========

    public function call(User $agent, Counter $counter): void
    {
        $this->update([
            'status' => self::STATUS_CALLED,
            'agent_id' => $agent->id,
            'counter_id' => $counter->id,
            'called_at' => now(),
        ]);

        // Le guichet reste dans son état actuel - séparation des états
    }

    

    public function serve(): void
    {
        $serviceTime = null;
        if ($this->called_at) {
            $serviceTime = now()->diffInSeconds($this->called_at);
        }

        $this->update([
            'status' => self::STATUS_SERVED,
            'served_at' => now(),
            'actual_service_time' => $serviceTime,
        ]);

        // Le guichet reste dans son état actuel - séparation des états
    }

    public function markAsMissed(): bool
    {
        $newMissedCount = $this->missed_count + 1;

        if ($newMissedCount >= 3) {
            // Annuler définitivement après 3 absences
            $this->update([
                'status' => self::STATUS_CANCELLED,
                'missed_count' => $newMissedCount,
                'missed_at' => now(),
                'cancellation_reason' => 'Absent après 3 appels',
            ]);

            // Le guichet reste dans son état actuel - séparation des états
            return false; // Ticket annulé
        }

        // Remettre en file d'attente temporairement
        $this->update([
            'status' => self::STATUS_MISSED_TEMP,
            'missed_count' => $newMissedCount,
            'counter_id' => null,
            'agent_id' => null,
        ]);

        // Le guichet reste dans son état actuel - séparation des états
        return true; // Ticket remis en file
    }

    public function requeue(): void
    {
        // Remettre un ticket manqué en file normale
        $this->update([
            'status' => self::STATUS_WAITING,
            'counter_id' => null,
            'agent_id' => null,
            'called_at' => null,
        ]);
    }

    public function cancel(string $reason = null): void
    {
        $this->update([
            'status' => self::STATUS_CANCELLED,
            'cancelled_at' => now(),
            'cancellation_reason' => $reason,
        ]);

        // Le guichet reste dans son état actuel - séparation des états
    }

    public function transfer(int $newServiceId, string $reason = null): void
    {
        $this->update([
            'service_id' => $newServiceId,
            'status' => self::STATUS_WAITING,
            'counter_id' => null,
            'agent_id' => null,
            'called_at' => null,
            'notes' => $this->notes . ($reason ? "\nTransfert: $reason" : ''),
        ]);
    }

    // ========== HELPERS ==========

    public function getPosition(): ?int
    {
        if (!$this->isWaiting()) {
            return null;
        }

        // Vérifier que le service existe
        if (!$this->service_id) {
            return null;
        }

        return Ticket::where('service_id', $this->service_id)
            ->where('status', 'waiting')
            ->where('created_at', '<', $this->created_at)
            ->count() + 1;
    }

    public function getEstimatedWaitTime(): int
    {
        if ($this->estimated_wait_time) {
            return $this->estimated_wait_time;
        }

        $position = $this->getPosition();
        if (!$position) {
            return 0;
        }

        $service = $this->service;
        $avgServiceTime = $service?->estimated_service_time ?? 5;

        return $position * $avgServiceTime;
    }

    public function isMissedTimeoutExpired(): bool
    {
        if (!$this->isCalled() || !$this->called_at) {
            return false;
        }

        $service = $this->service;
        $timeoutMinutes = $service?->missed_timeout ?? 5;

        return now()->diffInMinutes($this->called_at) >= $timeoutMinutes;
    }

    public function getWaitTimeMinutes(): ?int
    {
        if (!$this->called_at || !$this->created_at) {
            return null;
        }

        return $this->called_at->diffInMinutes($this->created_at);
    }

    public function getServiceTimeMinutes(): ?int
    {
        if (!$this->served_at || !$this->called_at) {
            return $this->actual_service_time;
        }

        return $this->served_at->diffInMinutes($this->called_at);
    }

    /**
     * Marquer un ticket comme servi
     */
    public function markAsServed(): void
    {
        $serviceTime = null;
        if ($this->called_at) {
            $serviceTime = now()->diffInSeconds($this->called_at);
        }

        $this->update([
            'status' => self::STATUS_SERVED,
            'served_at' => now(),
            'actual_service_time' => $serviceTime,
        ]);
    }

    /**
     * Marquer un ticket comme en cours de service
     */
    
}
