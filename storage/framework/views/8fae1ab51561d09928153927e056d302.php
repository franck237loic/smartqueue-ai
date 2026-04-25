<?php $__env->startSection('title', 'Dashboard - ' . $company->name); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Stats Cards Dark -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-dark-800 rounded-xl p-6 card-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-brand-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-dark-600">Services</p>
                    <p class="text-2xl font-bold text-white"><?php echo e($stats['services_count']); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-dark-800 rounded-xl p-6 card-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-dark-600">Guichets</p>
                    <p class="text-2xl font-bold text-white"><?php echo e($stats['counters_count']); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-dark-800 rounded-xl p-6 card-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-dark-600">Agents</p>
                    <p class="text-2xl font-bold text-white"><?php echo e($stats['agents_count']); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-dark-800 rounded-xl p-6 card-shadow">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-orange-500/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-dark-600">Tickets Aujourd'hui</p>
                    <p class="text-2xl font-bold text-white"><?php echo e($stats['tickets_today']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Services List Dark -->
    <div class="bg-dark-800 rounded-xl card-shadow overflow-hidden">
        <div class="p-6 border-b border-dark-700 flex justify-between items-center">
            <h2 class="text-lg font-bold text-white">Services Actifs</h2>
            <a href="<?php echo e(route('company.admin.services.create', $company)); ?>" class="px-4 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 text-sm font-medium shadow-lg shadow-brand-600/30">
                + Nouveau Service
            </a>
        </div>
        <div class="divide-y divide-dark-700">
            <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="p-6 flex items-center justify-between hover:bg-dark-700/50 transition">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-brand-500/20 rounded-lg flex items-center justify-center text-brand-500 font-bold text-lg">
                        <?php echo e($service->prefix); ?>

                    </div>
                    <div class="ml-4">
                        <p class="font-medium text-white"><?php echo e($service->name); ?></p>
                        <p class="text-sm text-dark-600">
                            <?php echo e($service->tickets_count); ?> tickets aujourd'hui
                            • <?php echo e($service->estimated_service_time); ?> min/ticket
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="px-3 py-1 rounded-full text-xs font-medium <?php echo e($service->isActive() ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400'); ?>">
                        <?php echo e($service->isActive() ? 'Actif' : 'Inactif'); ?>

                    </span>
                    <a href="<?php echo e(route('company.admin.services.edit', [$company, $service])); ?>" class="text-brand-500 hover:text-brand-400 text-sm">
                        Modifier
                    </a>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="p-8 text-center text-dark-600">
                Aucun service actif. Créez votre premier service.
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick Actions Dark -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="<?php echo e(route('company.admin.counters', $company)); ?>" class="bg-dark-800 rounded-xl p-6 card-shadow hover:bg-dark-700/50 transition group">
            <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center mb-3 group-hover:bg-green-500/30 transition">
                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="font-medium text-white mb-1">Gérer les Guichets</h3>
            <p class="text-sm text-dark-600">Configurer les guichets et assigner les agents</p>
        </a>

        <a href="<?php echo e(route('company.admin.agents', $company)); ?>" class="bg-dark-800 rounded-xl p-6 card-shadow hover:bg-dark-700/50 transition group">
            <div class="w-10 h-10 bg-purple-500/20 rounded-lg flex items-center justify-center mb-3 group-hover:bg-purple-500/30 transition">
                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <h3 class="font-medium text-white mb-1">Gérer les Agents</h3>
            <p class="text-sm text-dark-600">Ajouter ou retirer des agents de l'entreprise</p>
        </a>

        <a href="<?php echo e(route('company.admin.statistics', $company)); ?>" class="bg-dark-800 rounded-xl p-6 card-shadow hover:bg-dark-700/50 transition group">
            <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center mb-3 group-hover:bg-orange-500/30 transition">
                <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <h3 class="font-medium text-white mb-1">Statistiques</h3>
            <p class="text-sm text-dark-600">Voir les performances et rapports détaillés</p>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.company-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\company\admin\dashboard.blade.php ENDPATH**/ ?>