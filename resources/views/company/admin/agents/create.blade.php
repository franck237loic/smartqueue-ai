@extends('layouts.company-admin')

@section('title', 'Nouvel Agent')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('company.admin.agents', $company) }}" class="text-dark-600 hover:text-white flex items-center gap-2 text-sm mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux agents
        </a>
        <h2 class="text-2xl font-bold text-white">Nouvel Agent</h2>
        <p class="text-dark-600 mt-1">Créez un nouvel agent pour votre entreprise</p>
    </div>

    <!-- Form -->
    <div class="bg-dark-800 rounded-xl card-shadow p-6">
        <form action="{{ route('company.admin.agents.store', $company) }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Nom complet *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    @error('name')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    @error('email')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Mot de passe *</label>
                    <input type="password" name="password" required minlength="8"
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    @error('password')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Rôle *</label>
                    <select name="role" required
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                        <option value="agent" {{ old('role') == 'agent' ? 'selected' : '' }}>Agent</option>
                        <option value="company_admin" {{ old('role') == 'company_admin' ? 'selected' : '' }}>Admin entreprise</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-dark-600 mb-2">Assigner à un guichet</label>
                <select name="counter_id"
                    class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    <option value="">-- Non assigné --</option>
                    @foreach($counters as $counter)
                        <option value="{{ $counter->id }}" {{ old('counter_id') == $counter->id ? 'selected' : '' }}>
                            {{ $counter->name }} @if($counter->service) ({{ $counter->service->name }}) @endif
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-dark-600">L'agent ne pourra voir que les tickets de son service</p>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="{{ route('company.admin.agents', $company) }}" class="flex-1 px-4 py-3 border border-dark-700 text-dark-600 rounded-lg hover:bg-dark-700/50 text-center transition">
                    Annuler
                </a>
                <button type="submit" class="flex-1 px-4 py-3 bg-brand-600 text-white rounded-lg hover:bg-brand-700 font-medium transition">
                    Créer l'agent
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
