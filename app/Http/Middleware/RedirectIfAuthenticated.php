<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // Si l'utilisateur est déjà authentifié, le rediriger selon son rôle
            $user = Auth::user();
            
            // Redirection selon le rôle global
            if ($user->global_role === 'super_admin') {
                return redirect()->route('super_admin.dashboard');
            }
            
            // Pour les autres rôles, vérifier s'ils ont des entreprises
            $companies = $user->companies;
            if ($companies->isNotEmpty()) {
                // Prendre la première entreprise disponible
                $company = $companies->first();
                $user->setCurrentCompany($company);
                
                // Rediriger selon le rôle dans l'entreprise
                $role = $user->companyRole($company);
                if ($role === 'company_admin') {
                    return redirect()->route('company.admin.dashboard', $company);
                } elseif ($role === 'agent') {
                    return redirect()->route('company.agent.dashboard', $company);
                }
            }
            
            // Si aucune entreprise, rediriger vers l'accueil
            return redirect()->route('welcome');
        }

        return $next($request);
    }
}
