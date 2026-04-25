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
        $company = $request->route('company');

        // Log pour debug
        \Log::info('AgentOnly middleware', [
            'user_id' => $user->id,
            'company_id' => $company->id ?? 'null',
            'company_type' => gettype($company)
        ]);

        // Vérifier si l'utilisateur appartient à l'entreprise
        if (!$user->hasAccessToCompany($company)) {
            \Log::error('AgentOnly: No access to company', ['user_id' => $user->id, 'company_id' => $company->id]);
            abort(403, 'Vous n\'avez pas accès à cette entreprise.');
        }
        
        // Vérifier le rôle dans l'entreprise (uniquement 'agent')
        if (!$user->isAgentInCompany($company)) {
            \Log::info('AgentOnly: User is not agent, checking redirect', [
                'user_id' => $user->id,
                'company_id' => $company->id,
                'is_super_admin' => $user->isSuperAdmin(),
                'is_company_admin' => $user->companies()->where('company_id', $company->id)->wherePivot('role', 'company_admin')->exists()
            ]);
            
            // Si l'utilisateur n'est pas un agent, rediriger vers le dashboard approprié
            if ($user->isSuperAdmin()) {
                return redirect()->route('super_admin.dashboard');
            } elseif ($user->companies()->where('company_id', $company->id)->wherePivot('role', 'company_admin')->exists()) {
                return redirect()->route('company.admin.dashboard', $company);
            }
            
            // Sinon, refuser l'accès
            abort(403, 'Accès réservé aux agents');
        }

        \Log::info('AgentOnly: Access granted', ['user_id' => $user->id, 'company_id' => $company->id]);
        return $next($request);
    }
}
