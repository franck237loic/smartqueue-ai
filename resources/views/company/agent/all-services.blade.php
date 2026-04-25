@extends('layouts.modern-sidebar')

@section('title', 'Tous les services - ' . $company->name)

@section('content')
<div class="min-h-screen bg-slate-100">
    <!-- Header -->
    <div class="bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-xl font-bold">Tous les services</h1>
                    <p class="text-slate-400 text-sm">{{ $company->name }}</p>
                </div>
                <a href="{{ route('company.agent.dashboard', $company) }}" class="text-slate-400 hover:text-white">
                    ← Retour
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($services as $service)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <h2 class="text-white font-semibold text-lg">{{ $service->name }}</h2>
                        <p class="text-blue-100 text-sm mt-1">{{ $service->description ?? 'Service de ' . $service->name }}</p>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-slate-600">Guichets assignés</span>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                    {{ $service->counters->count() }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-slate-600">Statut</span>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    Actif
                                </span>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            @if($service->counters->isNotEmpty())
                                @foreach($service->counters as $counter)
                                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                        <div>
                                            <span class="font-medium">{{ $counter->name }}</span>
                                            <span class="text-sm text-slate-500">{{ $counter->location ?? 'Non spécifié' }}</span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                {{ $counter->status == 'open' ? 'bg-green-100 text-green-800' : 
                                                 $counter->status == 'closed' ? 'bg-red-100 text-red-800' : 
                                                 $counter->status == 'paused' ? 'bg-yellow-100 text-yellow-800' : 
                                                 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst($counter->status) }}
                                            </span>
                                            @if($counter->user)
                                                <span class="text-sm text-slate-600">{{ $counter->user->name }}</span>
                                            @else
                                                <span class="text-sm text-slate-400">Non assigné</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8 text-slate-500">
                                    Aucun guichet assigné à ce service
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-slate-200">
                            <div class="flex justify-between">
                                <a href="{{ route('company.agent.service', [$company, $service]) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                    <i class="w-4 h-4 mr-2" data-lucide="eye"></i>
                                    Voir le service
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                        <i class="w-16 h-16 mx-auto mb-4 text-slate-400" data-lucide="inbox"></i>
                        <h3 class="text-lg font-medium text-slate-900 mb-2">Aucun service disponible</h3>
                        <p class="text-slate-600">Vous n'avez accès à aucun service pour le moment.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons for this page
    try {
        if (window.lucide && window.lucide.createIcons) {
            window.lucide.createIcons({ icons: window.lucide.icons });
        }
    } catch (error) {
        console.log('Lucide icons initialization skipped:', error.message);
    }
</script>
@endsection
