@extends('layouts.app')

@section('title', 'Affichage Public - ' . $queue->name)

@section('content')
<div class="min-h-screen py-12 animate-fade-in" x-data="publicDisplay()" x-init="init()">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-text mb-2">{{ $queue->name }}</h1>
            <p class="text-gray-500 text-lg">Suivi en temps réel des tickets</p>
        </div>

        @if($current)
            <div class="mb-12">
                <div class="bg-gradient-to-r from-primary to-blue-600 rounded-3xl p-8 md:p-12 text-white text-center card-shadow animate-pulse-slow">
                    <p class="text-blue-100 text-xl font-medium mb-4">TICKET EN APPEL</p>
                    <div class="text-9xl md:text-[12rem] font-bold font-display tracking-tight mb-4">{{ $current->number }}</div>
                    <div class="flex items-center justify-center gap-4 text-lg">
                        <span class="px-4 py-2 rounded-full bg-white/20">Guichet: {{ $current->agent->name ?? 'Agent' }}</span>
                        <span class="px-4 py-2 rounded-full bg-white/20">Appelé à {{ $current->called_at->format('H:i') }}</span>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h2 class="text-xl font-semibold text-text mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Prochains tickets
                    </h2>
                    <div class="space-y-3">
                        @forelse($waiting->take(10) as $ticket)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-4">
                                    <span class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-bold">
                                        {{ $loop->iteration }}
                                    </span>
                                    <span class="text-2xl font-bold text-text">{{ $ticket->number }}</span>
                                </div>
                                <span class="text-gray-500">
                                    {{ $ticket->client_name ?? 'Client anonyme' }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                Aucun ticket en attente
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-2xl card-shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold text-text mb-4">Statistiques</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                            <span class="text-gray-500">En attente</span>
                            <span class="font-bold text-2xl text-text">{{ $waiting->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-xl">
                            <span class="text-gray-500">Estimation</span>
                            <span class="font-bold text-lg text-primary">{{ $queue->estimated_service_time }} min/ticket</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h3 class="text-lg font-semibold text-text mb-4">Heure actuelle</h3>
                    <div class="text-4xl font-bold text-center text-text font-display" id="clock">--:--</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function publicDisplay() {
        return {
            init() {
                this.updateClock();
                setInterval(() => this.updateClock(), 1000);
            },
            updateClock() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit' });
                const clockEl = document.getElementById('clock');
                if (clockEl) clockEl.textContent = timeString;
            }
        }
    }
</script>
@endpush
@endsection
