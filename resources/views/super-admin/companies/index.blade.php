@extends('layouts.super-admin')

@section('title', 'Super Admin - Entreprises')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Gestion des Entreprises</h1>
            <p class="text-gray-500 mt-1">{{ $companies->total() }} entreprises sur la plateforme</p>
        </div>
        <a href="{{ route('super_admin.companies.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nouvelle entreprise
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-gray-800 rounded-xl p-4 card-shadow border border-gray-700">
        <form method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" placeholder="Rechercher une entreprise..." value="{{ request('search') }}"
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-white placeholder-gray-400">
            </div>
            <select name="status" class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 text-white">
                <option value="">Tous les statuts</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspendue</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-700 text-gray-300 rounded-lg hover:bg-gray-600 transition">
                Filtrer
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-gray-800 rounded-xl card-shadow overflow-hidden border border-gray-700">
        <table class="w-full">
            <thead class="bg-gray-700 border-b border-gray-600">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Entreprise</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Contact</th>
                    <th class="px-6 py-4 text-center text-sm font-medium text-gray-300">Utilisateurs</th>
                    <th class="px-6 py-4 text-center text-sm font-medium text-gray-300">Services</th>
                    <th class="px-6 py-4 text-center text-sm font-medium text-gray-300">Guichets</th>
                    <th class="px-6 py-4 text-center text-sm font-medium text-gray-300">Statut</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($companies as $company)
                <tr class="hover:bg-gray-700/50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <span class="text-blue-400 font-bold">{{ substr($company->name, 0, 2) }}</span>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-white">{{ $company->name }}</p>
                                <p class="text-sm text-gray-400">{{ $company->slug }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-sm text-white">{{ $company->email }}</p>
                        <p class="text-sm text-gray-400">{{ $company->phone }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-sm font-medium">
                            {{ $company->users_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-full text-sm font-medium">
                            {{ $company->services_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-sm font-medium">
                            {{ $company->counters_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($company->status === 'active') bg-green-500/20 text-green-400
                            @elseif($company->status === 'suspended') bg-yellow-500/20 text-yellow-400
                            @else bg-gray-600/20 text-gray-400 @endif">
                            {{ $company->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('super_admin.companies.show', $company) }}" class="p-2 text-green-400 hover:bg-green-500/20 rounded-lg transition" title="Voir détails">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('super_admin.companies.edit', $company) }}" class="p-2 text-blue-400 hover:bg-blue-500/20 rounded-lg transition" title="Modifier">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('super_admin.companies.destroy', $company) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette entreprise ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-red-400 hover:bg-red-500/20 rounded-lg transition" title="Supprimer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                        Aucune entreprise trouvée
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $companies->links() }}
    </div>
</div>
@endsection
