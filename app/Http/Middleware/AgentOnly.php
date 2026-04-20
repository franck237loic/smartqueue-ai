<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifier que l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Vérifier que l'utilisateur a le rôle d'agent dans l'entreprise
        $company = $request->route('company');
        
        if (!$user->isAgentInCompany($company)) {
            // Si l'utilisateur n'est pas un agent, rediriger vers le dashboard approprié
            if ($user->isSuperAdmin()) {
                return redirect()->route('super_admin.dashboard');
            } elseif ($user->companies()->where('company_id', $company->id)->wherePivot('role', 'company_admin')->exists()) {
                return redirect()->route('company.admin.dashboard', $company);
            }
            
            // Sinon, refuser l'accès
            abort(403, 'Accès réservé aux agents');
        }

        return $next($request);
    }
}
