<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') | {{ $company->name }}</title>
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Glassmorphism sidebar */
        .sidebar-glass {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
        
        /* Link styles with glow effect */
        .sidebar-link {
            display: flex !important;
            align-items: center !important;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            white-space: nowrap;
        }
        
        .sidebar-link svg,
        .sidebar-link i,
        .sidebar-link img {
            flex-shrink: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .sidebar-link span {
            display: inline;
            line-height: 1;
        }
        
        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: linear-gradient(to bottom, #3B82F6, #8B5CF6);
            border-radius: 0 4px 4px 0;
            transition: height 0.3s ease;
        }
        
        .sidebar-link:hover::before,
        .sidebar-link.active::before {
            height: 70%;
        }
        
        .sidebar-link:hover {
            @apply bg-white/5 text-white;
            transform: translateX(4px);
        }
        
        .sidebar-link.active {
            @apply text-white;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15) 0%, rgba(139, 92, 246, 0.15) 100%);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3), inset 0 1px 0 rgba(255,255,255,0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
        }
        
        /* Icon animation */
        .sidebar-link svg {
            transition: transform 0.3s ease;
        }
        
        .sidebar-link:hover svg,
        .sidebar-link.active svg {
            transform: translateY(-2px);
        }
        
        /* Card shadow with glow */
        .card-shadow {
            @apply shadow-xl shadow-black/5 border border-gray-800/50;
        }
        
        /* Custom dark theme colors */
        .bg-dark-900 { background-color: #030712; }
        .bg-dark-800 { background-color: #111827; }
        .bg-dark-700 { background-color: #1f2937; }
        .text-dark-600 { color: #4b5563; }
        .border-dark-700 { border-color: #374151; }
        .border-dark-600 { border-color: #4b5563; }
        .bg-brand-500 { background-color: #3b82f6; }
        .bg-brand-600 { background-color: #2563eb; }
        .text-brand-500 { color: #3b82f6; }
        .text-brand-400 { color: #60a5fa; }
        .border-brand-500 { border-color: #3b82f6; }
        .shadow-brand-600 { box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.3); }
        
        /* User avatar glow */
        .avatar-glow {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.4);
        }
        
        /* Smooth scrollbar */
        nav::-webkit-scrollbar {
            width: 4px;
        }
        
        nav::-webkit-scrollbar-track {
            background: transparent;
        }
        
        nav::-webkit-scrollbar-thumb {
            background: rgba(71, 85, 105, 0.5);
            border-radius: 2px;
        }
        
        /* Badge Admin */
        .admin-badge {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
            border: 1px solid rgba(59, 130, 246, 0.4);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body class="bg-dark-900 text-white">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 sidebar-glass border-r border-dark-700/50 flex flex-col fixed h-full z-20">
            <!-- Logo Company -->
            <div class="p-6 border-b border-dark-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-brand-600/30">
                        <span class="text-white font-bold">{{ substr($company->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <h1 class="font-bold text-white text-sm truncate">{{ $company->name }}</h1>
                        <p class="text-xs text-gray-500">Admin</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('company.admin.dashboard', $company) }}" class="sidebar-link {{ request()->routeIs('company.admin.dashboard') ? 'active' : 'text-gray-400' }}">
                    <span class="icon-wrapper">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </span>
                    <span class="link-text">Dashboard</span>
                </a>

                <a href="{{ route('company.admin.services', $company) }}" class="sidebar-link {{ request()->routeIs('company.admin.services*') ? 'active' : 'text-gray-400' }}">
                    <span class="icon-wrapper">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </span>
                    <span class="link-text">Services</span>
                </a>

                <a href="{{ route('company.admin.counters', $company) }}" class="sidebar-link {{ request()->routeIs('company.admin.counters*') ? 'active' : 'text-gray-400' }}">
                    <span class="icon-wrapper">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </span>
                    <span class="link-text">Guichets</span>
                </a>

                <a href="{{ route('company.admin.agents', $company) }}" class="sidebar-link {{ request()->routeIs('company.admin.agents*') ? 'active' : 'text-gray-400' }}">
                    <span class="icon-wrapper">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </span>
                    <span class="link-text">Agents</span>
                </a>

                <div class="p-6 border-t border-gray-700">
                    <a href="{{ route('welcome') }}" class="sidebar-link text-gray-400">
                        <span class="icon-wrapper">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </span>
                        <span class="link-text">Accueil</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="sidebar-link text-red-400 w-full text-left">
                            <span class="icon-wrapper">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </span>
                            <span class="link-text">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </nav>

            <!-- User Profile -->
            <div class="p-4 border-t border-gray-700/50">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-800/50 border border-gray-700/30">
                    <div class="w-10 h-10 bg-gradient-to-br from-brand-500 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold avatar-glow">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 overflow-y-auto bg-dark-900">
            <!-- Top Bar -->
            <header class="bg-gray-800 border-b border-gray-700 sticky top-0 z-10">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h2 class="text-xl font-semibold text-white">@yield('title', 'Dashboard')</h2>
                        <p class="text-sm text-gray-500">{{ now()->format('l d F Y') }}</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="px-4 py-1.5 bg-gradient-to-r from-blue-600/20 to-purple-600/20 text-blue-400 rounded-full text-sm font-semibold border border-blue-500/30 shadow-lg shadow-blue-500/20">
                            <span class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                                Admin
                            </span>
                        </span>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-green-400">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-red-400">{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
