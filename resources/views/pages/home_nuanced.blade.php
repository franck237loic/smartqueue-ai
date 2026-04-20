<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartQueue AI - Gestion de File d'Attente Intelligente</title>
    
    <!-- CSS Nuancé et Professionnel -->
    <style>
        /* Reset et styles de base */
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #2c3e50;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        
        /* Layout */
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .text-center { text-align: center; }
        .space-x-4 > * + * { margin-left: 1rem; }
        .space-x-6 > * + * { margin-left: 1.5rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        
        /* Espacement */
        .max-w-7xl { max-width: 80rem; margin-left: auto; margin-right: auto; }
        .max-w-2xl { max-width: 42rem; margin-left: auto; margin-right: auto; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-20 { padding-top: 5rem; padding-bottom: 5rem; }
        .py-16 { padding-top: 4rem; padding-bottom: 4rem; }
        .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
        .py-8 { padding-top: 2rem; padding-bottom: 2rem; }
        .py-6 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
        .py-4 { padding-top: 1rem; padding-bottom: 1rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .px-8 { padding-left: 2rem; padding-right: 2rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        .mb-12 { margin-bottom: 3rem; }
        .mb-16 { margin-bottom: 4rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mt-8 { margin-top: 2rem; }
        .ml-3 { margin-left: 0.75rem; }
        .mr-3 { margin-right: 0.75rem; }
        
        /* Typographie */
        .text-4xl { font-size: 2.25rem; line-height: 2.5rem; font-weight: 700; }
        .text-5xl { font-size: 3rem; line-height: 1; font-weight: 800; }
        .text-xl { font-size: 1.25rem; line-height: 1.75rem; font-weight: 400; }
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; font-weight: 500; }
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; font-weight: 400; }
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; font-weight: 700; }
        .text-2xl { font-size: 1.5rem; line-height: 2rem; font-weight: 600; }
        .font-bold { font-weight: 700; }
        .font-semibold { font-weight: 600; }
        .font-medium { font-weight: 500; }
        .font-light { font-weight: 300; }
        
        /* Palette de couleurs nuancées */
        .bg-white { background-color: #ffffff; }
        .bg-cream { background-color: #fafaf9; }
        .bg-soft-gray { background-color: #f8f9fa; }
        .bg-warm-gray { background-color: #f1f3f4; }
        .bg-cool-gray { background-color: #e8eaed; }
        .bg-slate-50 { background-color: #f8fafc; }
        .bg-slate-100 { background-color: #f1f5f9; }
        .bg-slate-900 { background-color: #0f172a; }
        .bg-slate-800 { background-color: #1e293b; }
        
        /* Bleus nuancés (plus doux) */
        .bg-sky-blue { background-color: #87ceeb; }
        .bg-soft-blue { background-color: #6495ed; }
        .bg-cornflower { background-color: #6495ed; }
        .bg-powder-blue { background-color: #b0e0e6; }
        .bg-light-blue { background-color: #add8e6; }
        .bg-deep-sky { background-color: #1e90ff; }
        .bg-steel-blue { background-color: #4682b4; }
        .bg-midnight-blue { background-color: #191970; }
        
        /* Couleurs de texte nuancées */
        .text-white { color: #ffffff; }
        .text-charcoal { color: #36454f; }
        .text-dark-gray { color: #2c3e50; }
        .text-medium-gray { color: #7f8c8d; }
        .text-light-gray { color: #95a5a6; }
        .text-slate-400 { color: #94a3b8; }
        .text-slate-500 { color: #64748b; }
        .text-slate-600 { color: #475569; }
        .text-slate-700 { color: #334155; }
        .text-slate-800 { color: #1e293b; }
        .text-slate-900 { color: #0f172a; }
        
        /* Bleus de texte nuancés */
        .text-sky-blue { color: #87ceeb; }
        .text-soft-blue { color: #6495ed; }
        .text-deep-sky { color: #1e90ff; }
        .text-steel-blue { color: #4682b4; }
        
        /* Bordures nuancées */
        .border-soft-gray { border: 1px solid #e8eaed; }
        .border-warm-gray { border: 1px solid #f1f3f4; }
        .border-cool-gray { border: 1px solid #dadce0; }
        .border-slate-200 { border: 1px solid #e2e8f0; }
        .border-slate-300 { border: 1px solid #cbd5e1; }
        .border-2 { border: 2px solid #6495ed; }
        .border { border: 1px solid #e8eaed; }
        
        /* Arrondis */
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-xl { border-radius: 0.75rem; }
        .rounded-2xl { border-radius: 1rem; }
        .rounded-3xl { border-radius: 1.5rem; }
        .rounded-full { border-radius: 9999px; }
        
        /* Ombres douces */
        .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
        .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .shadow-xl { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
        
        /* Transitions douces */
        .transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .transition-colors { transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease; }
        .transition-transform { transition: transform 0.3s ease; }
        
        /* Hover states nuancés */
        .hover\:bg-cream:hover { background-color: #fafaf9; }
        .hover\:bg-soft-gray:hover { background-color: #f8f9fa; }
        .hover\:bg-warm-gray:hover { background-color: #f1f3f4; }
        .hover\:bg-powder-blue:hover { background-color: #b0e0e6; }
        .hover\:bg-soft-blue:hover { background-color: #5a9fd4; }
        .hover\:bg-deep-sky:hover { background-color: #1e7fc7; }
        .hover\:text-soft-blue:hover { color: #5a9fd4; }
        .hover\:text-deep-sky:hover { color: #1e7fc7; }
        .hover\:shadow-xl:hover { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .hover\:shadow-2xl:hover { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); }
        .hover\:scale-105:hover { transform: scale(1.05); }
        .hover\:translate-y-1:hover { transform: translateY(-0.25rem); }
        
        /* Positionnement */
        .sticky { position: sticky; }
        .top-0 { top: 0; }
        .z-50 { z-index: 50; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        
        /* Dimensions */
        .w-8 { width: 2rem; }
        .h-8 { height: 2rem; }
        .h-16 { height: 4rem; }
        .w-12 { width: 3rem; }
        .h-12 { height: 3rem; }
        .w-6 { width: 1.5rem; }
        .h-6 { height: 1.5rem; }
        .w-16 { width: 4rem; }
        .h-16 { height: 4rem; }
        .w-20 { width: 5rem; }
        .h-20 { height: 5rem; }
        
        /* Flex */
        .flex-col { flex-direction: column; }
        .flex-1 { flex: 1 1 0%; }
        
        /* Grid */
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .gap-6 { gap: 1.5rem; }
        .gap-8 { gap: 2rem; }
        .gap-4 { gap: 1rem; }
        
        /* Responsive */
        @media (min-width: 640px) {
            .sm\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        }
        
        @media (min-width: 768px) {
            .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .md\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .md\:text-5xl { font-size: 3rem; line-height: 1; }
            .md\:flex-row { flex-direction: row; }
            .md\:mb-0 { margin-bottom: 0; }
        }
        
        @media (min-width: 1024px) {
            .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .lg\:px-8 { padding-left: 2rem; padding-right: 2rem; }
        }
        
        /* Gradients nuancés */
        .bg-gradient-to-br { background-image: linear-gradient(to bottom right, var(--tw-gradient-stops)); }
        .from-soft-blue { --tw-gradient-from: #6495ed; }
        .to-steel-blue { --tw-gradient-to: #4682b4; }
        .from-cream { --tw-gradient-from: #fafaf9; }
        .to-soft-gray { --tw-gradient-to: #f8f9fa; }
        .from-powder-blue { --tw-gradient-from: #b0e0e6; }
        .to-soft-blue { --tw-gradient-to: #6495ed; }
        
        /* Curseur */
        .cursor-pointer { cursor: pointer; }
        
        /* Badge */
        .inline-flex { display: inline-flex; }
        .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
        .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
        .text-xs { font-size: 0.75rem; line-height: 1rem; }
        .font-medium { font-weight: 500; }
        
        /* Animations douces */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        /* Glassmorphism doux */
        .glass-soft {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        /* Card nuancé */
        .nuanced-card {
            background: linear-gradient(135deg, #ffffff 0%, #fafaf9 100%);
            border: 1px solid rgba(232, 234, 237, 0.8);
            position: relative;
            overflow: hidden;
        }
        
        .nuanced-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #6495ed, #4682b4, #87ceeb);
            border-radius: 3px 3px 0 0;
        }
        
        /* Bouton nuancé */
        .nuanced-btn {
            background: linear-gradient(135deg, #6495ed, #4682b4);
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .nuanced-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.6s;
        }
        
        .nuanced-btn:hover::before {
            left: 100%;
        }
    </style>
</head>
<body>
    <!-- Header Nuancé -->
    <nav class="glass-soft sticky top-0 z-50 shadow-lg">
        <div class="max-w-7xl px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="flex items-center group">
                        <div class="w-10 h-10 bg-gradient-to-br from-soft-blue to-steel-blue rounded-xl flex items-center justify-center shadow-md group-hover:shadow-xl transition-all">
                            <span class="text-white font-bold text-sm">SQ</span>
                        </div>
                        <span class="ml-3 font-bold text-xl text-dark-gray group-hover:text-soft-blue transition-colors">SmartQueue AI</span>
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('companies.index') }}" class="px-4 py-2 text-medium-gray rounded-lg hover:bg-cream transition font-medium text-sm cursor-pointer flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Entreprises
                    </a>
                    <a href="{{ route('login') }}" onclick="window.location.href='{{ route('login') }}'; return false;" class="nuanced-btn px-6 py-2 text-white rounded-xl hover:bg-soft-blue transition font-medium text-sm cursor-pointer shadow-md hover:shadow-xl">
                        Connexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section Nuancé -->
    <div class="bg-gradient-to-br from-soft-blue to-steel-blue text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-8"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full -mr-48 -mt-48"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full -ml-32 -mb-32"></div>
        
        <div class="max-w-7xl px-4 py-20 relative z-10">
            <div class="text-center animate-fade-in">
                <div class="inline-flex items-center px-4 py-2 bg-white bg-opacity-15 rounded-full text-sm font-medium mb-6 backdrop-filter backdrop-blur-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Solution de pointe
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Gestion Intelligente de File d'Attente</h1>
                <p class="text-xl text-powder-blue max-w-2xl mx-auto mb-8 font-light">
                    Simplifiez l'accueil de vos clients avec notre solution SaaS multi-entreprises. 
                    Tickets digitaux, appels automatiques, notifications en temps réel.
                </p>
                <div class="flex justify-center space-x-4">
                    <div class="flex items-center text-powder-blue">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Fiable
                    </div>
                    <div class="flex items-center text-powder-blue">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Rapide
                    </div>
                    <div class="flex items-center text-powder-blue">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </svg>
                        Intelligent
                    </div>
                </div>
                <div class="flex justify-center space-x-4 mt-8">
                    <a href="{{ route('login') }}" onclick="window.location.href='{{ route('login') }}'; return false;" class="nuanced-btn px-8 py-3 text-white rounded-xl hover:bg-soft-blue transition font-semibold text-lg cursor-pointer shadow-md hover:shadow-xl">
                        Accès Dashboard
                    </a>
                    <a href="{{ route('companies.index') }}" class="px-8 py-3 bg-white bg-opacity-20 text-white rounded-xl hover:bg-opacity-30 transition font-semibold text-lg cursor-pointer backdrop-filter backdrop-blur-sm">
                        Découvrir
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Companies Section Nuancée -->
    <div id="entreprises" class="max-w-7xl px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-dark-gray mb-4">Découvrez Nos Entreprises Partenaires</h2>
            <p class="text-medium-gray max-w-2xl mx-auto mb-8 font-medium">
                Plusieurs entreprises utilisent déjà SmartQueue AI pour optimiser leur gestion de files d'attente. 
                Cliquez ci-dessous pour découvrir toutes les entreprises disponibles et prendre un ticket.
            </p>
            <div class="flex justify-center">
                <a href="{{ route('companies.index') }}" onclick="window.location.href='{{ route('companies.index') }}'; return false;" class="nuanced-btn px-8 py-4 text-white rounded-xl hover:bg-soft-blue transition font-semibold text-lg cursor-pointer inline-flex items-center shadow-md hover:shadow-xl">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Voir les entreprises disponibles
                </a>
            </div>
        </div>

        <!-- Features Preview Nuancé -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
            <div class="nuanced-card p-6 rounded-2xl hover:bg-warm-gray transition-colors hover:shadow-xl animate-fade-in" style="animation-delay: 0.1s">
                <div class="w-12 h-12 bg-gradient-to-br from-powder-blue to-soft-blue rounded-xl flex items-center justify-center mb-4 shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2 text-dark-gray">Tickets Digitaux</h3>
                <p class="text-medium-gray text-sm">Prise de ticket simplifiée via QR code ou application web.</p>
            </div>
            <div class="nuanced-card p-6 rounded-2xl hover:bg-warm-gray transition-colors hover:shadow-xl animate-fade-in" style="animation-delay: 0.2s">
                <div class="w-12 h-12 bg-gradient-to-br from-powder-blue to-soft-blue rounded-xl flex items-center justify-center mb-4 shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2 text-dark-gray">Appel Vocal</h3>
                <p class="text-medium-gray text-sm">Synthèse vocale automatique pour guider les clients.</p>
            </div>
            <div class="nuanced-card p-6 rounded-2xl hover:bg-warm-gray transition-colors hover:shadow-xl animate-fade-in" style="animation-delay: 0.3s">
                <div class="w-12 h-12 bg-gradient-to-br from-powder-blue to-soft-blue rounded-xl flex items-center justify-center mb-4 shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2 text-dark-gray">Statistiques</h3>
                <p class="text-medium-gray text-sm">Tableaux de bord en temps réel et rapports détaillés.</p>
            </div>
        </div>
    </div>

    <!-- Footer Nuancé -->
    <footer class="bg-charcoal text-white py-16 mt-16">
        <div class="max-w-7xl px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-soft-blue to-steel-blue rounded-xl flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">SQ</span>
                        </div>
                        <span class="ml-3 font-bold text-2xl">SmartQueue AI</span>
                    </div>
                    <p class="text-light-gray leading-relaxed max-w-md">
                        Solution intelligente de gestion de files d'attente pour les entreprises modernes. 
                        Optimisez l'expérience client avec notre technologie de pointe.
                    </p>
                    <div class="flex space-x-4 mt-6">
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-slate-700 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-slate-700 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-slate-700 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-semibold text-lg mb-6">Produits</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-light-gray hover:text-white transition">Tickets Digitaux</a></li>
                        <li><a href="#" class="text-light-gray hover:text-white transition">Appel Vocal</a></li>
                        <li><a href="#" class="text-light-gray hover:text-white transition">Statistiques</a></li>
                        <li><a href="#" class="text-light-gray hover:text-white transition">API</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold text-lg mb-6">Support</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-light-gray hover:text-white transition">Documentation</a></li>
                        <li><a href="#" class="text-light-gray hover:text-white transition">Centre d'aide</a></li>
                        <li><a href="#" class="text-light-gray hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="text-light-gray hover:text-white transition">Statut du service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-slate-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-light-gray text-sm">© 2026 SmartQueue AI. Tous droits réservés.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-light-gray hover:text-white transition text-sm">Confidentialité</a>
                        <a href="#" class="text-light-gray hover:text-white transition text-sm">Conditions</a>
                        <a href="#" class="text-light-gray hover:text-white transition text-sm">Cookies</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
