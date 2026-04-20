<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Services\CompanyService;
use App\Services\CompanyStatsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminController extends Controller
{
    protected CompanyService $companyService;
    protected CompanyStatsService $companyStatsService;

    public function __construct(CompanyService $companyService, CompanyStatsService $companyStatsService)
    {
        $this->companyService = $companyService;
        $this->companyStatsService = $companyStatsService;
    }
    /**
     * Dashboard Super Admin
     */
    
    public function dashboard()
    {
        $stats = [
            'companies_count' => \App\Models\Company::count(),
            'active_companies' => \App\Models\Company::where('status', true)->count(),
            'total_users' => \App\Models\User::count(),
            'super_admins' => \App\Models\User::where('global_role', 'super_admin')->count(),
        ];
        
        $recentCompanies = \App\Models\Company::latest()->take(5)->get();
        
        return view('super-admin.dashboard', compact('stats', 'recentCompanies'));
    }

    // ========== GESTION ENTREPRISES ==========

    public function companies()
    {
        $companies = Company::withCount(['services', 'counters', 'users'])
            ->latest()
            ->paginate(20);

        return view('super-admin.companies.index', compact('companies'));
    }

    public function createCompany()
    {
        return view('super-admin.companies.create');
    }

    public function storeCompany(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:companies',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'status' => 'required|in:active,suspended,inactive',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|email|unique:users,email',
            'admin_password' => 'nullable|string|min:8',
        ]);

        // Créer l'entreprise avec son admin
        $companyData = [
            'name' => $data['name'],
            'slug' => $data['slug'] ?? Str::slug($data['name']),
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'website' => $data['website'],
            'status' => $data['status'],
        ];

        $adminData = [
            'name' => $data['admin_name'],
            'email' => $data['admin_email'],
            'password' => $data['admin_password'] ?? Str::random(12),
        ];

        $company = $this->companyService->createCompanyWithAdmin($companyData, $adminData);

        return redirect()->route('super_admin.companies')
            ->with('success', "Entreprise '{$company->name}' créée avec succès. Admin: {$adminData['email']}");
    }

    public function editCompany(Company $company)
    {
        return view('super-admin.companies.edit', compact('company'));
    }

    public function updateCompany(Request $request, Company $company)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:companies,slug,' . $company->id,
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'website' => 'nullable|url',
            'status' => 'required|in:active,suspended,inactive',
            'subscription_ends_at' => 'nullable|date',
        ]);

        $company->update($data);

        return redirect()->route('super_admin.companies')
            ->with('success', 'Entreprise mise à jour.');
    }

    public function destroyCompany(Company $company)
    {
        // Soft delete - ne supprime pas les données
        $company->delete();

        return redirect()->route('super_admin.companies')
            ->with('success', 'Entreprise supprimée.');
    }

    /**
     * Afficher le détail d'une entreprise avec statistiques
     */
    public function showCompany(Company $company)
    {
        $stats = $this->companyStatsService->getCompanyStats($company);

        return view('super-admin.companies.show', compact('company', 'stats'));
    }

    // ========== GESTION UTILISATEURS ==========

    public function users()
    {
        $users = User::with('currentCompany')
            ->withCount('companies')
            ->latest()
            ->paginate(20);

        return view('super-admin.users.index', compact('users'));
    }

    public function makeSuperAdmin(Request $request, User $user)
    {
        $user->update(['global_role' => 'super_admin']);

        return redirect()->back()
            ->with('success', $user->name . ' est maintenant Super Admin.');
    }
}
