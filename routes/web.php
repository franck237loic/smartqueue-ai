<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyAdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('pages.home');
})->name('welcome');

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
    // Validate request
    $validated = $request->validate([
        'service' => 'required|exists:services,id',
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'priority' => 'required|in:normal,urgent,vip',
    ]);

    // Get service details
    $service = \App\Models\Service::find($validated['service']);
    
    // Find available counter for this service
    $counter = \App\Models\Counter::where('service_id', $service->id)
        ->where('company_id', $company->id)
        ->where('status', 'closed')
        ->first();

    if (!$counter) {
        // If no closed counter, get the first available
        $counter = \App\Models\Counter::where('service_id', $service->id)
            ->where('company_id', $company->id)
            ->first();
    }

    // Generate ticket number
    $todayTickets = \App\Models\Ticket::whereDate('created_at', today())->count();
    $ticketNumber = $service->prefix . str_pad($todayTickets + 1, 3, '0', STR_PAD_LEFT);

    // Create ticket
    $ticket = \App\Models\Ticket::create([
        'company_id' => $company->id,
        'service_id' => $service->id,
        'counter_id' => $counter ? $counter->id : null,
        'number' => $ticketNumber,
        'client_name' => $validated['name'],
        'client_phone' => $validated['phone'],
        'client_email' => $validated['email'],
        'priority' => $validated['priority'],
        'status' => 'waiting',
        'created_at' => now(),
    ]);

    return response()->json([
        'success' => true,
        'ticket' => [
            'number' => $ticket->number,
            'service' => $service->name,
            'priority' => $ticket->priority,
            'counter' => $counter ? $counter->name : null,
            'estimated_time' => $service->estimated_service_time ?? 15,
        ]
    ]);
})->name('ticket.create');

// Agent call center
Route::get('/agent/call-center/{company}', function ($companyId) {
    $company = \App\Models\Company::findOrFail($companyId);
    return view('agent.call_center', compact('company'));
})->name('agent.call_center')->middleware('auth');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout accessible en GET (liens directs) et POST (formulaires)
Route::get('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout')->middleware('auth');

// Sélection d'entreprise (multi-entreprises)
Route::get('/select-company', [AuthController::class, 'selectCompany'])->name('select.company')->middleware('auth');

// Switch company route
Route::post('/switch-company/{company}', function (\App\Models\Company $company) {
    $user = auth()->user();
    
    // Vérifier que l'utilisateur a accès à cette entreprise
    if (!$user->hasAccessToCompany($company)) {
        return back()->with('error', 'Vous n\'avez pas accès à cette entreprise.');
    }
    
    // Définir l'entreprise actuelle
    $user->setCurrentCompany($company);
    
    // Redirection selon le rôle dans l'entreprise
    $role = $user->getRoleInCompany($company);
    
    if ($role === 'company_admin') {
        return redirect()->route('company.admin.dashboard', $company);
    } elseif ($role === 'agent') {
        return redirect()->route('company.agent.dashboard', $company);
    }
    
    // Fallback vers la page d'accueil
    return redirect()->route('welcome');
})->name('switch.company')->middleware('auth');

// Routes Super Admin pour la gestion des entreprises
Route::middleware(['auth', 'isSuperAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/company/{company}/deactivate', function (\App\Models\Company $company) {
        $company->deactivate();
        return back()->with('success', 'Entreprise désactivée avec succès. Accès fermés.');
    })->name('company.deactivate');
    
    Route::post('/company/{company}/activate', function (\App\Models\Company $company) {
        $company->activate();
        return back()->with('success', 'Entreprise réactivée avec succès.');
    })->name('company.activate');
    
    // Gestion des entreprises
    Route::get('/companies', [SuperAdminController::class, 'companies'])->name('admin.companies.index');
    
    // Récupération des identifiants des entreprises
    Route::get('/companies/{company}/reset-password', [SuperAdminController::class, 'showResetPasswordForm'])->name('companies.reset-password');
    Route::post('/companies/{company}/reset-password', [SuperAdminController::class, 'resetPassword'])->name('companies.reset-password.post');
    Route::post('/companies/{company}/auto-reset-password', [SuperAdminController::class, 'autoResetPassword'])->name('companies.auto-reset-password');
});

// Routes Client (sans authentification)
Route::prefix('client')->name('client.')->group(function () {
    Route::get('/', [PublicController::class, 'clientDashboard'])->name('dashboard');
    Route::get('/ticket', [PublicController::class, 'selectCompany'])->name('ticket');
    Route::get('/ticket/{ticket}', [PublicController::class, 'showTicket'])->name('ticket.show');
    Route::post('/ticket/{ticket}/confirm', [PublicController::class, 'confirmPresence'])->name('confirm');
    Route::delete('/ticket/{ticket}', [PublicController::class, 'cancelTicket'])->name('ticket.cancel');
});

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout.post')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Routes SaaS Multi-Tenant :company
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'belongs.to.company'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Routes Super Admin & Company Admin (doivent être avant company.dashboard)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'isCompanyAdmin'])->prefix('company/{company}/admin')->name('company.admin.')->group(function () {

        Route::get('/', [CompanyAdminController::class, 'dashboard'])->name('dashboard');

        // Services
        Route::get('/services', [CompanyAdminController::class, 'services'])->name('services');
        Route::get('/services/create', [CompanyAdminController::class, 'createService'])->name('services.create');
        Route::post('/services', [CompanyAdminController::class, 'storeService'])->name('services.store');
        Route::get('/services/{service}/edit', [CompanyAdminController::class, 'editService'])->name('services.edit');
        Route::put('/services/{service}', [CompanyAdminController::class, 'updateService'])->name('services.update');
        Route::delete('/services/{service}', [CompanyAdminController::class, 'destroyService'])->name('services.destroy');

        // Guichets
        Route::get('/counters', [CompanyAdminController::class, 'counters'])->name('counters');
        
        // Agents
        Route::get('/agents', [CompanyAdminController::class, 'agents'])->name('agents');
        Route::get('/agents/create', [CompanyAdminController::class, 'createAgent'])->name('agents.create');
        Route::post('/agents', [CompanyAdminController::class, 'storeAgent'])->name('agents.store');
        Route::get('/agents/{agent}/edit', [CompanyAdminController::class, 'editAgent'])->name('agents.edit');
        Route::put('/agents/{agent}', [CompanyAdminController::class, 'updateAgent'])->name('agents.update');
        Route::delete('/agents/{agent}', [CompanyAdminController::class, 'destroyAgent'])->name('agents.destroy');
        Route::get('/agents/{agent}/details', [CompanyAdminController::class, 'agentDetails'])->name('agents.details');
        
        // Counters
        Route::get('/counters', [CompanyAdminController::class, 'counters'])->name('counters');
        Route::get('/counters/create', [CompanyAdminController::class, 'createCounter'])->name('counters.create');
        Route::post('/counters', [CompanyAdminController::class, 'storeCounter'])->name('counters.store');
        Route::get('/counters/{counter}/edit', [CompanyAdminController::class, 'editCounter'])->name('counters.edit');
        Route::put('/counters/{counter}', [CompanyAdminController::class, 'updateCounter'])->name('counters.update');
        Route::delete('/counters/{counter}', [CompanyAdminController::class, 'destroyCounter'])->name('counters.destroy');

        // Statistiques
        Route::get('/statistics', [CompanyAdminController::class, 'statistics'])->name('statistics');
        Route::get('/statistics/service/{service}', [CompanyAdminController::class, 'serviceStatistics'])->name('statistics.service');

        // Gestion des tickets (admin)
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    });

    // Dashboard principal (redirection selon rôle) - doit être APRÈS les routes /admin
    Route::get('/company/{company}', [AuthController::class, 'dashboard'])->name('company.dashboard');

    /*
    |--------------------------------------------------------------------------
    | Routes Tickets - Client
    |--------------------------------------------------------------------------
    */
    Route::prefix('company/{company}/tickets')->name('tickets.')->group(function () {
        // Prise de ticket (public)
        Route::get('/select-service', [TicketController::class, 'selectService'])->name('select-service');
        Route::post('/', [TicketController::class, 'store'])->name('store');
        Route::get('/{ticket}/track', [TicketController::class, 'track'])->name('track');
        
        // Prise de ticket direct depuis service
        Route::post('/take/{service}', [TicketController::class, 'takeTicket'])->name('take');
        
        // Affichage public
        Route::get('/display', [TicketController::class, 'publicDisplay'])->name('public-display');
        Route::get('/api/currently-called', [TicketController::class, 'apiCurrentlyCalled'])->name('api.called');
        Route::get('/api/{ticket}/status', [TicketController::class, 'apiStatus'])->name('api.status');
    });

    /*
    |--------------------------------------------------------------------------
    | Routes Agents (Tickets)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'agent.only'])->prefix('company/{company}/agent')->name('company.agent.')->group(function () {

        Route::get('/', [AgentController::class, 'dashboard'])->name('dashboard');
        Route::get('/counter/{counter}', [AgentController::class, 'counter'])->name('counter');
        Route::get('/service/{service}', [AgentController::class, 'service'])->name('service');
        Route::get('/history', [AgentController::class, 'history'])->name('history');

        // Actions tickets (unifiées dans TicketController)
        Route::post('/call-next', [TicketController::class, 'callNext'])->name('call-next');
        Route::post('/ticket/{ticket}/present', [TicketController::class, 'markPresent'])->name('ticket.present');
        Route::post('/ticket/{ticket}/serve', [TicketController::class, 'markServed'])->name('ticket.serve');
        Route::post('/ticket/{ticket}/serving', [TicketController::class, 'markServing'])->name('ticket.serving');
        Route::post('/ticket/{ticket}/missed', [TicketController::class, 'markMissed'])->name('ticket.missed');
        Route::post('/ticket/{ticket}/recall', [TicketController::class, 'recallTicket'])->name('ticket.recall');
        Route::post('/ticket/{ticket}/transfer/{service}', [TicketController::class, 'transfer'])->name('ticket.transfer');

        // Ouvrir/Fermer guichet
        Route::post('/counter/{counter}/open', [AgentController::class, 'openCounter'])->name('counter.open');
        Route::post('/counter/{counter}/close', [AgentController::class, 'closeCounter'])->name('counter.close');
    });

    /*
    |--------------------------------------------------------------------------
    | Routes Public/Client (ACCÈS SANS AUTHENTIFICATION)
    |--------------------------------------------------------------------------
    */
});

// Routes publiques accessibles sans connexion
Route::get('/company/{company}/public', [PublicController::class, 'index'])->name('company.public');
Route::post('/company/{company}/ticket/take/{service}', [PublicController::class, 'takeTicket'])->name('company.ticket.take');
Route::get('/company/{company}/ticket/{ticket}', [PublicController::class, 'showTicket'])->name('company.ticket.show');
Route::get('/company/{company}/ticket/{ticket}/status', [PublicController::class, 'ticketStatus'])->name('company.ticket.status');
Route::delete('/company/{company}/ticket/{ticket}', [PublicController::class, 'cancelTicket'])->name('company.ticket.cancel');

// Écran d'appel public (TV/Affichage)
Route::get('/company/{company}/display', [PublicController::class, 'display'])->name('company.display');

/*
|--------------------------------------------------------------------------
| Routes Super Admin Global
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'isSuperAdmin'])->prefix('super-admin')->name('super_admin.')->group(function () {

    Route::get('/', [SuperAdminController::class, 'dashboard'])->name('dashboard');

    // Gestion entreprises
    Route::get('/companies', [SuperAdminController::class, 'companies'])->name('companies');
    Route::get('/companies/create', [SuperAdminController::class, 'createCompany'])->name('companies.create');
    Route::post('/companies', [SuperAdminController::class, 'storeCompany'])->name('companies.store');
    Route::get('/companies/{company}', [SuperAdminController::class, 'showCompany'])->name('companies.show');
    Route::get('/companies/{company}/edit', [SuperAdminController::class, 'editCompany'])->name('companies.edit');
    Route::put('/companies/{company}', [SuperAdminController::class, 'updateCompany'])->name('companies.update');
    Route::delete('/companies/{company}', [SuperAdminController::class, 'destroyCompany'])->name('companies.destroy');

    // Gestion utilisateurs globaux
    Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/make-super-admin', [SuperAdminController::class, 'makeSuperAdmin'])->name('users.make-super-admin');
});

// Routes de prise de ticket
Route::middleware(['auth'])->prefix('tickets')->group(function () {
    Route::get('/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
});

// API pour les informations des files
Route::get('/api/queues/{queue}/waiting-count', function (App\Models\Queue $queue) {
    return response()->json([
        'count' => $queue->waitingTickets()->count(),
        'next_ticket' => $queue->getNextTicketNumber()
    ]);
});


    // Routes pour la gestion des tickets par les agents
    Route::post('/company/{company}/agent/ticket/{ticket}/call', [AgentController::class, 'callTicket'])->name('company.agent.ticket.call');
    Route::post('/company/{company}/agent/ticket/{ticket}/serve', [AgentController::class, 'serveTicket'])->name('company.agent.ticket.serve');
    Route::post('/company/{company}/agent/ticket/{ticket}/complete', [AgentController::class, 'completeTicket'])->name('company.agent.ticket.complete');
    Route::post('/company/{company}/agent/ticket/{ticket}/miss', [AgentController::class, 'missTicket'])->name('company.agent.ticket.miss');
    Route::post('/company/{company}/agent/ticket/{ticket}/transfer', [AgentController::class, 'transferTicket'])->name('company.agent.ticket.transfer');
