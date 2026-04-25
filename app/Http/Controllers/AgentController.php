<?php

namespace App\Http\Controllers;

use App\Events\TicketCalled;
use App\Events\TicketServed;
use App\Events\TicketStatusChanged;
use App\Models\Company;
use App\Models\Counter;
use App\Models\Service;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AgentController extends Controller
{
    protected TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Dashboard agent
     */
    public function dashboard(Company $company)
    {
        try {
            $agent = auth()->user();
            
            // Guichets de l'agent
            $myCounters = $agent->assignedCounters()
                ->where('counters.company_id', $company->id)
                ->with(['service'])
                ->get();

            // Optimisation: Combiner les requêtes de statistiques en une seule
            $today = today()->format('Y-m-d');
            $ticketStats = Ticket::where('agent_id', $agent->id)
                ->where('company_id', $company->id)
                ->whereDate('created_at', $today)
                ->selectRaw('
                    COUNT(CASE WHEN status = ? THEN 1 END) as served_today,
                    COUNT(CASE WHEN status = ? THEN 1 END) as missed_today,
                    AVG(CASE WHEN status = ? AND actual_service_time IS NOT NULL THEN actual_service_time END) as avg_service_time
                ', ['SERVED', 'MISSED', 'SERVED'])
                ->first();

            $myTicketsToday = $ticketStats->served_today ?? 0;
            $missedTicketsToday = $ticketStats->missed_today ?? 0;
            $avgServiceTime = $ticketStats->avg_service_time ?? 0;

            // Services disponibles - SIMPLIFIÉ pour éviter la boucle infinie
            $services = $company->services()
                ->select('services.*')
                ->withCount(['waitingTickets' => function ($query) {
                    $query->where('status', 'WAITING');
                }])
                ->get();

            // Ticket en cours
            $currentTicket = Ticket::where('tickets.company_id', $company->id)
                ->where('agent_id', $agent->id)
                ->whereIn('status', ['CALLED', 'PRESENT', 'SERVING'])
                ->with(['service', 'counter'])
                ->first();

            // Taux de service aujourd'hui
            $totalHandledToday = $myTicketsToday + $missedTicketsToday;
            $serviceRateToday = $totalHandledToday > 0 ? round(($myTicketsToday / $totalHandledToday) * 100, 1) : 0;

            return view('company.agent.dashboard', compact(
                'company', 
                'myCounters', 
                'myTicketsToday', 
                'services', 
                'missedTicketsToday', 
                'currentTicket', 
                'avgServiceTime', 
                'serviceRateToday'
            ));
            
        } catch (\Exception $e) {
            // En cas d'erreur, retourner une vue simple avec l'erreur
            return response()->view('errors.debug', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Vue d'un guichet
     */
    public function counter(Company $company, Counter $counter)
    {
        $agent = auth()->user();
        
        \Log::info('COUNTER PAGE START', [
            'company_id' => $company->id,
            'counter_id' => $counter->id,
            'user_id' => auth()->id(),
        ]);
        
        // SIMPLIFIÉ: Vérification d'accès directe sans boucle infinie
        $hasAccess = \App\Models\Counter::where('company_id', $company->id)
            ->where('id', $counter->id)
            ->where(function($query) use ($agent) {
                $query->where('user_id', $agent->id)
                      ->orWhereNull('user_id');
            })
            ->exists();

        if (!$hasAccess) {
            return back()->with('error', 'Ce guichet ne vous appartient pas.');
        }

        // Optimisation 1: Ticket en cours unique
        $currentTicket = Ticket::where('counter_id', $counter->id)
            ->whereIn('status', ['CALLED', 'PRESENT', 'SERVING'])
            ->with(['service', 'agent'])
            ->first();

        // Optimisation 2: Tickets servis aujourd'hui avec index
        $calledToday = Ticket::where('company_id', $company->id)
            ->whereDate('served_at', now()->toDateString())
            ->whereNotNull('served_at')
            ->where('agent_id', $agent->id)
            ->with(['service', 'counter'])
            ->orderBy('served_at', 'desc')
            ->limit(20)
            ->get();

        // Optimisation 3: File d'attente limitée
        $waitingTickets = Ticket::where('company_id', $company->id)
            ->where('status', 'WAITING')
            ->where('service_id', $counter->service_id)
            ->with(['service'])
            ->orderBy('created_at', 'asc')
            ->limit(50) // Limiter à 50 tickets
            ->get();

        // Service du guichet
        $service = $counter->service;

        // Optimisation 4: Limiter les guichets du service
        $serviceCounters = \App\Models\Counter::where('service_id', $counter->service_id)
            ->where('company_id', $company->id)
            ->where('is_active', true)
            ->with(['user'])
            ->limit(10) // Limiter à 10 guichets
            ->get();

        \Log::info('Database queries completed, rendering view...');
        \Log::info('COUNTER PAGE BEFORE VIEW');

        return view('company.agent.counter', compact('company', 'counter', 'currentTicket', 'service', 'calledToday', 'waitingTickets', 'serviceCounters'));
    }

    /**
     * Vue d'un service
     */
    public function service(Company $company, Service $service)
    {
        $agent = auth()->user();
        
        // SIMPLIFIÉ: Vérification d'accès directe sans boucle infinie
        $hasAccess = \App\Models\Counter::where('company_id', $company->id)
            ->where('service_id', $service->id)
            ->where('user_id', $agent->id)
            ->exists();

        if (!$hasAccess) {
            return back()->with('error', 'Vous n\'avez pas accès à ce service.');
        }

        // Récupérer les tickets en attente
        $waitingTickets = $service->tickets()
            ->where('status', 'WAITING')
            ->orderBy('created_at', 'asc')
            ->get();

        // Récupérer les guichets de l'agent pour ce service - SIMPLIFIÉ
        $serviceCounters = \App\Models\Counter::where('company_id', $company->id)
            ->where('service_id', $service->id)
            ->where('user_id', $agent->id)
            ->get();

        return view('company.agent.service', compact(
            'company',
            'service',
            'waitingTickets',
            'serviceCounters'
        ));
    }

    /**
     * Appeler le prochain ticket
     */
    public function callNext(Company $company, Request $request)
    {
        $agent = auth()->user();
        $counterId = $request->input('counter_id');
        
        $counter = $this->getAgentCounter($company, $agent, $counterId);
        
        if (!$counter) {
            return back()->with('error', 'Guichet non trouvé ou non assigné.');
        }

        try {
            $ticket = $this->ticketService->callNextTicket($company, $agent, $counter);
            
            if ($ticket) {
                event(new TicketCalled($ticket, $counter, $agent));
                return back()->with('success', 'Ticket ' . $ticket->number . ' appelé.');
            }
            
            return back()->with('info', 'Aucun ticket en attente.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'appel du ticket: ' . $e->getMessage());
        }
    }

    /**
     * Ouvrir un guichet
     */
    public function openCounter(Company $company, Counter $counter)
    {
        $agent = auth()->user();
        
        // Vérifier que l'agent a accès à ce guichet via la table pivot
        $hasAccess = $agent->assignedCounters()
            ->where('counters.company_id', $company->id)
            ->where('counters.id', $counter->id)
            ->exists();
            
        if (!$hasAccess) {
            return back()->with('error', 'Ce guichet ne vous appartient pas.');
        }

        try {
            // Utiliser la méthode améliorée du model
            $counter->open();
            
            // Envoyer les events WebSocket
            event(new \App\Events\CounterOpened($counter, $agent));
            // event(new \App\Events\TicketStatusChanged(null, 'closed', 'open')); // Désactivé - ticket null
            
            return back()->with('success', 'Guichet ' . $counter->name . ' ouvert.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'ouverture du guichet: ' . $e->getMessage());
        }
    }

    /**
     * Fermer un guichet
     */
    public function closeCounter(Company $company, Counter $counter)
    {
        $agent = auth()->user();
        
        // Vérifier que l'agent a accès à ce guichet via la table pivot
        $hasAccess = $agent->assignedCounters()
            ->where('counters.company_id', $company->id)
            ->where('counters.id', $counter->id)
            ->exists();
            
        if (!$hasAccess) {
            return back()->with('error', 'Ce guichet ne vous appartient pas.');
        }

        try {
            // Logique de fermeture douce : vérifier si un ticket est en cours
            $currentTicket = $counter->currentTicket();
            
            if ($currentTicket) {
                // Ne pas fermer brutalement si un ticket est en cours
                return back()->with('error', 'Impossible de fermer le guichet : un ticket est en cours de service.');
            }
            
            // Utiliser la méthode améliorée du model
            $counter->close();
            
            // Envoyer les events WebSocket
            event(new \App\Events\CounterClosed($counter, $agent, 'manual'));
            // event(new \App\Events\TicketStatusChanged(null, 'open', 'closed')); // Désactivé - pas de ticket concerné
            
            return back()->with('success', 'Guichet ' . $counter->name . ' fermé.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la fermeture du guichet: ' . $e->getMessage());
        }
    }

    /**
     * Mettre en pause un guichet
     */
    public function pauseCounter(Company $company, Counter $counter)
    {
        $agent = auth()->user();
        
        // Vérifier que l'agent a accès à ce guichet
        $hasAccess = $agent->assignedCounters()
            ->where('counters.company_id', $company->id)
            ->where('counters.id', $counter->id)
            ->exists();
            
        if (!$hasAccess) {
            return back()->with('error', 'Ce guichet ne vous appartient pas.');
        }

        try {
            // Vérifier si un ticket est en cours
            $currentTicket = $counter->currentTicket();
            
            if ($currentTicket) {
                return back()->with('error', 'Impossible de mettre en pause : un ticket est en cours de service.');
            }
            
            // Mettre en pause
            $counter->pause();
            
            // Calculer l'heure de reprise (prochaine heure de travail)
            $workSchedule = \App\Models\WorkSchedule::where('counter_id', $counter->id)
                ->active()
                ->first();
            
            $resumeTime = $workSchedule ? $workSchedule->getNextOpenTime() : null;
            
            // Envoyer les events WebSocket
            event(new \App\Events\CounterPaused($counter, $agent, $resumeTime));
            
            return back()->with('success', 'Guichet ' . $counter->name . ' en pause.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise en pause: ' . $e->getMessage());
        }
    }

    /**
     * Reprendre un guichet
     */
    public function resumeCounter(Company $company, Counter $counter)
    {
        $agent = auth()->user();
        
        // Vérifier que l'agent a accès à ce guichet
        $hasAccess = $agent->assignedCounters()
            ->where('counters.company_id', $company->id)
            ->where('counters.id', $counter->id)
            ->exists();
            
        if (!$hasAccess) {
            return back()->with('error', 'Ce guichet ne vous appartient pas.');
        }

        try {
            // Reprendre le guichet
            $counter->resume();
            
            // Envoyer les events WebSocket
            event(new \App\Events\CounterOpened($counter, $agent));
            
            return back()->with('success', 'Guichet ' . $counter->name . ' repris.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la reprise: ' . $e->getMessage());
        }
    }

    /**
     * Page d'historique
     */
    public function history(Company $company)
    {
        $agent = auth()->user();
        
        // Calculer les statistiques
        $today = today()->format('Y-m-d');
        $stats = Ticket::where('agent_id', $agent->id)
            ->where('company_id', $company->id)
            ->selectRaw('
                COUNT(*) as total_today,
                COUNT(CASE WHEN status = ? THEN 1 END) as served_today,
                COUNT(CASE WHEN status = ? THEN 1 END) as missed_today,
                AVG(CASE WHEN actual_service_time IS NOT NULL THEN actual_service_time END) as avg_service_time
            ', ['SERVED', 'MISSED'])
            ->whereDate('created_at', $today)
            ->first();
        
        // SIMPLIFIÉ: Récupérer l'historique sans jointures complexes
        $tickets = Ticket::where('agent_id', $agent->id)
            ->where('company_id', $company->id)
            ->with(['service', 'counter'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);
        
        return view('company.agent.history', compact('company', 'stats', 'tickets'));
    }

    /**
     * Page tous les services
     */
    public function allServices(Company $company)
    {
        $agent = auth()->user();
        
        // Récupérer tous les services accessibles pour cet agent
        $services = \App\Models\Service::where('company_id', $company->id)
            ->whereHas('counters', function ($query) use ($agent) {
                $query->where('user_id', $agent->id);
            })
            ->with(['counters'])
            ->orderBy('name')
            ->get();
        
        return view('company.agent.all-services', compact('company', 'services'));
    }

    /**
     * Appeler un ticket spécifique
     */
    public function callTicket(Company $company, Ticket $ticket)
    {
        $agent = auth()->user();
        
        // Vérifier que le ticket appartient à l'entreprise
        if ($ticket->company_id !== $company->id) {
            abort(404);
        }
        
        // Vérifier que l'agent a accès au service du ticket
        $hasAccess = $agent->assignedCounters()
            ->where('counters.company_id', $company->id)
            ->where('counters.service_id', $ticket->service_id)
            ->exists();
            
        if (!$hasAccess) {
            return back()->with('error', 'Vous n\'avez pas accès à ce service.');
        }
        
        // Obtenir le guichet de l'agent pour ce service
        $counter = $agent->assignedCounters()
            ->where('counters.company_id', $company->id)
            ->where('counters.service_id', $ticket->service_id)
            ->first();
            
        if (!$counter) {
            return back()->with('error', 'Aucun guichet assigné pour ce service.');
        }
        
        try {
            // Appeler le ticket spécifique
            $this->ticketService->callSpecificTicket($ticket, $agent, $counter);
            
            event(new TicketCalled($ticket, $counter, $agent));
            // event(new TicketStatusChanged($ticket, 'waiting', 'called')); // Désactivé temporairement
            
            return back()->with('success', 'Ticket ' . $ticket->number . ' appelé.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'appel du ticket: ' . $e->getMessage());
        }
    }

    /**
     * Servir un ticket
     */
    public function serveTicket(Company $company, Ticket $ticket)
    {
        $agent = auth()->user();
        
        // Vérifier que le ticket appartient à l'entreprise
        if ($ticket->company_id !== $company->id) {
            abort(404);
        }
        
        // Vérifier que l'agent a accès au service du ticket
        $hasAccess = $agent->assignedCounters()
            ->where('counters.company_id', $company->id)
            ->where('counters.service_id', $ticket->service_id)
            ->exists();
            
        if (!$hasAccess) {
            return back()->with('error', 'Vous n\'avez pas accès à ce service.');
        }
        
        // Vérifier que le ticket est bien appelé par cet agent
        if ($ticket->agent_id !== $agent->id) {
            return back()->with('error', 'Ce ticket ne vous appartient pas.');
        }
        
        try {
            $ticket->serve();
            
            // Libérer le guichet
            if ($ticket->counter) {
                $ticket->counter->update(['status' => 'open']);
            }
            
            event(new TicketServed($ticket, $ticket->counter, $agent));
            // event(new TicketStatusChanged($ticket, 'called', 'served')); // Désactivé temporairement
            
            return back()->with('success', 'Ticket ' . $ticket->number . ' servi.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du service du ticket: ' . $e->getMessage());
        }
    }

    /**
     * Obtenir le guichet de l'agent
     */
    private function getAgentCounter(Company $company, $user, ?int $counterId): ?Counter
    {
        if ($counterId) {
            return $user->assignedCounters()
                ->where('counters.company_id', $company->id)
                ->where('counters.id', $counterId)
                ->first();
        }

        return $user->assignedCounters()
            ->where('counters.company_id', $company->id)
            ->where('counters.status', 'open')
            ->first();
    }
}
