@extends('layouts.app')

@section('title', $counter->name . ' - ' . $company->name)

@section('content')
<div class="min-h-screen bg-[#F8FAFC]" style="font-family: 'Inter', sans-serif;">
    <!-- Header -->
    <div class="bg-slate-900 text-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-bold">
                        {{ $counter->number }}
                    </div>
                    <div class="ml-3">
                        <h1 class="font-bold">{{ $counter->name }}</h1>
                        <p class="text-xs text-slate-400">{{ $company->name }} • {{ $service?->name ?? 'Sans service' }}</p>
                    </div>
                </div>
                <a href="{{ route('company.agent.dashboard', $company) }}" class="text-slate-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Zone principale - Ticket en cours -->
            <div class="lg:col-span-2 space-y-6">
                @if($currentTicket)
                <!-- Ticket Actuel -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-3xl p-8 text-white shadow-xl">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-blue-200 text-sm uppercase tracking-wide">Ticket en cours</p>
                            <p class="text-6xl font-bold mt-2">{{ $currentTicket->number }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-blue-200 text-sm uppercase tracking-wide">Appelé à</p>
                            <p class="text-2xl font-bold mt-2">{{ $currentTicket->called_at?->format('H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-center space-x-1 mb-8">
                        @for($i = 0; $i < 3; $i++)
                        <div class="w-2 h-8 bg-white/30 rounded-full animate-pulse" style="animation-delay: {{ $i * 0.2 }}s"></div>
                        @endfor
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <form method="POST" action="{{ route('company.agent.serve', [$company, $currentTicket]) }}" class="col-span-1">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-green-500 hover:bg-green-400 rounded-xl font-bold text-lg transition shadow-lg">
                                ✓ Servi
                            </button>
                        </form>

                        <form method="POST" action="{{ route('company.agent.missed', [$company, $currentTicket]) }}" class="col-span-1">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-red-500 hover:bg-red-400 rounded-xl font-bold text-lg transition shadow-lg">
                                ✗ Absent
                            </button>
                        </form>

                        <form method="POST" action="{{ route('company.agent.recall', [$company, $currentTicket]) }}" class="col-span-1">
                            @csrf
                            <button type="submit" class="w-full py-4 bg-blue-500 hover:bg-blue-400 rounded-xl font-bold text-lg transition shadow-lg">
                                ↻ Rappeler
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <!-- Aucun ticket -->
                <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-slate-200">
                    <div class="w-24 h-24 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    </div>
                    <p class="text-xl text-slate-500 mb-8">Aucun ticket en cours</p>

                    @if($service && $counter->isOpen())
                    <form method="POST" action="{{ route('company.agent.call', [$company, $service]) }}">
                        @csrf
                        <input type="hidden" name="counter_id" value="{{ $counter->id }}">
                        <button type="submit" class="px-12 py-6 bg-[#2563EB] hover:bg-blue-700 text-white rounded-2xl font-bold text-xl transition shadow-xl">
                            📢 Appeler Suivant
                        </button>
                    </form>
                    @elseif(!$counter->isOpen())
                    <p class="text-orange-600 font-medium bg-orange-50 inline-block px-6 py-3 rounded-xl">
                        Guichet fermé - Ouvrez le guichet pour appeler
                    </p>
                    @else
                    <p class="text-red-600 font-medium bg-red-50 inline-block px-6 py-3 rounded-xl">
                        Aucun service assigné à ce guichet
                    </p>
                    @endif
                </div>
                @endif

                <!-- Historique -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
                        <h3 class="font-bold text-slate-900">Historique Aujourd'hui</h3>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($calledToday as $ticket)
                        <div class="px-6 py-4 flex justify-between items-center hover:bg-slate-50 transition">
                            <div class="flex items-center">
                                <span class="w-10 h-10 bg-slate-100 rounded-lg flex items-center justify-center font-bold text-slate-700">
                                    {{ $ticket->number }}
                                </span>
                                <div class="ml-3">
                                    <p class="font-medium text-slate-900">{{ $ticket->service?->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $ticket->called_at?->format('H:i') }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($ticket->status === 'served') bg-green-100 text-green-700
                                @elseif($ticket->status === 'missed') bg-red-100 text-red-700
                                @else bg-blue-100 text-blue-700 @endif">
                                @if($ticket->status === 'served') Servi
                                @elseif($ticket->status === 'missed') Absent
                                @else En cours @endif
                            </span>
                        </div>
                        @empty
                        <div class="px-6 py-8 text-center text-slate-500">
                            Aucun ticket appelé aujourd'hui
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Statut -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <div class="flex items-center justify-between">
                        <span class="text-slate-600 font-medium">Statut du guichet</span>
                        <span class="px-4 py-2 rounded-full text-sm font-bold {{ $counter->isOpen() ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $counter->isOpen() ? 'OUVERT' : 'FERMÉ' }}
                        </span>
                    </div>
                </div>

                <!-- File d'attente -->
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-900">File d'Attente</h3>
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-bold">
                            {{ $waitingTickets->count() }}
                        </span>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @forelse($waitingTickets as $ticket)
                        <div class="px-6 py-3 border-b border-slate-50 flex justify-between items-center">
                            <span class="font-bold text-slate-900">{{ $ticket->number }}</span>
                            <span class="text-sm text-slate-400">{{ $ticket->created_at->diffForHumans() }}</span>
                        </div>
                        @empty
                        <div class="px-6 py-8 text-center text-slate-500">
                            Aucun ticket en attente
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Instructions -->
                <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100">
                    <h3 class="font-bold text-blue-900 mb-3">Instructions</h3>
                    <ul class="space-y-2 text-sm text-blue-700">
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Cliquez "Appeler Suivant" pour le prochain ticket</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>Patientez 45 secondes avant de marquer absent</span>
                        </li>
                        <li class="flex items-start">
                            <span class="mr-2">•</span>
                            <span>3 absences = ticket annulé automatiquement</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function callNext(counterId) {
    fetch('/company/2/agent/call-next', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: `counter_id=${counterId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mettre à jour l'interface
            updateCurrentTicket(data.ticket);
            updateWaitingTickets();
            showSuccess(`Ticket ${data.ticket.number} appelé avec succès!`);
        } else {
            showError(data.error || 'Erreur lors de l\'appel du ticket');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showError('Erreur réseau lors de l\'appel du ticket');
    });
}

function updateCurrentTicket(ticket) {
    const currentTicketDiv = document.getElementById('current-ticket');
    if (currentTicketDiv) {
        currentTicketDiv.innerHTML = `
            <div class="text-center">
                <div class="text-6xl font-bold text-blue-600 mb-2">${ticket.number}</div>
                <div class="text-lg text-slate-600">Service: ${ticket.service.name}</div>
                <div class="text-sm text-slate-500">Guichet: ${ticket.counter.name}</div>
                <div class="text-sm text-slate-400 mt-2">Appelé à: ${new Date(ticket.called_at).toLocaleTimeString()}</div>
            </div>
        `;
    }
}

function updateWaitingTickets() {
    // Rafraîchir la liste des tickets en attente
    setTimeout(() => {
        window.location.reload();
    }, 1000);
}

function showSuccess(message) {
    // Afficher un message de succès
    const alertDiv = document.createElement('div');
    alertDiv.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50';
    alertDiv.innerHTML = `
        <strong>Succès!</strong> ${message}
    `;
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}

function showError(message) {
    // Afficher un message d'erreur
    const alertDiv = document.createElement('div');
    alertDiv.className = 'fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50';
    alertDiv.innerHTML = `
        <strong>Erreur!</strong> ${message}
    `;
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.remove();
    }, 3000);
}
</script>
@endpush
