<?php $__env->startSection('title', $service->name . ' - ' . $company->name); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-[#F8FAFC]" style="font-family: 'Inter', sans-serif;">
    <!-- Header -->
    <div class="bg-slate-900 text-white sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-bold">
                        <?php echo e($service->prefix); ?>

                    </div>
                    <div class="ml-3">
                        <h1 class="font-bold"><?php echo e($service->name); ?></h1>
                        <p class="text-xs text-slate-400"><?php echo e($company->name); ?> Service</p>
                    </div>
                </div>
                <a href="<?php echo e(route('company.agent.dashboard', $company)); ?>" class="text-slate-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Service -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Tickets en attente</p>
                        <p class="text-2xl font-bold text-slate-900"><?php echo e($waitingTickets->count()); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-orange-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Temps moyen</p>
                        <p class="text-2xl font-bold text-slate-900"><?php echo e($service->estimated_service_time); ?> min</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Guichets</p>
                        <p class="text-2xl font-bold text-slate-900"><?php echo e($serviceCounters->count()); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Guichets du Service -->
        <h2 class="text-lg font-bold text-slate-900 mb-4">Guichets du Service</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <?php $__empty_1 = true; $__currentLoopData = $serviceCounters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-2xl shadow-sm border <?php echo e($counter->isOpen() ? 'border-green-200' : 'border-red-200'); ?> overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 <?php echo e($counter->isOpen() ? 'bg-green-50' : 'bg-red-50'); ?>">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 <?php echo e($counter->isOpen() ? 'bg-green-500' : 'bg-red-500'); ?> rounded-xl flex items-center justify-center text-white font-bold">
                                <?php echo e($counter->number); ?>

                            </div>
                            <div class="ml-3">
                                <h3 class="font-semibold text-slate-900"><?php echo e($counter->name); ?></h3>
                                <p class="text-xs text-slate-500"><?php echo e($counter->isOpen() ? 'Ouvert' : 'Fermé'); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="flex space-x-2">
                        <a href="<?php echo e(route('company.agent.counter', [$company->id, $counter->id])); ?>" class="flex-1 px-4 py-2 bg-[#2563EB] text-white rounded-lg hover:bg-blue-700 transition text-center text-sm font-medium">
                            Accéder
                        </a>

                        <?php if($counter->isOpen()): ?>
                        <form method="POST" action="<?php echo e(route('company.agent.counter.close', [$company->id, $counter->id])); ?>" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm font-medium">
                                Fermer
                            </button>
                        </form>
                        <?php else: ?>
                        <form method="POST" action="<?php echo e(route('company.agent.counter.open', [$company->id, $counter->id])); ?>" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition text-sm font-medium">
                                Ouvrir
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full bg-white rounded-2xl p-12 text-center shadow-sm border border-slate-200">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <p class="text-slate-500">Aucun guichet assigné à ce service.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Tickets en Attente -->
        <h2 class="text-lg font-bold text-slate-900 mb-4">Tickets en Attente</h2>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $waitingTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 font-bold">
                            <?php echo e($ticket->number); ?>

                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-slate-900">Ticket <?php echo e($ticket->number); ?></p>
                            <p class="text-sm text-slate-500"><?php echo e($ticket->created_at->format('H:i')); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-medium">
                            Position <?php echo e($ticket->getPosition()); ?>

                        </span>
                        <?php if($ticket->status === 'waiting'): ?>
                        <form method="POST" action="<?php echo e(route('company.agent.ticket.call', [$company->id, $ticket->id])); ?>" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                Appeler
                            </button>
                        </form>
                        <?php elseif($ticket->status === 'called'): ?>
                        <form method="POST" action="<?php echo e(route('company.agent.ticket.serve', [$company->id, $ticket->id])); ?>" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                Servir
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-6 py-8 text-center text-slate-500">
                    Aucun ticket en attente.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modern-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\company\agent\service.blade.php ENDPATH**/ ?>