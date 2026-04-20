<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Queue;
use App\Models\Ticket;
use App\Models\User;
use App\Services\QueueService;
use App\Services\AIEstimationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected $queueService;
    protected $aiService;

    public function __construct(QueueService $queueService, AIEstimationService $aiService)
    {
        $this->queueService = $queueService;
        $this->aiService = $aiService;
    }

    public function dashboard()
{
    // Calculer les statistiques nécessaires pour la vue
    $stats = [
        'total_queues' => App\Models\Queue::count(),
        'served_today' => App\Models\Ticket::whereDate('served_at', now()->today())->count(),
        'waiting_now' => App\Models\Ticket::where('status', 'waiting')->count(),
        'avg_wait_time' => App\Models\Ticket::where('status', 'served')
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, served_at)) as avg_wait')
            ->value('avg_wait') ?? 0,
    ];

    // Récupérer les files d'attente avec leurs relations
    $queues = App\Models\Queue::with(['waitingTickets', 'servedTickets', 'user'])->get();

    // Récupérer les agents
    $agents = App\Models\User::whereHas('companies', function($query) {
        $query->where('role', 'agent');
    })->get();

    return view('admin.dashboard', compact('stats', 'queues', 'agents'));
    }

    public function queues()
    {
        $queues = Queue::with(['user', 'tickets'])->latest()->paginate(10);
        return view('admin.queues.index', compact('queues'));
    }

    public function createQueue()
    {
        return view('admin.queues.create');
    }

    public function storeQueue(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prefix' => 'required|string|max:5',
            'estimated_service_time' => 'required|integer|min:1',
            'missed_timeout' => 'required|integer|min:1',
        ]);

        $queue = $this->queueService->createQueue(auth()->user(), $data);

        return redirect()->route('admin.queues')
            ->with('success', 'File créée avec succès.');
    }

    public function editQueue(Queue $queue)
    {
        return view('admin.queues.edit', compact('queue'));
    }

    public function updateQueue(Request $request, Queue $queue)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prefix' => 'required|string|max:5',
            'status' => 'required|in:active,paused,closed',
            'estimated_service_time' => 'required|integer|min:1',
            'missed_timeout' => 'required|integer|min:1',
        ]);

        $this->queueService->updateQueue($queue, $data);

        return redirect()->route('admin.queues')
            ->with('success', 'File mise à jour.');
    }

    public function destroyQueue(Queue $queue)
    {
        $this->queueService->deleteQueue($queue);

        return redirect()->route('admin.queues')
            ->with('success', 'File supprimée.');
    }

    public function agents()
    {
        $agents = User::where('role', 'agent')->with('tickets')->latest()->get();
        return view('admin.agents.index', compact('agents'));
    }

    public function createAgent()
    {
        return view('admin.agents.create');
    }

    public function storeAgent(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Créer l'utilisateur avec mot de passe hashé
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'global_role' => 'user',
            'current_company_id' => $company->id,
        ]);

        // Associer l'agent à l'entreprise
        $company->users()->attach($user->id, [
            'role' => 'agent',
            'is_default' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('company.admin.agents', $company)
            ->with('success', 'Agent créé avec succès.');
    }

    public function statistics(Queue $queue)
    {
        $stats = $this->queueService->getQueueStats($queue);
        $analytics = $this->aiService->getQueueAnalytics($queue);

        return view('admin.statistics', compact('queue', 'stats', 'analytics'));
    }

    /**
     * Afficher la liste des entreprises
     */
    public function companiesIndex()
    {
        $companies = Company::with('users')->get();
        return view('admin.companies.index', compact('companies'));
    }

    /**
     * Afficher le formulaire de réinitialisation du mot de passe d'une entreprise
     */
    public function showResetPasswordForm(Company $company)
    {
        // Récupérer les administrateurs et agents de l'entreprise
        $admins = $company->users()
            ->wherePivotIn('role', ['company_admin', 'agent'])
            ->get();

        return view('admin.companies.reset-password', compact('company', 'admins'));
    }

    /**
     * Réinitialiser le mot de passe d'un utilisateur d'entreprise
     */
    public function resetPassword(Request $request, Company $company)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($request->user_id);

        // Vérifier que l'utilisateur appartient bien à cette entreprise
        if (!$company->users()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Cet utilisateur n\'appartient pas à cette entreprise.');
        }

        // Mettre à jour le mot de passe
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Créer un log de l'action
        Log::info('Super admin a réinitialisé le mot de passe', [
            'super_admin_id' => auth()->id(),
            'target_user_id' => $user->id,
            'company_id' => $company->id,
            'action' => 'password_reset'
        ]);

        return back()->with('success', "Le mot de passe de {$user->name} ({$user->email}) a été réinitialisé avec succès.");
    }

    /**
     * Générer un mot de passe aléatoire sécurisé
     */
    private function generateSecurePassword($length = 12)
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        return substr(str_shuffle($chars), 0, $length);
    }

    /**
     * Réinitialiser automatiquement avec un mot de passe généré
     */
    public function autoResetPassword(Request $request, Company $company)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        // Vérifier que l'utilisateur appartient bien à cette entreprise
        if (!$company->users()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Cet utilisateur n\'appartient pas à cette entreprise.');
        }

        // Générer un mot de passe sécurisé
        $newPassword = $this->generateSecurePassword();
        
        // Mettre à jour le mot de passe
        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        // Créer un log de l'action
        Log::info('Super admin a généré un nouveau mot de passe', [
            'super_admin_id' => auth()->id(),
            'target_user_id' => $user->id,
            'company_id' => $company->id,
            'action' => 'auto_password_reset'
        ]);

        return back()->with('success', "Nouveau mot de passe généré pour {$user->name} ({$user->email}) : <strong>{$newPassword}</strong>");
    }
}
