<?php $__env->startSection('title', 'Choisir une entreprise - SmartQueue'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Choisissez une entreprise</h1>
            <p class="text-xl text-gray-600">Sélectionnez l'entreprise où vous souhaitez prendre un ticket</p>
        </div>

        <!-- Companies Grid -->
        <?php if($companies->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-2xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <div class="text-center">
                            <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                <span class="text-white font-bold text-2xl"><?php echo e(substr($company->name, 0, 1)); ?></span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo e($company->name); ?></h3>
                            <p class="text-gray-600 mb-4"><?php echo e($company->services->count()); ?> service(s) disponible(s)</p>
                            
                            <div class="space-y-3">
                                <a href="<?php echo e(route('company.public', $company)); ?>" class="w-full py-3 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium block text-center">
                                    Prendre un ticket
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucune entreprise disponible</h3>
                <p class="text-gray-600">Revenez plus tard ou contactez l'administrateur.</p>
            </div>
        <?php endif; ?>

        <!-- Back to Home -->
        <div class="text-center mt-12">
            <a href="<?php echo e(route('welcome')); ?>" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\client\select-company.blade.php ENDPATH**/ ?>