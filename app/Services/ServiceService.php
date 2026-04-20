<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Service;
use Illuminate\Pagination\LengthAwarePaginator;

class ServiceService
{
    /**
     * Récupérer tous les services d'une entreprise
     */
    public function getAllServices(Company $company): LengthAwarePaginator
    {
        return Service::where('company_id', $company->id)
            ->orderBy('name')
            ->paginate(10);
    }

    /**
     * Créer un nouveau service
     */
    public function createService(Company $company, array $data): Service
    {
        return Service::create([
            'company_id' => $company->id,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'] ?? 'active',
            'prefix' => $data['prefix'] ?? strtoupper(substr($data['name'], 0, 1)),
            'estimated_service_time' => $data['estimated_service_time'] ?? 5,
            'missed_timeout' => $data['missed_timeout'] ?? 5,
            'max_daily_tickets' => $data['max_daily_tickets'] ?? 100,
        ]);
    }

    /**
     * Mettre à jour un service
     */
    public function updateService(Service $service, array $data): Service
    {
        $service->update([
            'name' => $data['name'] ?? $service->name,
            'description' => $data['description'] ?? $service->description,
            'status' => $data['status'] ?? $service->status,
            'prefix' => $data['prefix'] ?? $service->prefix,
            'estimated_service_time' => $data['estimated_service_time'] ?? $service->estimated_service_time,
            'missed_timeout' => $data['missed_timeout'] ?? $service->missed_timeout,
            'max_daily_tickets' => $data['max_daily_tickets'] ?? $service->max_daily_tickets,
        ]);

        return $service->fresh();
    }

    /**
     * Supprimer un service
     */
    public function deleteService(Service $service): bool
    {
        // Vérifier si le service a des tickets
        if ($service->tickets()->count() > 0) {
            throw new \Exception('Impossible de supprimer un service qui a des tickets.');
        }

        return $service->delete();
    }

    /**
     * Récupérer les services actifs pour dropdown
     */
    public function getActiveServicesForDropdown(Company $company): \Illuminate\Support\Collection
    {
        return Service::where('company_id', $company->id)
            ->where('status', 'active')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    /**
     * Compter les services
     */
    public function countServices(Company $company): int
    {
        return Service::where('company_id', $company->id)->count();
    }
}
