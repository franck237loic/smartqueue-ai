@extends('layouts.company-admin')

@section('title', 'Modifier Agent - ' . $company->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-dark-800 rounded-xl p-6 card-shadow">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-brand-500/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white">Modifier l'Agent</h1>
                <p class="text-dark-600">
                    Modifier les informations de {{ $agent->name }} pour l'entreprise {{ $company->name }}
                </p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-dark-800 rounded-xl card-shadow">
        <form method="POST" action="{{ route('company.admin.agents.update', [$company, $agent]) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Personal Information -->
            <div class="p-6 border-b border-dark-700">
                <h2 class="text-lg font-bold text-white mb-6">Informations Personnelles</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-white mb-2">
                            Nom Complet <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" required
                               value="{{ $agent->name }}"
                               class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white placeholder-dark-500 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                               placeholder="Entrez le nom complet de l'agent">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-white mb-2">
                            Email <span class="text-red-400">*</span>
                        </label>
                        <input type="email" name="email" required
                               value="{{ $agent->email }}"
                               class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white placeholder-dark-500 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                               placeholder="agent@entreprise.com">
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div>
                        <label class="block text-sm font-medium text-white mb-2">
                            Nouveau Mot de Passe
                        </label>
                        <input type="password" name="password"
                               class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white placeholder-dark-500 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                               placeholder="Laissez vide pour ne pas modifier">
                        <p class="text-xs text-dark-600 mt-2">Minimum 8 caractères (laissez vide pour conserver l'actuel)</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-white mb-2">
                            Téléphone
                        </label>
                        <input type="tel" name="phone"
                               value="{{ $agent->phone ?? '' }}"
                               class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white placeholder-dark-500 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent"
                               placeholder="+33 1 23 45 67 89">
                    </div>
                </div>
            </div>
            
            <!-- Role Assignment -->
            <div class="p-6 border-b border-dark-700">
                <h2 class="text-lg font-bold text-white mb-6">Assignation</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-white mb-2">
                            Rôle <span class="text-red-400">*</span>
                        </label>
                        <select name="role" required
                                class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">Sélectionnez un rôle</option>
                            @php
                                $agentPivot = $agent->companies()->where('company_id', $company->id)->first();
                                $currentRole = $agentPivot ? $agentPivot->pivot->role : 'agent';
                            @endphp
                            <option value="agent" {{ $currentRole == 'agent' ? 'selected' : '' }}>
                                Agent
                            </option>
                            <option value="company_admin" {{ $currentRole == 'company_admin' ? 'selected' : '' }}>
                                Administrateur d'Entreprise
                            </option>
                        </select>
                        <p class="text-xs text-dark-600 mt-2">
                            Agent: Peut gérer les tickets et guichets<br>
                            Admin: Peut gérer toute l'entreprise
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-white mb-2">
                            Guichet Assigné
                        </label>
                        <select name="counter_id"
                                class="w-full px-4 py-3 bg-dark-700 border border-dark-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option value="">Aucun guichet assigné</option>
                            @foreach($counters as $counter)
                            <option value="{{ $counter->id }}" 
                                    {{ ($agentPivot && $agentPivot->pivot->counter_id == $counter->id) ? 'selected' : '' }}>
                                {{ $counter->name }} @if($counter->service) ({{ $counter->service->name }}) @endif
                            </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-dark-600 mt-2">
                            Optionnel: L'agent sera assigné à ce guichet par défaut
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Current Status -->
            <div class="p-6 border-b border-dark-700">
                <h2 class="text-lg font-bold text-white mb-6">Statut Actuel</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-sm text-dark-600 mb-1">Date de création</p>
                        <p class="text-white">{{ $agent->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-dark-600 mb-1">Dernière modification</p>
                        <p class="text-white">{{ $agent->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-dark-600 mb-1">Statut du compte</p>
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                            Actif
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="p-6 flex justify-between items-center">
                <div class="flex gap-4">
                    <a href="{{ route('company.admin.agents', $company) }}" 
                       class="px-6 py-3 bg-dark-700 text-white rounded-lg hover:bg-dark-600 font-medium">
                        Annuler
                    </a>
                    
                    <button type="button" 
                            onclick="confirmDelete()"
                            class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Supprimer l'Agent
                    </button>
                </div>
                
                <button type="submit" 
                        class="px-6 py-3 bg-brand-600 text-white rounded-lg hover:bg-brand-700 font-medium shadow-lg shadow-brand-600/30">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Enregistrer les Modifications
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-dark-800 rounded-xl p-6 max-w-md w-full card-shadow">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.932-2.5L13.068 4c-.57-.833-1.392-1.5-2.932-1.5H4.864c-1.54 0-2.362.667-2.932 1.5L2.068 16.5c-.57.833-.608 2.5.932 2.5h13.856c1.54 0 2.362-.667 2.932-1.5l1.068-11z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Supprimer l'agent</h3>
                    <p class="text-dark-600">Cette action est irréversible</p>
                </div>
            </div>
            
            <p class="text-dark-600 mb-6">
                Êtes-vous sûr de vouloir supprimer l'agent <span class="font-medium text-white">{{ $agent->name }}</span> ?
            </p>
            
            <div class="flex gap-3 justify-end">
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-dark-700 text-white rounded-lg hover:bg-dark-600 font-medium">
                    Annuler
                </button>
                <form method="POST" action="{{ route('company.admin.agents.destroy', [$company, $agent]) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Delete confirmation
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.querySelector('input[name="password"]').value;
    const email = document.querySelector('input[name="email"]').value;
    const name = document.querySelector('input[name="name"]').value;
    
    if (password && password.length < 8) {
        e.preventDefault();
        alert('Le mot de passe doit contenir au moins 8 caractères');
        return;
    }
    
    if (!email || !name) {
        e.preventDefault();
        alert('Le nom et l\'email sont obligatoires');
        return;
    }
});
</script>
@endsection
