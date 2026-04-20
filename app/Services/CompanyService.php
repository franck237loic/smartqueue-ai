<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CompanyService
{
    /**
     * Créer une entreprise avec son admin
     */
    public function createCompanyWithAdmin(array $companyData, array $adminData): Company
    {
        // Générer le slug si non fourni
        if (empty($companyData['slug'])) {
            $companyData['slug'] = Str::slug($companyData['name']);
        }

        // Créer l'entreprise
        $company = Company::create([
            'name' => $companyData['name'],
            'slug' => $companyData['slug'],
            'email' => $companyData['email'] ?? null,
            'phone' => $companyData['phone'] ?? null,
            'address' => $companyData['address'] ?? null,
            'website' => $companyData['website'] ?? null,
            'status' => $companyData['status'] ?? 'active',
        ]);

        // Créer l'admin de l'entreprise
        $admin = User::create([
            'name' => $adminData['name'] ?? 'Admin ' . $companyData['name'],
            'email' => $adminData['email'] ?? 'admin@' . $companyData['slug'] . '.com',
            'password' => Hash::make($adminData['password'] ?? 'password123'),
            'global_role' => 'user',
            'current_company_id' => $company->id,
        ]);

        // Lier l'admin à l'entreprise
        $admin->companies()->attach($company->id, [
            'role' => 'company_admin',
            'is_default' => true,
        ]);

        return $company;
    }

    /**
     * Mettre à jour le statut d'une entreprise
     */
    public function updateStatus(Company $company, string $status): void
    {
        $company->update(['status' => $status]);
    }

    /**
     * Soft delete une entreprise
     */
    public function deleteCompany(Company $company): void
    {
        $company->delete();
    }

    /**
     * Récupérer les stats globales pour le Super Admin
     */
    public function getGlobalStats(): array
    {
        return [
            'companies_count' => Company::count(),
            'active_companies' => Company::where('status', 'active')->count(),
            'suspended_companies' => Company::where('status', 'suspended')->count(),
            'total_users' => User::count(),
            'company_admins' => User::whereHas('companies', function ($q) {
                $q->where('role', 'company_admin');
            })->count(),
            'agents' => User::whereHas('companies', function ($q) {
                $q->where('role', 'agent');
            })->count(),
            'super_admins' => User::where('global_role', 'super_admin')->count(),
        ];
    }
}
