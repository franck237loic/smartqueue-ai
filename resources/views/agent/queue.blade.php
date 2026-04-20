@extends('layouts.app')

@section('title', 'Gestion - ' . $queue->name)

@section('content')
<div class="space-y-6 animate-fade-in" x-data="agentQueue()">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('agent.dashboard') }}" class="text-gray-500 hover:text-primary transition text-sm inline-flex items-center gap-2 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Retour aux files
            </a>
            <h1 class="text-3xl font-bold text-text">{{ $queue->name }}</h1>
        </div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $queue->isActive() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
            {{ $queue->isActive() ? 'Active' : 'Inactive' }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            @if($current)
                <div class="bg-gradient-to-r from-primary to-blue-600 rounded-2xl p-8 text-white card-shadow">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <p class="text-blue-100 text-sm mb-1">TICKET EN APPEL</p>
                            <h2 class="text-5xl font-bold font-display">{{ $current->number }}</h2>
                        </div>
                        <div class="text-right">
                            <p class="text-blue-100 text-sm">Appelé à</p>
                            <p class="text-xl font-semibold">{{ $current->called_at->format('H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <form method="POST" action="{{ route('agent.serve', $current) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-3 px-4 rounded-xl bg-white text-primary font-semibold hover:bg-gray-50 transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Marquer servi
                            </button>
                        </form>
                        <form method="POST" action="{{ route('agent.missed', $current) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-3 px-4 rounded-xl bg-white/20 text-white font-semibold hover:bg-white/30 transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Absent
                            </button>
                        </form>
                        <form method="POST" action="{{ route('agent.recall', $current) }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full py-3 px-4 rounded-xl bg-white/20 text-white font-semibold hover:bg-white/30 transition flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                Rappeler
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl card-shadow p-8 text-center">
                    <p class="text-gray-500 mb-6">Aucun ticket en cours d'appel</p>
                    <form method="POST" action="{{ route('agent.call', $queue) }}" class="max-w-xs mx-auto">
                        @csrf
                        <button type="submit" class="w-full py-4 px-6 rounded-xl gradient-primary text-white font-semibold text-lg hover:opacity-90 transition transform hover:scale-[1.02] flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            Appeler le suivant
                        </button>
                    </form>
                </div>
            @endif

            @if($waiting->count() > 0)
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-text flex items-center gap-2">
                            <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tickets en attente ({{ $waiting->count() }})
                        </h3>
                    </div>
                    <div class="space-y-2 max-h-96 overflow-y-auto">
                        @foreach($waiting as $ticket)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-4">
                                    <span class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-sm font-bold text-gray-600">
                                        {{ $loop->iteration }}
                                    </span>
                                    <span class="text-xl font-bold text-text">{{ $ticket->number }}</span>
                                    <span class="text-gray-500 text-sm">{{ $ticket->client_name ?? 'Anonyme' }}</span>
                                </div>
                                <span class="text-sm text-gray-400">{{ $ticket->created_at->format('H:i') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl card-shadow p-6">
                <h3 class="text-lg font-semibold text-text mb-4">Statistiques</h3>
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-gray-500 text-sm">En attente</p>
                        <p class="text-3xl font-bold text-text">{{ $waiting->count() }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-gray-500 text-sm">En appel</p>
                        <p class="text-3xl font-bold text-text">{{ $called->count() }}</p>
                    </div>
                    <div class="p-4 bg-gray-50 rounded-xl">
                        <p class="text-gray-500 text-sm">Temps moyen</p>
                        <p class="text-3xl font-bold text-text">{{ $queue->estimated_service_time }} min</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function agentQueue() {
        return {
            init() {
                setInterval(() => {
                    window.location.reload();
                }, 10000);
            }
        }
    }
</script>
@endpush
@endsection
