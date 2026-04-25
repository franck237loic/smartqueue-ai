<?php $__env->startSection('title', 'Agents - ' . $company->name); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-white">Agents</h2>
            <p class="text-dark-600 mt-1">Gérez les agents et leurs assignations</p>
        </div>
        <a href="<?php echo e(route('company.admin.agents.create', $company)); ?>" class="px-4 py-2 bg-brand-600 text-white rounded-lg hover:bg-brand-700 text-sm font-medium shadow-lg shadow-brand-600/30 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nouvel Agent
        </a>
    </div>

    <!-- Agents List -->
    <div class="bg-dark-800 rounded-xl card-shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-dark-700/50 border-b border-dark-700">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-dark-600">Agent</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-dark-600">Rôle</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-dark-600">Guichet assigné</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-dark-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-dark-700">
                <?php $__empty_1 = true; $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-dark-700/30 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-purple-500/20 rounded-full flex items-center justify-center text-purple-400 font-bold">
                                <?php echo e(substr($agent->name, 0, 1)); ?>

                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-white"><?php echo e($agent->name); ?></p>
                                <p class="text-sm text-dark-600"><?php echo e($agent->email); ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-xs font-medium <?php echo e($agent->pivot->role === 'company_admin' ? 'bg-brand-500/20 text-brand-500' : 'bg-dark-700 text-dark-600'); ?>">
                            <?php echo e($agent->pivot->role === 'company_admin' ? 'Admin' : 'Agent'); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <?php if($agent->pivot->counter_id): ?>
                            <?php
                                $counter = $company->counters()->find($agent->pivot->counter_id);
                            ?>
                            <?php if($counter): ?>
                                <span class="px-3 py-1 bg-green-500/20 rounded-full text-sm text-green-400">
                                    <?php echo e($counter->name); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-dark-600">-</span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-dark-700 rounded-full text-sm text-dark-600">Non assigné</span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <form action="<?php echo e(route('company.admin.agents.destroy', [$company, $agent])); ?>" method="POST" class="inline" onsubmit="return confirm('Retirer cet agent de l\'entreprise ?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="p-2 text-dark-600 hover:text-red-400 transition" title="Retirer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6"/>
                                </svg>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-dark-600">
                        Aucun agent. <a href="<?php echo e(route('company.admin.agents.create', $company)); ?>" class="text-brand-500 hover:text-brand-400">Créer un agent</a>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($agents->hasPages()): ?>
    <div class="flex justify-center">
        <?php echo e($agents->links()); ?>

    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.company-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\company\admin\agents\index.blade.php ENDPATH**/ ?>