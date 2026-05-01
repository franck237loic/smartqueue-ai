<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartQueue AI - Gestion de File d'Attente Intelligente</title>
    
    <!-- CSS Local -->
    <style>
        /* Reset et styles de base */
        * { box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            line-height: 1.6;
            color: #0F172A;
            background-color: #F8FAFC;
            margin: 0;
            padding: 0;
        }
        
        /* Layout */
        .flex { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .justify-center { justify-content: center; }
        .text-center { text-align: center; }
        .space-x-4 > * + * { margin-left: 1rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        
        /* Espacement */
        .max-w-7xl { max-width: 80rem; }
        .max-w-2xl { max-width: 42rem; }
        .mx-auto { margin-left: auto; margin-right: auto; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-20 { padding-top: 5rem; padding-bottom: 5rem; }
        .py-16 { padding-top: 4rem; padding-bottom: 4rem; }
        .py-12 { padding-top: 3rem; padding-bottom: 3rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
        .mb-6 { margin-bottom: 1.5rem; }
        .mb-8 { margin-bottom: 2rem; }
        .mb-12 { margin-bottom: 3rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .ml-3 { margin-left: 0.75rem; }
        .mr-3 { margin-right: 0.75rem; }
        
        /* Typographie */
        .text-4xl { font-size: 2.25rem; line-height: 2.5rem; }
        .text-5xl { font-size: 3rem; line-height: 1; }
        .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .font-bold { font-weight: 700; }
        .font-semibold { font-weight: 600; }
        .font-medium { font-weight: 500; }
        
        /* Couleurs */
        .bg-white { background-color: #ffffff; }
        .bg-slate-50 { background-color: #f8fafc; }
        .bg-slate-900 { background-color: #0f172a; }
        .bg-blue-600 { background-color: #2563eb; }
        .bg-blue-700 { background-color: #1d4ed8; }
        .bg-blue-100 { background-color: #dbeafe; }
        .bg-blue-50 { background-color: #eff6ff; }
        .text-white { color: #ffffff; }
        .text-slate-400 { color: #94a3b8; }
        .text-slate-500 { color: #64748b; }
        .text-slate-600 { color: #475569; }
        .text-slate-900 { color: #0f172a; }
        .text-blue-600 { color: #2563eb; }
        .text-blue-700 { color: #1d4ed8; }
        .text-blue-100 { color: #dbeafe; }
        .text-blue-50 { color: #eff6ff; }
        .border-slate-200 { border-color: #e2e8f0; }
        .border-2 { border-width: 2px; }
        .border { border-width: 1px; }
        
        /* Bordures et arrondis */
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-xl { border-radius: 0.75rem; }
        .rounded-2xl { border-radius: 1rem; }
        
        /* Ombres */
        .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); }
        
        /* Transitions */
        .transition { transition: all 0.2s ease; }
        .transition-colors { transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease; }
        
        /* Hover states */
        .hover\:bg-blue-50:hover { background-color: #eff6ff; }
        .hover\:bg-blue-700:hover { background-color: #1d4ed8; }
        .hover\:text-blue-700:hover { color: #1d4ed8; }
        
        /* Positionnement */
        .sticky { position: sticky; }
        .top-0 { top: 0; }
        .z-50 { z-index: 50; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .inset-y-0 { top: 0; bottom: 0; }
        .left-0 { left: 0; }
        .right-0 { right: 0; }
        
        /* Dimensions */
        .w-8 { width: 2rem; }
        .h-8 { height: 2rem; }
        .h-16 { height: 4rem; }
        .w-12 { width: 3rem; }
        .h-12 { height: 3rem; }
        .w-6 { width: 1.5rem; }
        .h-6 { height: 1.5rem; }
        
        /* Flex */
        .flex-col { flex-direction: column; }
        .flex-1 { flex: 1 1 0%; }
        
        /* Grid */
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .md\:grid-cols-3 { @media (min-width: 768px) { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
        .md\:flex-row { @media (min-width: 768px) { flex-direction: row; } }
        .md\:mb-0 { @media (min-width: 768px) { margin-bottom: 0; } }
        
        /* Responsive */
        @media (min-width: 640px) {
            .sm\:px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
        }
        
        @media (min-width: 768px) {
            .md\:text-5xl { font-size: 3rem; line-height: 1; }
            .md\:flex-row { flex-direction: row; }
            .md\:mb-0 { margin-bottom: 0; }
        }
        
        @media (min-width: 1024px) {
            .lg\:px-8 { padding-left: 2rem; padding-right: 2rem; }
        }
        
        /* Gradients */
        .bg-gradient-to-br { background-image: linear-gradient(to bottom right, var(--tw-gradient-stops)); }
        .from-blue-600 { --tw-gradient-from: #2563eb; }
        .to-blue-700 { --tw-gradient-to: #1d4ed8; }
        
        /* Curseur */
        .cursor-pointer { cursor: pointer; }
        
        /* Texte */
        .text-blue-100 { color: #dbeafe; }
        
        /* Classes manquantes */
        .text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        .h-full { height: 100%; }
        .min-h-screen { min-height: 100vh; }
        .gap-8 { gap: 2rem; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    <!-- Header -->
    <nav class="bg-white border border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">SQ</span>
                    </div>
                    <span class="ml-3 font-bold text-xl text-slate-900">SmartQueue AI</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="<?php echo e(route('login')); ?>" onclick="window.location.href='<?php echo e(route('login')); ?>'; return false;" class="px-4 py-2 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition font-medium text-sm cursor-pointer">Login</a>
                    <a href="<?php echo e(route('login')); ?>" onclick="window.location.href='<?php echo e(route('login')); ?>'; return false;" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium text-sm cursor-pointer">Dashboard</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <div class="bg-gradient-to-br from-blue-600 to-blue-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-6">Gestion Intelligente de File d'Attente</h1>
                <p class="text-xl text-blue-100 max-w-2xl mx-auto mb-8">
                    Simplifiez l'accueil de vos clients avec notre solution SaaS multi-entreprises. 
                    Tickets digitaux, appels automatiques, notifications en temps reel.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="<?php echo e(route('login')); ?>" onclick="window.location.href='<?php echo e(route('login')); ?>'; return false;" class="px-6 py-3 bg-white text-blue-700 rounded-xl hover:bg-blue-50 transition font-semibold cursor-pointer">
                        Accès Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Companies List -->
    <div id="entreprises" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">Entreprises Partenaires</h2>
            <p class="text-slate-500 max-w-2xl mx-auto">
                Rejoignez les entreprises qui font confiance a SmartQueue AI pour optimiser leur gestion de files d'attente.
            </p>
        </div>

        <?php
        $companies = \App\Models\Company::where('status', 'active')->get();
        ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="p-6 rounded-2xl bg-slate-50 hover:bg-blue-50 transition-colors">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2"><?php echo e($company->name); ?></h3>
                <p class="text-slate-500 text-sm"><?php echo e($company->description); ?></p>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- Features -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">Fonctionnalités</h2>
            <p class="text-slate-500 max-w-2xl mx-auto">
                Découvrez les fonctionnalités de SmartQueue AI pour optimiser votre gestion de files d'attente.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="p-6 rounded-2xl bg-slate-50 hover:bg-blue-50 transition-colors">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Tickets Digitaux</h3>
                <p class="text-slate-500 text-sm">Prise de ticket simplifiee via QR code ou application web.</p>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 hover:bg-blue-50 transition-colors">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Appel Vocal</h3>
                <p class="text-slate-500 text-sm">Synthese vocale automatique pour guider les clients.</p>
            </div>
            <div class="p-6 rounded-2xl bg-slate-50 hover:bg-blue-50 transition-colors">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Statistiques</h3>
                <p class="text-slate-500 text-sm">Tableaux de bord en temps reel et rapports detailles.</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center mb-4 md:mb-0">
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <span class="text-white font-bold text-sm">SQ</span>
                    </div>
                    <span class="font-bold text-white">SmartQueue AI</span>
                </div>
                <p class="text-sm">© 2026 SmartQueue AI. Tous droits reserves.</p>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\pages\home_backup.blade.php ENDPATH**/ ?>