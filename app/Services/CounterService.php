<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Counter;
use Illuminate\Pagination\LengthAwarePaginator;

class CounterService
{
    /**
     * Récupérer tous les guichets d'une entreprise
     */
    public function getAllCounters(Company $company): LengthAwarePaginator
    {
        return Counter::where('company_id', $company->id)
            ->with(['service', 'agent'])
            ->orderBy('number')
            ->paginate(10);
    }

    /**
     * Créer un nouveau guichet
     */
    public function createCounter(Company $company, array $data): Counter
    {
        return Counter::create([
            'company_id' => $company->id,
            'service_id' => $data['service_id'],
            'user_id' => $data['user_id'] ?? null,
            'name' => $data['name'],
            'number' => $data['number'],
            'location' => $data['location'] ?? null,
            'status' => $data['status'] ?? 'closed',
            'is_active' => $data['is_active'] ?? true,
        ]);
    }

    /**
     * Mettre à jour un guichet
     */
    public function updateCounter(Counter $counter, array $data): Counter
    {
        $counter->update([
            'service_id' => $data['service_id'] ?? $counter->service_id,
            'user_id' => $data['user_id'] ?? $counter->user_id,
            'name' => $data['name'] ?? $counter->name,
            'number' => $data['number'] ?? $counter->number,
            'location' => $data['location'] ?? $counter->location,
            'status' => $data['status'] ?? $counter->status,
            'is_active' => $data['is_active'] ?? $counter->is_active,
        ]);

        return $counter->fresh();
    }

    /**
     * Supprimer un guichet
     */
    public function deleteCounter(Counter $counter): bool
    {
        return $counter->delete();
    }

    /**
     * Assigner un agent à un guichet
     */
    public function assignAgent(Counter $counter, ?int $userId): Counter
    {
        $counter->update(['user_id' => $userId]);
        return $counter->fresh();
    }

    /**
     * Changer le statut d'un guichet
     */
    public function toggleStatus(Counter $counter): Counter
    {
        $counter->update([
            'status' => $counter->status === 'open' ? 'closed' : 'open'
        ]);
        return $counter->fresh();
    }

    /**
     * Compter les guichets
     */
    public function countCounters(Company $company): int
    {
        return Counter::where('company_id', $company->id)->count();
    }

    /**
     * Récupérer les guichets disponibles (sans agent assigné)
     */
    public function getAvailableCounters(Company $company): \Illuminate\Support\Collection
    {
        return Counter::where('company_id', $company->id)
            ->whereNull('user_id')
            ->where('is_active', true)
            ->with('service')
            ->get();
    }
}
