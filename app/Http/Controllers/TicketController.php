<?php

namespace App\Http\Controllers;

use App\Events\TicketCalled;
use App\Events\TicketServed;
use App\Events\TicketStatusChanged;
use App\Events\QueuePositionUpdated;
use App\Events\TicketRecalled;
use App\Events\TicketTimeout;
use App\Models\Company;
use App\Models\Service;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Sélectionner un service pour prendre un ticket
     */
    public function selectService(Company $company)
    {
        if (!$company->isActive()) {
            abort(403, 'Cette entreprise est inactive.');
        }

        $services = $company->services()
            ->where('status', 'active')
            ->withCount(['waitingTickets'])
            ->get();

        return view('tickets.select-service', compact('company', 'services'));
    }

    /**
     * Créer un nouveau ticket
     */
    public function store(Company $company, Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'nullable|string|max:20',
            'client_email' => 'nullable|email|max:255',
            'priority' => 'required|in:normal,urgent,vip',
        ]);

        $service = Service::findOrFail($request->service_id);

        // Vérifier que le service appartient à l'entreprise
        if ($service->company_id !== $company->id) {
            abort(404);
        }

        try {
            $data = $request->only(['client_name', 'client_phone', 'client_email', 'priority']);
            $ticket = $this->ticketService->createTicket($service, $data);

            return redirect()->route('tickets.track', [$company, $ticket])
                ->with('success', 'Ticket ' . $ticket->number . ' créé avec succès !');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création du ticket: ' . $e->getMessage());
        }
    }

    /**
     * Suivre un ticket
     */
    public function track(Company $company, Ticket $ticket)
    {
        if ($ticket->company_id !== $company->id) {
            abort(404);
        }

        $status = $this->ticketService->getTicketStatus($ticket);
        $position = $ticket->getPosition();
        $estimatedWait = $ticket->getEstimatedWaitTime();

        return view('tickets.track', compact('company', 'ticket', 'status', 'position', 'estimatedWait'));
    }

    /**
     * Prendre un ticket directement depuis un service
     */
    public function takeTicket(Company $company, Service $service, Request $request)
    {
        if (!$company->isActive() || !$service->isActive()) {
            return back()->with('error', 'Cette entreprise ou ce service est inactif.');
        }

        // Vérifier limite quotidienne
        if ($service->max_daily_tickets) {
            $todayCount = $service->tickets()->whereDate('created_at', today())->count();
            if ($todayCount >= $service->max_daily_tickets) {
                return back()->with('error', 'Limite quotidienne atteinte pour ce service.');
            }
        }

        $data = [
            'client_name' => $request->input('client_name', 'Client'),
            'client_phone' => $request->input('client_phone'),
            'client_email' => $request->input('client_email'),
            'priority' => $request->input('priority', 'normal'),
        ];

        try {
            $ticket = $this->ticketService->createTicket($service, $data);

            return redirect()->route('tickets.track', [$company, $ticket])
                ->with('success', 'Ticket ' . $ticket->number . ' créé avec succès !');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création du ticket: ' . $e->getMessage());
        }
    }

    /**
     * Affichage public des tickets
     */
    public function publicDisplay(Company $company)
    {
        if (!$company->isActive()) {
            abort(403, 'Cette entreprise est inactive.');
        }

        $services = $company->services()
            ->where('status', 'ACTIVE')
            ->with(['waitingTickets' => function ($query) {
                $query->orderBy('created_at', 'asc')->limit(5);
            }])
            ->withCount(['waitingTickets'])
            ->get();

        $calledTickets = Ticket::where('tickets.company_id', $company->id)
            ->where('status', 'CALLED')
            ->with(['service', 'counter'])
            ->orderBy('called_at', 'desc')
            ->get();

        return view('tickets.public-display', compact('company', 'services', 'calledTickets'));
    }

    /**
     * API pour obtenir les tickets actuellement appelés
     */
    public function apiCurrentlyCalled(Company $company)
    {
        $calledTickets = Ticket::where('tickets.company_id', $company->id)
            ->where('status', 'CALLED')
            ->with(['service', 'counter'])
            ->orderBy('called_at', 'desc')
            ->get();

        return response()->json([
            'called_tickets' => $calledTickets,
            'updated_at' => now()->format('H:i:s')
        ]);
    }

    /**
     * API pour obtenir le statut d'un ticket
     */
    public function apiStatus(Company $company, Ticket $ticket)
    {
        if ($ticket->company_id !== $company->id) {
            return response()->json(['error' => 'Ticket non trouvé'], 404);
        }

        $status = $this->ticketService->getTicketStatus($ticket);
        $position = $ticket->getPosition();

        return response()->json([
            'ticket' => $status,
            'position' => $position,
            'estimated_wait' => $ticket->getEstimatedWaitTime(),
            'service' => $ticket->service->name,
            'counter' => $ticket->counter?->name,
        ]);
    }

    // ========== MÉTHODES AGENTS ==========

    /**
     * Appeler le prochain ticket
     */
    public function callNext(Company $company, Request $request)
    {
        $agent = auth()->user();
        $counterId = $request->input('counter_id');
        
        $counter = $agent->assignedCounters()
            ->where('counters.company_id', $company->id)
            ->where('counters.id', $counterId)
            ->first();
        
        if (!$counter) {
            return back()->with('error', 'Guichet non trouvé ou non assigné.');
        }

        try {
            $ticket = $this->ticketService->callNextTicket($company, $agent, $counter);
            
            if ($ticket) {
                // Déclencher l'event d'appel
                event(new TicketCalled($ticket));
                
                // Mettre à jour les positions dans la queue
                $this->updateQueuePositions($ticket);
                
                // Programmer le timeout de 2 minutes (120 secondes)
                \App\Jobs\TicketTimeoutJob::dispatch($ticket)
                    ->delay(now()->addSeconds(120));
                
                return back()->with('success', 'Ticket ' . $ticket->number . ' appelé.');
            }
            
            return back()->with('info', 'Aucun ticket en attente.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'appel du ticket: ' . $e->getMessage());
        }
    }

    /**
     * Marquer un ticket comme servi
     */
    public function markServed(Company $company, Ticket $ticket)
    {
        $agent = auth()->user();
        
        if ($ticket->company_id !== $company->id) {
            abort(403);
        }

        try {
            $this->ticketService->serveTicket($ticket, $agent);
            
            event(new TicketServed($ticket, $agent));
            event(new TicketStatusChanged($ticket, 'called', 'served'));
            
            return back()->with('success', 'Ticket ' . $ticket->number . ' servi.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du service du ticket: ' . $e->getMessage());
        }
    }

    /**
     * Marquer un ticket comme en cours de service
     */
    public function markServing(Company $company, Ticket $ticket)
    {
        $agent = auth()->user();
        
        if ($ticket->company_id !== $company->id) {
            abort(403);
        }

        try {
            $this->ticketService->markAsServing($ticket, $agent);
            
            event(new TicketStatusChanged($ticket, 'called', 'serving'));
            
            return back()->with('success', 'Ticket ' . $ticket->number . ' mis en service.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la mise en service: ' . $e->getMessage());
        }
    }

    /**
     * Marquer un ticket comme manqué
     */
    public function markMissed(Company $company, Ticket $ticket)
    {
        $agent = auth()->user();
        
        if ($ticket->company_id !== $company->id) {
            abort(403);
        }

        try {
            $wasRequeued = $this->ticketService->markTicketAsMissed($ticket, $agent);
            
            event(new TicketStatusChanged($ticket, 'called', 'missed'));
            
            if ($wasRequeued) {
                return back()->with('success', 'Ticket ' . $ticket->number . ' marqué comme manqué et remis en file.');
            } else {
                return back()->with('info', 'Ticket ' . $ticket->number . ' annulé après 3 absences.');
            }
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du marquage du ticket: ' . $e->getMessage());
        }
    }

    /**
     * Confirmer la présence du client
     */
    public function markPresent(Company $company, Ticket $ticket)
    {
        if ($ticket->company_id !== $company->id) {
            abort(403);
        }

        try {
            $ticket->markPresent();
            
            event(new TicketStatusChanged($ticket, 'called', 'present'));
            
            return back()->with('success', 'Présence du ticket ' . $ticket->number . ' confirmée.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la confirmation de présence: ' . $e->getMessage());
        }
    }

    /**
     * Rappeler un ticket
     */
    public function recallTicket(Company $company, Ticket $ticket)
    {
        $agent = auth()->user();
        
        if ($ticket->company_id !== $company->id) {
            abort(403);
        }

        if ($ticket->status !== 'CALLED') {
            return back()->with('error', 'Seuls les tickets appelés peuvent être rappelés.');
        }

        try {
            // Incrémenter le compteur de rappels
            $recallCount = $ticket->recall_count ?? 0;
            $ticket->recall_count = $recallCount + 1;
            $ticket->save();

            // Déclencher l'event de rappel temps réel
            event(new TicketRecalled($ticket, $ticket->recall_count));
            
            return back()->with('success', 'Ticket ' . $ticket->number . ' rappelé.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du rappel: ' . $e->getMessage());
        }
    }

    /**
     * Transférer un ticket
     */
    public function transfer(Company $company, Ticket $ticket, Service $service, Request $request)
    {
        $agent = auth()->user();
        
        if ($ticket->company_id !== $company->id || $service->company_id !== $company->id) {
            abort(403);
        }

        $request->validate([
            'reason' => 'nullable|string|max:255'
        ]);
        
        try {
            $this->ticketService->transferTicket($ticket, $service, $agent, $request->reason);
            
            event(new TicketStatusChanged($ticket, $ticket->status, 'waiting'));
            
            return back()->with('success', 'Ticket ' . $ticket->number . ' transféré vers ' . $service->name . '.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors du transfert du ticket: ' . $e->getMessage());
        }
    }

    // ========== MÉTHODES ADMIN ==========

    /**
     * Liste des tickets pour l'admin
     */
    public function index(Company $company, Request $request)
    {
        $tickets = $company->tickets()
            ->with(['service', 'counter', 'agent'])
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->service_id, function ($query, $serviceId) {
                $query->where('service_id', $serviceId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $services = $company->services()->where('status', 'active')->get();

        return view('tickets.index', compact('company', 'tickets', 'services'));
    }

    /**
     * Mettre à jour les positions dans la queue après un appel
     */
    private function updateQueuePositions(Ticket $calledTicket)
    {
        $waitingTickets = $calledTicket->service->tickets()
            ->where('status', 'WAITING')
            ->where('company_id', $calledTicket->company_id)
            ->orderBy('created_at', 'asc')
            ->get();

        foreach ($waitingTickets as $index => $ticket) {
            $oldPosition = $index + 2; // +2 car le ticket appelé était position 1
            $newPosition = $index + 1;
            
            if ($oldPosition !== $newPosition) {
                event(new QueuePositionUpdated($ticket, $oldPosition, $newPosition));
            }
        }
    }
}
