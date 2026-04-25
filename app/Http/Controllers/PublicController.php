<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Service;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    /**
     * Dashboard client - liste des entreprises
     */
    public function clientDashboard()
    {
        $companies = Company::where('status', 'active')
            ->with(['services' => function ($q) {
                $q->where('status', 'active');
            }])
            ->get();

        return view('client.dashboard', compact('companies'));
    }

    /**
     * Sélectionner une entreprise pour prendre un ticket
     */
    public function selectCompany()
    {
        $companies = Company::where('status', 'active')
            ->with(['services' => function ($q) {
                $q->where('status', 'active');
            }])
            ->get();

        return view('client.select-company', compact('companies'));
    }

    /**
     * Page publique d'une entreprise - liste des services
     */
    public function index(Company $company)
    {
        if (!$company->isActive()) {
            abort(403, 'Cette entreprise est inactive.');
        }

        $services = $company->services()
            ->where('status', 'active')
            ->withCount(['waitingTickets', 'calledTickets'])
            ->get();

        return view('public.index', compact('company', 'services'));
    }

    /**
     * Afficher un ticket (suivi)
     */
    public function showTicket(Company $company, Ticket $ticket)
    {
        if ($ticket->company_id !== $company->id) {
            abort(404);
        }

        return view('public.ticket', compact('company', 'ticket'));
    }

    /**
     * Prendre un ticket
     */
    public function takeTicket(Request $request, Company $company, Service $service)
    {
        // Vérifier que le service appartient à l'entreprise
        if ($service->company_id !== $company->id) {
            abort(404);
        }

        if (!$service->isActive()) {
            return back()->with('error', 'Ce service est inactif.');
        }

        // Vérifier limite quotidienne
        if ($service->max_daily_tickets) {
            $todayCount = $service->tickets()->whereDate('created_at', today())->count();
            if ($todayCount >= $service->max_daily_tickets) {
                return back()->with('error', 'Limite quotidienne atteinte pour ce service.');
            }
        }

        // Créer le ticket
        $ticketNumber = $this->generateTicketNumber($service);

        $ticket = Ticket::create([
            'company_id' => $company->id,
            'service_id' => $service->id,
            'number' => $ticketNumber,
            'status' => 'waiting',
            'client_name' => $request->input('client_name'),
            'client_phone' => $request->input('client_phone'),
            'estimated_wait_time' => $this->calculateWaitTime($service),
        ]);

        return redirect()->route('company.ticket.show', [$company, $ticket])
            ->with('success', 'Votre ticket a été créé.');
    }

    /**
     * API pour obtenir le statut d'un ticket (pour le JavaScript)
     */
    public function ticketStatus(Company $company, Ticket $ticket)
    {
        if ($ticket->company_id !== $company->id) {
            return response()->json(['error' => 'Ticket non trouvé'], 404);
        }

        $position = $ticket->getPosition();
        $totalWaiting = Ticket::where('service_id', $ticket->service_id)
            ->where('status', 'waiting')
            ->count();

        return response()->json([
            'id' => $ticket->id,
            'number' => $ticket->number,
            'status' => $ticket->status,
            'position' => $position,
            'total' => $totalWaiting,
            'estimated_wait_time' => $ticket->getEstimatedWaitTime(),
            'service' => $ticket->service->name,
            'counter' => $ticket->counter?->name,
            'updated_at' => $ticket->updated_at->format('H:i:s')
        ]);
    }

    /**
     * Confirmer la présence du client
     */
    public function confirmPresence(Request $request, Ticket $ticket)
    {
        try {
            // Vérifier que le ticket est bien appelé
            if ($ticket->status !== 'CALLED') {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce ticket n\'est pas actuellement appelé'
                ], 400);
            }
            
            // Mettre le statut à PRESENT et enregistrer present_at
            $ticket->status = 'PRESENT';
            $ticket->present_at = now();
            $ticket->save();
            
            // Déclencher l'event temps réel
            event(new \App\Events\ClientConfirmedPresence($ticket));
            
            return response()->json([
                'success' => true,
                'message' => 'Présence confirmée! L\'agent a été notifié.',
                'ticket_status' => $ticket->status,
                'present_at' => $ticket->present_at->format('H:i:s'),
                'ticket_number' => $ticket->number
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la confirmation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Annuler un ticket
     */
    public function cancelTicket(Request $request, Company $company, Ticket $ticket)
    {
        if ($ticket->company_id !== $company->id) {
            abort(404);
        }

        try {
            $ticket->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => $request->input('reason', 'Client request')
            ]);

            return back()->with('success', 'Ticket annulé avec succès.');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'annulation: ' . $e->getMessage());
        }
    }

    /**
     * Écran d'affichage public (TV/Affichage)
     */
    public function display(Company $company)
    {
        if (!$company->isActive()) {
            abort(403);
        }

        $services = $company->services()
            ->where('status', 'active')
            ->with(['calledTickets' => function ($q) {
                $q->where('status', 'called')->with('counter');
            }, 'waitingTickets'])
            ->get();

        $calledTickets = Ticket::where('tickets.company_id', $company->id)
            ->where('status', 'called')
            ->with(['service', 'counter'])
            ->get();

        return view('public.display', compact('company', 'services', 'calledTickets'));
    }

    /**
     * Obtenir les statistiques de l'entreprise pour le dashboard agent
     */
    public function getStats(Company $company)
    {
        $today = now()->format('Y-m-d');
        
        $stats = [
            'served_today' => $company->tickets()
                ->where('status', 'SERVED')
                ->whereDate('updated_at', $today)
                ->count(),
            'missed_today' => $company->tickets()
                ->where('status', 'MISSED_TEMP')
                ->whereDate('updated_at', $today)
                ->count(),
            'present_today' => $company->tickets()
                ->where('status', 'PRESENT')
                ->whereDate('updated_at', $today)
                ->count(),
            'waiting_count' => $company->tickets()
                ->where('status', 'WAITING')
                ->count(),
            'called_count' => $company->tickets()
                ->where('status', 'CALLED')
                ->count(),
        ];
        
        return response()->json($stats);
    }

    /**
     * Obtenir les tickets en attente pour le dashboard agent
     */
    public function getWaitingTickets(Company $company)
    {
        $waitingTickets = $company->tickets()
            ->where('status', 'WAITING')
            ->with(['service'])
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($ticket, $index) {
                return [
                    'id' => $ticket->id,
                    'number' => $ticket->number,
                    'client_name' => $ticket->client_name,
                    'service' => $ticket->service->name,
                    'position' => $index + 1,
                    'created_at' => $ticket->created_at->format('H:i:s'),
                    'wait_time' => $ticket->created_at->diffInMinutes(now()),
                ];
            });

        return response()->json([
            'tickets' => $waitingTickets,
            'total_count' => $waitingTickets->count(),
            'updated_at' => now()->format('H:i:s')
        ]);
    }

    // ========== HELPERS ==========

    private function generateTicketNumber(Service $service): string
    {
        $prefix = $service->prefix;
        $date = now()->format('Ymd');
        $count = $service->tickets()->whereDate('created_at', today())->count() + 1;

        return $prefix . $date . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    private function calculateWaitTime(Service $service): int
    {
        $waitingTickets = $service->waitingTickets()->count();
        $estimatedTime = $service->estimated_service_time;

        return ($waitingTickets + 1) * $estimatedTime;
    }
}
