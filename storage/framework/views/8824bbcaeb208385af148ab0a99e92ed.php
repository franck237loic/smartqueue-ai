<?php $__env->startSection('title', 'Gestion des Entreprises - SmartQueue AI'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-text mb-2">Gestion des Entreprises</h1>
            <p class="text-gray-500">Gérez toutes les entreprises et leurs accès</p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="py-2 px-4 rounded-xl border-2 border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Retour
            </a>
        </div>
    </div>

    <?php if(session('success')): ?>
    <div class="bg-green-50 border-l-4 border-green-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 0l-2 2a1 1 0 101.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414l2-2z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700">
                    <?php echo e(session('success')); ?>

                </p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="bg-red-50 border-l-4 border-red-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700">
                    <?php echo e(session('error')); ?>

                </p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl card-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Entreprise</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisateurs</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créée le</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $__empty_1 = true; $__currentLoopData = App\Models\Company::with('users')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-text"><?php echo e($company->name); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo e($company->slug); ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm text-text"><?php echo e($company->email); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo e($company->phone); ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium <?php echo e($company->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e($company->status == 'active' ? 'Active' : 'Inactive'); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-text"><?php echo e($company->users->count()); ?></span>
                                    <div class="flex -space-x-1">
                                        <?php $__currentLoopData = $company->users->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="w-6 h-6 rounded-full bg-primary text-white text-xs flex items-center justify-center border-2 border-white">
                                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-text"><?php echo e($company->created_at->format('d/m/Y')); ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <!-- Récupération Mot de Passe -->
                                    <a href="<?php echo e(route('admin.companies.reset-password', $company)); ?>" 
                                       class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition"
                                       title="Réinitialiser les mots de passe">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 012 8.945V14a2 2 0 01-2 2h-2a2 2 0 01-2-2v-1.055A6 6 0 0112 3m0 0a6 6 0 016 8.945V14a2 2 0 01-2 2h-2a2 2 0 01-2-2v-1.055A6 6 0 0115 7m-6 3a2 2 0 002 2h2a2 2 0 002-2m-2-8a2 2 0 00-2 2H9a2 2 0 00-2 2v8a2 2 0 002 2h2a2 2 0 002-2V9z"/>
                                        </svg>
                                    </a>
                                    
                                    <!-- Activer/Désactiver -->
                                    <?php if($company->status == 'active'): ?>
                                    <form method="POST" action="<?php echo e(route('admin.company.deactivate', $company)); ?>" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition"
                                                title="Désactiver l'entreprise"
                                                onclick="return confirm('Êtes-vous sûr de vouloir désactiver cette entreprise ?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <?php else: ?>
                                    <form method="POST" action="<?php echo e(route('admin.company.activate', $company)); ?>" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="p-2 text-green-600 hover:text-green-800 hover:bg-green-50 rounded-lg transition"
                                                title="Activer l'entreprise">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune entreprise</h3>
                                    <p class="text-gray-500">Aucune entreprise n'a été créée pour le moment.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\admin\companies\index.blade.php ENDPATH**/ ?>