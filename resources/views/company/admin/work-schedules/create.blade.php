@extends('layouts.company-admin')

@section('title', 'Nouveau Planning - ' . $company->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Nouveau Planning</h1>
                    <p class="text-gray-600">Configurez les horaires de travail</p>
                </div>
                <a href="{{ route('company.admin.work-schedules.index', $company) }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour
                </a>
            </div>
        </div>
    </div>

    <!-- Formulaire -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white shadow sm:rounded-lg">
            <form id="scheduleForm" class="space-y-6 p-6">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Colonne de gauche -->
                    <div class="space-y-6">
                        <!-- Service -->
                        <div>
                            <label for="service_id" class="block text-sm font-medium text-gray-700">
                                Service <span class="text-red-500">*</span>
                            </label>
                            <select id="service_id" name="service_id" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Sélectionnez un service</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Guichet -->
                        <div>
                            <label for="counter_id" class="block text-sm font-medium text-gray-700">
                                Guichet <span class="text-gray-400">(optionnel)</span>
                            </label>
                            <select id="counter_id" name="counter_id" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Sélectionnez d'abord un service</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Laissez vide pour appliquer à tous les guichets du service</p>
                        </div>

                        <!-- Agent -->
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700">
                                Agent <span class="text-gray-400">(optionnel)</span>
                            </label>
                            <select id="user_id" name="user_id" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Sélectionnez d'abord un guichet</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Laissez vide pour appliquer à tous les agents du guichet</p>
                        </div>

                        <!-- Fuseau horaire -->
                        <div>
                            <label for="timezone" class="block text-sm font-medium text-gray-700">
                                Fuseau horaire <span class="text-red-500">*</span>
                            </label>
                            <select id="timezone" name="timezone" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="Europe/Paris">Europe/Paris</option>
                                <option value="Europe/London">Europe/London</option>
                                <option value="Europe/Berlin">Europe/Berlin</option>
                                <option value="Europe/Madrid">Europe/Madrid</option>
                                <option value="Europe/Rome">Europe/Rome</option>
                                <option value="America/New_York">America/New_York</option>
                                <option value="America/Los_Angeles">America/Los_Angeles</option>
                                <option value="Asia/Tokyo">Asia/Tokyo</option>
                            </select>
                        </div>
                    </div>

                    <!-- Colonne de droite -->
                    <div class="space-y-6">
                        <!-- Horaires matin -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Horaires du matin</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="morning_start" class="block text-sm font-medium text-gray-700">
                                        Ouverture <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="morning_start" name="morning_start" value="07:00" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="morning_end" class="block text-sm font-medium text-gray-700">
                                        Fermeture (pause) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="morning_end" name="morning_end" value="12:00" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Horaires après-midi -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Horaires de l'après-midi</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="afternoon_start" class="block text-sm font-medium text-gray-700">
                                        Ouverture (reprise) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="afternoon_start" name="afternoon_start" value="14:00" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label for="afternoon_end" class="block text-sm font-medium text-gray-700">
                                        Fermeture (fin journée) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" id="afternoon_end" name="afternoon_end" value="17:30" required
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Jours de travail -->
                        <div class="border rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Jours de travail</h3>
                            <div class="grid grid-cols-2 gap-2">
                                @foreach(['1' => 'Lundi', '2' => 'Mardi', '3' => 'Mercredi', '4' => 'Jeudi', '5' => 'Vendredi', '6' => 'Samedi', '7' => 'Dimanche'] as $day => $name)
                                    <label class="flex items-center">
                                        <input type="checkbox" name="working_days[]" value="{{ $day }}" 
                                               {{ $day <= 5 ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <span class="ml-2 text-sm text-gray-700">{{ $name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">
                                Notes <span class="text-gray-400">(optionnel)</span>
                            </label>
                            <textarea id="notes" name="notes" rows="3" maxlength="500"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Notes supplémentaires sur ce planning..."></textarea>
                            <p class="mt-1 text-sm text-gray-500">Maximum 500 caractères</p>
                        </div>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3 pt-6 border-t">
                    <a href="{{ route('company.admin.work-schedules.index', $company) }}" 
                       class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Annuler
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Créer le planning
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Données des guichets par service
const countersByService = @json($services->map(function($service) {
    return [
        'id' => $service->id,
        'counters' => $service->counters->map(function($counter) {
            return [
                'id' => $counter->id,
                'name' => $counter->name,
                'user_id' => $counter->user_id
            ];
        })
    ];
}));

// Données des agents
const agents = @json($agents->map(function($agent) {
    return [
        'id' => $agent->id,
        'name' => $agent->name
    ];
}));

// Mise à jour des guichets quand le service change
document.getElementById('service_id').addEventListener('change', function() {
    const serviceId = this.value;
    const counterSelect = document.getElementById('counter_id');
    const userSelect = document.getElementById('user_id');
    
    // Vider les selects
    counterSelect.innerHTML = '<option value="">Sélectionnez un guichet</option>';
    userSelect.innerHTML = '<option value="">Sélectionnez un agent</option>';
    
    if (serviceId) {
        const service = countersByService.find(s => s.id == serviceId);
        if (service) {
            service.counters.forEach(counter => {
                const option = document.createElement('option');
                option.value = counter.id;
                option.textContent = counter.name;
                counterSelect.appendChild(option);
            });
        }
    }
});

// Mise à jour des agents quand le guichet change
document.getElementById('counter_id').addEventListener('change', function() {
    const counterId = this.value;
    const userSelect = document.getElementById('user_id');
    
    userSelect.innerHTML = '<option value="">Sélectionnez un agent</option>';
    
    if (counterId) {
        agents.forEach(agent => {
            const option = document.createElement('option');
            option.value = agent.id;
            option.textContent = agent.name;
            userSelect.appendChild(option);
        });
    }
});

// Validation du formulaire
document.getElementById('scheduleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData.entries());
    
    // Convertir working_days en array
    if (!data.working_days) {
        data.working_days = [];
    } else if (typeof data.working_days === 'string') {
        data.working_days = [data.working_days];
    }
    
    // Validation des horaires
    const morningStart = data.morning_start;
    const morningEnd = data.morning_end;
    const afternoonStart = data.afternoon_start;
    const afternoonEnd = data.afternoon_end;
    
    if (morningStart >= morningEnd) {
        alert('L\'heure de fin matin doit être après l\'heure de début matin');
        return;
    }
    
    if (afternoonStart >= afternoonEnd) {
        alert('L\'heure de fin après-midi doit être après l\'heure de début après-midi');
        return;
    }
    
    if (morningEnd >= afternoonStart) {
        alert('L\'heure de début après-midi doit être après l\'heure de fin matin');
        return;
    }
    
    if (data.working_days.length === 0) {
        alert('Veuillez sélectionner au moins un jour de travail');
        return;
    }
    
    // Envoyer le formulaire
    fetch('{{ route('company.admin.work-schedules.store', $company) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Planning créé avec succès!');
            window.location.href = '{{ route('company.admin.work-schedules.index', $company) }}';
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Une erreur est survenue');
    });
});
</script>
@endsection
