@extends('layouts.app')

@section('title', 'Nouvelle File - SmartQueue AI')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('admin.queues') }}" class="text-gray-500 hover:text-primary transition text-sm inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux files
        </a>
    </div>

    <div class="bg-white rounded-2xl card-shadow p-8">
        <h1 class="text-2xl font-bold text-text mb-6">Créer une nouvelle file d'attente</h1>

        <form method="POST" action="{{ route('admin.queues.store') }}" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom de la file</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition"
                    placeholder="Ex: Accueil Principal">
                @error('name')
                    <p class="mt-2 text-sm text-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition"
                    placeholder="Description de la file d'attente...">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="prefix" class="block text-sm font-medium text-gray-700 mb-2">Préfixe</label>
                    <input type="text" id="prefix" name="prefix" value="{{ old('prefix', 'A') }}" required maxlength="5"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-center font-bold">
                    @error('prefix')
                        <p class="mt-2 text-sm text-error">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="estimated_service_time" class="block text-sm font-medium text-gray-700 mb-2">Temps moyen (min)</label>
                    <input type="number" id="estimated_service_time" name="estimated_service_time" value="{{ old('estimated_service_time', 5) }}" required min="1"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">
                </div>
            </div>

            <div>
                <label for="missed_timeout" class="block text-sm font-medium text-gray-700 mb-2">Délai d'absence (minutes)</label>
                <input type="number" id="missed_timeout" name="missed_timeout" value="{{ old('missed_timeout', 3) }}" required min="1"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">
                <p class="mt-2 text-sm text-gray-500">Temps avant qu'un ticket appelé soit marqué comme absent</p>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="{{ route('admin.queues') }}" class="flex-1 py-3 px-4 rounded-xl border-2 border-gray-200 text-gray-600 font-medium text-center hover:border-gray-300 transition">
                    Annuler
                </a>
                <button type="submit" class="flex-1 py-3 px-4 rounded-xl gradient-primary text-white font-medium hover:opacity-90 transition">
                    Créer la file
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
