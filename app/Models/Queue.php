<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Queue extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'prefix',
        'current_number',
        'status',
        'user_id',
        'estimated_service_time',
        'missed_timeout',
    ];

    protected $casts = [
        'current_number' => 'integer',
        'estimated_service_time' => 'integer',
        'missed_timeout' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function waitingTickets()
    {
        return $this->tickets()->where('status', 'WAITING')->orderBy('created_at');
    }

    public function calledTickets()
    {
        return $this->tickets()->where('status', 'CALLED')->orderBy('called_at');
    }

    public function servedTickets()
    {
        return $this->tickets()->where('status', 'SERVED');
    }

    public function missedTickets()
    {
        return $this->tickets()->where('status', 'MISSED_TEMP');
    }

    public function isActive(): bool
    {
        return $this->status === 'ACTIVE';
    }

    public function getNextTicketNumber(): string
    {
        $this->current_number++;
        $this->save();
        return $this->prefix . str_pad($this->current_number, 3, '0', STR_PAD_LEFT);
    }
}
