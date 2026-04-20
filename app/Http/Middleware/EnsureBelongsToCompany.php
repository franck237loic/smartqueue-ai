<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBelongsToCompany
{
    /**
     * Ensure user belongs to the company in the route.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Super admin appartient à toutes les entreprises
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Récupérer l'entreprise depuis la route
        $company = $request->route('company');

        // Si company est un ID, récupérer le modèle
        if (is_numeric($company)) {
            $company = \App\Models\Company::find($company);
        }

        if (!$company) {
            // Si pas d'entreprise dans la route, vérifier current_company_id
            if ($user->current_company_id) {
                return $next($request);
            }
            
            // Rediriger vers sélection d'entreprise (avec stop pour éviter boucle)
            return redirect()->route('select-company')->header('X-Redirect-Count', '1');
        }

        // Vérifier que l'utilisateur appartient à cette entreprise
        if (!$user->hasAccessToCompany($company)) {
            abort(403, 'Vous n\'avez pas accès à cette entreprise.');
        }

        // Mettre à jour l'entreprise courante si différente
        if ($user->current_company_id !== $company->id) {
            $user->setCurrentCompany($company);
        }

        return $next($request);
    }
}
