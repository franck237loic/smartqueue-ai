<?php $__env->startSection('title', 'Statistiques - ' . $queue->name); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8 animate-fade-in">
    <div class="mb-8">
        <a href="<?php echo e(route('admin.queues')); ?>" class="text-gray-500 hover:text-primary transition text-sm inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Retour aux files
        </a>
    </div>

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-text mb-2">Statistiques</h1>
            <p class="text-gray-500"><?php echo e($queue->name); ?></p>
        </div>
        <a href="<?php echo e(route('client.public', $queue)); ?>" target="_blank" class="py-2 px-4 rounded-xl border-2 border-primary text-primary font-medium hover:bg-primary/5 transition inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Vue publique
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-text"><?php echo e($stats['waiting']); ?></span>
            </div>
            <p class="text-gray-500 text-sm">En attente maintenant</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-text"><?php echo e($stats['called']); ?></span>
            </div>
            <p class="text-gray-500 text-sm">En appel</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-text"><?php echo e($stats['served']); ?></span>
            </div>
            <p class="text-gray-500 text-sm">Servis aujourd'hui</p>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold text-text"><?php echo e($stats['missed']); ?></span>
            </div>
            <p class="text-gray-500 text-sm">Absents aujourd'hui</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-lg font-semibold text-text mb-6">Analyse IA</h3>
            <div class="space-y-4">
                <div class="p-4 bg-gray-50 rounded-xl">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-500">Estimation satisfaction</span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            <?php echo e($analytics['satisfaction_estimate'] === 'excellent' ? 'bg-green-100 text-green-800' : ($analytics['satisfaction_estimate'] === 'good' ? 'bg-blue-100 text-blue-800' : ($analytics['satisfaction_estimate'] === 'average' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800'))); ?>">
                            <?php echo e(ucfirst($analytics['satisfaction_estimate'])); ?>

                        </span>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-500">Temps moyen de service</span>
                        <span class="font-semibold text-text">
                            <?php echo e($analytics['avg_service_time'] ? round($analytics['avg_service_time'], 1) . ' min' : 'N/A'); ?>

                        </span>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-500">Tickets (7 jours)</span>
                        <span class="font-semibold text-text"><?php echo e($analytics['tickets_last_week']); ?></span>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-500">Tickets (30 jours)</span>
                        <span class="font-semibold text-text"><?php echo e($analytics['tickets_last_month']); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl card-shadow p-6">
            <h3 class="text-lg font-semibold text-text mb-6">Heures de pointe prévues</h3>
            <div class="space-y-2 max-h-80 overflow-y-auto">
                <?php $__currentLoopData = $analytics['peak_hours']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hour => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl">
                        <span class="w-12 text-sm font-medium text-gray-600"><?php echo e(sprintf('%02d', $hour)); ?>h</span>
                        <div class="flex-1">
                            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full transition-all" style="width: <?php echo e(min(100, $data['predicted_tickets'] * 10)); ?>%"></div>
                            </div>
                        </div>
                        <span class="text-sm text-gray-500 w-16 text-right">~<?php echo e($data['predicted_tickets']); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\admin\statistics.blade.php ENDPATH**/ ?>