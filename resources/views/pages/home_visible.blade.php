<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartQueue AI - Gestion de File d'Attente Intelligente</title>
    
    <!-- CSS avec couleurs visibles et contrastées -->
    <style>
        /* Reset et styles de base */
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #1a202c;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        
        /* Palette de couleurs VISIBLES et contrastées */
        .bg-white { background-color: #ffffff; }
        .bg-purple { background-color: #805ad5; }
        .bg-indigo { background-color: #667eea; }
        .bg-pink { background-color: #ed64a6; }
        .bg-blue { background-color: #4299e1; }
        .bg-green { background-color: #48bb78; }
        .bg-yellow { background-color: #ecc94b; }
        .bg-red { background-color: #f56565; }
        .bg-orange { background-color: #ed8936; }
        .bg-teal { background-color: #38b2ac; }
        .bg-cyan { background-color: #0bc5ea; }
        .bg-lime { background-color: #84cc16; }
        .bg-emerald { background-color: #48bb78; }
        .bg-violet { background-color: #805ad5; }
        .bg-fuchsia { background-color: #d53f8c; }
        .bg-rose { background-color: #f43f5e; }
        .bg-sky { background-color: #0ea5e9; }
        .bg-amber { background-color: #f59e0b; }
        .bg-gray-50 { background-color: #f9fafb; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-gray-800 { background-color: #1f2937; }
        .bg-gray-900 { background-color: #111827; }
        
        /* Couleurs de texte VISIBLES */
        .text-white { color: #ffffff; }
        .text-black { color: #000000; }
        .text-gray-900 { color: #111827; }
        .text-gray-800 { color: #1f2937; }
        .text-gray-700 { color: #374151; }
        .text-gray-600 { color: #4b5563; }
        .text-gray-500 { color: #6b7280; }
        .text-purple { color: #805ad5; }
        .text-indigo { color: #667eea; }
        .text-pink { color: #ed64a6; }
        .text-blue { color: #4299e1; }
        .text-green { color: #48bb78; }
        .text-yellow { color: #ecc94b; }
        .text-red { color: #f56565; }
        .text-orange { color: #ed8936; }
        .text-teal { color: #38b2ac; }
        .text-cyan { color: #0bc5ea; }
        .text-lime { color: #84cc16; }
        .text-emerald { color: #48bb78; }
        .text-violet { color: #805ad5; }
        .text-fuchsia { color: #d53f8c; }
        .text-rose { color: #f43f5e; }
        .text-sky { color: #0ea5e9; }
        .text-amber { color: #f59e0b; }
        
        /* Bordures visibles */
        .border-white { border: 2px solid #ffffff; }
        .border-purple { border: 2px solid #805ad5; }
        .border-indigo { border: 2px solid #667eea; }
        .border-pink { border: 2px solid #ed64a6; }
        .border-blue { border: 2px solid #4299e1; }
        .border-green { border: 2px solid #48bb78; }
        .border-yellow { border: 2px solid #ecc94b; }
        .border-red { border: 2px solid #f56565; }
        .border-orange { border: 2px solid #ed8936; }
        .border-gray { border: 2px solid #e5e7eb; }
        
        /* Arrondis */
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-xl { border-radius: 0.75rem; }
        .rounded-2xl { border-radius: 1rem; }
        .rounded-3xl { border-radius: 1.5rem; }
        .rounded-full { border-radius: 9999px; }
        
        /* Ombres visibles */
        .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); }
        .shadow-md { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); }
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        .shadow-xl { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
        .shadow-purple { box-shadow: 0 10px 25px -5px rgba(128, 90, 213, 0.25); }
        .shadow-indigo { box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.25); }
        .shadow-pink { box-shadow: 0 10px 25px -5px rgba(237, 100, 166, 0.25); }
        .shadow-blue { box-shadow: 0 10px 25px -5px rgba(66, 153, 225, 0.25); }
        .shadow-green { box-shadow: 0 10px 25px -5px rgba(72, 187, 120, 0.25); }
        .shadow-yellow { box-shadow: 0 10px 25px -5px rgba(236, 201, 75, 0.25); }
        .shadow-red { box-shadow: 0 10px 25px -5px rgba(245, 101, 101, 0.25); }
        .shadow-orange { box-shadow: 0 10px 25px -5px rgba(237, 137, 54, 0.25); }
        
        /* Transitions */
        .transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .transition-colors { transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease; }
        .transition-transform { transition: transform 0.3s ease; }
        
        /* Hover states visibles */
        .hover\:bg-purple:hover { background-color: #6b46c1; }
        .hover\:bg-indigo:hover { background-color: #5a67d8; }
        .hover\:bg-pink:hover { background-color: #d53f8c; }
        .hover\:bg-blue:hover { background-color: #3182ce; }
        .hover\:bg-green:hover { background-color: #38a169; }
        .hover\:bg-yellow:hover { background-color: #d69e2e; }
        .hover\:bg-red:hover { background-color: #e53e3e; }
        .hover\:bg-orange:hover { background-color: #dd6b20; }
        .hover\:bg-white:hover { background-color: #f7fafc; }
        .hover\:bg-gray-100:hover { background-color: #e5e7eb; }
        .hover\:text-purple:hover { color: #6b46c1; }
        .hover\:text-indigo:hover { color: #5a67d8; }
        .hover\:text-pink:hover { color: #d53f8c; }
        .hover\:text-blue:hover { color: #3182ce; }
        .hover\:text-green:hover { color: #38a169; }
        .hover\:text-yellow:hover { color: #d69e2e; }
        .hover\:text-red:hover { color: #e53e3e; }
        .hover\:text-orange:hover { color: #dd6b20; }
        .hover\:shadow-xl:hover { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); }
        .hover\:shadow-2xl:hover { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); }
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
        
        /* Gradients visibles */
        .bg-gradient-to-br { background-image: linear-gradient(to bottom right, var(--tw-gradient-stops)); }
        .from-purple { --tw-gradient-from: #805ad5; }
        .to-pink { --tw-gradient-to: #ed64a6; }
        .from-indigo { --tw-gradient-from: #667eea; }
        .to-blue { --tw-gradient-to: #4299e1; }
        .from-green { --tw-gradient-from: #48bb78; }
        .to-teal { --tw-gradient-to: #38b2ac; }
        .from-yellow { --tw-gradient-from: #ecc94b; }
        .to-orange { --tw-gradient-to: #ed8936; }
        .from-red { --tw-gradient-from: #f56565; }
        .to-rose { --tw-gradient-to: #f43f5e; }
        
        /* Curseur */
        .cursor-pointer { cursor: pointer; }
        
        /* Badge */
        .inline-flex { display: inline-flex; }
        .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
        .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
        .text-xs { font-size: 0.75rem; line-height: 1rem; }
        .font-medium { font-weight: 500; }
        
        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        .animate-pulse {
            animation: pulse 2s infinite;
        }
        
        .animate-bounce {
            animation: bounce 2s infinite;
        }
        
        /* Cartes colorées */
        .card-purple {
            background: linear-gradient(135deg, #805ad5 0%, #6b46c1 100%);
            border: 2px solid #805ad5;
        }
        
        .card-indigo {
            background: linear-gradient(135deg, #667eea 0%, #5a67d8 100%);
            border: 2px solid #667eea;
        }
        
        .card-pink {
            background: linear-gradient(135deg, #ed64a6 0%, #d53f8c 100%);
            border: 2px solid #ed64a6;
        }
        
        .card-blue {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            border: 2px solid #4299e1;
        }
        
        .card-green {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border: 2px solid #48bb78;
        }
        
        .card-yellow {
            background: linear-gradient(135deg, #ecc94b 0%, #d69e2e 100%);
            border: 2px solid #ecc94b;
        }
        
        .card-red {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            border: 2px solid #f56565;
        }
        
        .card-orange {
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
            border: 2px solid #ed8936;
        }
        
        .card-teal {
            background: linear-gradient(135deg, #38b2ac 0%, #319795 100%);
            border: 2px solid #38b2ac;
        }
        
        /* Boutons colorés */
        .btn-purple {
            background: linear-gradient(135deg, #805ad5, #6b46c1);
            color: white;
            border: 2px solid #805ad5;
        }
        
        .btn-indigo {
            background: linear-gradient(135deg, #667eea, #5a67d8);
            color: white;
            border: 2px solid #667eea;
        }
        
        .btn-pink {
            background: linear-gradient(135deg, #ed64a6, #d53f8c);
            color: white;
            border: 2px solid #ed64a6;
        }
        
        .btn-blue {
            background: linear-gradient(135deg, #4299e1, #3182ce);
            color: white;
            border: 2px solid #4299e1;
        }
        
        .btn-green {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            border: 2px solid #48bb78;
        }
        
        .btn-yellow {
            background: linear-gradient(135deg, #ecc94b, #d69e2e);
            color: #1a202c;
            border: 2px solid #ecc94b;
        }
        
        .btn-red {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            color: white;
            border: 2px solid #f56565;
        }
        
        .btn-orange {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
            color: white;
            border: 2px solid #ed8936;
        }
        
        .btn-teal {
            background: linear-gradient(135deg, #38b2ac, #319795);
            color: white;
            border: 2px solid #38b2ac;
        }
    </style>
</head>
<body>
    <!-- Header Coloré -->
    <nav class="bg-white sticky top-0 z-50 shadow-lg border-purple">
        <div class="max-w-7xl px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('welcome') }}" class="flex items-center group">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple to-pink rounded-xl flex items-center justify-center shadow-purple group-hover:shadow-xl transition-all animate-pulse">
                            <span class="text-white font-bold text-sm">SQ</span>
                        </div>
                        <span class="ml-3 font-bold text-xl text-purple group-hover:text-pink transition-colors">SmartQueue AI</span>
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ route('companies.index') }}" class="px-4 py-2 text-indigo rounded-lg hover:bg-purple hover:text-white transition font-medium text-sm cursor-pointer flex items-center border-indigo">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Entreprises
                    </a>
                    <a href="{{ route('login') }}" onclick="window.location.href='{{ route('login') }}'; return false;" class="btn-purple px-6 py-2 rounded-xl hover:bg-indigo transition font-medium text-sm cursor-pointer shadow-purple hover:shadow-xl">
                        Connexion
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section Coloré -->
    <div class="bg-gradient-to-br from-indigo to-blue text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-yellow opacity-20 rounded-full -mr-48 -mt-48 animate-bounce"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-pink opacity-20 rounded-full -ml-32 -mb-32 animate-pulse"></div>
        
        <div class="max-w-7xl px-4 py-20 relative z-10">
            <div class="text-center animate-fade-in">
                <div class="inline-flex items-center px-4 py-2 bg-white bg-opacity-25 rounded-full text-sm font-medium mb-6 backdrop-filter backdrop-blur-sm border-yellow">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Solution de pointe
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mb-6 text-yellow">Gestion Intelligente de File d'Attente</h1>
                <p class="text-xl text-white max-w-2xl mx-auto mb-8 font-light">
                    Simplifiez l'accueil de vos clients avec notre solution SaaS multi-entreprises. 
                    Tickets digitaux, appels automatiques, notifications en temps réel.
                </p>
                <div class="flex justify-center space-x-4 mb-8">
                    <div class="flex items-center text-green bg-white bg-opacity-20 px-4 py-2 rounded-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Fiable
                    </div>
                    <div class="flex items-center text-orange bg-white bg-opacity-20 px-4 py-2 rounded-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Rapide
                    </div>
                    <div class="flex items-center text-red bg-white bg-opacity-20 px-4 py-2 rounded-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Intelligent
                    </div>
                </div>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('login') }}" onclick="window.location.href='{{ route('login') }}'; return false;" class="btn-indigo px-8 py-3 rounded-xl hover:bg-purple transition font-semibold text-lg cursor-pointer shadow-indigo hover:shadow-xl animate-bounce">
                        Accès Dashboard
                    </a>
                    <a href="{{ route('companies.index') }}" class="px-8 py-3 bg-white bg-opacity-30 text-white rounded-xl hover:bg-opacity-40 transition font-semibold text-lg cursor-pointer backdrop-filter backdrop-blur-sm border-yellow">
                        Découvrir
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Companies Section Colorée -->
    <div id="entreprises" class="max-w-7xl px-4 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-purple mb-4">Découvrez Nos Entreprises Partenaires</h2>
            <p class="text-gray-700 max-w-2xl mx-auto mb-8 font-medium">
                Plusieurs entreprises utilisent déjà SmartQueue AI pour optimiser leur gestion de files d'attente. 
                Cliquez ci-dessous pour découvrir toutes les entreprises disponibles et prendre un ticket.
            </p>
            <div class="flex justify-center">
                <a href="{{ route('companies.index') }}" onclick="window.location.href='{{ route('companies.index') }}'; return false;" class="btn-pink px-8 py-4 rounded-xl hover:bg-red transition font-semibold text-lg cursor-pointer inline-flex items-center shadow-pink hover:shadow-xl animate-pulse">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Voir les entreprises disponibles
                </a>
            </div>
        </div>

        <!-- Features Preview Coloré -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
            <div class="card-purple p-6 rounded-2xl hover:bg-indigo transition-colors hover:shadow-xl animate-fade-in" style="animation-delay: 0.1s">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow to-orange rounded-xl flex items-center justify-center mb-4 shadow-yellow">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2 text-yellow">Tickets Digitaux</h3>
                <p class="text-white text-sm">Prise de ticket simplifiée via QR code ou application web.</p>
            </div>
            <div class="card-indigo p-6 rounded-2xl hover:bg-blue transition-colors hover:shadow-xl animate-fade-in" style="animation-delay: 0.2s">
                <div class="w-12 h-12 bg-gradient-to-br from-green to-teal rounded-xl flex items-center justify-center mb-4 shadow-green">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2 text-green">Appel Vocal</h3>
                <p class="text-white text-sm">Synthèse vocale automatique pour guider les clients.</p>
            </div>
            <div class="card-pink p-6 rounded-2xl hover:bg-red transition-colors hover:shadow-xl animate-fade-in" style="animation-delay: 0.3s">
                <div class="w-12 h-12 bg-gradient-to-br from-red to-rose rounded-xl flex items-center justify-center mb-4 shadow-red">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2 text-orange">Statistiques</h3>
                <p class="text-white text-sm">Tableaux de bord en temps réel et rapports détaillés.</p>
            </div>
        </div>
    </div>

    <!-- Footer Coloré -->
    <footer class="bg-gray-900 text-white py-16 mt-16">
        <div class="max-w-7xl px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple to-pink rounded-xl flex items-center justify-center shadow-lg animate-pulse">
                            <span class="text-white font-bold text-lg">SQ</span>
                        </div>
                        <span class="ml-3 font-bold text-2xl text-purple">SmartQueue AI</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed max-w-md">
                        Solution intelligente de gestion de files d'attente pour les entreprises modernes. 
                        Optimisez l'expérience client avec notre technologie de pointe.
                    </p>
                    <div class="flex space-x-4 mt-6">
                        <a href="#" class="w-10 h-10 bg-purple rounded-lg flex items-center justify-center hover:bg-pink transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-indigo rounded-lg flex items-center justify-center hover:bg-blue transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.994 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-pink rounded-lg flex items-center justify-center hover:bg-red transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-semibold text-lg mb-6 text-yellow">Produits</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-green transition">Tickets Digitaux</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-orange transition">Appel Vocal</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-red transition">Statistiques</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-purple transition">API</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold text-lg mb-6 text-green">Support</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-400 hover:text-blue transition">Documentation</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-indigo transition">Centre d'aide</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-pink transition">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-yellow transition">Statut du service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">© 2026 SmartQueue AI. Tous droits réservés.</p>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-purple transition text-sm">Confidentialité</a>
                        <a href="#" class="text-gray-400 hover:text-indigo transition text-sm">Conditions</a>
                        <a href="#" class="text-gray-400 hover:text-pink transition text-sm">Cookies</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
