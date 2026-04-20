<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>

    <!-- Tailwind Global Variable - Défini au début -->
    <script>
        window.tailwind = {
            colors: {
                blue: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' },
                white: '#ffffff',
                gray: { 50: '#f9fafb', 100: '#f3f4f6', 200: '#e5e7eb', 300: '#d1d5db', 400: '#9ca3af', 500: '#6b7280', 600: '#4b5563', 700: '#374151', 800: '#1f2937', 900: '#111827' },
                red: { 50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171', 500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d' },
                green: { 50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0', 300: '#86efac', 400: '#4ade80', 500: '#22c55e', 600: '#16a34a', 700: '#15803d', 800: '#166534', 900: '#14532d' },
                yellow: { 50: '#fffbeb', 100: '#fef3c7', 200: '#fde68a', 300: '#fcd34d', 400: '#fbbf24', 500: '#f59e0b', 600: '#d97706', 700: '#b45309', 800: '#92400e', 900: '#78350f' },
                brand: { 50: '#eff6ff', 100: '#dbeafe', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8' },
                success: '#22c55e',
                warning: '#f59e0b',
                error: '#ef4444',
                surface: '#f8fafc',
                text: '#0f172a'
            }
        };
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'SmartQueue AI'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Styles CSS Vite -->
<?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
<!-- Configuration Tailwind inline pour éviter le CDN -->
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    brand: {
                        50: '#eff6ff',
                        100: '#dbeafe',
                        500: '#3b82f6',
                        600: '#2563eb',
                        700: '#1d4ed8',
                    },
                    'dark': {
                        600: '#4b5563',
                        700: '#374151',
                        800: '#1f2937',
                    }
                }
            }
        }
    }
</script>
    <style>
        * { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', sans-serif; }
        .bg-primary { background-color: #2563EB; }
        .bg-primary-600 { background-color: #1D4ED8; }
        .text-primary { color: #2563EB; }
        .text-success { color: #22C55E; }
        .text-warning { color: #F59E0B; }
        .text-error { color: #EF4444; }
        .bg-surface { background-color: #F8FAFC; }
        .text-text { color: #0F172A; }
        .border-primary { border-color: #2563EB; }
        .bg-green-50 { background-color: #F0FDF4; }
        .border-green-200 { border-color: #BBF7D0; }
        .bg-red-50 { background-color: #FEF2F2; }
        .border-red-200 { border-color: #FECACA; }
        .bg-amber-50 { background-color: #FFFBEB; }
        .border-amber-200 { border-color: #FDE68A; }
        .bg-blue-50 { background-color: #EFF6FF; }
        .border-blue-200 { border-color: #BFDBFE; }
        .hover\:bg-blue-600:hover { background-color: #1D4ED8; }
        .hover\:bg-red-50:hover { background-color: #FEF2F2; }
        .hover\:bg-primary\/5:hover { background-color: rgba(37, 99, 235, 0.05); }
        .hover\:text-primary:hover { color: #2563EB; }
        .hover\:text-error:hover { color: #EF4444; }
        .hover\:bg-white\/20:hover { background-color: rgba(255, 255, 255, 0.2); }
        .hover\:bg-white\/30:hover { background-color: rgba(255, 255, 255, 0.3); }
        .hover\:bg-gray-50:hover { background-color: #F9FAFB; }
        .hover\:border-gray-300:hover { border-color: #D1D5DB; }
        .hover\:opacity-90:hover { opacity: 0.9; }
        .hover\:scale-\[1\.02\]:hover { transform: scale(1.02); }
        .hover\:-translate-y-1:hover { transform: translateY(-4px); }
        .hover\:shadow-lg:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .hover\:bg-gray-100:hover { background-color: #F3F4F6; }
        .hover\:bg-red-50:hover { background-color: #FEF2F2; }
        .hover\:text-error:hover { color: #EF4444; }
        .hover\:underline:hover { text-decoration: underline; }
        .hover\:bg-blue-50:hover { background-color: #EFF6FF; }
        .cursor-not-allowed { cursor: not-allowed; }
        .gradient-primary { background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%); }
        .card-shadow { box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); }
        .card-hover:hover { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04); transform: translateY(-1px); }
        .animate-fade-in { animation: fadeIn 0.5s ease-out; }
        .animate-slide-up { animation: slideUp 0.5s ease-out; }
        .animate-pulse-slow { animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Tailwind Fallback pour éviter l'erreur -->
    <script>
        window.tailwind = {
            colors: {
                blue: { 500: '#3b82f6' },
                white: '#ffffff',
                gray: { 100: '#f3f4f6', 200: '#e5e7eb', 300: '#d1d5db', 400: '#9ca3af', 500: '#6b7280', 600: '#4b5563', 700: '#374151', 800: '#1f2937', 900: '#111827' }
            }
        };
    </script>

    <!-- Tailwind Global Variable -->
    <script>
        window.tailwind = {
            colors: {
                blue: { 50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a' },
                white: '#ffffff',
                gray: { 50: '#f9fafb', 100: '#f3f4f6', 200: '#e5e7eb', 300: '#d1d5db', 400: '#9ca3af', 500: '#6b7280', 600: '#4b5563', 700: '#374151', 800: '#1f2937', 900: '#111827' },
                red: { 50: '#fef2f2', 100: '#fee2e2', 200: '#fecaca', 300: '#fca5a5', 400: '#f87171', 500: '#ef4444', 600: '#dc2626', 700: '#b91c1c', 800: '#991b1b', 900: '#7f1d1d' },
                green: { 50: '#f0fdf4', 100: '#dcfce7', 200: '#bbf7d0', 300: '#86efac', 400: '#4ade80', 500: '#22c55e', 600: '#16a34a', 700: '#15803d', 800: '#166534', 900: '#14532d' },
                yellow: { 50: '#fffbeb', 100: '#fef3c7', 200: '#fde68a', 300: '#fcd34d', 400: '#fbbf24', 500: '#f59e0b', 600: '#d97706', 700: '#b45309', 800: '#92400e', 900: '#78350f' }
            },
            spacing: {
                px: '1px',
                '0': '0px',
                '1': '0.25rem',
                '2': '0.5rem',
                '3': '0.75rem',
                '4': '1rem',
                '5': '1.25rem',
                '6': '1.5rem',
                '7': '1.75rem',
                '8': '2rem',
                '9': '2.25rem',
                '10': '2.5rem'
            }
        };
    </script>
</head>
<body class="bg-gray-50 text-text antialiased min-h-screen">
    <?php if(auth()->guard()->check()): ?>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900 text-white fixed left-0 top-0 h-full z-50 hidden md:flex flex-col">
            <div class="h-16 flex items-center px-6 border-b border-slate-800">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center">
                        <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span class="font-display font-bold text-lg text-white">SmartQueue<span class="text-blue-400">AI</span></span>
                </a>
            </div>
            <?php
                $currentCompany = auth()->user()?->currentCompany ?? auth()->user()?->companies()->first();
            ?>
            <nav class="flex-1 px-4 py-6 space-y-1">
                <?php if($currentCompany): ?>
                    <?php if(auth()->user()->isSuperAdmin() || auth()->user()->hasRoleInCompany($currentCompany, 'company_admin')): ?>
                        <a href="<?php echo e(route('company.admin.dashboard', $currentCompany)); ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium <?php echo e(request()->routeIs('company.admin.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Dashboard Admin
                        </a>
                    <?php endif; ?>
                    <?php if(auth()->user()->hasRoleInCompany($currentCompany, 'agent')): ?>
                        <a href="<?php echo e(route('company.agent.dashboard', $currentCompany)); ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium <?php echo e(request()->routeIs('company.agent.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            Guichets Agent
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
                <a href="<?php echo e(route('welcome')); ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium <?php echo e(request()->routeIs('welcome') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white'); ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    Page d'accueil
                </a>
            </nav>
            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-red-600 hover:text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-64">
            <!-- Top Bar -->
            <div class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8 sticky top-0 z-40">
                <h2 class="text-lg font-semibold text-text"><?php echo $__env->yieldContent('title', 'SmartQueue AI'); ?></h2>
                <div class="flex items-center gap-4">
                    <!-- Sélecteur d'entreprise -->
                    <?php if(auth()->user()->companies()->count() > 1): ?>
                        <div class="relative">
                            <button 
                                type="button" 
                                class="flex items-center gap-2 px-3 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm hover:bg-gray-100 transition"
                                onclick="toggleCompanyDropdown()"
                            >
                                <span class="font-medium"><?php echo e(auth()->user()->currentCompany?->name ?? 'Sélectionner une entreprise'); ?></span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            
                            <div id="companyDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                                <div class="py-2 max-h-64 overflow-y-auto">
                                    <?php $__currentLoopData = auth()->user()->companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <form method="POST" action="<?php echo e(route('switch.company', $company)); ?>" class="block">
                                            <?php echo csrf_field(); ?>
                                            <button 
                                                type="submit" 
                                                class="w-full px-4 py-3 hover:bg-gray-50 transition text-left"
                                            >
                                                <div class="flex items-center justify-between">
                                                    <div>
                                                        <div class="font-medium text-gray-900"><?php echo e($company->name); ?></div>
                                                        <div class="text-sm text-gray-500"><?php echo e(ucfirst($company->pivot->role)); ?></div>
                                                    </div>
                                                    <?php if($company->id == auth()->user()->currentCompany?->id): ?>
                                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                        </svg>
                                                    <?php endif; ?>
                                                </div>
                                            </button>
                                        </form>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <span class="text-sm text-gray-500"><?php echo e(auth()->user()->name); ?></span>
                    <div class="w-8 h-8 rounded-full gradient-primary flex items-center justify-center text-white text-sm font-bold">
                        <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                    </div>
                </div>
            </div>
            <div class="p-8">
    <?php else: ?>
    <!-- Public Navigation -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg gradient-primary flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="font-display font-bold text-xl text-text">SmartQueue<span class="text-primary">AI</span></span>
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <a href="<?php echo e(route('login')); ?>" class="text-sm font-medium text-gray-600 hover:text-primary transition">Connexion</a>
                    <a href="<?php echo e(route('register')); ?>" class="text-sm font-medium px-4 py-2 rounded-lg bg-primary text-white hover:bg-blue-600 transition">Inscription</a>
                </div>
            </div>
        </div>
    </nav>
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <?php endif; ?>
        <?php if(session('success')): ?>
            <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-success animate-fade-in">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-error animate-fade-in">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('warning')): ?>
            <div class="mb-4 p-4 rounded-xl bg-amber-50 border border-amber-200 text-warning animate-fade-in">
                <?php echo e(session('warning')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('info')): ?>
            <div class="mb-4 p-4 rounded-xl bg-blue-50 border border-blue-200 text-primary animate-fade-in">
                <?php echo e(session('info')); ?>

            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    <?php if(auth()->guard()->check()): ?>
            </div>
        </main>
    </div>
    <?php else: ?>
    </main>
    <?php endif; ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    
    <!-- JavaScript pour le sélecteur d'entreprise -->
    <script>
        function toggleCompanyDropdown() {
            const dropdown = document.getElementById('companyDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Fermer le dropdown quand on clique ailleurs
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('companyDropdown');
            const button = event.target.closest('button[onclick="toggleCompanyDropdown()"]');
            
            if (!button && dropdown && dropdown.contains && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views/layouts/app.blade.php ENDPATH**/ ?>