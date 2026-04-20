@extends('layouts.app')

@section('title', 'Prendre un ticket - ' . $company->name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark-900 to-dark-800 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">{{ $company->name }}</h1>
            <p class="text-dark-400">Sélectionnez un service pour prendre votre ticket</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500/30 rounded-xl text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/30 rounded-xl text-red-400">
                {{ session('error') }}
            </div>
        @endif

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($services as $service)
                <div class="service-card bg-dark-800/50 border border-dark-700 rounded-2xl p-6 hover:border-brand-500/50 transition-all duration-300 cursor-pointer"
                     onclick="selectService({{ $service->id }}, '{{ $service->name }}')">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-brand-500 to-purple-600 rounded-xl flex items-center justify-center text-white text-xl font-bold">
                            {{ substr($service->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-white">{{ $service->name }}</h3>
                            <p class="text-dark-400 text-sm">
                                @php
                                    $waitingCount = \App\Models\Ticket::where('service_id', $service->id)
                                        ->where('status', 'WAITING')
                                        ->count();
                                @endphp
                                {{ $waitingCount }} en attente
                            </p>
                        </div>
                        <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-dark-400">Aucun service disponible</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal pour saisir les informations -->
<div id="ticketModal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 hidden items-center justify-center">
    <div class="bg-dark-800 border border-dark-700 rounded-2xl p-6 w-full max-w-md mx-4">
        <h2 class="text-xl font-bold text-white mb-4">Prendre un ticket</h2>
        
        <form id="ticketForm" method="POST" action="{{ route('tickets.store', $company) }}">
            @csrf
            <input type="hidden" name="service_id" id="serviceId">
            
            <div class="mb-4">
                <p class="text-dark-400 text-sm mb-2">Service sélectionné :</p>
                <p id="serviceName" class="text-white font-medium"></p>
            </div>
            
            <div class="mb-4">
                <label class="block text-dark-400 text-sm mb-2">Votre nom (optionnel)</label>
                <input type="text" name="guest_name" 
                       class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-xl text-white placeholder-dark-500 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all"
                       placeholder="Jean Dupont">
            </div>
            
            <div class="mb-6">
                <label class="block text-dark-400 text-sm mb-2">Téléphone (optionnel)</label>
                <input type="tel" name="guest_phone" 
                       class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-xl text-white placeholder-dark-500 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all"
                       placeholder="+33 6 12 34 56 78">
            </div>
            
            <div class="flex gap-3">
                <button type="button" onclick="closeModal()"
                        class="flex-1 px-4 py-3 bg-dark-700 hover:bg-dark-600 text-white rounded-xl transition-colors">
                    Annuler
                </button>
                <button type="submit"
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-brand-600 to-purple-600 hover:from-brand-500 hover:to-purple-500 text-white rounded-xl transition-all">
                    Confirmer
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .service-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 40px -10px rgba(59, 130, 246, 0.3);
    }
</style>

<script>
    function selectService(serviceId, serviceName) {
        document.getElementById('serviceId').value = serviceId;
        document.getElementById('serviceName').textContent = serviceName;
        document.getElementById('ticketModal').classList.remove('hidden');
        document.getElementById('ticketModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('ticketModal').classList.add('hidden');
        document.getElementById('ticketModal').classList.remove('flex');
    }

    // Fermer avec Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });

    // Fermer en cliquant à l'extérieur
    document.getElementById('ticketModal').addEventListener('click', function(e) {
        if (e.target === this) closeModal();
    });
</script>
@endsection
