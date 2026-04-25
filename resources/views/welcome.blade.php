<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartQueue - Gestion Intelligente de Files d'Attente</title>
    <meta name="description" content="Solution professionnelle de gestion de files d'attente multi-tenant avec appel intelligent et suivi en temps réel.">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
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
    
    <style>
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900 bg-white">
    
    <!-- Navigation -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="w-10 h-10 hero-gradient rounded-xl flex items-center justify-center">
                        <i data-lucide="layers" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="ml-3 text-xl font-bold gradient-text">SmartQueue</span>
                </div>
                
                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-gray-900 transition">Fonctionnalités</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-gray-900 transition">Comment ça marche</a>
                    <a href="#pricing" class="text-gray-600 hover:text-gray-900 transition">Tarifs</a>
                </div>
                
                <!-- Auth Buttons -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('select-company') }}" class="text-gray-600 hover:text-gray-900 transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 transition">
                                Connexion
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="hero-gradient text-white px-6 py-2.5 rounded-full font-medium hover:opacity-90 transition shadow-lg shadow-primary-500/30">
                                    Essai Gratuit
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-primary-50/50 to-transparent"></div>
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse-slow"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse-slow" style="animation-delay: 2s;"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary-50 text-primary-700 text-sm font-medium mb-6">
                        <span class="flex h-2 w-2 rounded-full bg-primary-500 mr-2"></span>
                        Nouveau : Appel intelligent par IA
                    </div>
                    <h1 class="text-4xl lg:text-6xl font-extrabold tracking-tight mb-6">
                        Gérez vos files d'attente
                        <span class="gradient-text">intelligemment</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto lg:mx-0">
                        Solution SaaS multi-tenant pour la gestion de tickets et files d'attente. 
                        Optimisez l'expérience client avec l'appel automatique et le suivi en temps réel.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('client.ticket') }}" class="hero-gradient text-white px-8 py-4 rounded-full font-semibold hover:opacity-90 transition shadow-xl shadow-primary-500/30 inline-flex items-center justify-center">
                            <i data-lucide="ticket" class="mr-2 w-5 h-5"></i>
                            Prendre un ticket
                        </a>
                        <a href="{{ route('register') }}" class="bg-white text-gray-700 border border-gray-300 px-8 py-4 rounded-full font-semibold hover:bg-gray-50 transition inline-flex items-center justify-center">
                            <i data-lucide="store" class="mr-2 w-5 h-5 text-primary-500"></i>
                            Espace Entreprise
                        </a>
                    </div>
                    
                    <!-- Stats -->
                    <div class="mt-10 grid grid-cols-3 gap-8 border-t border-gray-100 pt-8">
                        <div>
                            <div class="text-2xl font-bold text-gray-900">50K+</div>
                            <div class="text-sm text-gray-500">Tickets/jour</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">98%</div>
                            <div class="text-sm text-gray-500">Satisfaction</div>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-gray-900">30%</div>
                            <div class="text-sm text-gray-500">Temps gagné</div>
                        </div>
                    </div>
                </div>
                
                <!-- Hero Image/Illustration -->
                <div class="relative">
                    <div class="relative bg-white rounded-2xl shadow-2xl p-6 animate-float">
                        <!-- Mock Dashboard -->
                        <div class="bg-gray-50 rounded-xl p-4 mb-4">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                </div>
                                <span class="text-xs text-gray-400">Dashboard Agent</span>
                            </div>
                            <div class="space-y-3">
                                <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                            <span class="text-primary-700 font-bold">A</span>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">A042</div>
                                            <div class="text-xs text-gray-500">Accueil Principal</div>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Appelé</span>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                            <span class="text-purple-700 font-bold">B</span>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">B015</div>
                                            <div class="text-xs text-gray-500">Service Client</div>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">En attente</span>
                                </div>
                                <div class="bg-white p-3 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                            <span class="text-orange-700 font-bold">A</span>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">A043</div>
                                            <div class="text-xs text-gray-500">Accueil Principal</div>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">En file</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-3">
                            <button class="hero-gradient text-white py-3 rounded-lg font-medium flex items-center justify-center">
                                <i data-lucide="phone-call" class="w-5 h-5 mr-2"></i>
                                Appeler Suivant
                            </button>
                            <button class="bg-gray-100 text-gray-700 py-3 rounded-lg font-medium flex items-center justify-center hover:bg-gray-200 transition">
                                <i data-lucide="pause" class="w-5 h-5 mr-2"></i>
                                Pause
                            </button>
                        </div>
                        
                        <!-- Floating Badge -->
                        <div class="absolute -top-4 -right-4 bg-white rounded-full shadow-lg p-3 animate-float" style="animation-delay: 1s;">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">Service rapide!</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-primary-600 font-semibold text-sm uppercase tracking-wide">Fonctionnalités</span>
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-2 mb-4">
                    Tout ce dont vous avez besoin
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Une suite complète d'outils pour gérer efficacement vos files d'attente et améliorer l'expérience client.
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-sm border border-gray-100 transition-all duration-300">
                    <div class="w-14 h-14 bg-primary-100 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="ticket" class="w-7 h-7 text-primary-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Gestion des Tickets</h3>
                    <p class="text-gray-600">
                        Création automatique de tickets avec numérotation intelligente par service et suivi en temps réel.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-sm border border-gray-100 transition-all duration-300">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="users" class="w-7 h-7 text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Multi-Agents</h3>
                    <p class="text-gray-600">
                        Gestion simultanée de plusieurs guichets et agents avec distribution intelligente de la charge.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-sm border border-gray-100 transition-all duration-300">
                    <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="volume-2" class="w-7 h-7 text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Appel Vocal</h3>
                    <p class="text-gray-600">
                        Annonces vocales automatiques avec synthèse vocale pour guider les clients vers leur guichet.
                    </p>
                </div>
                
                <!-- Feature 4 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-sm border border-gray-100 transition-all duration-300">
                    <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="monitor" class="w-7 h-7 text-orange-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Affichage Public</h3>
                    <p class="text-gray-600">
                        Écran d'affichage temps réel pour les salles d'attente avec liste des tickets appelés.
                    </p>
                </div>
                
                <!-- Feature 5 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-sm border border-gray-100 transition-all duration-300">
                    <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="bell" class="w-7 h-7 text-red-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Notifications</h3>
                    <p class="text-gray-600">
                        Alertes SMS et email pour informer les clients de leur tour et réduire l'absentéisme.
                    </p>
                </div>
                
                <!-- Feature 6 -->
                <div class="feature-card bg-white rounded-2xl p-8 shadow-sm border border-gray-100 transition-all duration-300">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                        <i data-lucide="bar-chart-3" class="w-7 h-7 text-blue-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Analytics</h3>
                    <p class="text-gray-600">
                        Tableaux de bord et rapports détaillés sur les temps d'attente, service et satisfaction.
                    </p>
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
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
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

    <!-- CTA Section -->
    <section class="py-20 relative overflow-hidden">
        <div class="absolute inset-0 hero-gradient"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
                Prêt à moderniser votre gestion de files d'attente ?
            </h2>
            <p class="text-white/80 text-lg mb-8 max-w-2xl mx-auto">
                Rejoignez des centaines d'entreprises qui ont déjà optimisé leur expérience client avec SmartQueue.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-primary-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition shadow-lg inline-flex items-center justify-center">
                    Démarrer gratuitement
                    <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
                </a>
                <a href="{{ route('login') }}" class="glass-effect text-white px-8 py-4 rounded-full font-semibold hover:bg-white/20 transition inline-flex items-center justify-center">
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
</body>
</html>
