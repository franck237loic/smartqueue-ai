<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        $companies = \App\Models\Company::where('status', 'active')->get();
        return view('auth.login', compact('companies'));
    }

    public function login(Request $request)
    {
        // Augmenter le temps d'exécution pour cette requête (5 minutes max)
        set_time_limit(300);
        ini_set('max_execution_time', 300);
        
        // Désactiver le log des requêtes lentes temporairement
        \DB::disableQueryLog();
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Authentifier avec seulement email et password
        $authCredentials = [
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ];

        if (!Auth::attempt($authCredentials)) {
            return back()->withErrors([
                'email' => 'Les identifiants sont incorrects.',
            ]);
        }

        $request->session()->regenerate();
        $user = Auth::user();
        
        \Log::info('Connexion réussie', ['user_id' => $user->id, 'email' => $user->email]);
        
        // DÉTECTION AUTOMATIQUE DU RÔLE ET REDIRECTION INTELLIGENTE
        if ($user->isSuperAdmin()) {
            \Log::info('Redirection Super Admin vers dashboard');
            return redirect()->route('super_admin.dashboard');
        }
        
        // Récupérer les entreprises de l'utilisateur
        $companies = $user->companies;
        
        if ($companies->count() === 0) {
            \Log::error('Aucune entreprise associée à l\'utilisateur');
            return back()->withErrors([
                'email' => 'Aucune entreprise associée à votre compte.',
            ]);
        }
        
        if ($companies->count() === 1) {
            // UNE SEULE ENTREPRISE - REDIRECTION DIRECTE
            $company = $companies->first();
            $user->setCurrentCompany($company);
            
            $role = $user->companyRole($company);
            \Log::info('Redirection directe', [
                'company_id' => $company->id, 
                'role' => $role
            ]);
            
            if ($role === 'company_admin') {
                \Log::info('Redirection vers dashboard Admin Entreprise');
                return redirect()->route('company.admin.dashboard', $company);
            } elseif ($role === 'agent') {
                \Log::info('Redirection vers dashboard Agent');
                return redirect()->route('company.agent.dashboard', $company);
            }
            
            // Fallback vers dashboard agent par défaut
            return redirect()->route('company.agent.dashboard', $company);
        }
        
        // PLUSIEURS ENTREPRISES - PAGE DE SÉLECTION
        \Log::info('Redirection vers sélection d\'entreprise', ['companies_count' => $companies->count()]);
        return redirect()->route('select.company');
    }

    public function selectCompany()
    {
        $user = auth()->user();
        $companies = $user->companies()->get();
        
        return view('auth.select-company', compact('companies', 'user'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'company_name' => 'required|string|max:255',
        ]);

        // Créer l'utilisateur
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'global_role' => 'user',
        ]);

        // Créer l'entreprise
        $company = Company::create([
            'name' => $data['company_name'],
            'status' => 'active',
        ]);

        // Associer user comme admin de l'entreprise
        $user->companies()->attach($company->id, [
            'role' => 'company_admin',
            'is_default' => true,
        ]);

        $user->setCurrentCompany($company);

        Auth::login($user);

        return redirect()->route('company.dashboard', $company);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Sélectionner une entreprise
     */
    public function setCompany(Request $request, Company $company)
    {
        $user = Auth::user();

        if (!$user->hasAccessToCompany($company)) {
            abort(403);
        }

        $user->setCurrentCompany($company);

        return redirect()->route('company.dashboard', $company);
    }

    /**
     * Redirection après login selon le rôle
     */
    private function redirectAfterLogin()
    {
        $user = Auth::user();

        // Super admin -> dashboard super admin directement
        if ($user->isSuperAdmin()) {
            return redirect()->route('super_admin.dashboard');
        }

        // Vérifier si l'utilisateur a des entreprises
        $defaultCompany = $user->getDefaultCompany();

        if (!$defaultCompany) {
            // Déconnexion si aucune entreprise trouvée pour éviter les boucles
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Vous n\'avez accès à aucune entreprise. Contactez l\'administrateur.');
        }

        // Mettre à jour l'entreprise courante
        $user->setCurrentCompany($defaultCompany);

        // Rediriger vers le dashboard approprié selon le rôle
        return redirect()->route('company.dashboard', $defaultCompany);
    }

    /**
     * Afficher le dashboard selon le rôle dans l'entreprise
     */
    public function dashboard(Company $company)
    {
        $user = Auth::user();

        if (!$user->hasAccessToCompany($company)) {
            abort(403);
        }

        // Rediriger selon le rôle dans cette entreprise
        if ($user->isSuperAdmin() || $user->isCompanyAdmin($company)) {
            return redirect()->route('company.admin.dashboard', $company);
        }

        if ($user->isAgentInCompany($company)) {
            return redirect()->route('company.agent.dashboard', $company);
        }

        // Client/public
        return redirect()->route('company.public', $company);
    }
}
