@extends('layouts.super-admin')

@section('title', 'Super Admin - Utilisateurs')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Gestion des Utilisateurs</h1>
            <p class="text-gray-500 mt-1">{{ $users->total() }} utilisateurs sur la plateforme</p>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-gray-800 rounded-xl p-4 card-shadow border border-gray-700">
        <form method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" placeholder="Rechercher par nom ou email..." value="{{ request('search') }}"
                    class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 text-white placeholder-gray-400">
            </div>
            <select name="role" class="px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 text-white">
                <option value="">Tous les rôles</option>
                <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                <option value="company_admin" {{ request('role') === 'company_admin' ? 'selected' : '' }}>Admin Entreprise</option>
                <option value="agent" {{ request('role') === 'agent' ? 'selected' : '' }}>Agent</option>
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
                    <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Utilisateur</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Rôle Global</th>
                    <th class="px-6 py-4 text-left text-sm font-medium text-gray-300">Entreprises</th>
                    <th class="px-6 py-4 text-center text-sm font-medium text-gray-300">Entreprise actuelle</th>
                    <th class="px-6 py-4 text-right text-sm font-medium text-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($users as $user)
                <tr class="hover:bg-gray-700/50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-gray-600 rounded-full flex items-center justify-center">
                                <span class="text-gray-300 font-bold">{{ substr($user->name, 0, 2) }}</span>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium text-white">{{ $user->name }}</p>
                                <p class="text-sm text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($user->global_role === 'super_admin') bg-red-500/20 text-red-400
                            @else bg-gray-600/20 text-gray-400 @endif">
                            {{ $user->global_role }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-sm font-medium">
                            {{ $user->companies_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($user->currentCompany)
                            <span class="text-sm text-white">{{ $user->currentCompany->name }}</span>
                        @else
                            <span class="text-sm text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            @if($user->global_role !== 'super_admin')
                            <form action="{{ route('super_admin.users.make-super-admin', $user) }}" method="POST" class="inline" onsubmit="return confirm('Promouvoir cet utilisateur en Super Admin ?')">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-purple-500/20 text-purple-400 rounded-lg hover:bg-purple-500/30 transition text-sm" title="Promouvoir Super Admin">
                                    Promouvoir
                                </button>
                            </form>
                            @else
                                <span class="px-3 py-1 bg-red-500/20 text-red-400 rounded-lg text-sm">Super Admin</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                        Aucun utilisateur trouvé
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $users->links() }}
    </div>
</div>
@endsection
