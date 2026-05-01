<?php $__env->startSection('title', 'Guichets - ' . $company->name); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Guichets</h2>
            <p class="text-dark-600 mt-1">Gérez les guichets et assignez les agents</p>
        </div>
        <a href="<?php echo e(route('company.admin.counters.create', $company)); ?>" class="px-4 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 text-sm font-medium shadow-lg shadow-brand-600/30 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouveau Guichet
        </a>
    </div>

    <!-- Counters List -->
    <div class="bg-dark-800 rounded-xl card-shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-dark-700/50 border-b border-dark-700">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-dark-600">Guichet</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-dark-600">Service</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-dark-600">Agent</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-dark-600">Statut</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-dark-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-700">
                <?php $__empty_1 = true; $__currentLoopData = $counters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-dark-700/30 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-500/20 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-white"><?php echo e($counter->name); ?></p>
                                <?php if($counter->number): ?>
                                    <p class="text-xs text-dark-600">N° <?php echo e($counter->number); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <?php if($counter->service): ?>
                            <span class="px-3 py-1 bg-brand-500/20 rounded-full text-sm text-brand-500">
                                <?php echo e($counter->service->name); ?>

                            </span>
                        <?php else: ?>
                            <span class="text-dark-600">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php
                            // Récupérer l'agent assigné via company_user
                            $assignedUser = null;
                            if ($counter->id) {
                                $companyUser = \Illuminate\Support\Facades\DB::table('company_user')
                                    ->where('company_id', $company->id)
                                    ->where('counter_id', $counter->id)
                                    ->first();
                                if ($companyUser) {
                                    $assignedUser = \App\Models\User::find($companyUser->user_id);
                                }
                            }
                        ?>
                        <?php if($assignedUser): ?>
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-purple-500/20 rounded-full flex items-center justify-center text-purple-400 text-xs font-bold">
                                    <?php echo e(substr($assignedUser->name, 0, 1)); ?>

                                </div>
                                <span class="ml-2 text-white"><?php echo e($assignedUser->name); ?></span>
                            </div>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-dark-700 rounded-full text-sm text-dark-600">Non assigné</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <?php if($counter->status === 'open'): ?>
                            <span class="px-3 py-1 bg-green-500/20 rounded-full text-xs font-medium text-green-400">
                                Ouvert
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-red-500/20 rounded-full text-xs font-medium text-red-400">
                                Fermé
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?php echo e(route('company.admin.counters.edit', [$company, $counter])); ?>" class="p-2 text-dark-600 hover:text-brand-500 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="<?php echo e(route('company.admin.counters.destroy', [$company, $counter])); ?>" method="POST" class="inline" onsubmit="return confirm('Supprimer ce guichet ?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="p-2 text-dark-600 hover:text-red-400 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-dark-600">
                        Aucun guichet. <a href="<?php echo e(route('company.admin.counters.create', $company)); ?>" class="text-brand-500 hover:text-brand-400">Créer un guichet</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($counters->hasPages()): ?>
    <div class="flex justify-center">
        <?php echo e($counters->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.company-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\company\admin\counters\index.blade.php ENDPATH**/ ?>