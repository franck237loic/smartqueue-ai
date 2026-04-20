@extends('layouts.super-admin')

@section('title', 'Super Admin - ' . $company->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('super_admin.companies') }}" class="p-2 bg-gray-700 rounded-lg hover:bg-gray-600 transition">
                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-white">{{ $company->name }}</h1>
                <p class="text-gray-500">{{ $company->email }} • {{ $company->phone }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('super_admin.companies.edit', $company) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Modifier
            </a>
        </div>
    </div>

    <!-- Statut -->
    <div class="flex items-center gap-4">
        <span class="px-4 py-2 rounded-full text-sm font-medium
            @if($company->status === 'active') bg-green-500/20 text-green-400
            @elseif($company->status === 'suspended') bg-yellow-500/20 text-yellow-400
            @else bg-gray-600/20 text-gray-400 @endif">
            {{ ucfirst($company->status) }}
        </span>
        <span class="text-gray-500 text-sm">Créée le {{ $company->created_at->format('d/m/Y') }}</span>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gray-800 rounded-xl p-6 card-shadow border border-gray-700">
            <p class="text-sm text-gray-500 mb-1">Total Tickets</p>
            <p class="text-3xl font-bold text-white">{{ $stats['global']['total'] }}</p>
        </div>
        <div class="bg-gray-800 rounded-xl p-6 card-shadow border border-gray-700">
            <p class="text-sm text-gray-500 mb-1">En Attente</p>
            <p class="text-3xl font-bold text-yellow-400">{{ $stats['global']['waiting'] }}</p>
        </div>
        <div class="bg-gray-800 rounded-xl p-6 card-shadow border border-gray-700">
            <p class="text-sm text-gray-500 mb-1">Servis</p>
            <p class="text-3xl font-bold text-green-400">{{ $stats['global']['served'] }}</p>
        </div>
        <div class="bg-gray-800 rounded-xl p-6 card-shadow border border-gray-700">
            <p class="text-sm text-gray-500 mb-1">Taux Absence</p>
            <p class="text-3xl font-bold text-red-400">{{ $stats['global']['missed_rate'] }}%</p>
        </div>
    </div>

    <!-- Performance & Agents -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gray-800 rounded-xl p-6 card-shadow border border-gray-700">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2 text-white">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Performance
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Temps moyen d'attente</span>
                    <span class="font-bold text-lg text-white">{{ $stats['performance']['avg_wait_time'] }} min</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Temps moyen de service</span>
                    <span class="font-bold text-lg text-white">{{ $stats['performance']['avg_service_time'] }} min</span>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 rounded-xl p-6 card-shadow border border-gray-700">
            <h3 class="text-lg font-bold mb-4 flex items-center gap-2 text-white">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Agents & Services
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-400">Agents total</span>
                    <span class="font-semibold text-white">{{ $stats['agents']['total_agents'] }}</span>
                </div>
                @if($stats['agents']['top_agent'])
                <div class="flex justify-between">
                    <span class="text-gray-400">Agent le plus actif</span>
                    <span class="font-semibold text-white">{{ $stats['agents']['top_agent']['name'] }} ({{ $stats['agents']['top_agent']['tickets'] }} tickets)</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-400">Services</span>
                    <span class="font-semibold text-white">{{ $stats['services']['total_services'] }}</span>
                </div>
                @if($stats['services']['top_service'])
                <div class="flex justify-between">
                    <span class="text-gray-400">Service le plus utilisé</span>
                    <span class="font-semibold text-white">{{ $stats['services']['top_service']['name'] }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Graphique Tickets -->
    <div class="bg-gray-800 rounded-xl p-6 card-shadow border border-gray-700">
        <h3 class="text-lg font-bold mb-4 text-white">Activité des Tickets (7 derniers jours)</h3>
        <canvas id="ticketsChart" height="100"></canvas>
    </div>

    <!-- Activité Récente -->
    <div class="bg-gray-800 rounded-xl card-shadow overflow-hidden border border-gray-700">
        <div class="p-6 border-b border-gray-600">
            <h3 class="text-lg font-bold flex items-center gap-2 text-white">
                <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Activité Récente
            </h3>
        </div>
        <div class="divide-y divide-gray-700 max-h-96 overflow-y-auto">
            @forelse($stats['recent_activity'] as $activity)
            <div class="p-4 flex items-center justify-between hover:bg-gray-700/50">
                <div class="flex items-center gap-3">
                    <span class="px-2 py-1 rounded text-xs font-medium
                        @if($activity['action'] === 'Créé') bg-blue-500/20 text-blue-400
                        @elseif($activity['action'] === 'Appelé') bg-yellow-500/20 text-yellow-400
                        @elseif($activity['action'] === 'Servi') bg-green-500/20 text-green-400
                        @elseif($activity['action'] === 'Annulé') bg-red-500/20 text-red-400
                        @else bg-gray-600/20 text-gray-400 @endif">
                        {{ $activity['action'] }}
                    </span>
                    <span class="text-white">{{ $activity['description'] }}</span>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">{{ $activity['user'] }}</p>
                    <p class="text-xs text-gray-400">{{ $activity['date']->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                Aucune activité récente
            </div>
            @endforelse
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ticketsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($stats['tickets_by_day']['labels']),
            datasets: [{
                label: 'Tickets créés',
                data: @json($stats['tickets_by_day']['data']),
                borderColor: '#2563EB',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endsection
