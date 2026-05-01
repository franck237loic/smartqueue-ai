<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>SmartQueue - Gestion Intelligente de Files d'Attente</title>
    <meta name="description" content="Solution professionnelle de gestion de files d'attente multi-tenant avec appel intelligent et suivi en temps réel.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- STYLES IMPORTANTS POUR LA PAGE D'ACCUEIL -->
    <style>
        /* STYLES POUR S'ASSURER QUE LES EFFETS SONT VISIBLES */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
        }
        
        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }
        
        /* EFFETS DE CARTES - PLUS VISIBLES */
        .feature-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        
        .feature-card:hover {
            transform: translateY(-8px) !important;
            box-shadow: 0 25px 50px -15px rgba(0, 0, 0, 0.15) !important;
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        
        .card-hover:hover {
            transform: translateY(-10px) !important;
            box-shadow: 0 30px 60px -20px rgba(0, 0, 0, 0.2) !important;
        }
        
        /* EFFETS DE BOUTONS - PROPRES ET SANS GROSSISSEMENT */
        .btn-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        
        .btn-hover:hover {
            background-color: #f3f4f6 !important;
            border-color: #d1d5db !important;
        }
        
        .btn-hover:active {
            background-color: #e5e7eb !important;
            border-color: #9ca3af !important;
        }
        
        .hero-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
            transition: all 0.3s ease !important;
            position: relative !important;
            overflow: hidden !important;
        }
        
        .hero-btn:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 20px 40px -15px rgba(102, 126, 234, 0.4) !important;
        }
        
        /* EFFETS DE NAVIGATION */
        .nav-link {
            position: relative !important;
            transition: color 0.3s ease !important;
        }
        
        .nav-link::after {
            content: '' !important;
            position: absolute !important;
            bottom: -2px !important;
            left: 0 !important;
            width: 0 !important;
            height: 2px !important;
            background: linear-gradient(135deg, #667eea, #764ba2) !important;
            transition: width 0.3s ease !important;
        }
        
        .nav-link:hover::after {
            width: 100% !important;
        }
        
        /* ANIMATIONS */
        .animate-float {
            animation: float 6s ease-in-out infinite !important;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite !important;
        }
        
        /* TEST POUR VOIR SI LES STYLES S'APPLIQUENT */
        .test-styles {
            background: red !important;
            color: white !important;
            padding: 20px !important;
            margin: 20px !important;
            border-radius: 10px !important;
            font-size: 18px !important;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-white">
    
    <!-- ÉLÉMENT DE TEST POUR VÉRIFIER LES STYLES -->
    <div class="test-styles">TEST STYLES - Si vous voyez ce cadre rouge, les styles fonctionnent !</div>
    
    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white/95 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
            <div class="flex justify-between items-center h-14 sm:h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 hero-gradient rounded-xl flex items-center justify-center">
                        <i data-lucide="layers" class="w-4 h-4 sm:w-6 sm:h-6 text-white"></i>
                    </div>
                    <span class="ml-2 sm:ml-3 text-base sm:text-xl font-bold gradient-text">SmartQueue</span>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                    <i data-lucide="menu" class="w-5 h-5 text-gray-600"></i>
                </button>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-6 lg:space-x-8">
                    <a href="#features" class="nav-link text-gray-600 hover:text-gray-900 text-sm">Fonctionnalités</a>
                    <a href="#how-it-works" class="nav-link text-gray-600 hover:text-gray-900 text-sm">Comment ça marche</a>
                    <a href="#pricing" class="nav-link text-gray-600 hover:text-gray-900 text-sm">Tarifs</a>
                </div>

                <!-- Desktop Auth Buttons -->
                <div class="hidden md:flex items-center space-x-3 lg:space-x-4">
                    <?php if(Route::has('login')): ?>
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('select-company')); ?>" class="text-gray-600 hover:text-gray-900 transition text-sm">
                                Dashboard
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="text-gray-600 hover:text-gray-900 transition text-sm">
                                Connexion
                            </a>
                            <?php if(Route::has('register')): ?>
                                <a href="<?php echo e(route('register')); ?>" class="hero-gradient text-white px-4 lg:px-6 py-2 lg:py-2.5 rounded-full font-medium hover:opacity-90 transition shadow-lg shadow-primary-500/30 text-sm">
                                    Essai Gratuit
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-20 pb-16 sm:pt-24 sm:pb-20 md:pt-32 md:pb-20 lg:pt-40 lg:pb-32 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary-50/50 to-transparent"></div>
            <div class="absolute -top-40 -right-20 sm:-right-40 w-40 sm:w-80 h-40 sm:h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse-slow"></div>
            <div class="absolute -bottom-40 -left-20 sm:-left-40 w-40 sm:w-80 h-40 sm:h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse-slow" style="animation-delay: 2s;"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-12 items-center">
                <!-- Hero Content -->
                <div class="text-center lg:text-left order-2 lg:order-1">
                    <div class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 rounded-full bg-primary-50 text-primary-700 text-xs sm:text-sm font-medium mb-4 sm:mb-6">
                        <span class="flex h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-primary-500 mr-2"></span>
                        Nouveau : Appel IA
                    </div>
                    <h1 class="text-3xl sm:text-4xl lg:text-6xl font-extrabold tracking-tight mb-4 sm:mb-6">
                        Gérez vos files
                        <span class="gradient-text block sm:inline">intelligemment</span>
                    </h1>
                    <p class="text-sm sm:text-base md:text-lg text-gray-600 mb-4 sm:mb-6 md:mb-8 max-w-xs sm:max-w-2xl mx-auto lg:mx-0">
                        Solution SaaS pour la gestion de tickets. 
                        Optimisez l'expérience avec appel automatique.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center sm:justify-start lg:justify-start">
                        <a href="<?php echo e(route('client.ticket')); ?>" class="hero-btn text-white px-6 py-3 sm:px-8 sm:py-4 rounded-full font-semibold shadow-xl shadow-primary-500/30 inline-flex items-center justify-center text-sm sm:text-base btn-hover">
                            <i data-lucide="ticket" class="mr-2 w-4 h-4 sm:w-5 sm:h-5"></i>
                            Prendre un ticket
                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="bg-white text-gray-700 border border-gray-300 px-6 py-3 sm:px-8 sm:py-4 rounded-full font-semibold hover:bg-gray-50 hover:shadow-lg transition-all duration-300 inline-flex items-center justify-center text-sm sm:text-base btn-hover">
                            <i data-lucide="store" class="mr-2 w-4 h-4 sm:w-5 sm:h-5 text-primary-500"></i>
                            Espace Entreprise
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="mt-8 sm:mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-8 border-t border-gray-100 pt-6 sm:pt-8">
                        <div class="text-center">
                            <div class="text-xl sm:text-2xl font-bold text-gray-900">50K+</div>
                            <div class="text-xs sm:text-sm text-gray-500">Tickets/jour</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl sm:text-2xl font-bold text-gray-900">98%</div>
                            <div class="text-xs sm:text-sm text-gray-500">Satisfaction</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl sm:text-2xl font-bold text-gray-900">30%</div>
                            <div class="text-xs sm:text-sm text-gray-500">Temps gagné</div>
                        </div>
                    </div>
                </div>
                
                <!-- Hero Image/Illustration -->
                <div class="relative order-1 lg:order-2">
                    <!-- Main Hero Image -->
                    <div class="relative rounded-2xl shadow-2xl overflow-hidden animate-float max-w-md mx-auto lg:max-w-none">
                        <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600&h=400&fit=crop&crop=center&auto=format" 
                             alt="Gestion de file d'attente moderne" 
                             class="w-full h-auto object-cover"
                             loading="lazy"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="hidden items-center justify-center h-64 bg-gray-100 rounded-2xl">
                            <div class="text-center p-4">
                                <i data-lucide="image" class="w-12 h-12 text-gray-400 mx-auto mb-2"></i>
                                <p class="text-gray-500 text-sm">Image en cours de chargement...</p>
                            </div>
                        </div>
                        
                        <!-- Overlay with Mock Dashboard -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent">
                            <div class="absolute bottom-4 left-4 right-4 bg-white/90 backdrop-blur-sm rounded-xl p-3 sm:p-4">
                                <div class="flex items-center justify-between mb-2 sm:mb-3">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-green-400"></div>
                                        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-yellow-400"></div>
                                        <div class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-red-400"></div>
                                    </div>
                                    <span class="text-xs text-gray-600 font-medium">SmartQueue Live</span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between bg-white/80 rounded-lg p-2">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center">
                                                <span class="text-green-600 font-bold text-xs">A</span>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900 text-xs">A042</div>
                                                <div class="text-xs text-gray-500">Accueil</div>
                                            </div>
                                        </div>
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Appelé</span>
                                    </div>
                                    <div class="flex items-center justify-between bg-white/80 rounded-lg p-2">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center">
                                                <span class="text-purple-600 font-bold text-xs">B</span>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-gray-900 text-xs">B015</div>
                                                <div class="text-xs text-gray-500">Service</div>
                                            </div>
                                        </div>
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Attente</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-12 sm:py-16 lg:py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12 lg:mb-16">
                <span class="text-primary-600 font-semibold text-xs sm:text-sm uppercase tracking-wide">Fonctionnalités</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mt-2 mb-3 sm:mb-4">
                    Tout ce dont vous avez besoin
                </h2>
                <p class="text-gray-600 text-sm sm:text-base max-w-2xl mx-auto">
                    Une suite complète pour gérer efficacement vos files d'attente.
                </p>
            </div>
            
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                <!-- Feature 1 -->
                <div class="feature-card card-hover bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    <div class="relative h-32 sm:h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=400&h=250&fit=crop&crop=center&auto=format" 
                             alt="Gestion des tickets" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute top-4 left-4 w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i data-lucide="ticket" class="w-4 h-4 sm:w-5 sm:h-5 text-primary-600"></i>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">Gestion des Tickets</h3>
                        <p class="text-gray-600 text-sm sm:text-base">
                            Création automatique avec numérotation intelligente et suivi temps réel.
                        </p>
                    </div>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card card-hover bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    <div class="relative h-32 sm:h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=400&h=250&fit=crop&crop=center&auto=format" 
                             alt="Multi-agents" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute top-4 left-4 w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i data-lucide="users" class="w-4 h-4 sm:w-5 sm:h-5 text-purple-600"></i>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">Multi-Agents</h3>
                        <p class="text-gray-600 text-sm sm:text-base">
                            Gestion simultanée avec distribution intelligente de la charge.
                        </p>
                    </div>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card card-hover bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    <div class="relative h-32 sm:h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1592651380993-1a6497c629bd?w=400&h=250&fit=crop&crop=center&auto=format" 
                             alt="Appel vocal" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute top-4 left-4 w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i data-lucide="volume-2" class="w-4 h-4 sm:w-5 sm:h-5 text-green-600"></i>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">Appel Vocal</h3>
                        <p class="text-gray-600 text-sm sm:text-base">
                            Annonces vocales automatiques pour guider les clients.
                        </p>
                    </div>
                </div>
                
                <!-- Feature 4 -->
                <div class="feature-card card-hover bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    <div class="relative h-32 sm:h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?w=400&h=250&fit=crop&crop=center&auto=format" 
                             alt="Affichage public" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute top-4 left-4 w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i data-lucide="monitor" class="w-4 h-4 sm:w-5 sm:h-5 text-orange-600"></i>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">Affichage Public</h3>
                        <p class="text-gray-600 text-sm sm:text-base">
                            Écran temps réel pour les salles d'attente.
                        </p>
                    </div>
                </div>
                
                <!-- Feature 5 -->
                <div class="feature-card card-hover bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    <div class="relative h-32 sm:h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1611224923853-80b023f02d71?w=400&h=250&fit=crop&crop=center&auto=format" 
                             alt="Notifications" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute top-4 left-4 w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i data-lucide="bell" class="w-4 h-4 sm:w-5 sm:h-5 text-red-600"></i>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">Notifications</h3>
                        <p class="text-gray-600 text-sm sm:text-base">
                            Alertes SMS et email pour informer les clients.
                        </p>
                    </div>
                </div>
                
                <!-- Feature 6 -->
                <div class="feature-card card-hover bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100">
                    <div class="relative h-32 sm:h-40 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400&h=250&fit=crop&crop=center&auto=format" 
                             alt="Analytics" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute top-4 left-4 w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <i data-lucide="bar-chart-3" class="w-4 h-4 sm:w-5 sm:h-5 text-blue-600"></i>
                        </div>
                    </div>
                    <div class="p-4 sm:p-6">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2 sm:mb-3">Analytics</h3>
                        <p class="text-gray-600 text-sm sm:text-base">
                            Tableaux de bord et rapports sur les performances.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section id="how-it-works" class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary-600 font-semibold text-sm uppercase tracking-wide">Processus</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-2 mb-4">
                    Comment ça marche
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Un processus simple et efficace en 4 étapes pour une gestion optimale de vos files d'attente.
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-primary-100 rounded-2xl flex items-center justify-center mb-6 relative">
                        <span class="absolute -top-3 -right-3 w-8 h-8 hero-gradient rounded-full flex items-center justify-center text-white font-bold text-sm">1</span>
                        <i data-lucide="smartphone" class="w-10 h-10 text-primary-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Le client prend un ticket</h3>
                    <p class="text-gray-600 text-sm">
                        Via borne, QR code ou application web avec choix du service.
                    </p>
                </div>
                
                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-purple-100 rounded-2xl flex items-center justify-center mb-6 relative">
                        <span class="absolute -top-3 -right-3 w-8 h-8 hero-gradient rounded-full flex items-center justify-center text-white font-bold text-sm">2</span>
                        <i data-lucide="clock" class="w-10 h-10 text-purple-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Attente intelligente</h3>
                    <p class="text-gray-600 text-sm">
                        Le client suit sa position en temps réel sur l'écran ou son téléphone.
                    </p>
                </div>
                
                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-green-100 rounded-2xl flex items-center justify-center mb-6 relative">
                        <span class="absolute -top-3 -right-3 w-8 h-8 hero-gradient rounded-full flex items-center justify-center text-white font-bold text-sm">3</span>
                        <i data-lucide="phone-call" class="w-10 h-10 text-green-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Appel automatique</h3>
                    <p class="text-gray-600 text-sm">
                        L'agent appelle le prochain ticket avec annonce vocale et affichage.
                    </p>
                </div>
                
                <!-- Step 4 -->
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto bg-orange-100 rounded-2xl flex items-center justify-center mb-6 relative">
                        <span class="absolute -top-3 -right-3 w-8 h-8 hero-gradient rounded-full flex items-center justify-center text-white font-bold text-sm">4</span>
                        <i data-lucide="check-circle" class="w-10 h-10 text-orange-600"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Service terminé</h3>
                    <p class="text-gray-600 text-sm">
                        L'agent marque le ticket comme servi et passe au suivant.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-br from-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 sm:mb-12 lg:mb-16">
                <span class="text-primary-600 font-semibold text-xs sm:text-sm uppercase tracking-wide">Témoignages</span>
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mt-2 mb-3 sm:mb-4">
                    Ce que nos clients disent
                </h2>
                <p class="text-gray-600 text-sm sm:text-base max-w-2xl mx-auto">
                    Découvrez comment SmartQueue transforme l'expérience de nos clients.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Testimonial 1 -->
                <div class="card-hover bg-white rounded-2xl shadow-lg p-6 sm:p-8 relative">
                    <div class="absolute top-4 right-4 text-primary-200">
                        <i data-lucide="quote" class="w-8 h-8 sm:w-10 sm:h-10"></i>
                    </div>
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=60&h=60&fit=crop&crop=face&auto=format" 
                             alt="Client 1" 
                             class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover mr-4">
                        <div>
                            <div class="font-semibold text-gray-900">Jean Dupont</div>
                            <div class="text-sm text-gray-500">Directeur, Banque Central</div>
                        </div>
                    </div>
                    <div class="flex mb-3">
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                    </div>
                    <p class="text-gray-600 text-sm sm:text-base">
                        "SmartQueue a révolutionné notre gestion des files d'attente. Le temps d'attente moyen a diminué de 60% et nos clients sont beaucoup plus satisfaits."
                    </p>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="card-hover bg-white rounded-2xl shadow-lg p-6 sm:p-8 relative">
                    <div class="absolute top-4 right-4 text-purple-200">
                        <i data-lucide="quote" class="w-8 h-8 sm:w-10 sm:h-10"></i>
                    </div>
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b332c1ca?w=60&h=60&fit=crop&crop=face&auto=format" 
                             alt="Client 2" 
                             class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover mr-4">
                        <div>
                            <div class="font-semibold text-gray-900">Marie Martin</div>
                            <div class="text-sm text-gray-500">Responsable, Hôpital Ville</div>
                        </div>
                    </div>
                    <div class="flex mb-3">
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                    </div>
                    <p class="text-gray-600 text-sm sm:text-base">
                        "Un système simple et efficace. Nos patients apprécient le suivi en temps réel et le personnel est moins stressé. Vraiment recommandé !"
                    </p>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="card-hover bg-white rounded-2xl shadow-lg p-6 sm:p-8 relative">
                    <div class="absolute top-4 right-4 text-green-200">
                        <i data-lucide="quote" class="w-8 h-8 sm:w-10 sm:h-10"></i>
                    </div>
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&h=60&fit=crop&crop=face&auto=format" 
                             alt="Client 3" 
                             class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover mr-4">
                        <div>
                            <div class="font-semibold text-gray-900">Ahmed Koné</div>
                            <div class="text-sm text-gray-500">Manager, Service Client</div>
                        </div>
                    </div>
                    <div class="flex mb-3">
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                        <i data-lucide="star" class="w-4 h-4 text-yellow-400 fill-current"></i>
                    </div>
                    <p class="text-gray-600 text-sm sm:text-base">
                        "L'interface est intuitive et les fonctionnalités sont exactly ce dont nous avions besoin. Le support client est également excellent."
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 relative overflow-hidden">
        <div class="absolute inset-0 hero-gradient"></div>
        <div class="relative max-w-2xl sm:max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
                Prêt à moderniser votre gestion de files d'attente ?
            </h2>
            <p class="text-white/80 text-lg mb-8 max-w-2xl mx-auto">
                Rejoignez des centaines d'entreprises qui ont déjà optimisé leur expérience client avec SmartQueue.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo e(route('register')); ?>" class="bg-white text-primary-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition shadow-lg inline-flex items-center justify-center">
                    Démarrer gratuitement
                    <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
                </a>
                <a href="<?php echo e(route('login')); ?>" class="glass-effect text-white px-8 py-4 rounded-full font-semibold hover:bg-white/20 transition inline-flex items-center justify-center">
                    Connexion
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-2">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 hero-gradient rounded-lg flex items-center justify-center">
                            <i data-lucide="layers" class="w-5 h-5 text-white"></i>
                        </div>
                        <span class="ml-2 text-lg font-bold">SmartQueue</span>
                    </div>
                    <p class="text-gray-400 text-sm max-w-xs">
                        Solution professionnelle de gestion de files d'attente pour entreprises et administrations.
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Produit</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#features" class="hover:text-white transition">Fonctionnalités</a></li>
                        <li><a href="#pricing" class="hover:text-white transition">Tarifs</a></li>
                        <li><a href="#" class="hover:text-white transition">Documentation</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Centre d'aide</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">API</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    © 2026 SmartQueue. Tous droits réservés. realiser par ghomsi franck
                </p>
                <div class="flex space-x-4 mt-4 md:mt-0">
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i data-lucide="twitter" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i data-lucide="linkedin" class="w-5 h-5"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition">
                        <i data-lucide="github" class="w-5 h-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Initialize Lucide Icons -->
    <script>
        if (window.lucide) {
            window.lucide.createIcons({ icons: window.lucide.icons });
        }
    </script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // Mobile menu functionality
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const closeMobileMenuBtn = document.getElementById('close-mobile-menu');
        
        function openMobileMenu() {
            mobileMenu.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeMobileMenu() {
            mobileMenu.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        mobileMenuBtn?.addEventListener('click', openMobileMenu);
        closeMobileMenuBtn?.addEventListener('click', closeMobileMenu);
        
        // Close menu when clicking on links
        const mobileLinks = mobileMenu?.querySelectorAll('a');
        mobileLinks?.forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });
        
        // Close menu when clicking outside
        mobileMenu?.addEventListener('click', (e) => {
            if (e.target === mobileMenu) {
                closeMobileMenu();
            }
        });
        
        // Handle escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !mobileMenu?.classList.contains('hidden')) {
                closeMobileMenu();
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\welcome.blade.php ENDPATH**/ ?>