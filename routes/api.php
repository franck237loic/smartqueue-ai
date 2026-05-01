<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route de test API
Route::get('/test', function () {
    return response()->json([
        'message' => 'SmartQueue API is working!',
    ]);
});

// API routes pour les agents (authentifiés)
Route::middleware('auth')->group(function () {
    // Rappeler un ticket
    Route::post('/tickets/{ticket}/recall', function (App\Models\Ticket $ticket) {
        try {
            $user = auth()->user();
            
            // Super Admin (admin@smartqueue.ai) peut rappeler tous les tickets
            if ($user->email === 'admin@smartqueue.ai') {
                $hasAccess = true;
            } else {
                // Vérifier que l'utilisateur a accès au service du ticket via un counter
                $hasAccess = \App\Models\Counter::where('company_id', $ticket->company_id)
                    ->where('service_id', $ticket->service_id)
                    ->where('user_id', $user->id)
                    ->exists();
                
                // Si pas de counter spécifique, vérifier si l'utilisateur a des counters dans cette entreprise
                if (!$hasAccess) {
                    $hasAccess = \App\Models\Counter::where('company_id', $ticket->company_id)
                        ->where('user_id', $user->id)
                        ->exists();
                }
            }
            
            if (!$hasAccess) {
                return response()->json(['message' => 'Accès non autorisé à ce service'], 403);
            }
            
            // Rappeler le ticket et l'assigner à cet agent
            $ticket->update([
                'agent_id' => $user->id,
                'called_at' => now(),
                'status' => 'CALLED',
            ]);
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    });
});