<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Service;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    protected TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Dashboard client - liste des entreprises actives
     */
    public function dashboard()
    {
        $companies = Company::where('status', 'active')
            ->with(['services' => function ($query) {
                $query->where('status', 'active')
                      ->withCount(['waitingTickets']);
            }])
            ->get();

        $myTicket = null;
        if (auth()->check()) {
            $myTicket = Ticket::where('client_phone', auth()->user()->email)
                ->orWhere('client_name', auth()->user()->name)
                ->whereIn('status', ['waiting', 'called', 'serving'])
                ->with(['service', 'company'])
                ->first();
        }

        return view('client.dashboard', compact('companies', 'myTicket'));
    }

    /**
     * Prendre un ticket pour un service
     */
    public function takeTicket(Company $company, Service $service, Request $request)
    {
        // Vérifier que le service appartient à l'entreprise
        if ($service->company_id !== $company->id) {
            abort(404);
        }

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

        // Préparer les données du ticket
        $data = [
            'client_name' => $request->input('client_name'),
            'client_phone' => $request->input('client_phone'),
            'client_email' => $request->input('client_email'),
            'priority' => $request->input('priority', 'normal'),
        ];

        // Utiliser les données de l'utilisateur connecté si disponible
        if (auth()->check()) {
            $data['client_name'] = auth()->user()->name;
            $data['client_phone'] = auth()->user()->phone ?? auth()->user()->email;
            $data['client_email'] = auth()->user()->email;
        }

        try {
            $ticket = $this->ticketService->createTicket($service, $data);
            
            return redirect()->route('client.ticket.show', $ticket)
                ->with('success', 'Ticket ' . $ticket->number . ' créé avec succès !');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la création du ticket: ' . $e->getMessage());
        }
    }

    /**
     * Afficher les détails d'un ticket
     */
    public function showTicket(Ticket $ticket)
    {
        $status = $this->ticketService->getTicketStatus($ticket);
        $estimatedWait = $this->calculateEstimatedWait($ticket);

        return view('client.ticket', compact('ticket', 'status', 'estimatedWait'));
    }

    /**
     * Annuler un ticket
     */
    public function cancelTicket(Ticket $ticket, Request $request)
    {
        if ($ticket->status !== Ticket::STATUS_WAITING) {
            return back()->with('error', 'Ce ticket ne peut plus être annulé.');
        }

        // Vérifier les permissions
        if (auth()->check()) {
            $isOwner = $ticket->client_phone === auth()->user()->phone ||
                       $ticket->client_name === auth()->user()->name ||
                       $ticket->client_email === auth()->user()->email;

            if (!$isOwner && !auth()->user()->isAdmin()) {
                abort(403);
            }
        } else {
            $sessionTicket = session('current_ticket_id');
            if ($sessionTicket != $ticket->id) {
                abort(403);
            }
        }

        try {
            $ticket->cancel('Annulé par le client');
            
            return redirect()->route('client.dashboard')
                ->with('success', 'Ticket annulé avec succès.');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'annulation du ticket: ' . $e->getMessage());
        }
    }

    /**
     * API pour obtenir le statut d'un ticket en temps réel
     */
    public function getTicketStatus(Ticket $ticket)
    {
        $status = $this->ticketService->getTicketStatus($ticket);
        $estimatedWait = $this->calculateEstimatedWait($ticket);

        return response()->json([
            'ticket' => $status,
            'estimated_wait' => $estimatedWait,
            'position' => $ticket->getPosition(),
            'service' => $ticket->service->name,
            'company' => $ticket->company->name,
        ]);
    }

    /**
     * Afficher les files d'attente publiques d'une entreprise
     */
    public function publicQueue(Company $company)
    {
        if (!$company->isActive()) {
            abort(403, 'Cette entreprise est inactive.');
        }

        $services = $company->services()
            ->where('status', 'active')
            ->with(['waitingTickets' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }, 'calledTickets'])
            ->get();

        return view('client.public', compact('company', 'services'));
    }

    /**
     * Page de sélection de services pour prendre un ticket
     */
    public function selectServices(Company $company)
    {
        if (!$company->isActive()) {
            abort(403, 'Cette entreprise est inactive.');
        }

        $services = $company->services()
            ->where('status', 'active')
            ->withCount(['waitingTickets'])
            ->get();

        return view('client.select-services', compact('company', 'services'));
    }

    // ========== HELPERS ==========

    /**
     * Calculer le temps d'attente estimé
     */
    private function calculateEstimatedWait(Ticket $ticket): int
    {
        $position = $ticket->getPosition();
        if (!$position) {
            return 0;
        }

        $service = $ticket->service;
        $avgServiceTime = $service->estimated_service_time ?? 5;

        return $position * $avgServiceTime;
    }
}