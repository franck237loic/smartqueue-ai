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

            <!-- Horaires de Travail -->
            <div class="border-t border-dark-700 pt-6">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Horaires de Travail
                </h3>
                
                <div class="space-y-4">
                    <!-- Horaires du matin -->
                    <div class="bg-dark-900 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-white mb-3">Horaires du matin</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-dark-600 mb-1">Heure de début *</label>
                                <input type="time" name="heure_debut_matin" value="07:00" required
                                    class="w-full px-3 py-2 bg-dark-800 border border-dark-700 rounded text-white text-sm focus:outline-none focus:border-brand-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-dark-600 mb-1">Heure de fin (pause) *</label>
                                <input type="time" name="heure_fin_matin" value="12:00" required
                                    class="w-full px-3 py-2 bg-dark-800 border border-dark-700 rounded text-white text-sm focus:outline-none focus:border-brand-500">
                            </div>
                        </div>
                    </div>

                    <!-- Horaires de l'après-midi -->
                    <div class="bg-dark-900 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-white mb-3">Horaires de l'après-midi</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-dark-600 mb-1">Heure de début (reprise) *</label>
                                <input type="time" name="heure_debut_apres_midi" value="14:00" required
                                    class="w-full px-3 py-2 bg-dark-800 border border-dark-700 rounded text-white text-sm focus:outline-none focus:border-brand-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-dark-600 mb-1">Heure de fin (journée) *</label>
                                <input type="time" name="heure_fin_apres_midi" value="17:30" required
                                    class="w-full px-3 py-2 bg-dark-800 border border-dark-700 rounded text-white text-sm focus:outline-none focus:border-brand-500">
                            </div>
                        </div>
                    </div>

                    <!-- Jours de travail -->
                    <div class="bg-dark-900 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-white mb-3">Jours de travail</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <?php $__currentLoopData = ['1' => 'Lundi', '2' => 'Mardi', '3' => 'Mercredi', '4' => 'Jeudi', '5' => 'Vendredi', '6' => 'Samedi', '7' => 'Dimanche']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="flex items-center gap-2 text-sm text-white cursor-pointer hover:text-brand-500 transition">
                                    <input type="checkbox" name="jours_travail[]" value="<?php echo e($day); ?>" 
                                           <?php echo e($day <= 5 ? 'checked' : ''); ?>

                                           class="rounded border-dark-700 text-brand-500 bg-dark-800 focus:ring-brand-500 focus:border-brand-500">
                                    <span><?php echo e($name); ?></span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <p class="mt-2 text-xs text-dark-600">Cochez les jours de travail de cet agent</p>
                    </div>

                    <!-- Fuseau horaire -->
                    <div class="bg-dark-900 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-white mb-3">Fuseau horaire</h4>
                        <select name="timezone" required
                                class="w-full px-3 py-2 bg-dark-800 border border-dark-700 rounded text-white text-sm focus:outline-none focus:border-brand-500">
                            <option value="Africa/Douala" selected>Africa/Douala (Cameroun)</option>
                            <option value="Europe/Paris">Europe/Paris</option>
                            <option value="Europe/London">Europe/London</option>
                            <option value="Europe/Berlin">Europe/Berlin</option>
                            <option value="Europe/Madrid">Europe/Madrid</option>
                            <option value="Europe/Rome">Europe/Rome</option>
                            <option value="America/New_York">America/New_York</option>
                            <option value="America/Los_Angeles">America/Los_Angeles</option>
                            <option value="Asia/Tokyo">Asia/Tokyo</option>
                        </select>
                    </div>
                </div>
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