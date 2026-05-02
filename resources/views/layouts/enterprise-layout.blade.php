<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Enterprise Dashboard') | SmartQueue AI</title>
    
    <!-- Google Fonts Premium -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Enterprise Design System -->
    <style>
        :root {
            /* Corporate Color Palette */
            --primary-50: #f0f9ff;
            --primary-100: #e0f2fe;
            --primary-200: #bae6fd;
            --primary-300: #7dd3fc;
            --primary-400: #38bdf8;
            --primary-500: #0ea5e9;
            --primary-600: #0284c7;
            --primary-700: #0369a1;
            --primary-800: #075985;
            --primary-900: #0c4a6e;
            
            /* Sophisticated Neutrals */
            --neutral-50: #fafafa;
            --neutral-100: #f5f5f5;
            --neutral-200: #e5e5e5;
            --neutral-300: #d4d4d4;
            --neutral-400: #a3a3a3;
            --neutral-500: #737373;
            --neutral-600: #525252;
            --neutral-700: #404040;
            --neutral-800: #262626;
            --neutral-900: #171717;
            
            /* Accent Colors */
            --accent-amber: #f59e0b;
            --accent-emerald: #10b981;
            --accent-rose: #f43f5e;
            --accent-violet: #8b5cf6;
            --accent-cyan: #06b6d4;
            
            /* Semantic Colors */
            --success-50: #ecfdf5;
            --success-500: #10b981;
            --success-600: #059669;
            --warning-50: #fffbeb;
            --warning-500: #f59e0b;
            --warning-600: #d97706;
            --error-50: #fef2f2;
            --error-500: #ef4444;
            --error-600: #dc2626;
            --info-50: #eff6ff;
            --info-500: #3b82f6;
            --info-600: #2563eb;
            
            /* Enterprise Gradients */
            --gradient-primary: linear-gradient(135deg, #0ea5e9 0%, #0284c7 50%, #0369a1 100%);
            --gradient-secondary: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 50%, #6d28d9 100%);
            --gradient-accent: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
            --gradient-success: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            --gradient-subtle: linear-gradient(135deg, #fafafa 0%, #f5f5f5 50%, #e5e5e5 100%);
            
            /* Advanced Shadows */
            --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --shadow-inner: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
            
            /* Enterprise Shadows with Color */
            --shadow-primary: 0 10px 25px -3px rgba(14, 165, 233, 0.15);
            --shadow-secondary: 0 10px 25px -3px rgba(139, 92, 246, 0.15);
            --shadow-success: 0 10px 25px -3px rgba(16, 185, 129, 0.15);
            --shadow-warning: 0 10px 25px -3px rgba(245, 158, 11, 0.15);
            --shadow-error: 0 10px 25px -3px rgba(239, 68, 68, 0.15);
            
            /* Typography Scale */
            --font-mono: 'JetBrains Mono', monospace;
            --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-brand: 'Space Grotesk', sans-serif;
            
            /* Spacing Scale */
            --space-px: 1px;
            --space-0: 0;
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-5: 1.25rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-10: 2.5rem;
            --space-12: 3rem;
            --space-16: 4rem;
            --space-20: 5rem;
            --space-24: 6rem;
            --space-32: 8rem;
            
            /* Border Radius */
            --radius-none: 0;
            --radius-sm: 0.125rem;
            --radius-md: 0.375rem;
            --radius-lg: 0.5rem;
            --radius-xl: 0.75rem;
            --radius-2xl: 1rem;
            --radius-3xl: 1.5rem;
            --radius-full: 9999px;
            
            /* Transitions */
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-normal: 300ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-spring: 400ms cubic-bezier(0.175, 0.885, 0.32, 1.275);
            
            /* Z-Index Scale */
            --z-dropdown: 1000;
            --z-sticky: 1020;
            --z-fixed: 1030;
            --z-modal-backdrop: 1040;
            --z-modal: 1050;
            --z-popover: 1060;
            --z-tooltip: 1070;
            --z-toast: 1080;
        }
        
        /* Reset and Base */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        html {
            scroll-behavior: smooth;
            -webkit-text-size-adjust: 100%;
        }
        
        body {
            font-family: var(--font-sans);
            font-size: 0.875rem;
            line-height: 1.6;
            color: var(--neutral-900);
            background-color: var(--neutral-50);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
        }
        
        /* Enterprise Layout System */
        .enterprise-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            grid-template-rows: auto 1fr auto;
            min-height: 100vh;
            position: relative;
        }
        
        /* Advanced Sidebar */
        .enterprise-sidebar {
            grid-column: 1;
            grid-row: 1 / -1;
            background: var(--neutral-900);
            color: var(--neutral-100);
            display: flex;
            flex-direction: column;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow: hidden;
            z-index: var(--z-fixed);
        }
        
        .sidebar-header {
            padding: var(--space-6);
            border-bottom: 1px solid var(--neutral-800);
            background: linear-gradient(135deg, var(--neutral-900) 0%, var(--neutral-800) 100%);
        }
        
        .brand-container {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            text-decoration: none;
            color: inherit;
            transition: transform var(--transition-spring);
        }
        
        .brand-container:hover {
            transform: scale(1.02);
        }
        
        .brand-icon {
            width: 48px;
            height: 48px;
            background: var(--gradient-primary);
            border-radius: var(--radius-xl);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-primary);
        }
        
        .brand-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.2) 50%, transparent 70%);
            transform: rotate(45deg);
            animation: brandShimmer 3s infinite;
        }
        
        @keyframes brandShimmer {
            0% { transform: rotate(45deg) translateX(-100%); }
            100% { transform: rotate(45deg) translateX(100%); }
        }
        
        .brand-text {
            font-family: var(--font-brand);
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: var(--neutral-100);
        }
        
        .brand-text .accent {
            color: var(--primary-400);
        }
        
        /* Advanced Navigation */
        .sidebar-navigation {
            flex: 1;
            padding: var(--space-4);
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar-navigation::-webkit-scrollbar {
            width: 4px;
        }
        
        .sidebar-navigation::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .sidebar-navigation::-webkit-scrollbar-thumb {
            background: var(--neutral-700);
            border-radius: var(--radius-full);
        }
        
        .nav-category {
            margin-bottom: var(--space-6);
        }
        
        .nav-category-title {
            font-size: 0.6875rem;
            font-weight: 600;
            color: var(--neutral-500);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 0 var(--space-4);
            margin-bottom: var(--space-2);
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }
        
        .nav-category-title::before {
            content: '';
            width: 12px;
            height: 1px;
            background: var(--neutral-700);
        }
        
        .nav-category-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--neutral-700);
        }
        
        .nav-item {
            margin-bottom: var(--space-1);
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3) var(--space-4);
            color: var(--neutral-300);
            text-decoration: none;
            font-weight: 500;
            border-radius: var(--radius-lg);
            transition: all var(--transition-spring);
            position: relative;
            overflow: hidden;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: var(--gradient-primary);
            border-radius: 0 2px 2px 0;
            transition: height var(--transition-normal);
        }
        
        .nav-link:hover {
            background: rgba(14, 165, 233, 0.1);
            color: var(--primary-400);
            transform: translateX(4px);
        }
        
        .nav-link:hover::before {
            height: 60%;
        }
        
        .nav-link.active {
            background: var(--gradient-primary);
            color: var(--neutral-900);
            font-weight: 600;
            box-shadow: var(--shadow-primary);
        }
        
        .nav-link.active::before {
            height: 60%;
            background: var(--neutral-100);
        }
        
        .nav-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            transition: all var(--transition-fast);
        }
        
        .nav-link:hover .nav-icon {
            transform: scale(1.1) rotate(2deg);
        }
        
        .nav-badge {
            margin-left: auto;
            background: var(--gradient-accent);
            color: var(--neutral-900);
            font-size: 0.6875rem;
            font-weight: 700;
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius-full);
            min-width: 24px;
            text-align: center;
            box-shadow: var(--shadow-warning);
        }
        
        /* User Profile Section */
        .sidebar-profile {
            padding: var(--space-4);
            border-top: 1px solid var(--neutral-800);
            background: linear-gradient(135deg, var(--neutral-800) 0%, var(--neutral-900) 100%);
        }
        
        .profile-card {
            display: flex;
            align-items: center;
            gap: var(--space-3);
            padding: var(--space-3);
            background: var(--neutral-800);
            border: 1px solid var(--neutral-700);
            border-radius: var(--radius-xl);
            transition: all var(--transition-spring);
            cursor: pointer;
        }
        
        .profile-card:hover {
            background: var(--neutral-700);
            border-color: var(--primary-600);
            transform: translateY(-2px);
            box-shadow: var(--shadow-primary);
        }
        
        .profile-avatar {
            width: 40px;
            height: 40px;
            background: var(--gradient-secondary);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--neutral-100);
            font-weight: 700;
            font-size: 1rem;
            box-shadow: var(--shadow-secondary);
        }
        
        .profile-info {
            flex: 1;
            min-width: 0;
        }
        
        .profile-name {
            font-weight: 600;
            color: var(--neutral-100);
            font-size: 0.875rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .profile-role {
            font-size: 0.75rem;
            color: var(--neutral-400);
        }
        
        .profile-menu {
            color: var(--neutral-500);
            transition: color var(--transition-fast);
        }
        
        .profile-card:hover .profile-menu {
            color: var(--primary-400);
        }
        
        /* Main Content Area */
        .enterprise-main {
            grid-column: 2;
            grid-row: 1 / -1;
            display: flex;
            flex-direction: column;
            background: var(--neutral-50);
        }
        
        /* Advanced Header */
        .enterprise-header {
            background: var(--neutral-100);
            border-bottom: 1px solid var(--neutral-200);
            padding: var(--space-4) var(--space-6);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: var(--z-sticky);
            backdrop-filter: blur(10px);
            background: rgba(250, 250, 250, 0.95);
        }
        
        .header-left {
            display: flex;
            align-items: center;
            gap: var(--space-6);
        }
        
        .breadcrumb-trail {
            display: flex;
            align-items: center;
            gap: var(--space-2);
            font-size: 0.875rem;
            color: var(--neutral-600);
        }
        
        .breadcrumb-link {
            color: var(--primary-600);
            text-decoration: none;
            font-weight: 500;
            transition: color var(--transition-fast);
        }
        
        .breadcrumb-link:hover {
            color: var(--primary-700);
        }
        
        .breadcrumb-separator {
            color: var(--neutral-400);
        }
        
        .breadcrumb-current {
            color: var(--neutral-900);
            font-weight: 600;
        }
        
        /* Advanced Search */
        .search-container {
            position: relative;
            width: 400px;
        }
        
        .search-input {
            width: 100%;
            padding: var(--space-3) var(--space-4) var(--space-3) var(--space-10);
            background: var(--neutral-100);
            border: 1px solid var(--neutral-300);
            border-radius: var(--radius-xl);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--neutral-900);
            transition: all var(--transition-spring);
        }
        
        .search-input::placeholder {
            color: var(--neutral-500);
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary-500);
            background: var(--neutral-50);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1), var(--shadow-md);
            transform: translateY(-1px);
        }
        
        .search-icon {
            position: absolute;
            left: var(--space-3);
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: var(--neutral-500);
            pointer-events: none;
        }
        
        .search-shortcut {
            position: absolute;
            right: var(--space-3);
            top: 50%;
            transform: translateY(-50%);
            background: var(--neutral-200);
            color: var(--neutral-600);
            font-size: 0.6875rem;
            font-weight: 600;
            padding: var(--space-1) var(--space-2);
            border-radius: var(--radius-md);
            font-family: var(--font-mono);
        }
        
        /* Header Actions */
        .header-actions {
            display: flex;
            align-items: center;
            gap: var(--space-2);
        }
        
        .action-button {
            position: relative;
            width: 44px;
            height: 44px;
            border-radius: var(--radius-xl);
            background: var(--neutral-100);
            border: 1px solid var(--neutral-300);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-spring);
            color: var(--neutral-700);
        }
        
        .action-button:hover {
            background: var(--neutral-50);
            border-color: var(--primary-300);
            color: var(--primary-600);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .notification-indicator {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 20px;
            height: 20px;
            background: var(--gradient-accent);
            color: var(--neutral-900);
            border-radius: var(--radius-full);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.625rem;
            font-weight: 700;
            border: 2px solid var(--neutral-100);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }
        
        /* Content Area */
        .enterprise-content {
            flex: 1;
            padding: var(--space-6);
            overflow-y: auto;
        }
        
        .content-wrapper {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        /* Mobile Responsive */
        .mobile-menu-trigger {
            display: none;
            position: fixed;
            top: var(--space-4);
            left: var(--space-4);
            z-index: var(--z-modal);
            width: 48px;
            height: 48px;
            border-radius: var(--radius-xl);
            background: var(--neutral-900);
            border: 1px solid var(--neutral-800);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-lg);
        }
        
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: var(--z-modal-backdrop);
            opacity: 0;
            transition: opacity var(--transition-normal);
        }
        
        .mobile-overlay.active {
            opacity: 1;
        }
        
        @media (max-width: 1024px) {
            .search-container {
                width: 320px;
            }
            
        }
        
        @media (max-width: 768px) {
            .mobile-menu-trigger {
                display: flex;
            }
            
            .mobile-overlay {
                display: block;
            }
            
            .enterprise-layout {
                grid-template-columns: 1fr;
            }
            
            .enterprise-sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                height: 100vh;
                z-index: var(--z-modal);
                transition: left var(--transition-spring);
            }
            
            .enterprise-sidebar.mobile-open {
                left: 0;
            }
            
            .enterprise-main {
                grid-column: 1;
            }
            
            .enterprise-header {
                padding: var(--space-3) var(--space-4);
            }
            
            .header-left {
                gap: var(--space-3);
            }
            
            .search-container {
                display: none;
            }
            
            .enterprise-content {
                padding: var(--space-4);
            }
            
        }
    </style>
</head>
<body>
    <div class="enterprise-layout">
        <!-- Mobile Menu Trigger -->
        <button class="mobile-menu-trigger" onclick="toggleMobileSidebar()">
            <i data-lucide="menu" style="width: 24px; height: 24px; color: white;"></i>
        </button>
        
        <!-- Mobile Overlay -->
        <div class="mobile-overlay" onclick="toggleMobileSidebar()"></div>
        
        <!-- Enterprise Sidebar -->
        <aside class="enterprise-sidebar" id="enterpriseSidebar">
            <!-- Brand Header -->
            <div class="sidebar-header">
                <a href="{{ route('welcome') }}" class="brand-container">
                    <div class="brand-icon">
                        <i data-lucide="layers" style="width: 24px; height: 24px; color: white;"></i>
                    </div>
                    <div class="brand-text">
                        SmartQueue<span class="accent">AI</span>
                    </div>
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="sidebar-navigation">
                <!-- Main Navigation -->
                <div class="nav-category">
                    <div class="nav-category-title">Principal</div>
                    <div class="nav-item">
                        <a href="{{ route('company.admin.dashboard', $company ?? null) }}" class="nav-link {{ request()->routeIs('company.admin.dashboard') ? 'active' : '' }}">
                            <i data-lucide="layout-dashboard" class="nav-icon"></i>
                            <span>Tableau de Bord</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('company.admin.services', $company ?? null) }}" class="nav-link {{ request()->routeIs('company.admin.services*') ? 'active' : '' }}">
                            <i data-lucide="briefcase" class="nav-icon"></i>
                            <span>Services</span>
                            <span class="nav-badge">3</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('company.admin.counters', $company ?? null) }}" class="nav-link {{ request()->routeIs('company.admin.counters*') ? 'active' : '' }}">
                            <i data-lucide="users" class="nav-icon"></i>
                            <span>Guichets</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('company.admin.agents', $company ?? null) }}" class="nav-link {{ request()->routeIs('company.admin.agents*') ? 'active' : '' }}">
                            <i data-lucide="user-check" class="nav-icon"></i>
                            <span>Agents</span>
                        </a>
                    </div>
                </div>
                
                <!-- Analytics -->
                <div class="nav-category">
                    <div class="nav-category-title">Analytics</div>
                    <div class="nav-item">
                        <a href="{{ route('company.admin.statistics', $company ?? null) }}" class="nav-link {{ request()->routeIs('company.admin.statistics') ? 'active' : '' }}">
                            <i data-lucide="bar-chart-3" class="nav-icon"></i>
                            <span>Statistiques</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i data-lucide="trending-up" class="nav-icon"></i>
                            <span>Rapports</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i data-lucide="calendar" class="nav-icon"></i>
                            <span>Planning</span>
                        </a>
                    </div>
                </div>
                
                <!-- System -->
                <div class="nav-category">
                    <div class="nav-category-title">Système</div>
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i data-lucide="settings" class="nav-icon"></i>
                            <span>Paramètres</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <a href="{{ route('welcome') }}" class="nav-link">
                            <i data-lucide="home" class="nav-icon"></i>
                            <span>Accueil Public</span>
                        </a>
                    </div>
                    <div class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" style="width: 100%;">
                            @csrf
                            <button type="submit" class="nav-link" style="width: 100%; text-align: left; border: none; background: none; cursor: pointer;">
                                <i data-lucide="log-out" class="nav-icon"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
            
            <!-- User Profile -->
            <div class="sidebar-profile">
                <div class="profile-card">
                    <div class="profile-avatar">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="profile-info">
                        <div class="profile-name">{{ auth()->user()->name }}</div>
                        <div class="profile-role">Administrateur</div>
                    </div>
                    <i data-lucide="more-vertical" class="profile-menu" style="width: 16px; height: 16px;"></i>
                </div>
            </div>
        </aside>
        
        <!-- Main Content Area -->
        <main class="enterprise-main">
            <!-- Enterprise Header -->
            <header class="enterprise-header">
                <div class="header-left">
                    <!-- Breadcrumb -->
                    <div class="breadcrumb-trail">
                        <a href="{{ route('company.admin.dashboard', $company ?? null) }}" class="breadcrumb-link">Dashboard</a>
                        <span class="breadcrumb-separator">/</span>
                        <span class="breadcrumb-current">{{ request()->route()->getName() }}</span>
                    </div>
                    
                    <!-- Advanced Search -->
                    <div class="search-container">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" placeholder="Rechercher dans l'application..." class="search-input">
                        <span class="search-shortcut">⌘K</span>
                    </div>
                </div>
                
                <div class="header-actions">
                    <!-- Theme Toggle -->
                    <button class="action-button" title="Basculer le thème">
                        <i data-lucide="sun" style="width: 20px; height: 20px;"></i>
                    </button>
                    
                    <!-- Notifications -->
                    <button class="action-button" title="Notifications">
                        <i data-lucide="bell" style="width: 20px; height: 20px;"></i>
                        <span class="notification-indicator">3</span>
                    </button>
                    
                    <!-- Settings -->
                    <button class="action-button" title="Paramètres">
                        <i data-lucide="settings" style="width: 20px; height: 20px;"></i>
                    </button>
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="enterprise-content">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
            
        </main>
    </div>
    
    <!-- Enterprise JavaScript -->
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Mobile Sidebar Toggle
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('enterpriseSidebar');
            const overlay = document.querySelector('.mobile-overlay');
            
            sidebar.classList.toggle('mobile-open');
            overlay.classList.toggle('active');
        }
        
        // Close mobile sidebar when clicking overlay
        document.querySelector('.mobile-overlay').addEventListener('click', toggleMobileSidebar);
        
        // Advanced Search Functionality
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            // Keyboard shortcut (Cmd+K / Ctrl+K)
            document.addEventListener('keydown', function(e) {
                if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
                    e.preventDefault();
                    searchInput.focus();
                }
            });
            
            // Search functionality
            searchInput.addEventListener('input', function(e) {
                const query = e.target.value.trim();
                if (query.length > 2) {
                    // Implement search
                    console.log('Searching for:', query);
                }
            });
            
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const query = e.target.value.trim();
                    if (query) {
                        // Execute search
                        console.log('Execute search:', query);
                    }
                }
            });
        }
        
        // Notification Animation
        const notificationIndicator = document.querySelector('.notification-indicator');
        if (notificationIndicator) {
            setInterval(() => {
                notificationIndicator.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    notificationIndicator.style.transform = 'scale(1)';
                }, 300);
            }, 4000);
        }
        
        // Smooth Scroll for Internal Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Theme Toggle (placeholder)
        document.querySelector('.action-button[title="Basculer le thème"]').addEventListener('click', function() {
            document.body.classList.toggle('dark-theme');
            console.log('Theme toggled');
        });
        
        // Performance optimization: Lazy load images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
        
        // Add loading states to buttons
        document.querySelectorAll('button, .action-button').forEach(button => {
            button.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 100);
            });
        });
    </script>
</body>
</html>
