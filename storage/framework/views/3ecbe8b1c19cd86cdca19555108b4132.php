<?php $__env->startSection('title', 'Nouvel Agent - SmartQueue AI'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto px-4 sm:px-0 animate-fade-in">
    <div class="mb-6 sm:mb-8">
        <a href="<?php echo e(route('admin.agents')); ?>" class="text-gray-500 hover:text-primary transition text-sm inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux agents
        </a>
    </div>

    <div class="bg-white rounded-2xl card-shadow p-6 sm:p-8">
        <h1 class="text-xl sm:text-2xl font-bold text-text mb-4 sm:mb-6">Créer un nouvel agent</h1>

        <form method="POST" action="<?php echo e(route('admin.agents.store')); ?>" class="space-y-4 sm:space-y-6">
            <?php echo csrf_field(); ?>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nom complet</label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required
                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm sm:text-base"
                    placeholder="John Doe">
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
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required
                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm sm:text-base"
                    placeholder="agent@entreprise.com">
                <?php $__errorArgs = ['email'];
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
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Mot de passe</label>
                <input type="password" id="password" name="password" required
                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition text-sm sm:text-base"
                    placeholder="•••••">
                <p class="mt-2 text-sm text-gray-500">L'agent pourra changer son mot de passe après connexion</p>
                <?php $__errorArgs = ['password'];
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

            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-4">
                <a href="<?php echo e(route('admin.agents')); ?>" class="flex-1 py-2.5 sm:py-3 px-4 rounded-xl border-2 border-gray-200 text-gray-600 font-medium text-center hover:border-gray-300 transition text-sm sm:text-base">
                    Annuler
                </a>
                <button type="submit" class="flex-1 py-2.5 sm:py-3 px-4 rounded-xl gradient-primary text-white font-medium hover:opacity-90 transition text-sm sm:text-base">
                    Créer l'agent
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\admin\agents\create.blade.php ENDPATH**/ ?>