
<script>
if (typeof window.tailwind === 'undefined') {
    window.tailwind = { colors: { blue: { 500: '#3b82f6' }, white: '#ffffff', gray: { 500: '#6b7280' } } };
}
</script>
@extends('layouts.app')

@section('title', 'Dashboard Agent - ' . $company->name)

@section('content')
<div class="min-h-screen bg-slate-50">
    <!-- Header -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">{{ $company->name }}</h1>
                    <p class="text-sm text-slate-500">Interface Agent</p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-slate-600">Bonjour, {{ auth()->user()->name }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Mes Guichets -->
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Mes Guichets</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($myCounters as $counter)
            <div class="bg-white rounded-lg shadow p-6 {{ $counter->isOpen() ? 'border-l-4 border-green-500' : 'border-l-4 border-red-500' }}">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-semibold text-slate-900">{{ $counter->name }}</h3>
                        <p class="text-sm text-slate-500">{{ $counter->service?->name ?? 'Sans service' }}</p>
                    </div>
                    <span class="px-2 py-1 rounded-full text-xs font-medium {{ $counter->isOpen() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $counter->isOpen() ? 'Ouvert' : 'Fermé' }}
                    </span>
                </div>

                <div class="flex space-x-2">
                    <a href="{{ route('company.agent.counter', [$company, $counter]) }}" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-center text-sm font-medium">
                        Accéder
                    </a>

                    @if($counter->isOpen())
                    <form method="POST" action="{{ route('company.agent.counter.close', [$company, $counter]) }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 text-sm font-medium">
                            Fermer
                        </button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('company.agent.counter.open', [$company, $counter]) }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 text-sm font-medium">
                            Ouvrir
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-lg shadow p-8 text-center text-slate-500">
                <p>Aucun guichet ne vous est assigné.</p>
                <p class="text-sm mt-2">Contactez votre administrateur.</p>
            </div>
            @endforelse
        </div>

        <!-- Services Disponibles -->
        <h2 class="text-lg font-semibold text-slate-900 mb-4">Services Disponibles</h2>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="divide-y divide-slate-200">
                @forelse($services as $service)
                <div class="px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 font-bold">
                            {{ $service->prefix }}
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-slate-900">{{ $service->name }}</p>
                            <p class="text-sm text-slate-500">{{ $service->estimated_service_time }} min/ticket</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-sm font-medium">
                            {{ $service->waiting_tickets_count }} en attente
                        </span>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-slate-500">
                    Aucun service disponible.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Stats du jour -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-medium text-slate-900 mb-2">Mes Performances Aujourd'hui</h3>
                <div class="mt-4">
                    <p class="text-3xl font-bold text-blue-600">{{ $myTicketsToday }}</p>
                    <p class="text-sm text-slate-500">Tickets servis</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-medium text-slate-900 mb-2">Liens Rapides</h3>
                <div class="mt-4 space-y-2">
                    <a href="{{ route('company.public', $company) }}" target="_blank" class="block text-blue-600 hover:text-blue-800 text-sm">
                        → Voir la page publique
                    </a>
                    <a href="{{ route('company.display', $company) }}" target="_blank" class="block text-blue-600 hover:text-blue-800 text-sm">
                        → Ouvrir l'écran d'affichage
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
