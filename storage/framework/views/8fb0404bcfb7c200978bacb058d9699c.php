<?php $__env->startSection('title', 'Files d\'attente - SmartQueue AI'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8 animate-fade-in">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-text mb-2">Files d'attente</h1>
            <p class="text-gray-500">Gérez toutes les files du système</p>
        </div>
        <a href="<?php echo e(route('admin.queues.create')); ?>" class="py-3 px-6 rounded-xl gradient-primary text-white font-medium hover:opacity-90 transition inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouvelle file
        </a>
    </div>

    <div class="bg-white rounded-2xl card-shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Préfixe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">En attente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Temps/service</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Créée par</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $__empty_1 = true; $__currentLoopData = $queues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-semibold text-text"><?php echo e($queue->name); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo e(Str::limit($queue->description, 50)); ?></p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-md bg-gray-100 text-sm font-medium text-gray-800">
                                    <?php echo e($queue->prefix); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    <?php echo e($queue->isActive() ? 'bg-green-100 text-green-800' : ($queue->status === 'paused' ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-800')); ?>">
                                    <?php echo e($queue->status); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-text"><?php echo e($queue->waitingTickets()->count()); ?></td>
                            <td class="px-6 py-4 text-gray-600"><?php echo e($queue->estimated_service_time); ?> min</td>
                            <td class="px-6 py-4 text-gray-600"><?php echo e($queue->user->name); ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1">
                                    <a href="<?php echo e(route('admin.queues.edit', $queue)); ?>" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-primary transition" title="Modifier">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <a href="<?php echo e(route('admin.statistics', $queue)); ?>" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-primary transition" title="Statistiques">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="<?php echo e(route('admin.queues.destroy', $queue)); ?>" class="inline" onsubmit="return confirm('Supprimer cette file ? Tous les tickets seront perdus.')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="p-2 rounded-lg hover:bg-red-50 text-gray-500 hover:text-error transition" title="Supprimer">
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
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 mb-4">Aucune file d'attente créée</p>
                                <a href="<?php echo e(route('admin.queues.create')); ?>" class="text-primary hover:underline font-medium">Créer votre première file</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($queues->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-100">
                <?php echo e($queues->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\admin\queues\index.blade.php ENDPATH**/ ?>