<?php

namespace App\Http\Controllers;

use App\Models\WorkSchedule;
use App\Models\Company;
use App\Models\Service;
use App\Models\Counter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class WorkScheduleController extends Controller
{
    /**
     * Display a listing of work schedules.
     */
    public function index(Company $company, Request $request)
    {
        $schedules = WorkSchedule::forCompany($company->id)
            ->with(['service', 'counter', 'user'])
            ->when($request->service_id, function ($query, $serviceId) {
                return $query->forService($serviceId);
            })
            ->when($request->counter_id, function ($query, $counterId) {
                return $query->forCounter($counterId);
            })
            ->when($request->user_id, function ($query, $userId) {
                return $query->forUser($userId);
            })
            ->orderBy('service_id')
            ->orderBy('counter_id')
            ->paginate(20);

        $services = $company->services()->with('counters')->get();
        $counters = $company->counters()->with('service')->get();
        $agents = $company->users()->wherePivot('role', 'agent')->get();

        return view('company.admin.work-schedules.index', compact(
            'company', 'schedules', 'services', 'counters', 'agents'
        ));
    }

    /**
     * Show the form for creating a new work schedule.
     */
    public function create(Company $company)
    {
        $services = $company->services()->with('counters')->get();
        $counters = $company->counters()->with('service')->get();
        $agents = $company->users()->wherePivot('role', 'agent')->get();

        return view('company.admin.work-schedules.create', compact(
            'company', 'services', 'counters', 'agents'
        ));
    }

    /**
     * Store a newly created work schedule.
     */
    public function store(Company $company, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'counter_id' => 'nullable|exists:counters,id',
            'user_id' => 'nullable|exists:users,id',
            'morning_start' => 'required|date_format:H:i',
            'morning_end' => 'required|date_format:H:i|after:morning_start',
            'afternoon_start' => 'required|date_format:H:i|after:morning_end',
            'afternoon_end' => 'required|date_format:H:i|after:afternoon_start',
            'working_days' => 'required|array|min:1',
            'working_days.*' => 'integer|between:1,7',
            'timezone' => 'required|string|timezone',
            'notes' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ], [
            'morning_start.required' => 'L\'heure de début matin est obligatoire',
            'morning_end.required' => 'L\'heure de fin matin est obligatoire',
            'afternoon_start.required' => 'L\'heure de début après-midi est obligatoire',
            'afternoon_end.required' => 'L\'heure de fin après-midi est obligatoire',
            'working_days.required' => 'Au moins un jour de travail est requis',
            'timezone.required' => 'Le fuseau horaire est obligatoire',
        ]);

        // Validation logique métier
        if ($validated['counter_id'] && !$validated['service_id']) {
            return response()->json([
                'success' => false,
                'message' => 'Un guichet doit être associé à un service'
            ], 422);
        }

        if ($validated['user_id'] && !$validated['counter_id']) {
            return response()->json([
                'success' => false,
                'message' => 'Un agent doit être associé à un guichet'
            ], 422);
        }

        // Vérifier qu'il n'y a pas de conflit
        $conflict = WorkSchedule::where('company_id', $company->id)
            ->when($validated['service_id'], function ($query, $serviceId) {
                return $query->where('service_id', $serviceId);
            })
            ->when($validated['counter_id'], function ($query, $counterId) {
                return $query->where('counter_id', $counterId);
            })
            ->when($validated['user_id'], function ($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->active()
            ->exists();

        if ($conflict) {
            return response()->json([
                'success' => false,
                'message' => 'Un planning existe déjà pour cette configuration'
            ], 422);
        }

        try {
            $schedule = WorkSchedule::create([
                'company_id' => $company->id,
                'service_id' => $validated['service_id'],
                'counter_id' => $validated['counter_id'],
                'user_id' => $validated['user_id'],
                'morning_start' => $validated['morning_start'],
                'morning_end' => $validated['morning_end'],
                'afternoon_start' => $validated['afternoon_start'],
                'afternoon_end' => $validated['afternoon_end'],
                'working_days' => $validated['working_days'],
                'timezone' => $validated['timezone'],
                'notes' => $validated['notes'] ?? null,
                'is_active' => $validated['is_active'] ?? true,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Planning créé avec succès',
                'schedule' => $schedule->load(['service', 'counter', 'user'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du planning: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified work schedule.
     */
    public function show(Company $company, WorkSchedule $workSchedule)
    {
        if ($workSchedule->company_id !== $company->id) {
            abort(404);
        }

        $workSchedule->load(['service', 'counter', 'user']);

        return view('company.admin.work-schedules.show', compact('company', 'workSchedule'));
    }

    /**
     * Show the form for editing the specified work schedule.
     */
    public function edit(Company $company, WorkSchedule $workSchedule)
    {
        if ($workSchedule->company_id !== $company->id) {
            abort(404);
        }

        $services = $company->services()->with('counters')->get();
        $counters = $company->counters()->with('service')->get();
        $agents = $company->users()->wherePivot('role', 'agent')->get();

        return view('company.admin.work-schedules.edit', compact(
            'company', 'workSchedule', 'services', 'counters', 'agents'
        ));
    }

    /**
     * Update the specified work schedule.
     */
    public function update(Company $company, WorkSchedule $workSchedule, Request $request): JsonResponse
    {
        if ($workSchedule->company_id !== $company->id) {
            return response()->json([
                'success' => false,
                'message' => 'Planning non trouvé'
            ], 404);
        }

        $validated = $request->validate([
            'morning_start' => 'required|date_format:H:i',
            'morning_end' => 'required|date_format:H:i|after:morning_start',
            'afternoon_start' => 'required|date_format:H:i|after:morning_end',
            'afternoon_end' => 'required|date_format:H:i|after:afternoon_start',
            'working_days' => 'required|array|min:1',
            'working_days.*' => 'integer|between:1,7',
            'timezone' => 'required|string|timezone',
            'notes' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        try {
            $workSchedule->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Planning mis à jour avec succès',
                'schedule' => $workSchedule->load(['service', 'counter', 'user'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du planning: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified work schedule.
     */
    public function destroy(Company $company, WorkSchedule $workSchedule): JsonResponse
    {
        if ($workSchedule->company_id !== $company->id) {
            return response()->json([
                'success' => false,
                'message' => 'Planning non trouvé'
            ], 404);
        }

        try {
            $workSchedule->delete();

            return response()->json([
                'success' => true,
                'message' => 'Planning supprimé avec succès'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du planning: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle the active status of a work schedule.
     */
    public function toggle(Company $company, WorkSchedule $workSchedule): JsonResponse
    {
        if ($workSchedule->company_id !== $company->id) {
            return response()->json([
                'success' => false,
                'message' => 'Planning non trouvé'
            ], 404);
        }

        try {
            $workSchedule->update(['is_active' => !$workSchedule->is_active]);

            $status = $workSchedule->is_active ? 'activé' : 'désactivé';

            return response()->json([
                'success' => true,
                'message' => "Planning {$status} avec succès",
                'schedule' => $workSchedule->load(['service', 'counter', 'user'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du planning: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get work schedules for a specific counter.
     */
    public function forCounter(Company $company, Counter $counter): JsonResponse
    {
        if ($counter->company_id !== $company->id) {
            return response()->json([
                'success' => false,
                'message' => 'Guichet non trouvé'
            ], 404);
        }

        $schedules = WorkSchedule::forCompany($company->id)
            ->forCounter($counter->id)
            ->active()
            ->with(['service', 'user'])
            ->get();

        return response()->json([
            'success' => true,
            'schedules' => $schedules
        ]);
    }

    /**
     * Get current status of counters based on schedules.
     */
    public function currentStatus(Company $company): JsonResponse
    {
        $now = now();
        $counters = $company->counters()->with(['service', 'user', 'workSchedules'])->get();

        $statusData = [];

        foreach ($counters as $counter) {
            $schedule = $counter->workSchedules()->active()->first();
            
            $status = [
                'counter_id' => $counter->id,
                'counter_name' => $counter->name,
                'service' => $counter->service?->name,
                'agent' => $counter->user?->name,
                'current_status' => $counter->status,
                'is_scheduled' => $schedule ? true : false,
                'is_active_today' => $schedule ? $schedule->isActiveToday() : false,
                'is_in_working_hours' => $schedule ? $schedule->isInWorkingHours() : false,
                'next_open_time' => $schedule ? $schedule->getNextOpenTime()?->format('H:i') : null,
                'working_days' => $schedule ? $schedule->getWorkingDaysFormatted() : null,
            ];

            $statusData[] = $status;
        }

        return response()->json([
            'success' => true,
            'counters' => $statusData,
            'timestamp' => $now->toISOString()
        ]);
    }

    /**
     * Bulk create schedules for all counters in a service.
     */
    public function bulkCreate(Company $company, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'morning_start' => 'required|date_format:H:i',
            'morning_end' => 'required|date_format:H:i|after:morning_start',
            'afternoon_start' => 'required|date_format:H:i|after:morning_end',
            'afternoon_end' => 'required|date_format:H:i|after:afternoon_start',
            'working_days' => 'required|array|min:1',
            'working_days.*' => 'integer|between:1,7',
            'timezone' => 'required|string|timezone',
            'notes' => 'nullable|string|max:500',
        ]);

        $service = $company->services()->findOrFail($validated['service_id']);
        $counters = $service->counters;

        $created = [];
        $errors = [];

        foreach ($counters as $counter) {
            // Vérifier si un planning existe déjà
            $existing = WorkSchedule::forCompany($company->id)
                ->forService($service->id)
                ->forCounter($counter->id)
                ->active()
                ->first();

            if ($existing) {
                $errors[] = "Guichet {$counter->name}: planning déjà existant";
                continue;
            }

            try {
                $schedule = WorkSchedule::create([
                    'company_id' => $company->id,
                    'service_id' => $service->id,
                    'counter_id' => $counter->id,
                    'morning_start' => $validated['morning_start'],
                    'morning_end' => $validated['morning_end'],
                    'afternoon_start' => $validated['afternoon_start'],
                    'afternoon_end' => $validated['afternoon_end'],
                    'working_days' => $validated['working_days'],
                    'timezone' => $validated['timezone'],
                    'notes' => $validated['notes'] ?? null,
                    'is_active' => true,
                ]);

                $created[] = $schedule->counter_name;

            } catch (\Exception $e) {
                $errors[] = "Guichet {$counter->name}: " . $e->getMessage();
            }
        }

        return response()->json([
            'success' => count($errors) === 0,
            'message' => sprintf(
                '%d plannings créés, %d erreurs',
                count($created),
                count($errors)
            ),
            'created' => $created,
            'errors' => $errors
        ]);
    }
}
