@extends('layouts.app')

@section('title', 'Prise de Ticket Client - SmartQueue AI')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8 sm:py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8 sm:mb-12">
            <div class="flex justify-center mb-4 sm:mb-6">
                <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-2xl transform hover:scale-105 transition-transform duration-300">
                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-2 sm:mb-4">Bienvenue dans SmartQueue</h1>
            <p class="text-base sm:text-lg lg:text-xl text-gray-600 max-w-2xl mx-auto">
                Prenez votre ticket en quelques secondes
            </p>
        </div>

        <!-- Carte principale -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            @if($queues->count() > 0)
                <!-- En-tête -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white text-center">Sélectionnez une file d'attente</h2>
                    <p class="text-blue-100 text-center mt-2">Choisissez le service qui vous correspond</p>
                </div>

                <!-- Liste des files -->
                <div class="p-4 sm:p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        @foreach($queues as $queue)
                            <div class="group">
                                <div class="border-2 border-gray-200 rounded-2xl p-4 sm:p-6 hover:border-blue-400 hover:shadow-xl transition-all duration-300 cursor-pointer transform hover:-translate-y-2"
                                     onclick="selectQueue({{ $queue->id }}, '{{ $queue->name }}')">
                                    <!-- Icône -->
                                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-4 group-hover:scale-110 transition-transform">
                                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>

                                    <!-- Nom et description -->
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 text-center mb-2 group-hover:text-blue-600 transition-colors">
                                        {{ $queue->name }}
                                    </h3>
                                    <p class="text-gray-600 text-center text-xs sm:text-sm mb-3 sm:mb-4">
                                        {{ $queue->description }}
                                    </p>

                                    <!-- Statut et attente -->
                                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                                        <span class="inline-flex items-center px-2 py-1 sm:px-3 sm:py-1 rounded-full text-xs font-medium
                                            {{ $queue->isActive() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $queue->status }}
                                        </span>
                                        <div class="text-center">
                                            <div class="text-xl sm:text-2xl font-bold text-blue-600">{{ $queue->waitingTickets()->count() }}</div>
                                            <div class="text-xs text-gray-500">en attente</div>
                                        </div>
                                    </div>

                                    <!-- Bouton -->
                                    <button class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-2 sm:py-3 px-4 rounded-xl font-medium hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl group-hover:scale-105 transform text-sm sm:text-base">
                                        Prendre un ticket
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Message si aucune file -->
                <div class="p-16 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Aucune file d'attente disponible</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Il n'y a actuellement aucune file d'attente active. Veuillez revenir plus tard.
                    </p>
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors font-medium">
                        Retour à l'accueil
                    </a>
                </div>
            @endif
        </div>

        <!-- Informations supplémentaires -->
        <div class="mt-8 sm:mt-12 grid grid-cols-1 sm:grid-cols-3 gap-6 sm:gap-8">
            <div class="text-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2 text-sm sm:text-base">Rapide</h3>
                <p class="text-gray-600 text-xs sm:text-sm">Prenez votre ticket en quelques secondes</p>
            </div>
            
            <div class="text-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2 text-sm sm:text-base">Simple</h3>
                <p class="text-gray-600 text-xs sm:text-sm">Interface intuitive et facile à utiliser</p>
            </div>
            
            <div class="text-center">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2 text-sm sm:text-base">Efficace</h3>
                <p class="text-gray-600 text-xs sm:text-sm">Gestion optimisée des files d'attente</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation -->
<div id="confirmationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-6 sm:p-8 max-w-md w-full mx-4 transform transition-all">
        <div class="text-center mb-4 sm:mb-6">
            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Confirmer la prise de ticket</h3>
            <p class="text-gray-600 text-sm sm:text-base">
                Vous allez prendre un ticket pour: <span id="selectedQueueName" class="font-semibold text-blue-600"></span>
            </p>
        </div>
        
        <form method="POST" action="{{ route('tickets.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="queue_id" id="queue_id" value="">
            
            <div class="flex space-x-3">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-xl font-medium hover:bg-blue-700 transition-colors text-sm sm:text-base">
                    Confirmer
                </button>
                <button type="button" onclick="closeModal()" class="flex-1 bg-gray-200 text-gray-800 py-3 px-4 rounded-xl font-medium hover:bg-gray-300 transition-colors text-sm sm:text-base">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function selectQueue(queueId, queueName) {
    document.getElementById('queue_id').value = queueId;
    document.getElementById('selectedQueueName').textContent = queueName;
    document.getElementById('confirmationModal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('confirmationModal').style.display = 'none';
}

// Fermer le modal en cliquant à l'extérieur
document.getElementById('confirmationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});
</script>
@endsection