<?php $__env->startSection('title', $company->name . ' - File d\'attente'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center">
                <?php if($company->logo): ?>
                <img src="<?php echo e($company->logo); ?>" alt="<?php echo e($company->name); ?>" class="h-16 mx-auto mb-4">
                <?php endif; ?>
                <h1 class="text-3xl font-bold text-slate-900"><?php echo e($company->name); ?></h1>
                <p class="text-slate-500 mt-2">Prenez un ticket pour le service de votre choix</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-white font-bold text-lg"><?php echo e($service->name); ?></h3>
                        <span class="bg-white/20 text-white px-3 py-1 rounded-full text-sm font-medium">
                            <?php echo e($service->prefix); ?>

                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <?php if($service->description): ?>
                    <p class="text-slate-600 text-sm mb-4"><?php echo e($service->description); ?></p>
                    <?php endif; ?>

                    <div class="flex items-center justify-between text-sm text-slate-500 mb-6">
                        <span><?php echo e($service->estimated_service_time); ?> min/ticket</span>
                        <span><?php echo e($service->waiting_tickets_count); ?> en attente</span>
                    </div>

                    <form method="POST" action="<?php echo e(route('company.ticket.take', [$company, $service])); ?>" class="space-y-3">
                        <?php echo csrf_field(); ?>
                        <div>
                            <input type="text" name="client_name" placeholder="Votre nom (optionnel)"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <input type="tel" name="client_phone" placeholder="Votre téléphone (optionnel)"
                                class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium text-lg">
                            Prendre un Ticket
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-12">
                <p class="text-slate-500 text-lg">Aucun service disponible actuellement.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex justify-center items-center space-x-6 text-sm text-slate-500">
                <span>Propulsé par SmartQueue AI</span>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views/public/index.blade.php ENDPATH**/ ?>