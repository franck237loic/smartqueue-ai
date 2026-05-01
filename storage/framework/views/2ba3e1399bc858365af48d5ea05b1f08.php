<?php $__env->startSection('title', 'Modifier Guichet'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="<?php echo e(route('company.admin.counters', $company)); ?>" class="text-dark-600 hover:text-white flex items-center gap-2 text-sm mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux guichets
        </a>
        <h2 class="text-2xl font-bold text-white">Modifier le Guichet</h2>
        <p class="text-dark-600 mt-1"><?php echo e($counter->name); ?></p>
    </div>

    <!-- Form -->
    <div class="bg-dark-800 rounded-xl card-shadow p-6">
        <form action="<?php echo e(route('company.admin.counters.update', [$company, $counter])); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Nom *</label>
                    <input type="text" name="name" value="<?php echo e(old('name', $counter->name)); ?>" required
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
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Numéro</label>
                    <input type="text" name="number" value="<?php echo e(old('number', $counter->number)); ?>"
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-dark-600 mb-2">Service associé</label>
                <select name="service_id"
                    class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    <option value="">-- Aucun service --</option>
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($service->id); ?>" <?php echo e(old('service_id', $counter->service_id) == $service->id ? 'selected' : ''); ?>>
                            <?php echo e($service->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-dark-600 mb-2">Emplacement</label>
                <input type="text" name="location" value="<?php echo e(old('location', $counter->location)); ?>"
                    class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" value="1" id="is_active" <?php echo e(old('is_active', $counter->is_active) ? 'checked' : ''); ?>

                    class="w-4 h-4 bg-dark-900 border-dark-700 rounded text-brand-600 focus:ring-brand-500">
                <label for="is_active" class="ml-2 text-sm text-dark-600">Guichet actif</label>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="<?php echo e(route('company.admin.counters', $company)); ?>" class="flex-1 px-4 py-3 border border-dark-700 text-dark-600 rounded-lg hover:bg-dark-700/50 text-center transition">
                    Annuler
                </a>
                <button type="submit" class="flex-1 px-4 py-3 bg-brand-600 text-white rounded-lg hover:bg-brand-700 font-medium transition">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.company-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\company\admin\counters\edit.blade.php ENDPATH**/ ?>