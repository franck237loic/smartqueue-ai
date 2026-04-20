<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    /**
     * Redirection intelligente après login selon le rôle
     */
    public function redirectAfterLogin()
    {
        $user = Auth::user();

        // Super admin
        if ($user->isSuperAdmin()) {
            return redirect()->route('super_admin.dashboard');
        }

        // Rediriger vers la sélection d'entreprise
        return redirect()->route('select-company');
    }
}
