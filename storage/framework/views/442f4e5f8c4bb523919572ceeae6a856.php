<?php $__env->startSection('title', 'Super Admin - Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8" x-data="{ stats: <?php echo json_encode($stats ?? []); ?> }">
    <!-- Header avec animation -->
    <div class="flex items-center justify-between">
        <div class="space-y-2">
            <h1 class="text-4xl font-bold gradient-text animate-float">Dashboard Super Admin</h1>
            <p class="text-gray-500 text-lg">Vue d'ensemble de la plateforme SmartQueue AI</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Dernière synchronisation</p>
            <p class="text-lg font-semibold text-white" x-text="new Date().toLocaleTimeString()"></p>
        </div>
    </div>

    <!-- Stats Cards avec animations -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat-card rounded-2xl p-6 card-shadow group cursor-pointer" @click="animateCard($event)">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-brand-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-brand-600/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <div class="w-8 h-8 bg-green-500/20 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-2">Entreprises totales</p>
                <p class="text-3xl font-bold text-white mb-2" x-text="stats.companies_count"></p>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-emerald-400 font-medium">+12%</span>
                    <span class="text-xs text-gray-500">vs mois dernier</span>
                </div>
            </div>
        </div>

        <div class="stat-card rounded-2xl p-6 card-shadow group cursor-pointer" @click="animateCard($event)">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg shadow-green-600/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="w-8 h-8 bg-emerald-500/20 rounded-full flex items-center justify-center animate-pulse">
                        <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                    </div>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-2">Entreprises actives</p>
                <p class="text-3xl font-bold text-white mb-2" x-text="stats.active_companies"></p>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-emerald-400 font-medium">En ligne</span>
                    <span class="text-xs text-gray-500">• 99.9% uptime</span>
                </div>
            </div>
        </div>

        <div class="stat-card rounded-2xl p-6 card-shadow group cursor-pointer" @click="animateCard($event)">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-600/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    <div class="w-8 h-8 bg-violet-500/20 rounded-full flex items-center justify-center">
                        <span class="text-xs text-violet-400 font-bold">+8</span>
                    </div>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-2">Utilisateurs totaux</p>
                <p class="text-3xl font-bold text-white mb-2" x-text="stats.total_users || 0"></p>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-violet-400 font-medium">+25%</span>
                    <span class="text-xs text-gray-500">ce mois</span>
                </div>
            </div>
        </div>

        <div class="stat-card rounded-2xl p-6 card-shadow group cursor-pointer" @click="animateCard($event)">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-orange-600 rounded-2xl flex items-center justify-center shadow-lg shadow-red-600/30 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div class="w-8 h-8 bg-red-500/20 rounded-full flex items-center justify-center animate-pulse">
                        <svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm text-gray-500 font-medium mb-2">Super Admins</p>
                <p class="text-3xl font-bold text-white mb-2" x-text="stats.super_admins || <?php echo e(\App\Models\User::where('global_role', 'super_admin')->count()); ?>"></p>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-red-400 font-medium">Sécurisé</span>
                    <span class="text-xs text-gray-500">• Accès total</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides avec effets -->
    <div class="bg-gradient-to-br from-dark-800 via-purple-900/10 to-dark-800 rounded-2xl p-8 card-shadow">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold gradient-text">Actions rapides</h3>
            <div class="w-8 h-8 bg-brand-500/20 rounded-lg flex items-center justify-center animate-pulse">
                <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="<?php echo e(route('super_admin.companies.create')); ?>" class="btn-primary px-6 py-4 rounded-2xl text-center font-semibold shadow-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 group">
                <span class="relative z-10 flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Nouvelle entreprise
                </span>
            </a>
            <a href="<?php echo e(route('super_admin.companies')); ?>" class="px-6 py-4 bg-dark-700 text-dark-600 rounded-2xl text-center font-semibold hover:bg-dark-600 hover:text-white hover:shadow-xl transform hover:scale-105 transition-all duration-300 group">
                <span class="flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Voir toutes les entreprises
                </span>
            </a>
            <a href="<?php echo e(route('super_admin.users')); ?>" class="px-6 py-4 bg-dark-700 text-dark-600 rounded-2xl text-center font-semibold hover:bg-dark-600 hover:text-white hover:shadow-xl transform hover:scale-105 transition-all duration-300 group">
                <span class="flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    Gérer les utilisateurs
                </span>
            </a>
        </div>
    </div>

    <!-- Entreprises récentes avec design moderne -->
    <div class="bg-gradient-to-br from-dark-800 via-dark-800 to-dark-900 rounded-2xl card-shadow overflow-hidden">
        <div class="p-6 border-b border-dark-700 bg-gradient-to-r from-dark-800 to-purple-900/10">
            <div class="flex items-center justify-between">
                <h3 class="text-2xl font-bold gradient-text">Entreprises récentes</h3>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-sm text-green-400 font-medium">Temps réel</span>
                </div>
            </div>
        </div>
        <div class="divide-y divide-dark-700/50">
            <?php $__empty_1 = true; $__currentLoopData = $recentCompanies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="p-6 flex items-center justify-between hover:bg-gradient-to-r hover:from-dark-700/30 hover:to-purple-900/10 transition-all duration-300 group cursor-pointer">
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <div class="w-12 h-12 bg-gradient-to-br from-brand-500/20 to-purple-500/20 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <span class="text-brand-500 font-bold text-lg"><?php echo e(substr($company->name, 0, 2)); ?></span>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-3 h-3 bg-green-400 rounded-full border-2 border-dark-800 animate-pulse"></div>
                    </div>
                    <div>
                        <a href="<?php echo e(route('super_admin.companies.show', $company)); ?>" class="font-semibold text-white hover:text-brand-500 transition-colors text-lg group-hover:text-brand-400">
                            <?php echo e($company->name); ?>

                        </a>
                        <div class="flex items-center gap-3 mt-1">
                            <p class="text-sm text-dark-600"><?php echo e($company->email); ?></p>
                            <span class="text-dark-600">•</span>
                            <p class="text-sm text-dark-600"><?php echo e($company->created_at->format('d/m/Y')); ?></p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="px-4 py-2 rounded-full text-sm font-semibold backdrop-blur-sm
                        <?php if($company->status === 'active'): ?> bg-green-500/20 text-green-400 border border-green-500/30
                        <?php elseif($company->status === 'suspended'): ?> bg-yellow-500/20 text-yellow-400 border border-yellow-500/30
                        <?php else: ?> bg-dark-700 text-dark-600 border border-dark-600 <?php endif; ?>">
                        <?php echo e($company->status); ?>

                    </span>
                    <div class="w-8 h-8 bg-dark-700 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-dark-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-dark-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <p class="text-dark-600 text-lg font-medium">Aucune entreprise créée</p>
                <p class="text-dark-600 text-sm mt-2">Commencez par ajouter votre première entreprise</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function animateCard(event) {
    const card = event.currentTarget;
    card.style.transform = 'scale(0.95)';
    setTimeout(() => {
        card.style.transform = 'scale(1)';
    }, 150);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.super-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\super-admin\dashboard.blade.php ENDPATH**/ ?>