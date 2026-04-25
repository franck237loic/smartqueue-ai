<?php $__env->startSection('title', 'Tous les services - ' . $company->name); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-100">
    <!-- Header -->
    <div class="bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-xl font-bold">Tous les services</h1>
                    <p class="text-slate-400 text-sm"><?php echo e($company->name); ?></p>
                </div>
                <a href="<?php echo e(route('company.agent.dashboard', $company)); ?>" class="text-slate-400 hover:text-white">
                    ← Retour
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <h2 class="text-white font-semibold text-lg"><?php echo e($service->name); ?></h2>
                        <p class="text-blue-100 text-sm mt-1"><?php echo e($service->description ?? 'Service de ' . $service->name); ?></p>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-slate-600">Guichets assignés</span>
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                    <?php echo e($service->counters->count()); ?>

                                </span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-slate-600">Statut</span>
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                                    Actif
                                </span>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <?php if($service->counters->isNotEmpty()): ?>
                                <?php $__currentLoopData = $service->counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                                        <div>
                                            <span class="font-medium"><?php echo e($counter->name); ?></span>
                                            <span class="text-sm text-slate-500"><?php echo e($counter->location ?? 'Non spécifié'); ?></span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                                <?php echo e($counter->status == 'open' ? 'bg-green-100 text-green-800' : 
                                                 $counter->status == 'closed' ? 'bg-red-100 text-red-800' : 
                                                 $counter->status == 'paused' ? 'bg-yellow-100 text-yellow-800' : 
                                                 'bg-gray-100 text-gray-800'); ?>">
                                                <?php echo e(ucfirst($counter->status)); ?>

                                            </span>
                                            <?php if($counter->user): ?>
                                                <span class="text-sm text-slate-600"><?php echo e($counter->user->name); ?></span>
                                            <?php else: ?>
                                                <span class="text-sm text-slate-400">Non assigné</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="text-center py-8 text-slate-500">
                                    Aucun guichet assigné à ce service
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mt-4 pt-4 border-t border-slate-200">
                            <div class="flex justify-between">
                                <a href="<?php echo e(route('company.agent.service', [$company, $service])); ?>" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                    <i class="w-4 h-4 mr-2" data-lucide="eye"></i>
                                    Voir le service
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                        <i class="w-16 h-16 mx-auto mb-4 text-slate-400" data-lucide="inbox"></i>
                        <h3 class="text-lg font-medium text-slate-900 mb-2">Aucun service disponible</h3>
                        <p class="text-slate-600">Vous n'avez accès à aucun service pour le moment.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Initialize Lucide icons for this page
    if (window.lucide) {
        window.lucide.createIcons({ icons: window.lucide.icons });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modern-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\company\agent\all-services.blade.php ENDPATH**/ ?>