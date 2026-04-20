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
        $agent = auth()->user();
        
        // Guichets de l'agent
        $myCounters = $agent->assignedCounters()
            ->where('counters.company_id', $company->id)
            ->with(['service'])
            ->get();

        // Tickets servis aujourd'hui
        $myTicketsToday = Ticket::where('agent_id', $agent->id)
            ->where('tickets.company_id', $company->id)
            ->whereDate('served_at', today())
            ->count();

        // Services disponibles
        $services = $company->services()
            ->with(['counters' => function($query) use ($agent) {
                $query->where('user_id', $agent->id);
            }])
            ->withCount(['waitingTickets' => function ($query) {
                $query->where('status', 'WAITING');
            }])
            ->get();

        // Tickets manqués aujourd'hui
        $missedTicketsToday = Ticket::where('agent_id', $agent->id)
            ->where('tickets.company_id', $company->id)
            ->whereDate('updated_at', today())
            ->where('status', 'MISSED_TEMP')
            ->count();

        // Ticket en cours
        $currentTicket = Ticket::where('tickets.company_id', $company->id)
            ->where('agent_id', $agent->id)
            ->whereIn('status', ['CALLED', 'PRESENT', 'SERVING'])
            ->with(['service', 'counter'])
            ->first();

        // Temps moyen de traitement
        $avgServiceTime = Ticket::where('agent_id', $agent->id)
            ->where('tickets.company_id', $company->id)
            ->where('status', 'SERVED')
            ->whereNotNull('actual_service_time')
            ->avg('actual_service_time');

        // Taux de service aujourd'hui
        $totalHandledToday = $myTicketsToday + $missedTicketsToday;
        $serviceRateToday = $totalHandledToday > 0 ? round(($myTicketsToday / $totalHandledToday) * 100, 1) : 0;

        return view('company.agent.dashboard-fintech', compact(
            'company', 
            'myCounters', 
            'myTicketsToday', 
            'services', 
            'missedTicketsToday', 
            'currentTicket', 
            'avgServiceTime', 
            'serviceRateToday'
        ));
    }

    /**
     * Vue d'un guichet
     */
    public function counter(Company $company, Counter $counter)
    {
        $user = auth()->user();

        if ($counter->company_id !== $company->id) {
            abort(404);
        }

        $currentTicket = Ticket::where('counter_id', $counter->id)
            ->whereIn('status', ['CALLED', 'PRESENT', 'SERVING'])
            ->with(['service', 'agent'])
            ->first();

        // Récupérer le service associé au guichet
        $service = $counter->service;

        // Récupérer les tickets appelés aujourd'hui pour ce guichet
        $calledToday = Ticket::where('counter_id', $counter->id)
            ->where('agent_id', auth()->id())
            ->where('status', 'served')
            ->whereDate('served_at', today())
            ->orderBy('served_at', 'desc')
            ->get();

        // Récupérer les tickets en attente pour le service associé à ce guichet
        $waitingTickets = Ticket::where('company_id', $company->id)
            ->where('service_id', $counter->service_id)
            ->where('status', 'WAITING')
            ->orderBy('created_at', 'asc')
            ->get();

        // Récupérer les guichets du service pour l'affichage
        $serviceCounters = \App\Models\Counter::where('service_id', $counter->service_id)
            ->where('company_id', $company->id)
            ->where('is_active', true)
            ->with(['user'])
            ->get();

        return view('company.agent.counter', compact('company', 'counter', 'currentTicket', 'service', 'calledToday', 'waitingTickets', 'serviceCounters'));
    }

    /**
     * Vue d'un service
     */
    public function service(Company $company, Service $service)
    {
        $agent = auth()->user();
        
        // Vérifier que l'agent a accès à ce service
        $hasAccess = $agent->assignedCounters()
            ->where('counters.company_id', $company->id)
            ->where('counters.service_id', $service->id)
            ->exists();

        if (!$hasAccess) {
            return back()->with('error', 'Vous n\'avez pas accès à ce service.');
        }

        // Récupérer les tickets en attente
        $waitingTickets = $service->tickets()
            ->where('status', 'WAITING')
            ->orderBy('created_at', 'asc')
            ->get();

        // Récupérer les guichets de l'agent pour ce service
        $serviceCounters = $agent->assignedCounters()
            ->where('counters.company_id', $company->id)
            ->where('counters.service_id', $service->id)
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
            $counter->update(['status' => 'open']);
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
            $counter->update(['status' => 'closed']);
            return back()->with('success', 'Guichet ' . $counter->name . ' fermé.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la fermeture du guichet: ' . $e->getMessage());
        }
    }

    /**
     * Historique des tickets
     */
    public function history(Company $company, Request $request)
    {
        $agent = auth()->user();
        
        $tickets = $company->tickets()
            ->where('agent_id', $agent->id)
            ->with(['service', 'counter'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total_today' => $company->tickets()
                ->where('agent_id', $agent->id)
                ->whereDate('created_at', today())
                ->count(),
            'served_today' => $company->tickets()
                ->where('agent_id', $agent->id)
                ->where('status', 'SERVED')
                ->whereDate('served_at', today())
                ->count(),
            'missed_today' => $company->tickets()
                ->where('agent_id', $agent->id)
                ->where('status', 'MISSED_TEMP')
                ->whereDate('updated_at', today())
                ->count(),
            'avg_service_time' => $company->tickets()
                ->where('agent_id', $agent->id)
                ->where('status', 'SERVED')
                ->whereNotNull('actual_service_time')
                ->avg('actual_service_time'),
            'total_served' => $company->tickets()
                ->where('agent_id', $agent->id)
                ->where('status', 'SERVED')
                ->count(),
            'total_missed' => $company->tickets()
                ->where('agent_id', $agent->id)
                ->where('status', 'MISSED_TEMP')
                ->count(),
        ];

        return view('company.agent.history', compact('company', 'tickets', 'stats'));
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
            event(new TicketStatusChanged($ticket, 'waiting', 'called'));
            
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
            event(new TicketStatusChanged($ticket, 'called', 'served'));
            
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
