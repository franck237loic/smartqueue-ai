<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Counter;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class AgentService
{
    /**
     * Récupérer tous les agents d'une entreprise
     */
    public function getAllAgents(Company $company): LengthAwarePaginator
    {
        return User::whereHas('companies', function ($query) use ($company) {
            $query->where('company_id', $company->id)
                  ->where('role', 'agent');
        })
        ->with(['counters' => function ($query) use ($company) {
            $query->where('company_id', $company->id);
        }])
        ->orderBy('name')
        ->paginate(10);
    }

    /**
     * Créer un nouvel agent
     */
    public function createAgent(Company $company, array $data): User
    {
        // Créer l'utilisateur
        $agent = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'global_role' => 'user',
            'current_company_id' => $company->id,
        ]);

        // Attacher l'agent à l'entreprise avec le rôle agent
        $agent->companies()->attach($company->id, [
            'role' => 'agent',
            'is_default' => true,
        ]);

        // Assigner à un guichet si spécifié
        if (!empty($data['counter_id'])) {
            $this->assignToCounter($agent, $data['counter_id'], $company);
        }

        return $agent->fresh();
    }

    /**
     * Mettre à jour un agent
     */
    public function updateAgent(User $agent, Company $company, array $data): User
    {
        $updateData = [
            'name' => $data['name'] ?? $agent->name,
            'email' => $data['email'] ?? $agent->email,
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $agent->update($updateData);

        // Mettre à jour l'assignation guichet
        if (isset($data['counter_id'])) {
            $this->assignToCounter($agent, $data['counter_id'], $company);
        }

        return $agent->fresh();
    }

    /**
     * Supprimer un agent
     */
    public function deleteAgent(User $agent, Company $company): bool
    {
        // Détacher de l'entreprise
        $agent->companies()->detach($company->id);

        // Libérer le guichet
        Counter::where('company_id', $company->id)
            ->where('user_id', $agent->id)
            ->update(['user_id' => null]);

        // Si l'agent n'appartient à aucune entreprise, on le supprime
        if ($agent->companies()->count() === 0) {
            return $agent->delete();
        }

        return true;
    }

    /**
     * Assigner un agent à un guichet
     */
    public function assignToCounter(User $agent, ?int $counterId, Company $company): void
    {
        // Désassigner des anciens guichets de cette entreprise
        Counter::where('company_id', $company->id)
            ->where('user_id', $agent->id)
            ->update(['user_id' => null]);

        // Assigner au nouveau guichet
        if ($counterId) {
            $counter = Counter::where('id', $counterId)
                ->where('company_id', $company->id)
                ->first();

            if ($counter) {
                $counter->update(['user_id' => $agent->id]);
            }
        }
    }

    /**
     * Compter les agents
     */
    public function countAgents(Company $company): int
    {
        return User::whereHas('companies', function ($query) use ($company) {
            $query->where('company_id', $company->id)
                  ->where('role', 'agent');
        })->count();
    }

    /**
     * Récupérer les agents disponibles (non assignés à un guichet)
     */
    public function getAvailableAgents(Company $company): \Illuminate\Support\Collection
    {
        $assignedAgentIds = Counter::where('company_id', $company->id)
            ->whereNotNull('user_id')
            ->pluck('user_id');

        return User::whereHas('companies', function ($query) use ($company) {
            $query->where('company_id', $company->id)
                  ->where('role', 'agent');
        })
        ->whereNotIn('id', $assignedAgentIds)
        ->get(['id', 'name']);
    }
}
