<?php
 
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyAdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WorkScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
 
/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/
 
Route::get('/', function () {
    return view('pages.home');
})->name('welcome');
 
// Page d'affichage public du ticket
Route::get('/ticket/{ticket}/display', function (App\Models\Ticket $ticket, Request $request) {
    try {
        // Vérifier l'accès par code de réponse ou par email/téléphone
        $responseCode = $request->input('code');
        $email = $request->input('email');
        $phone = $request->input('phone');
        
        $hasAccess = false;
        
        if ($responseCode && $ticket->client_response_code === $responseCode) {
            $hasAccess = true;
        } elseif ($email && $ticket->guest_email === $email) {
            $hasAccess = true;
        } elseif ($phone && $ticket->guest_phone === $phone) {
            $hasAccess = true;
        }
        
        if (!$hasAccess) {
            return response()->view('errors.403', [], 403);
        }
        
        return view('client.ticket-display', compact('ticket'));
        
    } catch (\Exception $e) {
        return response()->view('errors.500', [
            'error' => $e->getMessage()
        ], 500);
    }
})->name('ticket.display');

// Routes de test SMS (admin)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/sms-test', function () {
        return view('admin.sms-test');
    })->name('sms.test');
    
    Route::post('/sms-test/send', function (Request $request) {
        try {
            $smsService = app(App\Services\SMSService::class);
            $result = $smsService->send($request->phone, $request->message);
            
            return back()->with('success', 'Message de test envoyé! Vérifiez les logs.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    })->name('sms.test.send');
});

// API pour les logs SMS
Route::get('/api/sms-logs', function () {
    // Lire les logs récents pour les SMS
    $logFile = storage_path('logs/laravel.log');
    $logs = [];
    
    if (file_exists($logFile)) {
        $content = file_get_contents($logFile);
        $lines = array_reverse(explode("\n", $content));
        
        foreach ($lines as $line) {
            if (strpos($line, 'SMS SIMULATION') !== false || strpos($line, 'SMS sent') !== false) {
                // Parser la ligne pour extraire les infos
                if (preg_match('/\{.*\}/', $line, $matches)) {
                    $data = json_decode($matches[0], true);
                    if ($data) {
                        $logs[] = [
                            'to' => $data['to'] ?? 'Inconnu',
                            'message' => $data['message'] ?? 'Message vide',
                            'time' => $data['timestamp'] ?? now()->format('H:i:s'),
                            'sent' => strpos($line, 'SMS sent') !== false
                        ];
                    }
                }
            }
            
            if (count($logs) >= 10) break; // Limiter à 10 logs récents
        }
    }
    
    return response()->json(['logs' => $logs]);
});

// API pour tester l'appel de ticket
Route::post('/api/test/ticket-call', function (Request $request) {
    try {
        // Créer un ticket de test
        $ticket = App\Models\Ticket::create([
            'company_id' => 1,
            'service_id' => 1,
            'guest_phone' => $request->phone,
            'guest_name' => 'Test Client',
            'number' => 'TEST' . rand(100, 999),
            'status' => 'WAITING'
        ]);
        
        // Simuler l'appel du ticket
        $ticket->call();
        
        // Envoyer la notification
        $notificationService = app(App\Services\NotificationService::class);
        $notificationService->sendTicketCalledNotification($ticket);
        
        return response()->json([
            'success' => true,
            'ticket_id' => $ticket->id,
            'message' => 'Test d\'appel ticket effectué'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
});


// API publique pour les réponses client (sans authentification)
Route::post('/api/client/tickets/{ticket}/respond', function (App\Models\Ticket $ticket, Request $request) {
    try {
        $response = $request->input('response');
        $delayMinutes = $request->input('delay_minutes', 5);
        
        // Vérifier que le ticket est bien appelé
        if ($ticket->status !== 'CALLED') {
            return response()->json([
                'success' => false,
                'message' => 'Ce ticket n\'est pas actuellement appelé'
            ], 400);
        }
        
        switch ($response) {
            case 'coming':
                $ticket->respondAsComing();
                $ticket->serve(); // Marquer comme servi immédiatement
                $message = 'Présence confirmée! Le ticket est maintenant servi.';
                
                // Envoyer la notification à l'agent
                $notificationService = app(App\Services\NotificationService::class);
                $notificationService->sendClientResponseNotification($ticket, 'COMING');
                break;
            case 'delayed':
                $ticket->respondAsDelayed($delayMinutes);
                $message = "Noté. Retard de {$delayMinutes} minutes enregistré.";
                
                $notificationService = app(App\Services\NotificationService::class);
                $notificationService->sendClientResponseNotification($ticket, 'DELAYED');
                break;
            case 'not_coming':
                $ticket->respondAsNotComing();
                $message = 'Votre ticket a été annulé.';
                
                $notificationService = app(App\Services\NotificationService::class);
                $notificationService->sendClientResponseNotification($ticket, 'NOT_COMING');
                break;
            case 'need_help':
                $ticket->respondAsNeedHelp();
                $message = 'Un agent va vous aider rapidement.';
                
                $notificationService = app(App\Services\NotificationService::class);
                $notificationService->sendClientResponseNotification($ticket, 'NEED_HELP');
                break;
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Réponse non valide'
                ], 400);
        }
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'ticket_status' => $ticket->status,
            'client_response' => $ticket->getClientResponseStatus()
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la réponse: ' . $e->getMessage()
        ], 500);
    }
})->name('api.client.tickets.respond');


// Page de réponse client (publique)
Route::get('/ticket/{ticket}/respond', function (App\Models\Ticket $ticket, Request $request) {
    try {
        // Vérifier l'accès par code de réponse ou par email/téléphone
        $responseCode = $request->input('code');
        $email = $request->input('email');
        $phone = $request->input('phone');
        
        $hasAccess = false;
        
        if ($responseCode && $ticket->client_response_code === $responseCode) {
            $hasAccess = true;
        } elseif ($email && $ticket->guest_email === $email) {
            $hasAccess = true;
        } elseif ($phone && $ticket->guest_phone === $phone) {
            $hasAccess = true;
        }
        
        if (!$hasAccess) {
            return response()->view('errors.403', [], 403);
        }
        
        // Vérifier que le ticket est bien appelé
        if ($ticket->status !== 'CALLED') {
            return response()->view('errors.404', [
                'message' => 'Ce ticket n\'est pas actuellement appelé'
            ], 404);
        }
        
        return view('client.ticket-response', compact('ticket'));
        
    } catch (\Exception $e) {
        return response()->view('errors.500', [
            'error' => $e->getMessage()
        ], 500);
    }
})->name('ticket.respond');
 
// Companies page
Route::get('/entreprises', function () {
    return view('pages.companies');
})->name('companies.index');
 
// Public ticket page
Route::get('/ticket/{company}', function ($companyId) {
    $company = \App\Models\Company::findOrFail($companyId);
    return view('pages.ticket', compact('company'));
})->name('ticket');
 
// Client ticket selection page
Route::get('/client/ticket', function () {
    $companies = \App\Models\Company::where('status', 'active')->get();
    return view('pages.client-ticket', compact('companies'));
})->name('client.ticket');
 
// Create ticket route
Route::post('/ticket/{company}', function (\App\Models\Company $company, \Illuminate\Http\Request $request) {
    $validated = $request->validate([
        'service'  => 'required|exists:services,id',
        'name'     => 'required|string|max:255',
        'phone'    => 'nullable|string|max:20',
        'email'    => 'nullable|email|max:255',
        'priority' => 'required|in:normal,urgent,vip',
    ]);
 
    $service = \App\Models\Service::find($validated['service']);
 
    $counter = \App\Models\Counter::where('service_id', $service->id)
        ->where('company_id', $company->id)
        ->where('status', 'closed')
        ->first();
 
    if (!$counter) {
        $counter = \App\Models\Counter::where('service_id', $service->id)
            ->where('company_id', $company->id)
            ->first();
    }
 
    $todayTickets = \App\Models\Ticket::whereDate('created_at', today())->count();
    $ticketNumber = $service->prefix . str_pad($todayTickets + 1, 3, '0', STR_PAD_LEFT);
 
    $ticket = \App\Models\Ticket::create([
        'company_id'   => $company->id,
        'service_id'   => $service->id,
        'counter_id'   => $counter ? $counter->id : null,
        'number'       => $ticketNumber,
        'guest_name'   => $validated['name'],
        'guest_phone'  => $validated['phone'],
        'priority'     => $validated['priority'],
        'status'       => 'WAITING',
        'created_at'   => now(),
    ]);
 
    return response()->json([
        'success' => true,
        'ticket'  => [
            'number'         => $ticket->number,
            'service'        => $service->name,
            'priority'       => $ticket->priority,
            'counter'        => $counter ? $counter->name : null,
            'estimated_time' => $service->estimated_service_time ?? 15,
        ],
    ]);
})->name('ticket.create');
 
 
/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
 
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
 
// Inscription réservée au super admin
Route::middleware(['auth', 'is.super.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
 
// Logout
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout')->middleware('auth');
 
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout.post')->middleware('auth');
 
// Sélection d'entreprise
Route::get('/select-company', [AuthController::class, 'selectCompany'])
    ->name('select.company')
    ->middleware('auth');
 
// Switch company
Route::post('/switch-company/{company}', function (\App\Models\Company $company) {
    $user = auth()->user();
 
    if (!$user->hasAccessToCompany($company)) {
        return back()->with('error', 'Vous n\'avez pas accès à cette entreprise.');
    }
 
    $user->setCurrentCompany($company);
    $role = $user->getRoleInCompany($company);
 
    if ($role === 'company_admin') {
        return redirect()->route('company.admin.dashboard', $company);
    } elseif ($role === 'agent') {
        return redirect()->route('company.agent.dashboard', $company);
    }
 
    return redirect()->route('welcome');
})->name('switch.company')->middleware('auth');
 
 
/*
|--------------------------------------------------------------------------
| Routes Super Admin (gestion entreprises)
|--------------------------------------------------------------------------
*/
 
Route::middleware(['auth', 'isSuperAdmin'])->prefix('admin')->name('admin.')->group(function () {
 
    Route::post('/company/{company}/deactivate', function (\App\Models\Company $company) {
        $company->deactivate();
        return back()->with('success', 'Entreprise désactivée avec succès. Accès fermés.');
    })->name('company.deactivate');
 
    Route::post('/company/{company}/activate', function (\App\Models\Company $company) {
        $company->activate();
        return back()->with('success', 'Entreprise réactivée avec succès.');
    })->name('company.activate');
 
    Route::get('/companies', [SuperAdminController::class, 'companies'])->name('admin.companies.index');
    Route::get('/companies/{company}/reset-password', [SuperAdminController::class, 'showResetPasswordForm'])->name('companies.reset-password');
    Route::post('/companies/{company}/reset-password', [SuperAdminController::class, 'resetPassword'])->name('companies.reset-password.post');
    Route::post('/companies/{company}/auto-reset-password', [SuperAdminController::class, 'autoResetPassword'])->name('companies.auto-reset-password');
});
 
 
/*
|--------------------------------------------------------------------------
| Routes Client (sans authentification)
|--------------------------------------------------------------------------
*/
 
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/', [PublicController::class, 'clientDashboard'])->name('dashboard');
    Route::get('/ticket', [PublicController::class, 'selectCompany'])->name('ticket');
    Route::get('/ticket/{ticket}', [PublicController::class, 'showTicket'])->name('ticket.show');
    Route::delete('/ticket/{ticket}', [PublicController::class, 'cancelTicket'])->name('ticket.cancel');
});

// Route POST séparée pour éviter les conflits
Route::post('/client/ticket/{ticket}/confirm', [PublicController::class, 'confirmPresence'])->name('client.ticket.confirm');
 
 
/*
|--------------------------------------------------------------------------
| Routes Publiques Company (sans auth)
|--------------------------------------------------------------------------
*/
 
Route::get('/company/{company}/public', [PublicController::class, 'index'])->name('company.public');
Route::post('/company/{company}/ticket/take/{service}', [PublicController::class, 'takeTicket'])->name('company.ticket.take');
Route::get('/company/{company}/ticket/{ticket}', [PublicController::class, 'showTicket'])->name('company.ticket.show');
Route::get('/company/{company}/ticket/{ticket}/status', [PublicController::class, 'ticketStatus'])->name('company.ticket.status');
Route::delete('/company/{company}/ticket/{ticket}', [PublicController::class, 'cancelTicket'])->name('company.ticket.cancel');
Route::get('/company/{company}/stats', [PublicController::class, 'getStats'])->name('company.stats');
Route::get('/company/{company}/waiting-tickets', [PublicController::class, 'getWaitingTickets'])->name('company.waiting-tickets');
 
// Écran d'appel public (TV/Affichage)
Route::get('/company/{company}/display', [PublicController::class, 'display'])->name('company.display');

/*
|--------------------------------------------------------------------------
| Routes Analytics et Monitoring (nécessitent auth)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Analytics
    Route::get('/company/{company}/analytics', [AnalyticsController::class, 'dashboard'])->name('company.analytics.dashboard');
    Route::get('/company/{company}/analytics/real-time', [AnalyticsController::class, 'realTimeData'])->name('company.analytics.realtime');
    Route::get('/company/{company}/analytics/export', [AnalyticsController::class, 'exportReport'])->name('company.analytics.export');
    Route::get('/company/{company}/analytics/widget', [AnalyticsController::class, 'widget'])->name('company.analytics.widget');
    Route::get('/company/{company}/analytics/metrics', [AnalyticsController::class, 'metrics'])->name('company.analytics.metrics');
    
    // Monitoring
    // Route::get('/company/{company}/monitoring', [MonitoringController::class, 'dashboard'])->name('company.monitoring.dashboard');
    // Route::get('/company/{company}/monitoring/real-time', [MonitoringController::class, 'realTimeMonitoring'])->name('company.monitoring.realtime');
    // Route::get('/company/{company}/monitoring/metrics', [MonitoringController::class, 'metrics'])->name('company.monitoring.metrics');
});

/*
|--------------------------------------------------------------------------
| Routes API pour les services externes
|--------------------------------------------------------------------------
*/

// Route::get('/health', [MonitoringController::class, 'healthCheck'])->name('health.check');
Route::get('/api/company/{company}/predict/wait-time', function (Company $company) {
    $predictor = app(\App\Services\WaitTimePredictor::class);
    return response()->json($predictor->getAllServicesPredictions($company));
})->name('api.predict.wait-time');

Route::get('/api/company/{company}/analytics/load', function (Company $company) {
    $analyzer = app(\App\Services\LoadAnalyzer::class);
    return response()->json($analyzer->analyzeCurrentLoad($company));
})->name('api.analytics.load');

Route::get('/api/company/{company}/performance/score', function (Company $company) {
    $scorer = app(\App\Services\PerformanceScorer::class);
    return response()->json($scorer->calculateCompanyScore($company));
})->name('api.performance.score');
 
 
/*
|--------------------------------------------------------------------------
| Routes Authentifiées - Multi-Tenant :company
|--------------------------------------------------------------------------
*/
 
Route::middleware(['auth', 'belongs.to.company'])->group(function () {
 
    // Dashboard principal (redirection selon rôle)
    Route::get('/company/{company}', [AuthController::class, 'dashboard'])->name('company.dashboard');
 
    /*
    |--------------------------------------------------------------------------
    | Routes Company Admin
    |--------------------------------------------------------------------------
    */
    Route::middleware(['isCompanyAdmin'])
        ->prefix('company/{company}/admin')
        ->name('company.admin.')
        ->group(function () {
 
            Route::get('/', [CompanyAdminController::class, 'dashboard'])->name('dashboard');
 
            // Services
            Route::get('/services', [CompanyAdminController::class, 'services'])->name('services');
            Route::get('/services/create', [CompanyAdminController::class, 'createService'])->name('services.create');
            Route::post('/services', [CompanyAdminController::class, 'storeService'])->name('services.store');
            Route::get('/services/{service}/edit', [CompanyAdminController::class, 'editService'])->name('services.edit');
            Route::put('/services/{service}', [CompanyAdminController::class, 'updateService'])->name('services.update');
            Route::delete('/services/{service}', [CompanyAdminController::class, 'destroyService'])->name('services.destroy');
 
            // Guichets / Counters
            Route::get('/counters', [CompanyAdminController::class, 'counters'])->name('counters');
            Route::get('/counters/create', [CompanyAdminController::class, 'createCounter'])->name('counters.create');
            Route::post('/counters', [CompanyAdminController::class, 'storeCounter'])->name('counters.store');
            Route::get('/counters/{counter}/edit', [CompanyAdminController::class, 'editCounter'])->name('counters.edit');
            Route::put('/counters/{counter}', [CompanyAdminController::class, 'updateCounter'])->name('counters.update');
            Route::delete('/counters/{counter}', [CompanyAdminController::class, 'destroyCounter'])->name('counters.destroy');
 
            // Agents
            Route::get('/agents', [CompanyAdminController::class, 'agents'])->name('agents');
            Route::get('/agents/create', [CompanyAdminController::class, 'createAgent'])->name('agents.create');
            Route::post('/agents', [CompanyAdminController::class, 'storeAgent'])->name('agents.store');
            Route::get('/agents/{agent}/edit', [CompanyAdminController::class, 'editAgent'])->name('agents.edit');
            Route::put('/agents/{agent}', [CompanyAdminController::class, 'updateAgent'])->name('agents.update');
            Route::post('/agents/{agent}', [CompanyAdminController::class, 'updateAgent'])->name('agents.update.post');
            Route::delete('/agents/{agent}', [CompanyAdminController::class, 'destroyAgent'])->name('agents.destroy');
            Route::get('/agents/{agent}/details', [CompanyAdminController::class, 'agentDetails'])->name('agents.details');
 
            // Statistiques
            Route::get('/statistics', [CompanyAdminController::class, 'statistics'])->name('statistics');

            // Horaires de travail
            Route::get('/work-schedules', [WorkScheduleController::class, 'index'])->name('work-schedules');
            Route::get('/work-schedules/create', [WorkScheduleController::class, 'create'])->name('work-schedules.create');
            Route::post('/work-schedules', [WorkScheduleController::class, 'store'])->name('work-schedules.store');
            Route::get('/work-schedules/{workSchedule}', [WorkScheduleController::class, 'show'])->name('work-schedules.show');
            Route::get('/work-schedules/{workSchedule}/edit', [WorkScheduleController::class, 'edit'])->name('work-schedules.edit');
            Route::put('/work-schedules/{workSchedule}', [WorkScheduleController::class, 'update'])->name('work-schedules.update');
            Route::delete('/work-schedules/{workSchedule}', [WorkScheduleController::class, 'destroy'])->name('work-schedules.destroy');
            Route::post('/work-schedules/{workSchedule}/toggle', [WorkScheduleController::class, 'toggle'])->name('work-schedules.toggle');
            Route::get('/work-schedules/counter/{counter}', [WorkScheduleController::class, 'forCounter'])->name('work-schedules.counter');
            Route::get('/work-schedules/status/current', [WorkScheduleController::class, 'currentStatus'])->name('work-schedules.status');
            Route::post('/work-schedules/bulk-create', [WorkScheduleController::class, 'bulkCreate'])->name('work-schedules.bulk-create');
            Route::get('/statistics/service/{service}', [CompanyAdminController::class, 'serviceStatistics'])->name('statistics.service');
 
            // Tickets admin
            Route::get('/tickets', [TicketController::class, 'index'])->name('admin.tickets.index');
            
            // Paramètres
            Route::get('/settings', [CompanyAdminController::class, 'settings'])->name('settings');
        });
 
    /*
    |--------------------------------------------------------------------------
    | Routes Tickets - Client authentifié
    |--------------------------------------------------------------------------
    */
    Route::prefix('company/{company}/tickets')->name('tickets.')->group(function () {
        Route::get('/select-service', [TicketController::class, 'selectService'])->name('select-service');
        Route::post('/', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/{ticket}/track', [TicketController::class, 'track'])->name('track');
        Route::post('/take/{service}', [TicketController::class, 'takeTicket'])->name('take');
        Route::get('/display', [TicketController::class, 'publicDisplay'])->name('public-display');
        Route::get('/api/currently-called', [TicketController::class, 'apiCurrentlyCalled'])->name('api.called');
        Route::get('/api/{ticket}/status', [TicketController::class, 'apiStatus'])->name('api.status');
    });
 
    /*
    |--------------------------------------------------------------------------
    | Routes Agent
    | ✅ UNE SEULE définition de company.agent.dashboard ici
    |--------------------------------------------------------------------------
    */
 
    // Dashboard agent (accessible sans middleware agent.only pour éviter la boucle)
    Route::get('/company/{company}/agent', [AgentController::class, 'dashboard'])
        ->name('company.agent.dashboard');
 
    // Reste des routes agent protégées par agent.only
    Route::middleware(['agent.only'])
        ->prefix('company/{company}/agent')
        ->name('company.agent.')
        ->group(function () {
 
            Route::get('/counter/{counter}', [AgentController::class, 'counter'])->name('counter');
            Route::get('/service/{service}', [AgentController::class, 'service'])->name('service');
            Route::get('/service/all', [AgentController::class, 'allServices'])->name('service.all');
            Route::get('/history', [AgentController::class, 'history'])->name('history');
 
            // Actions tickets
            Route::post('/call-next', [TicketController::class, 'callNext'])->name('call-next');
            Route::post('/ticket/{ticket}/present', [TicketController::class, 'markPresent'])->name('ticket.present');
            Route::post('/ticket/{ticket}/serve', [TicketController::class, 'markServed'])->name('ticket.serve');
            Route::post('/ticket/{ticket}/serving', [TicketController::class, 'markServing'])->name('ticket.serving');
            Route::post('/ticket/{ticket}/missed', [TicketController::class, 'markMissed'])->name('ticket.missed');
            Route::post('/ticket/{ticket}/recall', [TicketController::class, 'recallTicket'])->name('ticket.recall');
            Route::post('/ticket/{ticket}/transfer/{service}', [TicketController::class, 'transfer'])->name('agent.ticket.transfer');
 
            // Ouvrir/Fermer guichet
            Route::post('/counter/{counter}/open', [AgentController::class, 'openCounter'])->name('counter.open');
            Route::post('/counter/{counter}/close', [AgentController::class, 'closeCounter'])->name('counter.close');
            Route::post('/counter/{counter}/pause', [AgentController::class, 'pauseCounter'])->name('counter.pause');
            Route::post('/counter/{counter}/resume', [AgentController::class, 'resumeCounter'])->name('counter.resume');
        });
 
    // Actions tickets agent (hors groupe préfixé)
    Route::post('/company/{company}/agent/ticket/{ticket}/call', [AgentController::class, 'callTicket'])->name('company.agent.ticket.call');
    Route::post('/company/{company}/agent/ticket/{ticket}/serve', [AgentController::class, 'serveTicket'])->name('company.agent.ticket.serve');
    Route::post('/company/{company}/agent/ticket/{ticket}/complete', [AgentController::class, 'completeTicket'])->name('company.agent.ticket.complete');
    Route::post('/company/{company}/agent/ticket/{ticket}/miss', [AgentController::class, 'missTicket'])->name('company.agent.ticket.miss');
    Route::post('/company/{company}/agent/ticket/{ticket}/transfer', [AgentController::class, 'transferTicket'])->name('company.agent.ticket.transfer');
});
 
 
/*
|--------------------------------------------------------------------------
| Routes Super Admin Global
|--------------------------------------------------------------------------
*/
 
Route::middleware(['auth', 'isSuperAdmin'])
    ->prefix('super-admin')
    ->name('super_admin.')
    ->group(function () {
 
        Route::get('/', [SuperAdminController::class, 'dashboard'])->name('dashboard');
 
        Route::get('/companies', [SuperAdminController::class, 'companies'])->name('companies');
        Route::get('/companies/create', [SuperAdminController::class, 'createCompany'])->name('companies.create');
        Route::post('/companies', [SuperAdminController::class, 'storeCompany'])->name('companies.store');
        Route::get('/companies/{company}', [SuperAdminController::class, 'showCompany'])->name('companies.show');
        Route::get('/companies/{company}/edit', [SuperAdminController::class, 'editCompany'])->name('companies.edit');
        Route::put('/companies/{company}', [SuperAdminController::class, 'updateCompany'])->name('companies.update');
        Route::delete('/companies/{company}', [SuperAdminController::class, 'destroyCompany'])->name('companies.destroy');
 
        Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
        Route::post('/users/{user}/make-super-admin', [SuperAdminController::class, 'makeSuperAdmin'])->name('users.make-super-admin');
    });
 
 
/*
|--------------------------------------------------------------------------
| Routes Tickets (auth général)
|--------------------------------------------------------------------------
*/
 
Route::middleware(['auth'])->prefix('tickets')->group(function () {
    Route::get('/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
});
 
 
/*
|--------------------------------------------------------------------------
| Route de Test Debug
|--------------------------------------------------------------------------
*/
Route::get('/test-debug', function () {
    return response()->json([
        'debug' => 'Test route working',
        'php_version' => PHP_VERSION,
        'laravel_version' => app()->version(),
        'user_authenticated' => auth()->check(),
        'user_id' => auth()->id(),
        'timestamp' => now()->toISOString()
    ]);
});

Route::get('/test-agent', function () {
    try {
        if (!auth()->check()) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }
        
        $user = auth()->user();
        $company = \App\Models\Company::find(1);
        
        if (!$company) {
            return response()->json(['error' => 'Company not found'], 404);
        }
        
        return response()->json([
            'debug' => 'Agent test working',
            'user_id' => $user->id,
            'user_email' => $user->email,
            'company_id' => $company->id,
            'company_name' => $company->name,
            'has_access' => $user->hasAccessToCompany($company),
            'is_agent' => $user->isAgentInCompany($company)
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]);
    }
});

// API Routes pour Dashboard Agent
Route::middleware(['auth', 'belongs.to.company'])->prefix('api')->group(function () {
    // Appeler le prochain ticket pour un service
    Route::post('/services/{service}/call-next', function (App\Models\Service $service) {
        try {
            $user = auth()->user();
            $company = $service->company;
            
            // Vérifier que l'utilisateur est un agent
            if (!$user->isAgentInCompany($company)) {
                return response()->json(['message' => 'Accès non autorisé'], 403);
            }
            
            // Récupérer le prochain ticket en attente
            $nextTicket = $service->waitingTickets()
                ->where('status', 'WAITING')
                ->orderBy('created_at', 'asc')
                ->first();
            
            if (!$nextTicket) {
                return response()->json(['message' => 'Aucun ticket en attente'], 404);
            }
            
            // Marquer le ticket comme appelé
            $nextTicket->update([
                'status' => 'CALLED',
                'called_at' => now(),
                'agent_id' => $user->id,
            ]);
            
            return response()->json([
                'success' => true,
                'ticket' => [
                    'id' => $nextTicket->id,
                    'number' => $nextTicket->number,
                    'service_name' => $nextTicket->service->name,
                    'guest_name' => $nextTicket->guest_name,
                    'status' => $nextTicket->status,
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    });
    
    // Réponses client
    Route::post('/tickets/{ticket}/respond', function (App\Models\Ticket $ticket, Request $request) {
        try {
            $user = auth()->user();
            
            // Vérifier que l'utilisateur a accès à l'entreprise
            if (!$user->hasAccessToCompany($ticket->company)) {
                return response()->json(['message' => 'Accès non autorisé'], 403);
            }
            
            $response = $request->input('response');
            $delayMinutes = $request->input('delay_minutes', 5);
            
            switch ($response) {
                case 'coming':
                    $ticket->respondAsComing();
                    $message = 'Merci ! Nous vous attendons.';
                    break;
                case 'delayed':
                    $ticket->respondAsDelayed($delayMinutes);
                    $message = "Noté. Retard de {$delayMinutes} minutes enregistré.";
                    break;
                case 'not_coming':
                    $ticket->respondAsNotComing();
                    $message = 'Votre ticket a été annulé.';
                    break;
                case 'need_help':
                    $ticket->respondAsNeedHelp();
                    $message = 'Un agent va vous aider rapidement.';
                    break;
                default:
                    return response()->json(['message' => 'Réponse invalide'], 400);
            }
            
            // Notifier l'agent
            broadcast(new App\Events\TicketUpdated($ticket, [
                'type' => 'client_responded',
                'response' => $response,
                'message' => $ticket->getClientResponseStatus(),
            ]));
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'ticket' => [
                    'id' => $ticket->id,
                    'number' => $ticket->number,
                    'status' => $ticket->status,
                    'client_response' => $ticket->client_response,
                    'client_response_at' => $ticket->client_response_at,
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    });
    
    // Obtenir le statut d'un ticket pour le client
    Route::get('/tickets/{ticket}/status', function (App\Models\Ticket $ticket, Request $request) {
        try {
            // Vérifier l'accès par code de réponse ou par email/téléphone
            $responseCode = $request->input('code');
            $email = $request->input('email');
            $phone = $request->input('phone');
            
            $hasAccess = false;
            
            if ($responseCode && $ticket->client_response_code === $responseCode) {
                $hasAccess = true;
            } elseif ($email && $ticket->guest_email === $email) {
                $hasAccess = true;
            } elseif ($phone && $ticket->guest_phone === $phone) {
                $hasAccess = true;
            }
            
            if (!$hasAccess) {
                return response()->json(['message' => 'Accès non autorisé'], 403);
            }
            
            return response()->json([
                'success' => true,
                'ticket' => [
                    'id' => $ticket->id,
                    'number' => $ticket->number,
                    'service_name' => $ticket->service->name,
                    'status' => $ticket->status,
                    'called_at' => $ticket->called_at,
                    'client_response' => $ticket->client_response,
                    'client_response_at' => $ticket->client_response_at,
                    'client_response_status' => $ticket->getClientResponseStatus(),
                    'can_respond' => $ticket->status === 'CALLED' && !$ticket->hasClientResponded(),
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    });
    
    // Marquer un ticket comme servi
    Route::post('/tickets/{ticket}/serve', function (App\Models\Ticket $ticket) {
        try {
            $user = auth()->user();
            
            // Vérifier que l'utilisateur est l'agent assigné
            if ($ticket->agent_id !== $user->id) {
                return response()->json(['message' => 'Accès non autorisé'], 403);
            }
            
            // Marquer comme servi
            $ticket->serve();
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    });
    
    // Marquer un ticket comme absent
    Route::post('/tickets/{ticket}/miss', function (App\Models\Ticket $ticket) {
        try {
            $user = auth()->user();
            
            // Vérifier que l'utilisateur est l'agent assigné
            if ($ticket->agent_id !== $user->id) {
                return response()->json(['message' => 'Accès non autorisé'], 403);
            }
            
            // Marquer comme manqué
            $ticket->markAsMissed();
            
            return response()->json(['success' => true]);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    });
    
    // Rappeler un ticket
    Route::post('/tickets/{ticket}/recall', function (App\Models\Ticket $ticket) {
        try {
            $user = auth()->user();
            
            // Vérifier que l'utilisateur a accès au service du ticket
            $hasAccess = \App\Models\Counter::where('company_id', $ticket->company_id)
                ->where('service_id', $ticket->service_id)
                ->where('user_id', $user->id)
                ->exists();
            
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
    
    // Obtenir le statut d'un service
    Route::get('/services/{service}/status', function (App\Models\Service $service) {
        try {
            $user = auth()->user();
            
            // Vérifier que l'utilisateur a accès à l'entreprise
            if (!$user->hasAccessToCompany($service->company)) {
                return response()->json(['message' => 'Accès non autorisé'], 403);
            }
            
            return response()->json([
                'service_id' => $service->id,
                'service_name' => $service->name,
                'waiting_count' => $service->waitingTickets()->where('status', 'WAITING')->count(),
                'total_today' => $service->tickets()->whereDate('created_at', today())->count(),
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    });
    
    // Obtenir les statistiques de performance de l'entreprise
    Route::get('/companies/{company}/performance', function (App\Models\Company $company) {
        try {
            $user = auth()->user();
            
            // Vérifier que l'utilisateur a accès à l'entreprise
            if (!$user->hasAccessToCompany($company)) {
                return response()->json(['message' => 'Accès non autorisé'], 403);
            }
            
            $intelligenceService = app(\App\Services\TicketIntelligenceService::class);
            $stats = $intelligenceService->getCompanyPerformanceStats($company);
            
            return response()->json([
                'success' => true,
                'stats' => $stats,
                'timestamp' => now()->toISOString(),
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    });
});

/*
|--------------------------------------------------------------------------
| API Files d'attente
|--------------------------------------------------------------------------
*/
 
Route::get('/api/companies/{company}/queues/stats', function (App\Models\Company $company) {
    $services = $company->services()->withCount(['waitingTickets'])->get();
    
    return response()->json([
        'services' => $services->map(function ($service) {
            return [
                'id' => $service->id,
                'name' => $service->name,
                'prefix' => $service->prefix,
                'waiting_count' => $service->waiting_tickets_count,
                'next_ticket' => $service->prefix . str_pad(($service->tickets()->max('sequence') ?? 0) + 1, 3, '0', STR_PAD_LEFT),
            ];
        }),
        'total_waiting' => $company->tickets()->where('status', 'WAITING')->count(),
    ]);
});


// Route de secours pour l'ancienne URL client/ticket/{id}/confirm (évite les conflits)
Route::post('/client-confirm/{ticket}', function (App\Models\Ticket $ticket, Request $request) {
    try {
        // Vérifier que le ticket est bien appelé
        if ($ticket->status !== 'CALLED') {
            return response()->json([
                'success' => false,
                'message' => 'Ce ticket n\'est pas actuellement appelé'
            ], 400);
        }
        
        // Marquer comme présent et servi
        $ticket->respondAsComing();
        $ticket->serve();
        
        // Envoyer la notification à l'agent
        $notificationService = app(App\Services\NotificationService::class);
        $notificationService->sendClientResponseNotification($ticket, 'COMING');
        
        return response()->json([
            'success' => true,
            'message' => 'Présence confirmée! Le ticket est maintenant servi.',
            'ticket_status' => $ticket->status,
            'client_response' => $ticket->getClientResponseStatus()
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur lors de la confirmation: ' . $e->getMessage()
        ], 500);
    }
})->name('client.confirm');
 