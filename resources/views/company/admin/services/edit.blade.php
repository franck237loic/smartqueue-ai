@extends('layouts.company-admin')

@section('title', 'Modifier Service')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('company.admin.services', $company) }}" class="text-dark-600 hover:text-white flex items-center gap-2 text-sm mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux services
        </a>
        <h2 class="text-2xl font-bold text-white">Modifier le Service</h2>
        <p class="text-dark-600 mt-1">{{ $service->name }}</p>
    </div>

    <!-- Form -->
    <div class="bg-dark-800 rounded-xl card-shadow p-6">
        <form action="{{ route('company.admin.services.update', [$company, $service]) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-dark-600 mb-2">Nom du service *</label>
                <input type="text" name="name" value="{{ old('name', $service->name) }}" required
                    class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                @error('name')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Préfixe *</label>
                    <input type="text" name="prefix" value="{{ old('prefix', $service->prefix) }}" required maxlength="10"
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    @error('prefix')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Temps estimé (min) *</label>
                    <input type="number" name="estimated_service_time" value="{{ old('estimated_service_time', $service->estimated_service_time) }}" required min="1"
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-dark-600 mb-2">Description</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Timeout absence (min) *</label>
                    <input type="number" name="missed_timeout" value="{{ old('missed_timeout', $service->missed_timeout) }}" required min="1"
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Statut *</label>
                    <select name="status" required
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                        <option value="active" {{ $service->status === 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="inactive" {{ $service->status === 'inactive' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="{{ route('company.admin.services', $company) }}" class="flex-1 px-4 py-3 border border-dark-700 text-dark-600 rounded-lg hover:bg-dark-700/50 text-center transition">
                    Annuler
                </a>
                <button type="submit" class="flex-1 px-4 py-3 bg-brand-600 text-white rounded-lg hover:bg-brand-700 font-medium transition">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
