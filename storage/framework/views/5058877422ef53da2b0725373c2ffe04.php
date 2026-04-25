<?php $__env->startSection('title', 'Administration - SmartQueue AI'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8 animate-fade-in">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-text mb-2">Tableau de bord</h1>
            <p class="text-gray-500">Vue d'ensemble du système</p>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('admin.queues.create')); ?>" class="py-2 px-4 rounded-xl gradient-primary text-white font-medium hover:opacity-90 transition inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nouvelle file
            </a>
            <a href="<?php echo e(route('admin.agents.create')); ?>" class="py-2 px-4 rounded-xl border-2 border-primary text-primary font-medium hover:bg-primary/5 transition inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Nouvel agent
            </a>
            <a href="/admin/companies" class="py-2 px-4 rounded-xl bg-amber-500 text-white font-medium hover:bg-amber-600 transition inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Gérer les entreprises
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-text"><?php echo e($stats['total_queues']); ?></span>
            </div>
            <p class="text-gray-500 text-sm">Files totales</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-text"><?php echo e($stats['served_today']); ?></span>
            </div>
            <p class="text-gray-500 text-sm">Servis aujourd'hui</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-text"><?php echo e($stats['waiting_now']); ?></span>
            </div>
            <p class="text-gray-500 text-sm">En attente maintenant</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-text"><?php echo e(round($stats['avg_wait_time'])); ?> min</span>
            </div>
            <p class="text-gray-500 text-sm">Attente moyenne</p>
        </div>
    </div>

    <div>
        <h2 class="text-xl font-semibold text-text mb-6">Files d'attente</h2>
        <div class="bg-white rounded-2xl card-shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Préfixe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">En attente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Servis (24h)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php $__empty_1 = true; $__currentLoopData = $queues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-semibold text-text"><?php echo e($queue->name); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($queue->description); ?></p>
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
                                <td class="px-6 py-4 text-gray-600"><?php echo e($queue->servedTickets()->whereDate('served_at', today())->count()); ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="<?php echo e(route('admin.queues.edit', $queue)); ?>" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-primary transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        <a href="<?php echo e(route('admin.statistics', $queue)); ?>" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500 hover:text-primary transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                            </svg>
                                        </a>
                                        <form method="POST" action="<?php echo e(route('admin.queues.destroy', $queue)); ?>" class="inline" onsubmit="return confirm('Supprimer cette file ?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="p-2 rounded-lg hover:bg-red-50 text-gray-500 hover:text-error transition">
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
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    Aucune file d'attente créée
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php if($agents->count() > 0): ?>
        <div>
            <h2 class="text-xl font-semibold text-text mb-6">Agents</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-2xl card-shadow p-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
                                <span class="text-lg font-bold text-primary"><?php echo e(substr($agent->name, 0, 1)); ?></span>
                            </div>
                            <div>
                                <p class="font-semibold text-text"><?php echo e($agent->name); ?></p>
                                <p class="text-sm text-gray-500"><?php echo e($agent->email); ?></p>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between text-sm">
                            <span class="text-gray-500">Tickets servis</span>
                            <span class="font-semibold text-text"><?php echo e($agent->tickets()->where('status', 'served')->count()); ?></span>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\admin\dashboard.blade.php ENDPATH**/ ?>