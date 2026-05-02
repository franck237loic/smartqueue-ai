<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Premium Dashboard') | SmartQueue AI</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Premium Design System -->
    <style>
        :root {
            /* Palette Claire et Élégante */
            --primary-blue: #3b82f6;
            --primary-indigo: #6366f1;
            --secondary-purple: #8b5cf6;
            --accent-pink: #ec4899;
            --accent-teal: #14b8a6;
            --accent-emerald: #10b981;
            
            /* Neutrals Sophistiqués */
            --white: #ffffff;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            
            /* Pastels Élégants */
            --blue-50: #eff6ff;
            --blue-100: #dbeafe;
            --indigo-50: #eef2ff;
            --indigo-100: #e0e7ff;
            --purple-50: #faf5ff;
            --purple-100: #f3e8ff;
            --pink-50: #fdf2f8;
            --pink-100: #fce7f3;
            --teal-50: #f0fdfa;
            --teal-100: #ccfbf1;
            
            /* Gradients Premium */
            --gradient-primary: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            --gradient-secondary: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
            --gradient-accent: linear-gradient(135deg, #14b8a6 0%, #10b981 100%);
            --gradient-soft: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            
            /* Shadows Élégants */
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --shadow-premium: 0 35px 60px -15px rgba(59, 130, 246, 0.15);
            
            /* Transitions */
            --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-normal: 300ms cubic-bezier(0.4, 0, 0.2, 1);
            --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        
        /* Layout Principal */
        .app-layout {
            display: flex;
            min-height: 100vh;
            position: relative;
        }
        
        /* Sidebar Premium */
        .sidebar {
            width: 280px;
            background: var(--white);
            border-right: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            z-index: 40;
            transition: transform var(--transition-normal);
        }
        
        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            background: var(--gradient-soft);
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
            color: inherit;
        }
        
        .logo-icon {
            width: 48px;
            height: 48px;
            background: var(--gradient-primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }
        
        .logo-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255, 255, 255, 0.3) 50%, transparent 70%);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: rotate(45deg) translateX(-100%); }
            100% { transform: rotate(45deg) translateX(100%); }
        }
        
        .logo-text {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .logo-text span {
            color: var(--accent-pink);
            -webkit-text-fill-color: var(--accent-pink);
        }
        
        /* Navigation Sidebar */
        .sidebar-nav {
            flex: 1;
            padding: 1.5rem 0;
            overflow-y: auto;
        }
        
        .nav-section {
            margin-bottom: 2rem;
        }
        
        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: var(--gray-700);
            text-decoration: none;
            font-weight: 500;
            transition: all var(--transition-fast);
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
            transition: height var(--transition-fast);
        }
        
        .nav-link:hover {
            background: var(--blue-50);
            color: var(--primary-blue);
            transform: translateX(4px);
        }
        
        .nav-link:hover::before {
            height: 70%;
        }
        
        .nav-link.active {
            background: var(--gradient-primary);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }
        
        .nav-link.active::before {
            height: 70%;
            background: var(--white);
        }
        
        .nav-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            transition: transform var(--transition-fast);
        }
        
        .nav-link:hover .nav-icon {
            transform: scale(1.1);
        }
        
        .nav-badge {
            margin-left: auto;
            background: var(--accent-pink);
            color: var(--white);
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.125rem 0.5rem;
            border-radius: 50px;
            min-width: 24px;
            text-align: center;
        }
        
        /* User Profile Sidebar */
        .sidebar-profile {
            padding: 1.5rem;
            border-top: 1px solid var(--gray-100);
            background: var(--gray-50);
        }
        
        .profile-card {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: var(--white);
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            transition: all var(--transition-fast);
        }
        
        .profile-card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }
        
        .profile-avatar {
            width: 40px;
            height: 40px;
            background: var(--gradient-secondary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 1rem;
        }
        
        .profile-info {
            flex: 1;
            min-width: 0;
        }
        
        .profile-name {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 0.875rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .profile-role {
            font-size: 0.75rem;
            color: var(--gray-500);
        }
        
        /* Main Content Area */
        .main-content {
            flex: 1;
            margin-left: 280px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* Top Navigation Bar */
        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 30;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--gray-500);
        }
        
        .breadcrumb a {
            color: var(--primary-blue);
            text-decoration: none;
            transition: color var(--transition-fast);
        }
        
        .breadcrumb a:hover {
            color: var(--primary-indigo);
        }
        
        .breadcrumb-separator {
            color: var(--gray-400);
        }
        
        .search-bar {
            position: relative;
            width: 320px;
        }
        
        .search-input {
            width: 100%;
            padding: 0.625rem 1rem 0.625rem 2.5rem;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            background: var(--gray-50);
            font-size: 0.875rem;
            transition: all var(--transition-fast);
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary-blue);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            color: var(--gray-400);
        }
        
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .topbar-button {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid var(--gray-200);
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all var(--transition-fast);
        }
        
        .topbar-button:hover {
            background: var(--gray-50);
            border-color: var(--gray-300);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 20px;
            height: 20px;
            background: var(--accent-pink);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.625rem;
            font-weight: 700;
            border: 2px solid var(--white);
        }
        
        /* Content Area */
        .content {
            flex: 1;
            padding: 2rem;
            background: var(--gray-50);
        }
        
        /* Footer Premium */
        .footer {
            background: var(--white);
            border-top: 1px solid var(--gray-200);
            padding: 2rem;
            margin-top: auto;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 2rem;
        }
        
        .footer-brand {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--gray-900);
        }
        
        .footer-logo-icon {
            width: 32px;
            height: 32px;
            background: var(--gradient-primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }
        
        .footer-description {
            color: var(--gray-600);
            font-size: 0.875rem;
            line-height: 1.6;
        }
        
        .footer-social {
            display: flex;
            gap: 0.5rem;
        }
        
        .social-link {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-600);
            transition: all var(--transition-fast);
        }
        
        .social-link:hover {
            background: var(--gradient-primary);
            color: var(--white);
            transform: translateY(-2px);
        }
        
        .footer-section h4 {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
        
        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .footer-link {
            color: var(--gray-600);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color var(--transition-fast);
        }
        
        .footer-link:hover {
            color: var(--primary-blue);
        }
        
        .footer-bottom {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--gray-200);
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--gray-500);
            font-size: 0.875rem;
        }
        
        .footer-bottom-links {
            display: flex;
            gap: 1.5rem;
        }
        
        .footer-bottom-link {
            color: var(--gray-500);
            text-decoration: none;
            transition: color var(--transition-fast);
        }
        
        .footer-bottom-link:hover {
            color: var(--primary-blue);
        }
        
        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 50;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--white);
            border: 1px solid var(--gray-200);
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: var(--shadow-md);
        }
        
        /* Responsive Design */
        @media (max-width: 1024px) {
            .search-bar {
                width: 240px;
            }
        }
        
        @media (max-width: 768px) {
            .mobile-menu-toggle {
                display: flex;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .topbar {
                padding: 1rem;
            }
            
            .topbar-left {
                gap: 1rem;
            }
            
            .search-bar {
                display: none;
            }
            
            .content {
                padding: 1rem;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            
            .footer-bottom {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="app-layout">
        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" onclick="toggleSidebar()">
            <i data-lucide="menu" style="width: 20px; height: 20px;"></i>
        </button>
        
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <!-- Logo -->
            <div class="sidebar-header">
                <a href="{{ route('welcome') }}" class="logo-container">
                    <div class="logo-icon">
                        <i data-lucide="layers" style="width: 24px; height: 24px; color: white;"></i>
                    </div>
                    <div class="logo-text">
                        SmartQueue<span>AI</span>
                    </div>
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="sidebar-nav">
                <div class="nav-section">
                    <div class="nav-section-title">Principal</div>
                    <a href="{{ route('company.admin.dashboard', $company ?? null) }}" class="nav-link {{ request()->routeIs('company.admin.dashboard') ? 'active' : '' }}">
                        <i data-lucide="layout-dashboard" class="nav-icon"></i>
                        <span>Tableau de Bord</span>
                    </a>
                    <a href="{{ route('company.admin.services', $company ?? null) }}" class="nav-link {{ request()->routeIs('company.admin.services*') ? 'active' : '' }}">
                        <i data-lucide="briefcase" class="nav-icon"></i>
                        <span>Services</span>
                        <span class="nav-badge">3</span>
                    </a>
                    <a href="{{ route('company.admin.counters', $company ?? null) }}" class="nav-link {{ request()->routeIs('company.admin.counters*') ? 'active' : '' }}">
                        <i data-lucide="users" class="nav-icon"></i>
                        <span>Guichets</span>
                    </a>
                    <a href="{{ route('company.admin.agents', $company ?? null) }}" class="nav-link {{ request()->routeIs('company.admin.agents*') ? 'active' : '' }}">
                        <i data-lucide="user-check" class="nav-icon"></i>
                        <span>Agents</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Analytics</div>
                    <a href="{{ route('company.admin.statistics', $company ?? null) }}" class="nav-link {{ request()->routeIs('company.admin.statistics') ? 'active' : '' }}">
                        <i data-lucide="bar-chart-3" class="nav-icon"></i>
                        <span>Statistiques</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i data-lucide="trending-up" class="nav-icon"></i>
                        <span>Rapports</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i data-lucide="calendar" class="nav-icon"></i>
                        <span>Planning</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-section-title">Système</div>
                    <a href="#" class="nav-link">
                        <i data-lucide="settings" class="nav-icon"></i>
                        <span>Paramètres</span>
                    </a>
                    <a href="{{ route('welcome') }}" class="nav-link">
                        <i data-lucide="home" class="nav-icon"></i>
                        <span>Accueil Public</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link" style="width: 100%; text-align: left; border: none; background: none; cursor: pointer;">
                            <i data-lucide="log-out" class="nav-icon"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
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
                    <i data-lucide="more-vertical" style="width: 16px; height: 16px; color: var(--gray-400);"></i>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navigation -->
            <header class="topbar">
                <div class="topbar-left">
                    <div class="breadcrumb">
                        <a href="{{ route('company.admin.dashboard', $company ?? null) }}">Dashboard</a>
                        <span class="breadcrumb-separator">/</span>
                        <span>{{ request()->route()->getName() }}</span>
                    </div>
                    
                    <div class="search-bar">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" placeholder="Rechercher..." class="search-input">
                    </div>
                </div>
                
                <div class="topbar-right">
                    <button class="topbar-button">
                        <i data-lucide="sun" style="width: 18px; height: 18px;"></i>
                    </button>
                    
                    <button class="topbar-button">
                        <i data-lucide="bell" style="width: 18px; height: 18px;"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    
                    <button class="topbar-button">
                        <i data-lucide="settings" style="width: 18px; height: 18px;"></i>
                    </button>
                </div>
            </header>
            
            <!-- Page Content -->
            <div class="content">
                @yield('content')
            </div>
            
            <!-- Footer Premium -->
            <footer class="footer">
                <div class="footer-content">
                    <div class="footer-brand">
                        <div class="footer-logo">
                            <div class="footer-logo-icon">
                                <i data-lucide="layers" style="width: 18px; height: 18px;"></i>
                            </div>
                            SmartQueue AI
                        </div>
                        <p class="footer-description">
                            Solution intelligente de gestion de files d'attente qui transforme l'expérience client et optimise l'efficacité opérationnelle.
                        </p>
                        <div class="footer-social">
                            <a href="#" class="social-link">
                                <i data-lucide="facebook" style="width: 16px; height: 16px;"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i data-lucide="twitter" style="width: 16px; height: 16px;"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i data-lucide="linkedin" style="width: 16px; height: 16px;"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i data-lucide="instagram" style="width: 16px; height: 16px;"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="footer-section">
                        <h4>Produit</h4>
                        <div class="footer-links">
                            <a href="#" class="footer-link">Fonctionnalités</a>
                            <a href="#" class="footer-link">Tarification</a>
                            <a href="#" class="footer-link">Intégrations</a>
                            <a href="#" class="footer-link">API</a>
                        </div>
                    </div>
                    
                    <div class="footer-section">
                        <h4>Entreprise</h4>
                        <div class="footer-links">
                            <a href="#" class="footer-link">À propos</a>
                            <a href="#" class="footer-link">Carrières</a>
                            <a href="#" class="footer-link">Blog</a>
                            <a href="#" class="footer-link">Presse</a>
                        </div>
                    </div>
                    
                    <div class="footer-section">
                        <h4>Support</h4>
                        <div class="footer-links">
                            <a href="#" class="footer-link">Documentation</a>
                            <a href="#" class="footer-link">Centre d'aide</a>
                            <a href="#" class="footer-link">Contact</a>
                            <a href="#" class="footer-link">Statut</a>
                        </div>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <div>© 2024 SmartQueue AI. Tous droits réservés.</div>
                    <div class="footer-bottom-links">
                        <a href="#" class="footer-bottom-link">Confidentialité</a>
                        <a href="#" class="footer-bottom-link">Conditions</a>
                        <a href="#" class="footer-bottom-link">Cookies</a>
                    </div>
                </div>
            </footer>
        </main>
    </div>
    
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Mobile sidebar toggle
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }
        
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.mobile-menu-toggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target) && 
                sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
            }
        });
        
        // Search functionality
        const searchInput = document.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const query = this.value.trim();
                    if (query) {
                        // Implement search functionality
                        console.log('Searching for:', query);
                    }
                }
            });
        }
        
        // Notification badge animation
        const notificationBadge = document.querySelector('.notification-badge');
        if (notificationBadge) {
            setInterval(() => {
                notificationBadge.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    notificationBadge.style.transform = 'scale(1)';
                }, 200);
            }, 3000);
        }
        
        // Smooth scroll for anchor links
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
    </script>
</body>
</html>
