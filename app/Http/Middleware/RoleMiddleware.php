<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        $hasRole = match ($role) {
            'admin' => $user->isAdmin(),
            'agent' => $user->isAgent() || $user->isAdmin(),
            'client' => true,
            default => false,
        };

        if (!$hasRole) {
            abort(403, 'Accès non autorisé.');
        }

        return $next($request);
    }
}
