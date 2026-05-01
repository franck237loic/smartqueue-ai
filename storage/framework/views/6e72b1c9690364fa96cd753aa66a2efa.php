<?php $__env->startSection('title', 'Nouveau Service'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="<?php echo e(route('company.admin.services', $company)); ?>" class="text-dark-600 hover:text-white flex items-center gap-2 text-sm mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux services
        </a>
        <h2 class="text-2xl font-bold text-white">Nouveau Service</h2>
        <p class="text-dark-600 mt-1">Créez un nouveau service pour votre entreprise</p>
    </div>

    <!-- Form -->
    <div class="bg-dark-800 rounded-xl card-shadow p-6">
        <form action="<?php echo e(route('company.admin.services.store', $company)); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>

            <div>
                <label class="block text-sm font-medium text-dark-600 mb-2">Nom du service *</label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" required
                    class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Préfixe *</label>
                    <input type="text" name="prefix" value="<?php echo e(old('prefix')); ?>" required maxlength="10"
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    <?php $__errorArgs = ['prefix'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-400"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Temps estimé (min) *</label>
                    <input type="number" name="estimated_service_time" value="<?php echo e(old('estimated_service_time', 5)); ?>" required min="1"
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-dark-600 mb-2">Description</label>
                <textarea name="description" rows="3"
                    class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500"><?php echo e(old('description')); ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Timeout absence (min) *</label>
                    <input type="number" name="missed_timeout" value="<?php echo e(old('missed_timeout', 5)); ?>" required min="1"
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Max tickets/jour</label>
                    <input type="number" name="max_daily_tickets" value="<?php echo e(old('max_daily_tickets', 100)); ?>" min="1"
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="<?php echo e(route('company.admin.services', $company)); ?>" class="flex-1 px-4 py-3 border border-dark-700 text-dark-600 rounded-lg hover:bg-dark-700/50 text-center transition">
                    Annuler
                </a>
                <button type="submit" class="flex-1 px-4 py-3 bg-brand-600 text-white rounded-lg hover:bg-brand-700 font-medium transition">
                    Créer le service
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.company-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\company\admin\services\create.blade.php ENDPATH**/ ?>