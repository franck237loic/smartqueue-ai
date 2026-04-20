<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'address',
        'phone',
        'email',
        'website',
        'status',
        'subscription_ends_at',
        'settings',
    ];

    protected $casts = [
        'subscription_ends_at' => 'datetime',
        'settings' => 'array',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'company_user')
            ->withPivot(['role', 'counter_id', 'is_default', 'last_login_at'])
            ->withTimestamps();
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
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

    public function isSubscriptionValid(): bool
    {
        return $this->subscription_ends_at === null || $this->subscription_ends_at->isFuture();
    }

    public function deactivate(): bool
    {
        // Désactiver l'entreprise
        $this->status = 'inactive';
        $this->save();
        
        // Désactiver tous les guichets
        $this->counters()->update(['status' => 'closed', 'is_active' => false]);
        
        // Désactiver tous les services
        $this->services()->update(['status' => 'inactive']);
        
        // Annuler tous les tickets en attente
        $this->tickets()->where('status', 'waiting')->update(['status' => 'cancelled']);
        
        // Bloquer l'accès de tous les utilisateurs
        $this->users()->update(['current_company_id' => null]);
        
        return true;
    }

    public function activate(): bool
    {
        // Réactiver l'entreprise
        $this->status = 'active';
        $this->save();
        
        // Réactiver tous les services
        $this->services()->update(['status' => 'active']);
        
        // Réactiver les guichets principaux
        $this->counters()->limit(5)->update(['status' => 'closed', 'is_active' => true]);
        
        return true;
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($company) {
            if (empty($company->slug)) {
                $company->slug = Str::slug($company->name);
            }
        });

        // Suppression en cascade COMPLÈTE des utilisateurs associés
        static::deleting(function ($company) {
            // Récupérer TOUS les utilisateurs associés à cette entreprise
            $users = $company->users;
            
            foreach ($users as $user) {
                // Supprimer TOUS les utilisateurs associés à cette entreprise
                // Même s'ils sont dans d'autres entreprises, ils sont supprimés
                $user->delete();
            }
        });
    }
}
