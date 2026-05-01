<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Super Admin'); ?> | SmartQueue AI</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        :root {
            --brand-500: #3b82f6;
            --brand-600: #2563eb;
        }
        
        body { 
            font-family: 'Inter', sans-serif;
            background: #030712;
            color: white;
        }
        
        .sidebar-link { @apply flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all duration-200; }
        .sidebar-link:hover { @apply bg-white/10 text-white transform translate-x-1; }
        .sidebar-link.active { @apply bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg shadow-blue-600/40 transform scale-105; }
        .card-shadow { @apply shadow-2xl shadow-black/10 border border-gray-800/50 hover:shadow-3xl hover:shadow-blue-600/10 transition-all duration-300; }
        .glass { @apply bg-gray-900/90 backdrop-blur-2xl border border-white/10; }
        .gradient-text { @apply bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 bg-clip-text text-transparent; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-pulse-slow { animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .stat-card {
            @apply relative overflow-hidden;
            background: linear-gradient(135deg, rgba(17, 24, 39, 0.9) 0%, rgba(31, 41, 55, 0.9) 100%);
        }
        
        .stat-card::before {
            content: '';
            @apply absolute inset-0 opacity-0 hover:opacity-100 transition-opacity duration-500;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(147, 51, 234, 0.1) 100%);
        }
        
        .btn-primary {
            @apply relative overflow-hidden bg-gradient-to-r from-blue-600 to-purple-600 text-white;
            transition: all 0.3s ease;
        }
        
        .btn-primary::before {
            content: '';
            @apply absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 opacity-0 hover:opacity-100 transition-opacity duration-300;
        }
        
        .btn-primary:hover {
            @apply transform scale-105 shadow-2xl shadow-blue-600/40;
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
        .shadow-brand-600 { box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.3); }
    </style>
</head>
<body class="bg-dark-900 text-white">
    <div class="flex h-screen">
        <!-- Sidebar Modern -->
        <aside class="w-72 bg-gradient-to-b from-gray-900 via-gray-900 to-black backdrop-blur-xl border-r border-white/5 flex flex-col fixed h-full z-20 shadow-2xl shadow-black/30" x-data="{ sidebarOpen: true }">
            <!-- Logo Section -->
            <div class="p-6 border-b border-white/5">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-600/40 ring-2 ring-white/20 animate-pulse-slow">
                        <svg class="w-7 h-7 text-white animate-float" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-lg gradient-text tracking-tight">SmartQueue</h1>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                            <p class="text-xs text-gray-500 font-medium">Super Admin</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Navigation -->
            <nav class="flex-1 px-4 py-6 overflow-y-auto">
                <div class="space-y-2">
                    <p class="px-4 text-xs font-semibold text-dark-600 uppercase tracking-wider mb-3">Menu Principal</p>
                    
                    <a href="<?php echo e(route('super_admin.dashboard')); ?>" class="group flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-medium transition-all duration-300 <?php echo e(request()->routeIs('super_admin.dashboard') ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg shadow-blue-600/25' : 'text-gray-400 hover:bg-white/5 hover:text-white'); ?>">
                        <div class="w-9 h-9 rounded-lg <?php echo e(request()->routeIs('super_admin.dashboard') ? 'bg-white/20' : 'bg-blue-500/10 group-hover:bg-blue-500/20'); ?> flex items-center justify-center transition-all">
                            <svg class="w-5 h-5 <?php echo e(request()->routeIs('super_admin.dashboard') ? 'text-white' : 'text-blue-500'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                        <span>Dashboard</span>
                    </a>

                    <a href="<?php echo e(route('super_admin.companies')); ?>" class="group flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-medium transition-all duration-300 <?php echo e(request()->routeIs('super_admin.companies*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/25' : 'text-dark-600 hover:bg-white/5 hover:text-white'); ?>">
                        <div class="w-9 h-9 rounded-lg <?php echo e(request()->routeIs('super_admin.companies*') ? 'bg-white/20' : 'bg-green-500/10 group-hover:bg-green-500/20'); ?> flex items-center justify-center transition-all">
                            <svg class="w-5 h-5 <?php echo e(request()->routeIs('super_admin.companies*') ? 'text-white' : 'text-green-500'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <span>Entreprises</span>
                        <?php
                            $companiesCount = \App\Models\Company::count();
                        ?>
                        <?php if($companiesCount > 0): ?>
                            <span class="ml-auto bg-brand-600 text-white px-2.5 py-0.5 rounded-full text-xs font-bold shadow-sm"><?php echo e($companiesCount); ?></span>
                        <?php endif; ?>
                    </a>

                    <a href="<?php echo e(route('super_admin.users')); ?>" class="group flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-medium transition-all duration-300 <?php echo e(request()->routeIs('super_admin.users*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/25' : 'text-dark-600 hover:bg-white/5 hover:text-white'); ?>">
                        <div class="w-9 h-9 rounded-lg <?php echo e(request()->routeIs('super_admin.users*') ? 'bg-white/20' : 'bg-purple-500/10 group-hover:bg-purple-500/20'); ?> flex items-center justify-center transition-all">
                            <svg class="w-5 h-5 <?php echo e(request()->routeIs('super_admin.users*') ? 'text-white' : 'text-purple-500'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <span>Utilisateurs</span>
                    </a>
                </div>

                <!-- System Section -->
                <div class="mt-8 pt-6 border-t border-white/5">
                    <p class="px-4 text-xs font-semibold text-dark-600 uppercase tracking-wider mb-3">Système</p>
                    
                    <div class="space-y-1">
                        <a href="<?php echo e(route('welcome')); ?>" class="group flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-dark-600 hover:bg-white/5 hover:text-white transition-all duration-300">
                            <div class="w-9 h-9 rounded-lg bg-dark-700/50 group-hover:bg-dark-600 flex items-center justify-center transition-all">
                                <svg class="w-5 h-5 text-dark-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                            <span>Page d'accueil</span>
                        </a>

                        <form action="<?php echo e(route('logout')); ?>" method="POST" class="block">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="group w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-all duration-300">
                                <div class="w-9 h-9 rounded-lg bg-red-500/10 group-hover:bg-red-500/20 flex items-center justify-center transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </div>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- User Profile Card -->
            <div class="p-4 m-4 bg-gradient-to-br from-dark-700/60 via-purple-900/20 to-dark-800/60 rounded-2xl border border-white/10 backdrop-blur-xl hover:border-white/20 transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-11 h-11 bg-gradient-to-br from-brand-500 via-purple-500 to-pink-500 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-brand-600/40 ring-2 ring-white/20">
                            <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                        </div>
                        <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-gradient-to-br from-green-400 to-green-500 rounded-full border-2 border-dark-800 animate-pulse"></div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate"><?php echo e(auth()->user()->name); ?></p>
                        <p class="text-xs text-dark-600 truncate"><?php echo e(auth()->user()->email); ?></p>
                    </div>
                    <a href="#" class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                        <svg class="w-4 h-4 text-dark-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-72 overflow-y-auto bg-dark-900">
            <!-- Top Bar -->
            <header class="bg-dark-800 border-b border-dark-700 sticky top-0 z-10">
                <div class="flex items-center justify-between px-8 py-4">
                    <div>
                        <h2 class="text-xl font-semibold text-white"><?php echo $__env->yieldContent('title', 'Dashboard'); ?></h2>
                        <p class="text-sm text-dark-600"><?php echo e(now()->format('l d F Y')); ?></p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <span class="px-4 py-2 bg-gradient-to-r from-brand-600 via-purple-600 to-pink-600 text-white rounded-full text-sm font-bold shadow-lg shadow-brand-600/40 animate-pulse-slow">
                                Super Admin
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-brand-600 via-purple-600 to-pink-600 rounded-full blur-lg opacity-50 animate-pulse"></div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-8">
                <?php if(session('success')): ?>
                    <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-green-400"><?php echo e(session('success')); ?></p>
                    </div>
                <?php endif; ?>

                <?php if(session('error')): ?>
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-red-400"><?php echo e(session('error')); ?></p>
                    </div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </main>
    </div>
</body>
</html>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\layouts\super-admin.blade.php ENDPATH**/ ?>