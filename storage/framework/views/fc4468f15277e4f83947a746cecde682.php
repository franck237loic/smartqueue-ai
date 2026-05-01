<?php $__env->startSection('title', 'Agents - SmartQueue AI'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8 animate-fade-in">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-text mb-1 sm:mb-2">Agents</h1>
            <p class="text-gray-500 text-sm sm:text-base">Gérez les agents du système</p>
        </div>
        <a href="<?php echo e(route('admin.agents.create')); ?>" class="py-2 px-4 sm:py-3 sm:px-6 rounded-xl gradient-primary text-white font-medium hover:opacity-90 transition inline-flex items-center gap-2 text-sm sm:text-base">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
            <span class="hidden sm:inline">Nouvel agent</span>
            <span class="sm:hidden">Ajouter</span>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-2xl card-shadow p-4 sm:p-6">
                <div class="flex items-start justify-between mb-3 sm:mb-4">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full gradient-primary flex items-center justify-center text-white text-lg sm:text-xl font-bold">
                            <?php echo e(substr($agent->name, 0, 1)); ?>

                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-semibold text-text text-base sm:text-lg truncate"><?php echo e($agent->name); ?></p>
                            <p class="text-xs sm:text-sm text-gray-500 truncate"><?php echo e($agent->email); ?></p>
                        </div>
                    </div>
                </div>

                <div class="space-y-2 sm:space-y-3 pt-3 sm:pt-4 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-xs sm:text-sm">Tickets servis</span>
                        <span class="font-semibold text-text text-sm sm:text-base"><?php echo e($agent->tickets()->where('status', 'served')->count()); ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-xs sm:text-sm">Servis aujourd'hui</span>
                        <span class="font-semibold text-success text-sm sm:text-base"><?php echo e($agent->tickets()->where('status', 'served')->whereDate('served_at', today())->count()); ?></span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 text-xs sm:text-sm">En appel</span>
                        <span class="font-semibold text-primary text-sm sm:text-base"><?php echo e($agent->tickets()->where('status', 'called')->count()); ?></span>
                    </div>
                </div>

                <div class="mt-3 sm:mt-4 pt-3 sm:pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400">Membre depuis <?php echo e($agent->created_at->format('d/m/Y')); ?></p>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-8 sm:py-12 bg-white rounded-2xl card-shadow">
                <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <p class="text-gray-500 mb-3 sm:mb-4 text-sm sm:text-base">Aucun agent créé</p>
                <a href="<?php echo e(route('admin.agents.create')); ?>" class="text-primary hover:underline font-medium text-sm sm:text-base">Ajouter un agent</a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\admin\agents\index.blade.php ENDPATH**/ ?>