<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'prefix',
        'description',
        'estimated_service_time',
        'missed_timeout',
        'max_daily_tickets',
        'status',
        'working_hours',
    ];

    protected $casts = [
        'working_hours' => 'array',
        'estimated_service_time' => 'integer',
        'missed_timeout' => 'integer',
        'max_daily_tickets' => 'integer',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function counters(): HasMany
    {
        return $this->hasMany(Counter::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function waitingTickets(): HasMany
    {
        return $this->tickets()->where('status', 'waiting');
    }

    public function calledTickets(): HasMany
    {
        return $this->tickets()->where('status', 'called');
    }

    public function servedToday(): HasMany
    {
        return $this->tickets()->where('status', 'served')
            ->whereDate('served_at', today());
    }
}
