<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SmartQueue AI')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Styles -->
    <style>
        * { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        
        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .sidebar.collapsed {
            width: 80px;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: white;
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            transition: opacity 0.3s;
        }
        
        .sidebar.collapsed .logo-text {
            opacity: 0;
            visibility: hidden;
        }
        
        .toggle-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            padding: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.05);
        }
        
        .sidebar-nav {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
        }
        
        .nav-section {
            margin-bottom: 2rem;
        }
        
        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.75rem;
            padding: 0 0.75rem;
            transition: opacity 0.3s;
        }
        
        .sidebar.collapsed .nav-section-title {
            opacity: 0;
            visibility: hidden;
        }
        
        .nav-item {
            display: block;
            padding: 0.75rem;
            margin-bottom: 0.25rem;
            border-radius: 12px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }
        
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(4px);
        }
        
        .nav-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }
        
        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background: white;
            border-radius: 0 4px 4px 0;
        }
        
        .nav-content {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .nav-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }
        
        .nav-text {
            font-size: 0.875rem;
            font-weight: 500;
            transition: opacity 0.3s;
        }
        
        .sidebar.collapsed .nav-text {
            opacity: 0;
            visibility: hidden;
        }
        
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            margin-bottom: 1rem;
        }
        
        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            flex-shrink: 0;
        }
        
        .user-info {
            flex: 1;
            transition: opacity 0.3s;
        }
        
        .sidebar.collapsed .user-info {
            opacity: 0;
            visibility: hidden;
        }
        
        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: white;
            margin-bottom: 0.125rem;
        }
        
        .user-role {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.6);
        }
        
        .logout-btn {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 12px;
            background: rgba(239, 68, 68, 0.1);
            color: rgba(239, 68, 68, 0.9);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        
        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            transform: translateY(-1px);
        }
        
        .sidebar.collapsed .logout-btn span {
            display: none;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-height: 100vh;
            background: #f8fafc;
        }
        
        .sidebar.collapsed + .main-content {
            margin-left: 80px;
        }
        
        /* Mobile Responsive */
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }
        
        .mobile-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 50;
            background: #1e293b;
            border: none;
            color: white;
            padding: 0.75rem;
            border-radius: 8px;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                height: 100vh;
                z-index: 50;
            }
            
            .sidebar.open {
                left: 0;
            }
            
            .sidebar.collapsed {
                width: 280px;
                left: -280px;
            }
            
            .sidebar.collapsed.open {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .mobile-overlay.show {
                display: block;
            }
            
            .mobile-toggle {
                display: flex;
            }
            
            .sidebar.collapsed .nav-text,
            .sidebar.collapsed .logo-text,
            .sidebar.collapsed .user-info,
            .sidebar.collapsed .nav-section-title {
                opacity: 1;
                visibility: visible;
            }
        }
        
        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        .nav-item {
            animation: slideIn 0.3s ease-out;
        }
        
        .nav-item:nth-child(1) { animation-delay: 0.1s; }
        .nav-item:nth-child(2) { animation-delay: 0.15s; }
        .nav-item:nth-child(3) { animation-delay: 0.2s; }
        .nav-item:nth-child(4) { animation-delay: 0.25s; }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    @auth
    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle" onclick="toggleMobileSidebar()">
        <i data-lucide="menu" style="width: 20px; height: 20px;"></i>
    </button>
    
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" onclick="toggleMobileSidebar()"></div>
    
    <div class="flex">
        <!-- Modern Sidebar -->
        <aside class="sidebar" id="sidebar">
            <!-- Header -->
            <div class="sidebar-header">
                <a href="{{ route('welcome') }}" class="logo">
                    <div class="logo-icon">
                        <i data-lucide="layout-dashboard" style="width: 24px; height: 24px; color: white;"></i>
                    </div>
                    <span class="logo-text">SmartQueue<span style="color: #60a5fa;">AI</span></span>
                </a>
                <button class="toggle-btn" onclick="toggleSidebar()">
                    <i data-lucide="chevron-left" style="width: 20px; height: 20px;"></i>
                </button>
            </div>
            
            <!-- Navigation -->
            <nav class="sidebar-nav">
                @php
                    $currentCompany = auth()->user()?->currentCompany ?? auth()->user()?->companies()->first();
                @endphp
                
                @if($currentCompany)
                    <!-- Section Gestion -->
                    <div class="nav-section">
                        <div class="nav-section-title">Gestion</div>
                        
                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasRoleInCompany($currentCompany, 'company_admin'))
                            <a href="{{ route('company.admin.dashboard', $currentCompany) }}" 
                               class="nav-item {{ request()->routeIs('company.admin.*') ? 'active' : '' }}">
                                <div class="nav-content">
                                    <i class="nav-icon" data-lucide="shield-check"></i>
                                    <span class="nav-text">Dashboard Admin</span>
                                </div>
                            </a>
                        @endif
                        
                        @if(auth()->user()->hasRoleInCompany($currentCompany, 'agent'))
                            <a href="{{ route('company.agent.dashboard', $currentCompany) }}" 
                               class="nav-item {{ request()->routeIs('company.agent.*') ? 'active' : '' }}">
                                <div class="nav-content">
                                    <i class="nav-icon" data-lucide="headphones"></i>
                                    <span class="nav-text">Guichets Agent</span>
                                </div>
                            </a>
                        @endif
                    </div>
                    
                    <!-- Section Services -->
                    <div class="nav-section">
                        <div class="nav-section-title">Services</div>
                        
                        <a href="{{ route('company.agent.history', $currentCompany) }}" 
                           class="nav-item {{ request()->routeIs('company.agent.history') ? 'active' : '' }}">
                            <div class="nav-content">
                                <i class="nav-icon" data-lucide="history"></i>
                                <span class="nav-text">Historique</span>
                            </div>
                        </a>
                        
                                            </div>
                @endif
                
                <!-- Section Général -->
                <div class="nav-section">
                    <div class="nav-section-title">Général</div>
                    
                    <a href="{{ route('welcome') }}" 
                       class="nav-item {{ request()->routeIs('welcome') ? 'active' : '' }}">
                        <div class="nav-content">
                            <i class="nav-icon" data-lucide="home"></i>
                            <span class="nav-text">Page d'accueil</span>
                        </div>
                    </a>
                    
                                        
                    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasRoleInCompany($currentCompany, 'company_admin'))
                        <a href="{{ route('company.admin.settings', $currentCompany ?? auth()->user()?->companies()->first()) }}" 
                           class="nav-item {{ request()->routeIs('company.admin.settings*') ? 'active' : '' }}">
                            <div class="nav-content">
                                <i class="nav-icon" data-lucide="settings"></i>
                                <span class="nav-text">Paramètres</span>
                            </div>
                        </a>
                    @endif
                </div>
            </nav>
            
            <!-- Footer -->
            <div class="sidebar-footer">
                <!-- User Profile -->
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">
                            @if($currentCompany)
                                {{ ucfirst(auth()->user()->companies()->where('company_id', $currentCompany->id)->first()?->pivot->role ?? 'Agent') }}
                            @else
                                Utilisateur
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout.post') }}">
                    @csrf
                    <button type="submit" class="logout-btn" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                        <i data-lucide="log-out" style="width: 18px; height: 18px;"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="bg-white border-b border-gray-200 sticky top-0 z-30">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">@yield('title', 'SmartQueue AI')</h1>
                            @if($currentCompany)
                                <p class="text-sm text-gray-500 mt-1">{{ $currentCompany->name }} - Interface Agent</p>
                            @endif
                        </div>
                        
                        <!-- Company Selector -->
                        @if(auth()->user()->companies()->count() > 1)
                            <div class="relative">
                                <button 
                                    type="button" 
                                    class="flex items-center gap-2 px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm hover:bg-gray-100 transition"
                                    onclick="toggleCompanyDropdown()"
                                >
                                    <span class="font-medium">{{ auth()->user()->currentCompany?->name ?? 'Sélectionner une entreprise' }}</span>
                                    <i data-lucide="chevron-down" style="width: 16px; height: 16px;"></i>
                                </button>
                                
                                <div id="companyDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                                    <div class="py-2 max-h-64 overflow-y-auto">
                                        @foreach(auth()->user()->companies as $company)
                                            <form method="POST" action="{{ route('switch.company', $company) }}" class="block">
                                                @csrf
                                                <button 
                                                    type="submit" 
                                                    class="w-full px-4 py-3 hover:bg-gray-50 transition text-left"
                                                >
                                                    <div class="flex items-center justify-between">
                                                        <div>
                                                            <div class="font-medium text-gray-900">{{ $company->name }}</div>
                                                            <div class="text-sm text-gray-500">{{ ucfirst($company->pivot->role) }}</div>
                                                        </div>
                                                        @if($company->id == auth()->user()->currentCompany?->id)
                                                            <i data-lucide="check" style="width: 20px; height: 20px; color: #3b82f6;"></i>
                                                        @endif
                                                    </div>
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Page Content -->
            <div class="p-6">
                @yield('content')
            </div>
        </main>
    </div>
    
    <script>
        // Initialize Lucide icons
        if (window.lucide) {
            window.lucide.createIcons({ icons: window.lucide.icons });
        }
        
        // Toggle Sidebar (Desktop)
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (!sidebar) return;
            
            const toggleBtn = sidebar.querySelector('.toggle-btn i');
            
            sidebar.classList.toggle('collapsed');
            
            // Update icon
            if (toggleBtn) {
                if (sidebar.classList.contains('collapsed')) {
                    toggleBtn.setAttribute('data-lucide', 'chevron-right');
                } else {
                    toggleBtn.setAttribute('data-lucide', 'chevron-left');
                }
            }
            
            // Re-initialize icons
            if (window.lucide) {
                window.lucide.createIcons({ icons: window.lucide.icons });
            }
        }
        
        // Toggle Mobile Sidebar
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }
        
        // Toggle Company Dropdown
        function toggleCompanyDropdown() {
            const dropdown = document.getElementById('companyDropdown');
            dropdown.classList.toggle('hidden');
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('companyDropdown');
            const button = event.target.closest('button[onclick="toggleCompanyDropdown()"]');
            
            if (!button && dropdown && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
        
        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.querySelector('.mobile-overlay');
                
                sidebar.classList.remove('open');
                overlay.classList.remove('show');
            }
        });
        
        // Re-initialize icons after dynamic content changes - REMOVED TO PREVENT INFINITE LOOP
        // const observer = new MutationObserver(function(mutations) {
        //     mutations.forEach(function(mutation) {
        //         if (mutation.type === 'childList') {
        //             if (window.lucide) {
        //                 window.lucide.createIcons({ icons: window.lucide.icons });
        //             }
        //         }
        //     });
        // });
        
        // observer.observe(document.body, {
        //     childList: true,
        //     subtree: true
        // });
    </script>
    @else
    <!-- Non-authenticated layout -->
    <div class="min-h-screen bg-gray-50">
        @yield('content')
    </div>
    @endauth
    
    <!-- Include original styles and scripts -->
    @stack('styles')
    </body>
</html>
