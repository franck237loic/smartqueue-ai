<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Setting;
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

    // ========== STATISTIQUES SYSTÈME ==========

    public function statistics()
    {
        // Données pour les graphiques
        $period = request('period', 'month');
        
        $stats = [
            'companies' => [
                'total' => Company::count(),
                'growth' => 15, // Pourcentage de croissance (à calculer)
            ],
            'users' => [
                'total' => User::count(),
                'growth' => 12,
            ],
            'services' => [
                'total' => \App\Models\Service::count(),
                'growth' => 8,
            ],
            'counters' => [
                'total' => \App\Models\Counter::count(),
                'growth' => 5,
            ],
            'performance' => [
                'avg_wait_time' => 12,
                'avg_service_time' => 8,
                'satisfaction_rate' => 94,
                'efficiency' => 87,
            ],
            'tickets_chart' => [
                'labels' => ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                'data' => [45, 52, 38, 65, 48, 72, 55],
            ],
            'processed_tickets_chart' => [
                'labels' => ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
                'data' => [42, 48, 35, 61, 45, 68, 52],
            ],
            'top_companies' => [
                [
                    'name' => 'SmartQueue AI',
                    'tickets' => 1234,
                    'users' => 45,
                    'avg_wait_time' => 8,
                    'satisfaction' => 96,
                ],
                [
                    'name' => 'TechCorp',
                    'tickets' => 856,
                    'users' => 32,
                    'avg_wait_time' => 12,
                    'satisfaction' => 92,
                ],
            ],
        ];

        return view('super-admin.statistics', compact('stats'));
    }

    // ========== PARAMÈTRES SYSTÈME ==========

    public function settings()
    {
        return view('super-admin.settings');
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'default_email' => 'required|email',
            'timezone' => 'required|string',
            'default_locale' => 'required|string',
            'max_wait_time' => 'required|integer|min:1|max:180',
            'avg_service_time' => 'required|integer|min:1|max:60',
            'daily_ticket_limit' => 'required|integer|min:10|max:10000',
            'auto_notifications' => 'boolean',
            'min_password_length' => 'required|integer|min:6|max:32',
            'session_lifetime' => 'required|integer',
            'enable_2fa' => 'boolean',
            'enable_activity_log' => 'boolean',
            'mail_driver' => 'required|string',
            'mail_host' => 'required|string',
            'mail_port' => 'required|integer',
            'mail_encryption' => 'nullable|string',
        ]);

        // Sauvegarder tous les paramètres en base de données
        Setting::set('app_name', $validated['app_name'], 'string', 'Nom de l\'application');
        Setting::set('default_email', $validated['default_email'], 'string', 'Email par défaut');
        Setting::set('timezone', $validated['timezone'], 'string', 'Fuseau horaire par défaut');
        Setting::set('default_locale', $validated['default_locale'], 'string', 'Langue par défaut');
        Setting::set('max_wait_time', $validated['max_wait_time'], 'integer', 'Temps d\'attente maximal (minutes)');
        Setting::set('avg_service_time', $validated['avg_service_time'], 'integer', 'Temps de service moyen (minutes)');
        Setting::set('daily_ticket_limit', $validated['daily_ticket_limit'], 'integer', 'Limite de tickets par jour');
        Setting::set('auto_notifications', $validated['auto_notifications'], 'boolean', 'Notifications automatiques');
        Setting::set('min_password_length', $validated['min_password_length'], 'integer', 'Longueur minimale du mot de passe');
        Setting::set('session_lifetime', $validated['session_lifetime'], 'integer', 'Durée de session (heures)');
        Setting::set('enable_2fa', $validated['enable_2fa'], 'boolean', 'Activer 2FA');
        Setting::set('enable_activity_log', $validated['enable_activity_log'], 'boolean', 'Journal d\'activité');
        Setting::set('mail_driver', $validated['mail_driver'], 'string', 'Driver email');
        Setting::set('mail_host', $validated['mail_host'], 'string', 'Hôte SMTP');
        Setting::set('mail_port', $validated['mail_port'], 'integer', 'Port SMTP');
        Setting::set('mail_encryption', $validated['mail_encryption'] ?? '', 'string', 'Chiffrement SMTP');

        return redirect()->route('super_admin.settings')
            ->with('success', 'Paramètres sauvegardés avec succès en base de données.');
    }

    // ========== GESTION ADMINISTRATEURS ==========

    public function administrators()
    {
        $administrators = User::where('global_role', 'super_admin')
            ->withCount(['companies'])
            ->latest()
            ->paginate(20);

        return view('super-admin.administrators', compact('administrators'));
    }

    public function createAdministrator()
    {
        return view('super-admin.administrators.create');
    }

    public function storeAdministrator(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'global_role' => 'super_admin',
            'email_verified_at' => now(),
        ]);

        return redirect()->route('super_admin.administrators')
            ->with('success', 'Administrateur créé avec succès.');
    }

    public function suspendAdministrator(Request $request, User $administrator)
    {
        if ($administrator->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'Vous ne pouvez pas suspendre votre propre compte.');
        }

        $administrator->update(['status' => 'suspended']);

        return response()->json(['success' => true]);
    }

    public function resetAdministratorPassword(Request $request, User $administrator)
    {
        $newPassword = Str::random(12);
        $administrator->update(['password' => Hash::make($newPassword)]);

        return response()->json([
            'success' => true,
            'password' => $newPassword,
            'message' => 'Mot de passe réinitialisé avec succès.'
        ]);
    }

    public function destroyAdministrator(User $administrator)
    {
        if ($administrator->id === auth()->id()) {
            return redirect()->back()
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        $administrator->delete();

        return response()->json(['success' => true]);
    }

    // ========== PROFIL SUPER ADMIN ==========

    public function profile()
    {
        return view('super-admin.profile');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);

        return redirect()->route('super_admin.profile')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Vérifier le mot de passe actuel
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        // Mettre à jour le mot de passe
        $user->update([
            'password' => Hash::make($validated['password']),
            'password_changed_at' => now(),
        ]);

        return redirect()->route('super_admin.profile')
            ->with('success', 'Mot de passe mis à jour avec succès.');
    }
}
