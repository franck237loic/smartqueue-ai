<?php $__env->startSection('title', 'Nouvel Agent'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <a href="<?php echo e(route('company.admin.agents', $company)); ?>" class="text-dark-600 hover:text-white flex items-center gap-2 text-sm mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux agents
        </a>
        <h2 class="text-2xl font-bold text-white">Nouvel Agent</h2>
        <p class="text-dark-600 mt-1">Créez un nouvel agent pour votre entreprise</p>
    </div>

    <!-- Form -->
    <div class="bg-dark-800 rounded-xl card-shadow p-6">
        <form action="<?php echo e(route('company.admin.agents.store', $company)); ?>" method="POST" class="space-y-6">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Nom complet *</label>
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
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Email *</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    <?php $__errorArgs = ['email'];
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
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-dark-600 mb-2">Mot de passe *</label>
                    <input type="password" name="password" required minlength="8"
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white placeholder-dark-600 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    <?php $__errorArgs = ['password'];
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
                    <label class="block text-sm font-medium text-dark-600 mb-2">Rôle *</label>
                    <select name="role" required
                        class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                        <option value="agent" <?php echo e(old('role') == 'agent' ? 'selected' : ''); ?>>Agent</option>
                        <option value="company_admin" <?php echo e(old('role') == 'company_admin' ? 'selected' : ''); ?>>Admin entreprise</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-dark-600 mb-2">Assigner à un guichet</label>
                <select name="counter_id"
                    class="w-full px-4 py-3 bg-dark-900 border border-dark-700 rounded-lg text-white focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                    <option value="">-- Non assigné --</option>
                    <?php $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($counter->id); ?>" <?php echo e(old('counter_id') == $counter->id ? 'selected' : ''); ?>>
                            <?php echo e($counter->name); ?> <?php if($counter->service): ?> (<?php echo e($counter->service->name); ?>) <?php endif; ?>
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="mt-1 text-xs text-dark-600">L'agent ne pourra voir que les tickets de son service</p>
            </div>

            <div class="flex gap-4 pt-4">
                <a href="<?php echo e(route('company.admin.agents', $company)); ?>" class="flex-1 px-4 py-3 border border-dark-700 text-dark-600 rounded-lg hover:bg-dark-700/50 text-center transition">
                    Annuler
                </a>
                <button type="submit" class="flex-1 px-4 py-3 bg-brand-600 text-white rounded-lg hover:bg-brand-700 font-medium transition">
                    Créer l'agent
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.company-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\company\admin\agents\create.blade.php ENDPATH**/ ?>