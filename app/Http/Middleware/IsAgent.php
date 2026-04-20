<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class IsAgent
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
        
        // Récupérer l'entreprise depuis l'URL
        $companyId = $request->route('company');
        
        if (!$companyId) {
            abort(404, 'Entreprise non spécifiée');
        }

        // Vérifier que l'entreprise existe
        $company = Company::find($companyId);
        if (!$company) {
            abort(404, 'Entreprise non trouvée');
        }

        // Vérifier que l'utilisateur est agent dans cette entreprise
        if (!$user->isAgentInCompany($company)) {
            abort(403, 'Accès non autorisé. Vous devez être agent dans cette entreprise.');
        }

        // Ajouter l'entreprise à la requête pour utilisation dans les contrôleurs
        $request->merge(['current_company' => $company]);

        return $next($request);
    }
}
