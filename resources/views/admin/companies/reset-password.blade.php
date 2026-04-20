@extends('layouts.app')

@section('title', 'Réinitialiser Mot de Passe - ' . $company->name)

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="bg-white shadow-xl rounded-lg">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Réinitialiser Mot de Passe</h2>
                        <p class="text-blue-100 text-sm">Entreprise: {{ $company->name }}</p>
                    </div>
                    <div class="text-white">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 012 8.945V14a2 2 0 01-2 2h-2a2 2 0 01-2-2v-1.055A6 6 0 0112 3m0 0a6 6 0 016 8.945V14a2 2 0 01-2 2h-2a2 2 0 01-2-2v-1.055A6 6 0 0115 7m-6 3a2 2 0 002 2h2a2 2 0 002-2m-2-8a2 2 0 00-2 2H9a2 2 0 00-2 2v8a2 2 0 002 2h2a2 2 0 002-2V9z"/>
                        </svg>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 m-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414l2-2z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            {!! session('success') !!}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 m-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            {{ session('error') }}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <div class="p-6">
                <!-- Formulaire Manuel -->
                <form method="POST" action="{{ route('admin.companies.reset-password.post', $company) }}" class="space-y-6">
                    @csrf
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-blue-900 mb-4">🔐 Réinitialisation Manuelle</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Sélectionner l'utilisateur
                                </label>
                                <select name="user_id" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Choisir un utilisateur...</option>
                                    @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}">
                                        {{ $admin->name }} ({{ $admin->email }}) - {{ $admin->pivot->role }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nouveau mot de passe
                                </label>
                                <input type="password" name="new_password" required minlength="8"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Entrez le nouveau mot de passe">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirmer le mot de passe
                                </label>
                                <input type="password" name="new_password_confirmation" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Confirmez le nouveau mot de passe">
                            </div>
                        </div>
                        
                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 font-medium">
                            🔄 Réinitialiser le mot de passe
                        </button>
                    </div>
                </form>

                <!-- Séparateur -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">OU</span>
                    </div>
                </div>

                <!-- Formulaire Automatique -->
                <form method="POST" action="{{ route('admin.companies.auto-reset-password', $company) }}" class="space-y-4">
                    @csrf
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-green-900 mb-4">🎲 Génération Automatique</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Sélectionner l'utilisateur
                                </label>
                                <select name="user_id" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500">
                                    <option value="">Choisir un utilisateur...</option>
                                    @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}">
                                        {{ $admin->name }} ({{ $admin->email }}) - {{ $admin->pivot->role }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="bg-yellow-50 border border-yellow-200 rounded p-3">
                                <p class="text-sm text-yellow-800">
                                    ⚠️ <strong>Attention:</strong> Un mot de passe sécurisé sera généré automatiquement et affiché dans le message de succès.
                                </p>
                            </div>
                            
                            <button type="submit" 
                                    class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 font-medium">
                                🎯 Générer un mot de passe sécurisé
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Actions -->
                <div class="mt-6 flex justify-between">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                        ← Retour au Dashboard
                    </a>
                    
                    <div class="text-sm text-gray-500">
                        Entreprise: {{ $company->name }} ({{ $admins->count() }} utilisateur(s))
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
