<?php

namespace App\Http\Middleware;

use App\Models\Company;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCompanyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $company = $request->route('company');

        // Super Admin a toujours accès
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Si company est un ID, récupérer le modèle
        if (is_numeric($company)) {
            $company = Company::find($company);
        }

        // Vérifier si l'utilisateur est admin de cette entreprise
        if (!$company || !$user->hasRoleInCompany($company, 'company_admin')) {
            abort(403, 'Accès refusé. Vous devez être administrateur de cette entreprise.');
        }

        return $next($request);
    }
}
