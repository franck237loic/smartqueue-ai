<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#667eea">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <title>Dashboard Agent - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Laravel Echo & Pusher -->
    @if(config('services.pusher.key'))
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="{{ asset('js/smartqueue-echo.js') }}"></script>
    @endif
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --transition-fast: 0.3s ease-out;
            --transition-medium: 0.5s;
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        @keyframes slideIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .card-animate { animation: slideIn var(--transition-fast); }
        .pulse-animation { animation: pulse 2s infinite; }
        .shake-animation { animation: shake var(--transition-medium); }
        .gradient-bg { background: var(--primary-gradient); }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform var(--transition-fast);
        }
        
        .mobile-menu.open {
            transform: translateX(0);
        }
        
        .overlay {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease-in-out;
        }
        .overlay.show {
            opacity: 1;
            pointer-events: auto;
        }
        @media (max-width: 768px) {
            .mobile-only { display: block !important; }
            .desktop-only { display: none !important; }
            .grid-responsive { grid-template-columns: 1fr !important; }
            .text-responsive { font-size: 0.875rem !important; }
        }
        @media (min-width: 769px) {
            .mobile-only { display: none !important; }
            .desktop-only { display: block !important; }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Mobile Menu Button -->
    <button id="mobileMenuBtn" class="mobile-only fixed top-4 left-4 z-50 bg-white p-3 rounded-lg shadow-lg md:hidden">
        <i class="fas fa-bars text-gray-700"></i>
    </button>

    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="overlay fixed inset-0 bg-black/50 z-40 md:hidden"></div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="mobile-menu fixed top-0 left-0 w-64 h-full bg-white shadow-xl z-50 md:hidden">
        <div class="p-4 border-b">
            <div class="flex items-center justify-between">
                <h3 class="font-bold text-lg">{{ $company->name }}</h3>
                <button id="closeMobileMenu" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="p-4">
            <div class="space-y-2">
                <div class="text-sm text-gray-600">Connecté en tant que</div>
                <div class="font-semibold">{{ auth()->user()->name }}</div>
                <form method="POST" action="{{ route('logout.post') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="gradient-bg text-white shadow-lg relative">
        <div class="container mx-auto px-4 py-4 md:py-6">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center space-y-4 md:space-y-0">
                <div class="flex items-center space-x-3 md:space-x-4">
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-white/20 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    
                    <div class="bg-white/20 p-2 md:p-3 rounded-lg">
                        <i class="fas fa-users-cog text-lg md:text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-lg md:text-2xl font-bold">{{ $company->name }}</h1>
                        <p class="text-xs md:text-sm text-white/80">Dashboard Agent</p>
                    </div>
                </div>
                <div class="desktop-only flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-xs text-white/80">Connecté en tant que</p>
                        <p class="font-semibold text-sm">{{ auth()->user()->name }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout.post') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-white/20 hover:bg-white/30 px-3 md:px-4 py-2 rounded-lg transition-all duration-200 flex items-center space-x-2 text-sm">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="hidden md:inline">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu-overlay" class="fixed inset-0 bg-black/50 z-40 hidden md:hidden" onclick="closeMobileMenu()"></div>
    
    <!-- Mobile Menu Sidebar -->
    <div id="mobile-menu-sidebar" class="fixed top-0 left-0 h-full w-64 bg-white shadow-xl z-50 transform -translate-x-full transition-transform duration-300 md:hidden">
        <div class="p-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Menu</h2>
                <button onclick="closeMobileMenu()" class="p-2 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <nav class="space-y-2">
                <a href="{{ route('company.agent.dashboard', $company) }}" class="flex items-center gap-3 p-3 rounded-lg bg-blue-50 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('company.agent.history', $company) }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Historique</span>
                </a>
                
                <a href="{{ route('company.agent.all-services', $company) }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <span>Tous Services</span>
                </a>
                
                <div class="border-t pt-2 mt-2">
                    <div class="flex items-center gap-3 p-3">
                        <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-gray-600 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">Agent</p>
                        </div>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout.post') }}" class="pt-2">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 p-3 rounded-lg hover:bg-red-50 text-red-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-4 md:py-8">
        <!-- Performance Stats -->
        <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-purple-600"></i>
                    Performance Entreprise
                </h2>
                <button onclick="refreshPerformanceStats()" class="bg-gray-100 hover:bg-gray-200 p-2 rounded-lg transition-colors">
                    <i class="fas fa-sync-alt text-gray-600"></i>
                </button>
            </div>
            
            <div id="performanceStats" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4">
                <!-- Stats will be loaded here -->
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-green-600">-</div>
                    <div class="text-xs md:text-sm text-gray-500">Rapidité</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-blue-600">-</div>
                    <div class="text-xs md:text-sm text-gray-500">Présence</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-purple-600">-</div>
                    <div class="text-xs md:text-sm text-gray-500">Efficacité</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-orange-600">-</div>
                    <div class="text-xs md:text-sm text-gray-500">Score Global</div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6">
            <div class="card-animate bg-white rounded-xl shadow-lg p-4 md:p-6 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-xs md:text-sm">Tickets Servis</p>
                        <p class="text-xl md:text-3xl font-bold text-green-600">{{ $myTicketsToday }}</p>
                        <p class="text-xs text-gray-400 mt-1">Aujourd'hui</p>
                    </div>
                    <div class="bg-green-100 p-2 md:p-3 rounded-full ml-2">
                        <i class="fas fa-check-circle text-green-600 text-sm md:text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="card-animate bg-white rounded-xl shadow-lg p-4 md:p-6 hover:shadow-xl transition-shadow" style="animation-delay: 0.1s">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-xs md:text-sm">Tickets Manqués</p>
                        <p class="text-xl md:text-3xl font-bold text-red-600">{{ $missedTicketsToday }}</p>
                        <p class="text-xs text-gray-400 mt-1">Aujourd'hui</p>
                    </div>
                    <div class="bg-red-100 p-2 md:p-3 rounded-full ml-2">
                        <i class="fas fa-times-circle text-red-600 text-sm md:text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="card-animate bg-white rounded-xl shadow-lg p-4 md:p-6 hover:shadow-xl transition-shadow" style="animation-delay: 0.2s">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-xs md:text-sm">Temps Moyen</p>
                        <p class="text-xl md:text-3xl font-bold text-blue-600">{{ number_format($avgServiceTime, 1) }}s</p>
                        <p class="text-xs text-gray-400 mt-1">Par ticket</p>
                    </div>
                    <div class="bg-blue-100 p-2 md:p-3 rounded-full ml-2">
                        <i class="fas fa-clock text-blue-600 text-sm md:text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="card-animate bg-white rounded-xl shadow-lg p-4 md:p-6 hover:shadow-xl transition-shadow" style="animation-delay: 0.3s">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-500 text-xs md:text-sm">Taux Service</p>
                        <p class="text-xl md:text-3xl font-bold text-purple-600">{{ $serviceRateToday }}%</p>
                        <p class="text-xs text-gray-400 mt-1">Efficacité</p>
                    </div>
                    <div class="bg-purple-100 p-2 md:p-3 rounded-full ml-2">
                        <i class="fas fa-chart-line text-purple-600 text-sm md:text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Work Schedule Status Section -->
        <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-clock mr-2 text-green-600"></i>
                    Statut des Guichets
                </h2>
                <button onclick="refreshScheduleStatus()" class="bg-gray-100 hover:bg-gray-200 p-2 rounded-lg transition-colors">
                    <i class="fas fa-sync-alt text-gray-600"></i>
                </button>
            </div>
            
            <div id="scheduleStatus" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Schedule status will be loaded here -->
                <div class="text-center py-8">
                    <i class="fas fa-spinner fa-spin text-3xl text-gray-400"></i>
                    <p class="text-gray-500 mt-2">Chargement du statut...</p>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 md:gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-lg p-4 md:p-6">
                <div class="flex items-center justify-between mb-4 md:mb-6">
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-concierge-bell mr-2 text-blue-600"></i>
                        Services Actifs
                    </h2>
                    <span class="bg-blue-100 text-blue-600 px-2 md:px-3 py-1 rounded-full text-xs md:text-sm font-semibold">
                        {{ $services->count() }} services
                    </span>
                </div>
                
                <div class="space-y-3 md:space-y-4">
                    @foreach($services as $service)
                    <div class="border rounded-lg p-3 md:p-4 hover:bg-gray-50 transition-colors service-card" data-service-id="{{ $service->id }}">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-3 md:space-y-0">
                            <div class="flex items-center space-x-3">
                                <div class="bg-blue-100 p-2 rounded-lg">
                                    <i class="fas fa-door-open text-blue-600"></i>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-800 text-sm md:text-base">{{ $service->name }}</h3>
                                    <p class="text-xs md:text-sm text-gray-500">{{ $service->prefix ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between md:justify-end space-x-3">
                                <div class="bg-orange-100 text-orange-600 px-2 md:px-3 py-1 rounded-full text-xs md:text-sm font-semibold pulse-animation">
                                    {{ $service->waiting_tickets_count }} en attente
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action buttons -->
                        <div class="mt-3 md:mt-4 grid grid-cols-2 gap-2" id="service-actions-{{ $service->id }}">
                            <button onclick="callNextTicket({{ $service->id }})" class="bg-green-600 hover:bg-green-700 text-white px-3 md:px-4 py-2 rounded-lg transition-colors flex items-center justify-center space-x-2 text-sm">
                                <i class="fas fa-bell"></i>
                                <span class="hidden md:inline">Appeler</span>
                                <span class="md:hidden">Appeler</span>
                            </button>
                            <button onclick="refreshService({{ $service->id }})" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-lg transition-colors">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Current Ticket Section -->
            <div class="bg-white rounded-xl shadow-lg p-4 md:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 md:mb-6 gap-3">
                    <h2 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-ticket-alt mr-2 text-green-600"></i>
                        Ticket en Cours
                    </h2>
                </div>
                
                <div id="current-ticket-section">

                @if($currentTicket)
                <div class="border-2 border-green-500 rounded-lg p-4 md:p-6 bg-green-50">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-green-600 mb-2">{{ $currentTicket->number }}</div>
                        <p class="text-gray-600 mb-4 text-sm md:text-base">{{ $currentTicket->service->name }}</p>
                        <div class="flex flex-col md:flex-row items-center justify-center space-y-2 md:space-y-0 md:space-x-4 mb-4 md:mb-6">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $currentTicket->status }}
                            </span>
                            @if($currentTicket->guest_name)
                            <span class="text-gray-600 text-sm">
                                <i class="fas fa-user"></i> {{ $currentTicket->guest_name }}
                            </span>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-4">
                            <button onclick="markAsServed({{ $currentTicket->id }})" class="bg-green-600 hover:bg-green-700 text-white px-3 md:px-4 py-2 md:py-3 rounded-lg transition-colors flex items-center justify-center space-x-2 text-sm">
                                <i class="fas fa-check"></i>
                                <span>Servi</span>
                            </button>
                            <button onclick="markAsMissed({{ $currentTicket->id }})" class="bg-orange-600 hover:bg-orange-700 text-white px-3 md:px-4 py-2 md:py-3 rounded-lg transition-colors flex items-center justify-center space-x-2 text-sm">
                                <i class="fas fa-user-clock"></i>
                                <span>Absent</span>
                            </button>
                            <button onclick="recallTicket({{ $currentTicket->id }})" class="bg-blue-600 hover:bg-blue-700 text-white px-3 md:px-4 py-2 md:py-3 rounded-lg transition-colors flex items-center justify-center space-x-2 text-sm">
                                <i class="fas fa-bell"></i>
                                <span>Rappeler</span>
                            </button>
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-8 md:py-12 text-gray-400">
                    <i class="fas fa-inbox text-4xl md:text-6xl mb-4"></i>
                    <p class="text-base md:text-lg">Aucun ticket en cours</p>
                    <p class="text-xs md:text-sm mt-2">Appellez le prochain ticket pour commencer</p>
                </div>
                @endif
                </div>
            </div>
        </div>

        <!-- My Counters Section -->
        @if($myCounters->count() > 0)
        <div class="bg-white rounded-xl shadow-lg p-4 md:p-6">
            <div class="flex items-center justify-between mb-4 md:mb-6">
                <h2 class="text-lg md:text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-desktop mr-2 text-purple-600"></i>
                    Mes Guichets
                </h2>
                <span class="bg-purple-100 text-purple-600 px-2 md:px-3 py-1 rounded-full text-xs md:text-sm font-semibold">
                    {{ $myCounters->count() }} guichets
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($myCounters as $counter)
                <div class="border rounded-lg p-3 md:p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-semibold text-gray-800 text-sm md:text-base">{{ $counter->name }}</h3>
                        <div class="w-2 h-2 md:w-3 md:h-3 rounded-full {{ $counter->status === 'open' ? 'bg-green-500' : 'bg-red-500' }}"></div>
                    </div>
                    <p class="text-xs md:text-sm text-gray-600 mb-3">{{ $counter->service->name ?? 'Non assigné' }}</p>
                    <a href="{{ route('company.agent.counter', [$company, $counter]) }}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white text-center px-3 md:px-4 py-2 rounded-lg transition-colors text-sm">
                        Accéder au guichet
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </main>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 bg-green-600 text-white px-4 md:px-6 py-3 rounded-lg shadow-lg transform translate-y-full transition-transform duration-300 z-50 max-w-xs md:max-w-md">
        <div class="flex items-center space-x-2">
            <i class="fas fa-check-circle"></i>
            <span id="toast-message" class="text-sm">Action réussie</span>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-4 md:p-6 flex items-center space-x-3">
            <div class="animate-spin rounded-full h-5 w-5 md:h-6 md:w-6 border-b-2 border-blue-600"></div>
            <span class="text-sm md:text-base">Traitement en cours...</span>
        </div>
    </div>

    <!-- Sound Elements -->
    <audio id="ticketCalledSound" preload="auto">
        <source src="/sounds/ticket-called.mp3" type="audio/mpeg">
    </audio>
    <audio id="preparationSound" preload="auto">
        <source src="/sounds/preparation-alert.mp3" type="audio/mpeg">
    </audio>
    <audio id="absentSound" preload="auto">
        <source src="/sounds/ticket-absent.mp3" type="audio/mpeg">
    </audio>

    <script>
        // WebSocket/Pusher connection - Fallback to polling if not configured
        let echoInstance = null;
        let isWebSocketConnected = false;

        function initializeRealtimeConnection() {
            // Check if Pusher is configured
            const pusherKey = '{{ config('services.pusher.key') }}';
            
            if (pusherKey && pusherKey !== '') {
                // Use Laravel Echo with Pusher
                try {
                    echoInstance = new Echo({
                        broadcaster: 'pusher',
                        key: pusherKey,
                        cluster: '{{ config('services.pusher.cluster', 'mt1') }}',
                        wsHost: '{{ config('services.pusher.host') }}',
                        wsPort: {{ config('services.pusher.port', 443) }},
                        wssPort: {{ config('services.pusher.port', 443) }},
                        forceTLS: '{{ config('services.pusher.scheme', 'https') }}' === 'https',
                        enabledTransports: ['ws', 'wss'],
                        disableStats: true,
                    });
                    
                    // Subscribe to company channel
                    const channel = echoInstance.channel('company.{{ $company->id }}');
                    
                    channel.listen('TicketCalled', (data) => {
                        handleRealtimeMessage({
                            type: 'ticket.called',
                            ticket: data.ticket
                        });
                    });
                    
                    channel.listen('PlaySound', (data) => {
                        handleRealtimeMessage({
                            type: 'sound.play',
                            sound_type: data.sound_type
                        });
                    });
                    
                    channel.listen('TicketUpdated', (data) => {
                        handleRealtimeMessage({
                            type: data.type,
                            ticket: data.ticket,
                            message: data.message
                        });
                    });
                    
                    isWebSocketConnected = true;
                    console.log('Laravel Echo connected successfully');
                    
                } catch (error) {
                    console.error('Failed to initialize Laravel Echo:', error);
                    initializePollingFallback();
                }
            } else {
                // Fallback to polling
                console.log('Pusher not configured, using polling fallback');
                initializePollingFallback();
            }
        }

        function initializePollingFallback() {
            // Polling fallback - check for updates every 5 seconds
            setInterval(async () => {
                try {
                    const response = await fetch(`/api/companies/{{ $company->id }}/performance`);
                    if (response.ok) {
                        const data = await response.json();
                        updatePerformanceStats(data.stats);
                    }
                } catch (error) {
                    console.log('Polling failed, continuing...');
                }
            }, 5000);
        }

        function handleRealtimeMessage(data) {
            switch(data.type) {
                case 'ticket.called':
                    showToast('Ticket appelé: ' + data.ticket.number, 'success');
                    playSound('ticketCalledSound');
                    updateServiceStats(data.ticket.service_id);
                    break;
                case 'ticket.absent':
                    showToast('Client absent pour le ticket', 'warning');
                    playSound('absentSound');
                    break;
                case 'sound.play':
                    if (data.sound_type === 'ticket-called') {
                        playSound('ticketCalledSound');
                    } else if (data.sound_type === 'preparation-alert') {
                        playSound('preparationSound');
                    } else if (data.sound_type === 'ticket-absent') {
                        playSound('absentSound');
                    }
                    break;
                case 'performance.updated':
                    updatePerformanceStats(data.stats);
                    break;
                case 'client_responded':
                    showToast('Client a répondu: ' + data.message, 'info');
                    break;
            }
        }

        // Close mobile menu
        function closeMobileMenu() {
            document.getElementById('mobile-menu-sidebar').classList.remove('translate-x-0');
            document.getElementById('mobile-menu-sidebar').classList.add('-translate-x-full');
            document.getElementById('mobile-menu-overlay').classList.add('hidden');
        }

        // Open mobile menu
        function openMobileMenu() {
            document.getElementById('mobile-menu-sidebar').classList.remove('-translate-x-full');
            document.getElementById('mobile-menu-sidebar').classList.add('translate-x-0');
            document.getElementById('mobile-menu-overlay').classList.remove('hidden');
        }

        // Mobile menu handlers
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenuSidebar = document.getElementById('mobile-menu-sidebar');
            const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', openMobileMenu);
            }

            if (mobileMenuOverlay) {
                mobileMenuOverlay.addEventListener('click', closeMobileMenu);
            }
        });

        // Show toast notification
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            
            toastMessage.textContent = message;
            toast.className = `fixed bottom-4 right-4 px-4 md:px-6 py-3 rounded-lg shadow-lg transform transition-transform duration-300 z-50 max-w-xs md:max-w-md ${
                type === 'success' ? 'bg-green-600 text-white' : 
                type === 'error' ? 'bg-red-600 text-white' : 
                type === 'warning' ? 'bg-orange-600 text-white' :
                'bg-blue-600 text-white'
            }`;
            
            toast.style.transform = 'translateY(0)';
            
            setTimeout(() => {
                toast.style.transform = 'translateY(100%)';
            }, 3000);
        }

        // Show/hide loading
        function setLoading(show) {
            const loading = document.getElementById('loading');
            if (show) {
                loading.classList.remove('hidden');
            } else {
                loading.classList.add('hidden');
            }
        }

        // Play sound
        function playSound(soundId) {
            try {
                const audio = document.getElementById(soundId);
                if (audio) {
                    audio.play().catch(e => console.log('Sound play failed:', e));
                }
            } catch (error) {
                console.log('Sound error:', error);
            }
        }

        // Load performance stats
        async function loadPerformanceStats() {
            try {
                const response = await fetch(`/api/companies/{{ $company->id }}/performance`);
                const data = await response.json();
                
                if (response.ok) {
                    updatePerformanceStats(data.stats);
                }
            } catch (error) {
                console.error('Failed to load performance stats:', error);
            }
        }

        // Update performance stats
        function updatePerformanceStats(stats) {
            const container = document.getElementById('performanceStats');
            if (!container || !stats) return;
            
            container.innerHTML = `
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-green-600">${stats.global_score?.speed || 0}%</div>
                    <div class="text-xs md:text-sm text-gray-500">Rapidité</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-blue-600">${stats.global_score?.presence || 0}%</div>
                    <div class="text-xs md:text-sm text-gray-500">Présence</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-purple-600">${stats.global_score?.efficiency || 0}%</div>
                    <div class="text-xs md:text-sm text-gray-500">Efficacité</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-orange-600">${stats.global_score?.overall || 0}%</div>
                    <div class="text-xs md:text-sm text-gray-500">Score Global</div>
                </div>
            `;
        }

        // Refresh performance stats
        function refreshPerformanceStats() {
            loadPerformanceStats();
            showToast('Statistiques actualisées', 'info');
        }

        // Update service stats
        function updateServiceStats(serviceId) {
            const serviceCard = document.querySelector(`[data-service-id="${serviceId}"]`);
            if (!serviceCard) return;
            
            // Refresh the waiting count
            refreshService(serviceId);
        }

        // Call next ticket
        async function callNextTicket(serviceId) {
            setLoading(true);
            try {
                const response = await fetch(`/api/services/${serviceId}/call-next`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();
                
                if (response.ok) {
                    showToast('Ticket appelé avec succès', 'success');
                    playSound('ticketCalledSound');
                    
                    // Afficher immédiatement le ticket appelé avec les boutons
                    if (data.ticket) {
                        showCurrentTicket(data.ticket);
                    }
                    
                    // Rafraîchir la page après 2 secondes pour mettre à jour tout le dashboard
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showToast(data.message || 'Erreur lors de l\'appel du ticket', 'error');
                }
            } catch (error) {
                showToast('Erreur de communication avec le serveur', 'error');
                console.error('Error:', error);
            } finally {
                setLoading(false);
            }
        }

        // Afficher le ticket appelé immédiatement
        function showCurrentTicket(ticket) {
            const currentTicketSection = document.querySelector('#current-ticket-section');
            if (!currentTicketSection) return;
            
            currentTicketSection.innerHTML = `
                <div class="border-2 border-green-500 rounded-lg p-4 md:p-6 bg-green-50">
                    <div class="text-center">
                        <div class="text-3xl md:text-4xl font-bold text-green-600 mb-2">${ticket.number}</div>
                        <p class="text-gray-600 mb-4 text-sm md:text-base">${ticket.service_name}</p>
                        <div class="flex flex-col md:flex-row items-center justify-center space-y-2 md:space-y-0 md:space-x-4 mb-4 md:mb-6">
                            <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                ${ticket.status}
                            </span>
                            ${ticket.guest_name ? `
                            <span class="text-gray-600 text-sm">
                                <i class="fas fa-user"></i> ${ticket.guest_name}
                            </span>
                            ` : ''}
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-4">
                            <button onclick="markAsServed(${ticket.id})" class="bg-green-600 hover:bg-green-700 text-white px-3 md:px-4 py-2 md:py-3 rounded-lg transition-colors flex items-center justify-center space-x-2 text-sm">
                                <i class="fas fa-check"></i>
                                <span>Servi</span>
                            </button>
                            <button onclick="markAsMissed(${ticket.id})" class="bg-orange-600 hover:bg-orange-700 text-white px-3 md:px-4 py-2 md:py-3 rounded-lg transition-colors flex items-center justify-center space-x-2 text-sm">
                                <i class="fas fa-user-clock"></i>
                                <span>Absent</span>
                            </button>
                            <button onclick="recallTicket(${ticket.id})" class="bg-blue-600 hover:bg-blue-700 text-white px-3 md:px-4 py-2 md:py-3 rounded-lg transition-colors flex items-center justify-center space-x-2 text-sm">
                                <i class="fas fa-bell"></i>
                                <span>Rappeler</span>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        }

        // Mark ticket as served
        async function markAsServed(ticketId) {
            if (!confirm('Marquer ce ticket comme servi ?')) return;
            
            setLoading(true);
            try {
                const response = await fetch(`/api/tickets/${ticketId}/serve`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();
                
                if (response.ok) {
                    showToast('Ticket marqué comme servi', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message || 'Erreur lors du traitement', 'error');
                }
            } catch (error) {
                showToast('Erreur de communication avec le serveur', 'error');
                console.error('Error:', error);
            } finally {
                setLoading(false);
            }
        }

        // Mark ticket as missed
        async function markAsMissed(ticketId) {
            if (!confirm('Marquer ce ticket comme absent ?')) return;
            
            setLoading(true);
            try {
                const response = await fetch(`/api/tickets/${ticketId}/miss`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();
                
                if (response.ok) {
                    showToast('Ticket marqué comme absent', 'warning');
                    playSound('absentSound');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message || 'Erreur lors du traitement', 'error');
                }
            } catch (error) {
                showToast('Erreur de communication avec le serveur', 'error');
                console.error('Error:', error);
            } finally {
                setLoading(false);
            }
        }

        // Recall ticket
        async function recallTicket(ticketId) {
            setLoading(true);
            try {
                const response = await fetch(`/api/tickets/${ticketId}/recall`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();
                
                if (response.ok) {
                    showToast('Ticket rappelé avec succès', 'success');
                    playSound('ticketCalledSound');
                } else {
                    showToast(data.message || 'Erreur lors du rappel', 'error');
                }
            } catch (error) {
                showToast('Erreur de communication avec le serveur', 'error');
                console.error('Error:', error);
            } finally {
                setLoading(false);
            }
        }

        // Refresh service data
        async function refreshService(serviceId) {
            try {
                const response = await fetch(`/api/services/${serviceId}/status`);
                const data = await response.json();
                
                if (response.ok) {
                    // Update waiting count
                    const serviceCard = document.querySelector(`[data-service-id="${serviceId}"]`);
                    const waitingCount = serviceCard.querySelector('.pulse-animation');
                    if (waitingCount) {
                        waitingCount.textContent = `${data.waiting_count} en attente`;
                    }
                    showToast('Données actualisées', 'info');
                } else {
                    showToast('Erreur lors de l\'actualisation', 'error');
                }
            } catch (error) {
                showToast('Erreur de communication avec le serveur', 'error');
                console.error('Error:', error);
            }
        }

        // Load and display schedule status
        async function loadScheduleStatus() {
            try {
                const response = await fetch('/api/work-schedules/status');
                const data = await response.json();
                
                if (response.ok) {
                    displayScheduleStatus(data);
                } else {
                    console.error('Failed to load schedule status');
                }
            } catch (error) {
                console.error('Error loading schedule status:', error);
            }
        }

        // Display schedule status in the UI
        function displayScheduleStatus(schedules) {
            const container = document.getElementById('scheduleStatus');
            
            if (!schedules || schedules.length === 0) {
                container.innerHTML = `
                    <div class="col-span-2 text-center py-8">
                        <i class="fas fa-calendar-times text-4xl text-gray-400"></i>
                        <p class="text-gray-500 mt-2">Aucun horaire de travail configuré</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = schedules.map(schedule => `
                <div class="border rounded-lg p-4 ${schedule.is_active ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-gray-50'}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-3 h-3 rounded-full ${schedule.status === 'open' ? 'bg-green-500' : schedule.status === 'closed' ? 'bg-red-500' : 'bg-yellow-500'}"></div>
                                <h3 class="font-semibold text-sm">${schedule.service_name || 'Entreprise'}</h3>
                                <span class="text-xs px-2 py-1 rounded-full ${schedule.is_active ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600'}">
                                    ${schedule.is_active ? 'Actif' : 'Inactif'}
                                </span>
                            </div>
                            <div class="space-y-1 text-xs text-gray-600">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-clock"></i>
                                    <span>${schedule.morning_start} - ${schedule.morning_end}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-clock"></i>
                                    <span>${schedule.afternoon_start} - ${schedule.afternoon_end}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-calendar"></i>
                                    <span>${schedule.working_days_formatted}</span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold ${schedule.status === 'open' ? 'text-green-600' : 'text-red-600'}">
                                ${schedule.status === 'open' ? 'Ouvert' : schedule.status === 'closed' ? 'Fermé' : 'En pause'}
                            </div>
                            <div class="text-xs text-gray-500">
                                ${schedule.status_message}
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Refresh schedule status
        function refreshScheduleStatus() {
            loadScheduleStatus();
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize real-time connection
            initializeRealtimeConnection();
            
            // Load performance stats
            loadPerformanceStats();
            
            // Load schedule status
            loadScheduleStatus();
            
            // Auto-refresh every 30 seconds (reduced if WebSocket works)
            setInterval(() => {
                if (!isWebSocketConnected) {
                    loadPerformanceStats();
                    loadScheduleStatus();
                }
            }, 30000);
            
            // Handle page visibility change
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    loadPerformanceStats();
                    loadScheduleStatus();
                }
            });
        });

        // Make functions globally accessible for onclick handlers
        window.callNextTicket = callNextTicket;
        window.markAsServed = markAsServed;
        window.markAsMissed = markAsMissed;
        window.recallTicket = recallTicket;
        window.refreshService = refreshService;
        window.refreshPerformanceStats = refreshPerformanceStats;
        window.refreshScheduleStatus = refreshScheduleStatus;
        window.closeMobileMenu = closeMobileMenu;
    </script>
</body>
</html>
