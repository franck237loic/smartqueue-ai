<?php $__env->startSection('title', 'Modifier File - SmartQueue AI'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="mb-8">
        <a href="<?php echo e(route('admin.queues')); ?>" class="text-gray-500 hover:text-primary transition text-sm inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux files
        </a>
    </div>

    <div class="bg-white rounded-2xl card-shadow p-8">
        <h1 class="text-2xl font-bold text-text mb-6">Modifier la file d'attente</h1>

        <form method="POST" action="<?php echo e(route('admin.queues.update', $queue)); ?>" class="space-y-6">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom de la file</label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name', $queue->name)); ?>" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-error"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition"><?php echo e(old('description', $queue->description)); ?></textarea>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                <select id="status" name="status" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">
                    <option value="active" <?php echo e($queue->status === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="paused" <?php echo e($queue->status === 'paused' ? 'selected' : ''); ?>>En pause</option>
                    <option value="closed" <?php echo e($queue->status === 'closed' ? 'selected' : ''); ?>>Fermée</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="prefix" class="block text-sm font-medium text-gray-700 mb-2">Préfixe</label>
                    <input type="text" id="prefix" name="prefix" value="<?php echo e(old('prefix', $queue->prefix)); ?>" required maxlength="5"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-center font-bold">
                </div>
                <div>
                    <label for="estimated_service_time" class="block text-sm font-medium text-gray-700 mb-2">Temps moyen (min)</label>
                    <input type="number" id="estimated_service_time" name="estimated_service_time" value="<?php echo e(old('estimated_service_time', $queue->estimated_service_time)); ?>" required min="1"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">
                </div>
            </div>

            <div>
                <label for="missed_timeout" class="block text-sm font-medium text-gray-700 mb-2">Délai d'absence (minutes)</label>
                <input type="number" id="missed_timeout" name="missed_timeout" value="<?php echo e(old('missed_timeout', $queue->missed_timeout)); ?>" required min="1"
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition">
            </div>

            <div class="flex gap-4 pt-4">
                <a href="<?php echo e(route('admin.queues')); ?>" class="flex-1 py-3 px-4 rounded-xl border-2 border-gray-200 text-gray-600 font-medium text-center hover:border-gray-300 transition">
                    Annuler
                </a>
                <button type="submit" class="flex-1 py-3 px-4 rounded-xl gradient-primary text-white font-medium hover:opacity-90 transition">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\admin\queues\edit.blade.php ENDPATH**/ ?>