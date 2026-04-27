@extends('layouts.app')

@section('title', 'Administration - SmartQueue AI')

@section('content')
<div class="space-y-8 animate-fade-in">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-text mb-1 sm:mb-2">Tableau de bord</h1>
            <p class="text-gray-500 text-sm sm:text-base">Vue d'ensemble du système</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
            <a href="{{ route('admin.queues.create') }}" class="py-2 px-3 sm:px-4 rounded-xl gradient-primary text-white font-medium hover:opacity-90 transition inline-flex items-center gap-2 text-sm sm:text-base">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="hidden sm:inline">Nouvelle file</span>
                <span class="sm:hidden">File</span>
            </a>
            <a href="{{ route('admin.agents.create') }}" class="py-2 px-3 sm:px-4 rounded-xl border-2 border-primary text-primary font-medium hover:bg-primary/5 transition inline-flex items-center gap-2 text-sm sm:text-base">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span class="hidden sm:inline">Nouvel agent</span>
                <span class="sm:hidden">Agent</span>
            </a>
            <a href="/admin/companies" class="py-2 px-3 sm:px-4 rounded-xl bg-amber-500 text-white font-medium hover:bg-amber-600 transition inline-flex items-center gap-2 text-sm sm:text-base">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span class="hidden sm:inline">Entreprises</span>
                <span class="sm:hidden">Entrep.</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <div class="bg-white rounded-2xl card-shadow p-4 sm:p-6">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <span class="text-xl sm:text-2xl font-bold text-text">{{ $stats['total_queues'] }}</span>
            </div>
            <p class="text-gray-500 text-xs sm:text-sm">Files totales</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-4 sm:p-6">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <span class="text-xl sm:text-2xl font-bold text-text">{{ $stats['served_today'] }}</span>
            </div>
            <p class="text-gray-500 text-xs sm:text-sm">Servis aujourd'hui</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-4 sm:p-6">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xl sm:text-2xl font-bold text-text">{{ $stats['waiting_now'] }}</span>
            </div>
            <p class="text-gray-500 text-xs sm:text-sm">En attente</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-4 sm:p-6">
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-xl sm:text-2xl font-bold text-text">{{ round($stats['avg_wait_time']) }} min</span>
            </div>
            <p class="text-gray-500 text-xs sm:text-sm">Attente moyenne</p>
        </div>
    </div>

    <div>
        <h2 class="text-xl font-semibold text-text mb-6">Files d'attente</h2>
        <div class="bg-white rounded-2xl card-shadow overflow-hidden">
            <!-- Mobile View: Cards -->
            <div class="sm:hidden">
                <div class="p-4 space-y-3">
                    @forelse($queues as $queue)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="font-semibold text-text">{{ $queue->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $queue->description }}</p>
                                </div>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    {{ $queue->isActive() ? 'bg-green-100 text-green-800' : ($queue->status === 'paused' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ $queue->status }}
                                </span>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 mb-3 text-sm">
                                <div>
                                    <span class="text-gray-500">Préfixe:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-gray-100 font-medium text-gray-800 ml-1">
                                        {{ $queue->prefix }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-500">En attente:</span>
                                    <span class="font-semibold text-text ml-1">{{ $queue->waitingTickets()->count() }}</span>
                                </div>
                            </div>
                            
                            <div class="text-sm text-gray-500 mb-3">
                                Servis (24h): {{ $queue->servedTickets()->whereDate('served_at', today())->count() }}
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.queues.edit', $queue) }}" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-primary transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('admin.statistics', $queue) }}" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-primary transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('admin.queues.destroy', $queue) }}" class="inline" onsubmit="return confirm('Supprimer cette file ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg hover:bg-red-50 text-gray-500 hover:text-error transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            Aucune file d'attente créée
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Desktop View: Table -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Préfixe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">En attente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servis (24h)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($queues as $queue)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-text">{{ $queue->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $queue->description }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-gray-100 text-sm font-medium text-gray-800">
                                        {{ $queue->prefix }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $queue->isActive() ? 'bg-green-100 text-green-800' : ($queue->status === 'paused' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $queue->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-text">{{ $queue->waitingTickets()->count() }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $queue->servedTickets()->whereDate('served_at', today())->count() }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.queues.edit', $queue) }}" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-primary transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.statistics', $queue) }}" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-primary transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                            </svg>
                                        </a>
                                        <form method="POST" action="{{ route('admin.queues.destroy', $queue) }}" class="inline" onsubmit="return confirm('Supprimer cette file ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg hover:bg-red-50 text-gray-500 hover:text-error transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    Aucune file d'attente créée
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($agents->count() > 0)
        <div class="mt-8">
            <h2 class="text-lg sm:text-xl font-semibold text-text mb-4 sm:mb-6">Agents</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                @foreach($agents as $agent)
                    <div class="bg-white rounded-2xl card-shadow p-4 sm:p-6">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary/10 flex items-center justify-center">
                                <span class="text-base sm:text-lg font-bold text-primary">{{ substr($agent->name, 0, 1) }}</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-text text-sm sm:text-base truncate">{{ $agent->name }}</p>
                                <p class="text-xs sm:text-sm text-gray-500 truncate">{{ $agent->email }}</p>
                            </div>
                        </div>
                        <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100 flex justify-between text-xs sm:text-sm">
                            <span class="text-gray-500">Tickets servis</span>
                            <span class="font-semibold text-text">{{ $agent->tickets()->where('status', 'served')->count() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
