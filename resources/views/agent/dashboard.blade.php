
<script>
if (typeof window.tailwind === 'undefined') {
    window.tailwind = { colors: { blue: { 500: '#3b82f6' }, white: '#ffffff', gray: { 500: '#6b7280' } } };
}
</script>
@extends('layouts.app')

@section('title', 'Espace Agent - SmartQueue AI')

@section('content')
<div class="space-y-8 animate-fade-in">
    <div>
        <h1 class="text-3xl font-bold text-text mb-2">Espace Agent</h1>
        <p class="text-gray-500">Gérez les files d'attente et servez les clients</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($queues as $queue)
            <div class="bg-white rounded-2xl card-shadow card-hover p-6 transition duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                        <span class="text-xl font-bold text-primary">{{ $queue->prefix }}</span>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $queue->isActive() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $queue->isActive() ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                <h3 class="text-lg font-semibold text-text mb-2">{{ $queue->name }}</h3>
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ $queue->waitingTickets()->count() }} en attente
                    </span>
                </div>
                @if($queue->isActive())
                    <a href="{{ route('agent.queue', $queue) }}" class="block w-full py-3 px-4 rounded-xl gradient-primary text-white font-medium text-center hover:opacity-90 transition transform hover:scale-[1.02]">
                        Ouvrir la file
                    </a>
                @else
                    <button disabled class="w-full py-3 px-4 rounded-xl bg-gray-100 text-gray-400 font-medium cursor-not-allowed">
                        File inactive
                    </button>
                @endif
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-2xl card-shadow">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-gray-500">Aucune file d'attente disponible</p>
            </div>
        @endforelse
    </div>

    @if($myTickets->count() > 0)
        <div>
            <h2 class="text-xl font-semibold text-text mb-6">Mes tickets récents</h2>
            <div class="bg-white rounded-2xl card-shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Heure d'appel</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($myTickets as $ticket)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-semibold text-text">{{ $ticket->number }}</td>
                                    <td class="px-6 py-4 text-gray-600">{{ $ticket->queue->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $ticket->isCalled() ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $ticket->isCalled() ? 'En appel' : 'Servi' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">{{ $ticket->called_at?->format('H:i') ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
