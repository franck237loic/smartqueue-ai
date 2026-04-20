<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param array<string> $roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Super admin a accès à tout
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Vérifier le rôle global
        if (in_array($user->global_role, $roles)) {
            return $next($request);
        }

        // Vérifier le rôle dans l'entreprise courante
        $company = $request->route('company') ?? $user->currentCompany;

        if ($company && in_array($user->companyRole($company), $roles)) {
            return $next($request);
        }

        abort(403, 'Accès non autorisé.');
    }
}
