@extends('layouts.app')

@section('title', 'Agents - SmartQueue AI')

@section('content')
<div class="space-y-8 animate-fade-in">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-text mb-2">Agents</h1>
            <p class="text-gray-500">Gérez les agents du système</p>
        </div>
        <a href="{{ route('admin.agents.create') }}" class="py-3 px-6 rounded-xl gradient-primary text-white font-medium hover:opacity-90 transition inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            Nouvel agent
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($agents as $agent)
            <div class="bg-white rounded-2xl card-shadow p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full gradient-primary flex items-center justify-center text-white text-xl font-bold">
                            {{ substr($agent->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-text text-lg">{{ $agent->name }}</p>
                            <p class="text-sm text-gray-500">{{ $agent->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-3 pt-4 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-sm">Tickets servis (total)</span>
                        <span class="font-semibold text-text">{{ $agent->tickets()->where('status', 'served')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-sm">Servis aujourd'hui</span>
                        <span class="font-semibold text-success">{{ $agent->tickets()->where('status', 'served')->whereDate('served_at', today())->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-sm">En appel</span>
                        <span class="font-semibold text-primary">{{ $agent->tickets()->where('status', 'called')->count() }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400">Membre depuis {{ $agent->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-2xl card-shadow">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <p class="text-gray-500 mb-4">Aucun agent créé</p>
                <a href="{{ route('admin.agents.create') }}" class="text-primary hover:underline font-medium">Ajouter un agent</a>
            </div>
        @endforelse
    </div>
</div>
@endsection
