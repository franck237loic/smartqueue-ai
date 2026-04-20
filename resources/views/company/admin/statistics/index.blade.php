@extends('layouts.company-admin')

@section('title', 'Statistiques - ' . $company->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-white">Statistiques</h2>
        <p class="text-dark-600 mt-1">Performance de l'entreprise</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-dark-800 rounded-xl p-6 card-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-brand-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-dark-600">Total Tickets</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['total_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-dark-800 rounded-xl p-6 card-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-dark-600">Servis</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['served_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-dark-800 rounded-xl p-6 card-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-dark-600">Absents</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['missed_tickets'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-dark-800 rounded-xl p-6 card-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-orange-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-dark-600">Temps moyen d'attente</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['avg_wait_time'] ? round($stats['avg_wait_time']) : 0 }} min</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Summary -->
    <div class="bg-dark-800 rounded-xl card-shadow p-6">
        <h3 class="text-lg font-bold text-white mb-4">Performance</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center p-4 bg-dark-900 rounded-xl">
                <p class="text-sm text-dark-600 mb-1">Taux de service</p>
                <p class="text-3xl font-bold text-green-400">
                    @if($stats['total_tickets'] > 0)
                        {{ round(($stats['served_tickets'] / $stats['total_tickets']) * 100) }}%
                    @else
                        0%
                    @endif
                </p>
            </div>
            <div class="text-center p-4 bg-dark-900 rounded-xl">
                <p class="text-sm text-dark-600 mb-1">Taux d'absence</p>
                <p class="text-3xl font-bold text-red-400">
                    @if($stats['total_tickets'] > 0)
                        {{ round(($stats['missed_tickets'] / $stats['total_tickets']) * 100) }}%
                    @else
                        0%
                    @endif
                </p>
            </div>
            <div class="text-center p-4 bg-dark-900 rounded-xl">
                <p class="text-sm text-dark-600 mb-1">Temps moyen de service</p>
                <p class="text-3xl font-bold text-brand-500">{{ $stats['avg_service_time'] ? round($stats['avg_service_time']) : 0 }} min</p>
            </div>
        </div>
    </div>
</div>
@endsection
