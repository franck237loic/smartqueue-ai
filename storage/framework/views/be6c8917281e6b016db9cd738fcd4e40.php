<script>
// Définition immédiate de tailwind pour éviter les erreurs
(function() {
    if (typeof window.tailwind === 'undefined') {
        window.tailwind = {
            colors: {
                blue: { 500: '#3b82f6' },
                white: '#ffffff',
                gray: { 100: '#f3f4f6', 200: '#e5e7eb', 300: '#d1d5db', 400: '#9ca3af', 500: '#6b7280', 600: '#4b5563', 700: '#374151', 800: '#1f2937', 900: '#111827' },
                green: { 500: '#22c55e' },
                red: { 500: '#ef4444' },
                yellow: { 500: '#f59e0b' }
            }
        };
        console.log('Tailwind défini immédiatement pour éviter les erreurs');
    }
})();
</script>


<?php $__env->startSection('title', 'Dashboard Agent - ' . $company->name); ?>

<?php $__env->startSection('content'); ?>
<script>
// Vérification de sécurité pour Tailwind
if (typeof window.tailwind === 'undefined') {
    console.warn('Tailwind n\'est pas disponible, création de l\'objet');
    window.tailwind = {
        colors: {
            blue: { 500: '#3b82f6' },
            white: '#ffffff',
            gray: { 100: '#f3f4f6', 200: '#e5e7eb', 300: '#d1d5db', 400: '#9ca3af', 500: '#6b7280', 600: '#4b5563', 700: '#374151', 800: '#1f2937', 900: '#111827' },
            green: { 500: '#22c55e' },
            red: { 500: '#ef4444' },
            yellow: { 500: '#f59e0b' }
        }
    };
}
</script>
<div class="min-h-screen bg-[#F8FAFC]" style="font-family: 'Inter', sans-serif;">
    <!-- Header Moderne -->
    <div class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="w-8 h-8 bg-[#2563EB] rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">A</span>
                    </div>
                    <div class="ml-3">
                        <h1 class="font-bold text-slate-900"><?php echo e($company->name); ?></h1>
                        <p class="text-xs text-slate-500">Interface Agent</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-slate-600"><?php echo e(auth()->user()->name); ?></span>
                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Tickets Servis</p>
                        <p class="text-2xl font-bold text-slate-900"><?php echo e($myTicketsToday ?? 0); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Guichets Actifs</p>
                        <p class="text-2xl font-bold text-slate-900"><?php echo e($myCounters->where('status', 'open')->count()); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">En Attente</p>
                        <p class="text-2xl font-bold text-orange-600">
                            <?php echo e($services->sum('waiting_tickets_count')); ?>

                        </p>
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
                        <p class="text-sm text-slate-500 mb-1">Temps Moyen</p>
                        <p class="text-2xl font-bold text-slate-900"><?php echo e($avgServiceTime ? round($avgServiceTime / 60) . 'm' : 'N/A'); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Tickets Manqués</p>
                        <p class="text-2xl font-bold text-red-600"><?php echo e($missedTicketsToday); ?></p>
                    </div>
                    <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 mb-1">Taux de Service</p>
                        <p class="text-2xl font-bold text-green-600"><?php echo e($serviceRateToday); ?>%</p>
                    </div>
                    <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ticket en Cours -->
        <?php if($currentTicket): ?>
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white mb-8">
            <h2 class="text-lg font-bold mb-4">Ticket en Cours</h2>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-3xl font-bold"><?php echo e($currentTicket->number); ?></p>
                    <p class="text-blue-100"><?php echo e($currentTicket->service->name); ?></p>
                    <p class="text-blue-100">Guichet <?php echo e($currentTicket->counter->number); ?></p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-blue-100">Appelé à</p>
                    <p class="text-lg font-semibold"><?php echo e($currentTicket->called_at->format('H:i')); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Actions Rapides -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-slate-900">Actions Rapides</h2>
            <a href="<?php echo e(route('company.agent.history', $company)); ?>" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Voir l'historique
            </a>
        </div>

        <!-- Guichets Cards -->
        <h2 class="text-lg font-bold text-slate-900 mb-4">Mes Guichets</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <?php $__empty_1 = true; $__currentLoopData = $myCounters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-2xl shadow-sm border <?php echo e($counter->isOpen() ? 'border-green-200' : 'border-red-200'); ?> overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 <?php echo e($counter->isOpen() ? 'bg-green-50' : 'bg-red-50'); ?>">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 <?php echo e($counter->isOpen() ? 'bg-green-500' : 'bg-red-500'); ?> rounded-xl flex items-center justify-center text-white font-bold">
                                <?php echo e($counter->number); ?>

                            </div>
                            <div class="ml-3">
                                <h3 class="font-semibold text-slate-900"><?php echo e($counter->name); ?></h3>
                                <p class="text-xs text-slate-500"><?php echo e($counter->service?->name ?? 'Sans service'); ?></p>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs font-medium <?php echo e($counter->isOpen() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e($counter->isOpen() ? 'Ouvert' : 'Fermé'); ?>

                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <?php if($counter->currentTicket()): ?>
                    <div class="mb-4 p-4 bg-blue-50 rounded-xl">
                        <p class="text-xs text-blue-600 mb-1">Ticket en cours</p>
                        <p class="text-2xl font-bold text-blue-700"><?php echo e($counter->currentTicket()->number); ?></p>
                    </div>
                    <?php else: ?>
                    <div class="mb-4 p-4 bg-slate-50 rounded-xl text-center">
                        <p class="text-slate-400 text-sm">Aucun ticket en cours</p>
                    </div>
                    <?php endif; ?>

                    <div class="flex space-x-2">
                        <a href="<?php echo e(route('company.agent.counter', [$company->id, $counter->id])); ?>" class="flex-1 px-4 py-2 bg-[#2563EB] text-white rounded-lg hover:bg-blue-700 transition text-center text-sm font-medium">
                            Accéder
                        </a>

                        <?php if($counter->isOpen()): ?>
                        <form method="POST" action="<?php echo e(route('company.agent.counter.close', [$company, $counter])); ?>" class="flex-1">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition text-sm font-medium">
                                Fermer
                            </button>
                        </form>
                        <?php else: ?>
                        <form method="POST" action="<?php echo e(route('company.agent.counter.open', [$company, $counter])); ?>" class="flex-1">
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
            <div class="col-span-full bg-white rounded-2xl shadow-sm border border-slate-200 p-12 text-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <p class="text-slate-500">Aucun guichet assigné. Contactez votre administrateur.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Services -->
        <h2 class="text-lg font-bold text-slate-900 mb-4">Services</h2>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50 transition-colors">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 font-bold">
                            <?php echo e($service->prefix); ?>

                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-slate-900"><?php echo e($service->name); ?></p>
                            <p class="text-sm text-slate-500"><?php echo e($service->estimated_service_time); ?> min/ticket</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-medium">
                            <?php echo e($service->waiting_tickets_count); ?> en attente
                        </span>
                        <a href="<?php echo e(route('company.agent.service', [$company, $service])); ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                            Accéder
                        </a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="px-6 py-8 text-center text-slate-500">
                    Aucun service disponible.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views/company/agent/dashboard-fintech.blade.php ENDPATH**/ ?>