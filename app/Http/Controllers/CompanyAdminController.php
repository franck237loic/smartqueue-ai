<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Counter;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyAdminController extends Controller
{
    /**
     * Dashboard admin entreprise
     */
    public function dashboard(Company $company)
    {
        $stats = [
            'services_count' => $company->services()->count(),
            'counters_count' => $company->counters()->count(),
            'agents_count' => $company->users()->wherePivotIn('role', ['company_admin', 'agent'])->count(),
            'tickets_today' => $company->tickets()->whereDate('created_at', today())->count(),
            'tickets_served_today' => $company->tickets()->where('status', 'served')->whereDate('served_at', today())->count(),
        ];

        $services = $company->services()->withCount(['tickets' => function ($q) {
            $q->whereDate('created_at', today());
        }])->get();

        return view('company.admin.dashboard', compact('company', 'stats', 'services'));
    }

    // ========== SERVICES ==========

    public function services(Company $company)
    {
        $services = $company->services()->withCount('counters')->paginate(10);
        return view('company.admin.services.index', compact('company', 'services'));
    }

    public function createService(Company $company)
    {
        return view('company.admin.services.create', compact('company'));
    }

    public function storeService(Request $request, Company $company)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'prefix' => 'required|string|max:10|unique:services,prefix,NULL,id,company_id,' . $company->id,
            'description' => 'nullable|string',
            'estimated_service_time' => 'required|integer|min:1',
            'missed_timeout' => 'required|integer|min:1',
            'max_daily_tickets' => 'nullable|integer|min:1',
        ]);

        $data['company_id'] = $company->id;
        $data['status'] = 'active';

        Service::create($data);

        return redirect()->route('company.admin.services', $company)
            ->with('success', 'Service créé avec succès.');
    }

    public function editService(Company $company, Service $service)
    {
        $this->authorizeService($company, $service);
        return view('company.admin.services.edit', compact('company', 'service'));
    }

    public function updateService(Request $request, Company $company, Service $service)
    {
        $this->authorizeService($company, $service);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'prefix' => 'required|string|max:10|unique:services,prefix,' . $service->id . ',id,company_id,' . $company->id,
            'description' => 'nullable|string',
            'estimated_service_time' => 'required|integer|min:1',
            'missed_timeout' => 'required|integer|min:1',
            'max_daily_tickets' => 'nullable|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $service->update($data);

        return redirect()->route('company.admin.services', $company)
            ->with('success', 'Service mis à jour.');
    }

    public function destroyService(Company $company, Service $service)
    {
        $this->authorizeService($company, $service);

        if ($service->tickets()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des tickets existent.');
        }

        $service->delete();

        return redirect()->route('company.admin.services', $company)
            ->with('success', 'Service supprimé.');
    }

    // ========== COUNTERS (GUICHETS) ==========

    public function counters(Company $company)
    {
        $counters = $company->counters()->with(['service', 'user'])->paginate(10);
        return view('company.admin.counters.index', compact('company', 'counters'));
    }

    public function createCounter(Company $company)
    {
        $services = $company->services()->where('status', 'active')->get();
        return view('company.admin.counters.create', compact('company', 'services'));
    }

    public function storeCounter(Request $request, Company $company)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'nullable|string|max:10|unique:counters,number,NULL,id,company_id,' . $company->id,
            'service_id' => 'nullable|exists:services,id',
            'location' => 'nullable|string',
        ]);

        $data['company_id'] = $company->id;
        $data['status'] = 'closed';

        Counter::create($data);

        return redirect()->route('company.admin.counters', $company)
            ->with('success', 'Guichet créé avec succès.');
    }

    public function editCounter(Company $company, Counter $counter)
    {
        $this->authorizeCounter($company, $counter);
        $services = $company->services()->where('status', 'active')->get();
        return view('company.admin.counters.edit', compact('company', 'counter', 'services'));
    }

    public function updateCounter(Request $request, Company $company, Counter $counter)
    {
        $this->authorizeCounter($company, $counter);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'number' => 'nullable|string|max:10|unique:counters,number,' . $counter->id . ',id,company_id,' . $company->id,
            'service_id' => 'nullable|exists:services,id',
            'location' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $counter->update($data);

        return redirect()->route('company.admin.counters', $company)
            ->with('success', 'Guichet mis à jour.');
    }

    public function destroyCounter(Company $company, Counter $counter)
    {
        $this->authorizeCounter($company, $counter);

        if ($counter->tickets()->exists()) {
            return back()->with('error', 'Impossible de supprimer : historique de tickets.');
        }

        $counter->delete();

        return redirect()->route('company.admin.counters', $company)
            ->with('success', 'Guichet supprimé.');
    }

    // ========== AGENTS ==========

    public function agents(Company $company)
    {
        $agents = $company->users()
            ->wherePivotIn('role', ['company_admin', 'agent'])
            ->withPivot(['counter_id', 'role'])
            ->get();
        
        return view('company.admin.agents', compact('company', 'agents'));
    }

    public function createAgent(Company $company)
    {
        $counters = $company->counters()->where('status', 'closed')->get();
        
        return view('company.admin.agents.create', compact('company', 'counters'));
    }

    public function storeAgent(Request $request, Company $company)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:company_admin,agent',
            'counter_id' => [
                'nullable',
                'exists:counters,id',
                function ($attribute, $value, $fail) use ($company) {
                    if ($value && \App\Models\Counter::find($value)?->company_id !== $company->id) {
                        $fail('Le guichet sélectionné n\'appartient pas à cette entreprise.');
                    }
                },
            ],
        ]);

        // Créer l'utilisateur
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'password' => Hash::make($data['password']),
            'global_role' => 'user',
        ]);

        // Attacher à l'entreprise
        $user->companies()->attach($company->id, [
            'role' => $data['role'],
            'counter_id' => $data['counter_id'] ?? null,
        ]);

        return redirect()->route('company.admin.agents', $company)
            ->with('success', 'Agent créé avec succès.');
    }

    public function editAgent(Company $company, User $agent)
    {
        // Vérifier que l'agent appartient à cette entreprise
        if (!$company->users()->where('user_id', $agent->id)->exists()) {
            abort(403, 'Cet agent n\'appartient pas à cette entreprise.');
        }

        $counters = $company->counters()->where('status', 'closed')->get();
        
        return view('company.admin.agents.edit', compact('company', 'agent', 'counters'));
    }

    public function updateAgent(Request $request, Company $company, User $agent)
    {
        // Vérifier que l'agent appartient à cette entreprise
        if (!$company->users()->where('user_id', $agent->id)->exists()) {
            abort(403, 'Cet agent n\'appartient pas à cette entreprise.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $agent->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:company_admin,agent',
            'counter_id' => [
                'nullable',
                'exists:counters,id',
                function ($attribute, $value, $fail) use ($company) {
                    if ($value && \App\Models\Counter::find($value)?->company_id !== $company->id) {
                        $fail('Le guichet sélectionné n\'appartient pas à cette entreprise.');
                    }
                },
            ],
        ]);

        // Mettre à jour l'utilisateur
        $agent->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
        ]);

        // Mettre à jour le mot de passe si fourni
        if (!empty($data['password'])) {
            $agent->update(['password' => Hash::make($data['password'])]);
        }

        // Mettre à jour l'association avec l'entreprise
        $company->users()->updateExistingPivot($agent->id, [
            'role' => $data['role'],
            'counter_id' => $data['counter_id'] ?? null,
        ]);

        return redirect()->route('company.admin.agents', $company)
            ->with('success', 'Agent mis à jour avec succès.');
    }

    public function destroyAgent(Company $company, User $agent)
    {
        // Vérifier que l'agent appartient à cette entreprise
        if (!$company->users()->where('user_id', $agent->id)->exists()) {
            abort(403, 'Cet agent n\'appartient pas à cette entreprise.');
        }

        // Détacher de l'entreprise
        $company->users()->detach($agent->id);

        // Vérifier si l'agent est associé à d'autres entreprises
        $otherCompanies = $agent->companies()->where('company_user.company_id', '!=', $company->id)->count();
        
        // Si l'agent n'est associé qu'à cette entreprise, le supprimer
        if ($otherCompanies === 0) {
            $agent->delete();
        }

        return redirect()->route('company.admin.agents', $company)
            ->with('success', 'Agent supprimé avec succès.');
    }

    public function agentDetails(Company $company, User $agent)
    {
        try {
            // Vérifier que l'agent appartient à cette entreprise
            $pivot = $company->users()->where('user_id', $agent->id)->first();
            if (!$pivot) {
                return response()->json(['error' => 'Agent non trouvé dans cette entreprise'], 404);
            }

            // Récupérer tous les guichets assignés à l'agent dans cette entreprise
            $assignedCounter = $agent->getAssignedCounter($company->id);
            $assignedCounters = $assignedCounter ? [$assignedCounter] : [];

            return response()->json([
                'id' => $agent->id,
                'name' => $agent->name,
                'email' => $agent->email,
                'phone' => $agent->phone ?? 'Non spécifié',
                'created_at' => $agent->created_at,
                'deleted_at' => $agent->deleted_at,
                'pivot_role' => $pivot->pivot->role,
                'company' => [
                    'id' => $company->id,
                    'name' => $company->name,
                ],
                'assigned_counters' => $assignedCounters,
                'status' => $agent->deleted_at ? 'Supprimé' : 'Actif',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in agentDetails: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur lors du chargement des détails'], 500);
        }
    }

    public function removeAgent(Company $company, User $user)
    {
        $company->users()->detach($user->id);

        return redirect()->route('company.admin.agents', $company)
            ->with('success', 'Agent retiré de l\'entreprise.');
    }

    // ========== STATISTIQUES ==========

    public function statistics(Company $company)
    {
        $period = request('period', 'today');

        $stats = [
            'total_tickets' => $company->tickets()->count(),
            'served_tickets' => $company->tickets()->where('status', 'served')->count(),
            'missed_tickets' => $company->tickets()->where('status', 'missed')->count(),
            'avg_wait_time' => $company->tickets()->where('status', 'served')->avg('estimated_wait_time'),
            'avg_service_time' => $company->tickets()->where('status', 'served')->avg('actual_service_time'),
        ];

        return view('company.admin.statistics.index', compact('company', 'stats'));
    }

    public function serviceStatistics(Company $company, Service $service)
    {
        $this->authorizeService($company, $service);

        $stats = [
            'tickets_today' => $service->tickets()->whereDate('created_at', today())->count(),
            'served_today' => $service->servedToday()->count(),
            'waiting' => $service->waitingTickets()->count(),
            'avg_service_time' => $service->tickets()->where('status', 'served')->avg('actual_service_time'),
        ];

        return view('company.admin.statistics.service', compact('company', 'service', 'stats'));
    }

    // ========== HELPERS ==========

    private function authorizeService(Company $company, Service $service): void
    {
        if ($service->company_id !== $company->id) {
            abort(403);
        }
    }

    private function authorizeCounter(Company $company, Counter $counter): void
    {
        if ($counter->company_id !== $company->id) {
            abort(403);
        }
    }
}
