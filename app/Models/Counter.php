<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Counter extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'service_id',
        'user_id',
        'name',
        'number',
        'location',
        'status',
        'is_active',
        'opened_at',
        'closed_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function workSchedules()
    {
        return $this->hasMany(WorkSchedule::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function currentTicket(): ?Ticket
    {
        return $this->tickets()
            ->where('status', 'called')
            ->whereNull('served_at')
            ->first();
    }

    public function isOpen(): bool
    {
        return $this->status === 'open' && $this->is_active;
    }

    public function isPaused(): bool
    {
        return $this->status === 'paused' && $this->is_active;
    }

    public function isAutoClosed(): bool
    {
        return $this->status === 'auto_closed';
    }

    public function isOffline(): bool
    {
        return $this->status === 'offline' || !$this->is_active;
    }

    public function open(): void
    {
        $this->update([
            'status' => 'open',
            'is_active' => true,
            'opened_at' => now(),
        ]);
    }

    public function close(): void
    {
        $this->update([
            'status' => 'closed',
            'is_active' => false,
            'closed_at' => now(),
        ]);
    }

    public function pause(): void
    {
        $this->update([
            'status' => 'paused',
            'paused_at' => now(),
        ]);
    }

    public function resume(): void
    {
        $this->update([
            'status' => 'open',
            'is_active' => true,
        ]);
    }

    public function autoClose(): void
    {
        $this->update([
            'status' => 'auto_closed',
            'is_active' => false,
            'auto_closed_at' => now(),
        ]);
    }

    public function setOffline(): void
    {
        $this->update([
            'status' => 'offline',
            'is_active' => false,
            'offline_at' => now(),
        ]);
    }
}
