<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'global_role',
        'current_company_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'deleted_at' => 'datetime',
        ];
    }

    // ========== RELATIONS SaaS ==========

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'company_user')
            ->withPivot(['role', 'counter_id', 'is_default', 'last_login_at'])
            ->withTimestamps();
    }

    public function currentCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'current_company_id');
    }

    public function companyRole(Company $company): ?string
    {
        $pivot = $this->companies()->where('company_user.company_id', $company->id)->first()?->pivot;
        return $pivot?->role;
    }

    public function getRoleInCompany(Company $company): ?string
    {
        return $this->companyRole($company);
    }

    public function counters(): HasMany
    {
        return $this->hasMany(Counter::class);
    }

    public function assignedCounters()
    {
        // Récupérer les guichets assignés via la table company_user
        return $this->belongsToMany(Counter::class, 'company_user', 'user_id', 'counter_id')
            ->wherePivotNotNull('counter_id');
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'agent_id');
    }

    // ========== RÔLES GLOBALS ==========

    public function isSuperAdmin(): bool
    {
        return $this->global_role === 'super_admin';
    }

    // ========== RÔLES DANS ENTREPRISE ==========

    public function isCompanyAdmin(Company $company): bool
    {
        return $this->isSuperAdmin() || $this->companyRole($company) === 'company_admin';
    }

    
    /**
     * Vérifier si l'utilisateur est un agent dans l'entreprise (gère les deux cas)
     */
    public function isAgentInCompany($company): bool
    {
        // Si c'est un objet Company, utiliser la méthode existante
        if ($company instanceof \App\Models\Company) {
            $role = $this->companyRole($company);
            return in_array($role, ['company_admin', 'agent']);
        }
        
        // Si c'est un ID (string/integer), charger l'entreprise
        if (is_string($company) || is_numeric($company)) {
            $companyModel = \App\Models\Company::find($company);
            if ($companyModel) {
                $role = $this->companyRole($companyModel);
                return in_array($role, ['company_admin', 'agent']);
            }
        }
        
        return false;
    }

    public function hasRoleInCompany(Company $company, string $role): bool
    {
        return $this->companyRole($company) === $role;
    }

    public function hasAccessToCompany(Company $company): bool
    {
        return $this->isSuperAdmin() || $this->companies()->where('company_id', $company->id)->exists();
    }

    // ========== HELPERS ==========

    public function setCurrentCompany(Company $company): void
    {
        $this->update(['current_company_id' => $company->id]);
    }

    public function getDefaultCompany(): ?Company
    {
        // Utiliser une requête optimisée avec eager loading limité
        $company = $this->companies()
            ->wherePivot('is_default', true)
            ->select('companies.id', 'companies.name', 'companies.slug', 'companies.status')
            ->first();
        
        if (!$company) {
            // Fallback: prendre la première entreprise active
            $company = $this->companies()
                ->where('companies.status', 'active')
                ->select('companies.id', 'companies.name', 'companies.slug', 'companies.status')
                ->first();
        }
        
        return $company;
    }
}
