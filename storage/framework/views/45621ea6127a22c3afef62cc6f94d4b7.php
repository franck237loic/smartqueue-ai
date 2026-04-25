<?php $__env->startSection('title', $counter->name . ' - ' . $company->name); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-slate-100">
    <!-- Header -->
    <div class="bg-slate-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div>
                    <h1 class="text-xl font-bold"><?php echo e($counter->name); ?></h1>
                    <p class="text-slate-400 text-sm"><?php echo e($company->name); ?> • <?php echo e($service?->name ?? 'Sans service'); ?></p>
                </div>
                <a href="<?php echo e(route('company.agent.dashboard', $company)); ?>" class="text-slate-400 hover:text-white">
                    ← Retour
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne principale - Ticket en cours -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Ticket Actuel -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                        <h2 class="text-white font-semibold">Ticket en Cours</h2>
                    </div>
                    <div class="p-8">
                        <?php if($currentTicket): ?>
                        <div class="text-center">
                            <div class="text-6xl font-bold text-blue-600 mb-4"><?php echo e($currentTicket->number); ?></div>
                            <p class="text-slate-600 mb-6">
                                <?php if($currentTicket->isCalled()): ?>
                                    Appelé à <?php echo e($currentTicket->called_at?->format('H:i')); ?>

                                <?php elseif($currentTicket->isPresent()): ?>
                                    ✅ Présent confirmé à <?php echo e($currentTicket->present_at?->format('H:i')); ?>

                                <?php elseif($currentTicket->isServing()): ?>
                                    🔧 En service depuis <?php echo e($currentTicket->serving_at?->format('H:i')); ?>

                                <?php endif; ?>
                            </p>

                            <div class="flex justify-center space-x-4">
                                <?php if($currentTicket->isCalled()): ?>
                                <form method="POST" action="<?php echo e(route('company.agent.ticket.present', [$company, $currentTicket])); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="px-8 py-3 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 font-medium">
                                        ✅ Confirmer Présence
                                    </button>
                                </form>
                                <?php endif; ?>

                                <?php if($currentTicket->isPresent()): ?>
                                <form method="POST" action="<?php echo e(route('company.agent.ticket.serving', [$company, $currentTicket])); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                                        🔧 Débuter Service
                                    </button>
                                </form>
                                <?php endif; ?>

                                <form method="POST" action="<?php echo e(route('company.agent.ticket.serve', [$company, $currentTicket])); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                                        ✓ Servi
                                    </button>
                                </form>

                                <form method="POST" action="<?php echo e(route('company.agent.ticket.missed', [$company, $currentTicket])); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="px-8 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                                        ✗ Absent
                                    </button>
                                </form>

                                <form method="POST" action="<?php echo e(route('company.agent.ticket.recall', [$company, $currentTicket])); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                        ↻ Rappeler
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-8">
                            <p class="text-slate-500 text-lg mb-6">Aucun ticket en cours</p>

                            <?php if($service && $counter->isOpen()): ?>
                            <form method="POST" action="<?php echo e(route('company.agent.call-next', [$company])); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="counter_id" value="<?php echo e($counter->id); ?>">
                                <button type="submit" class="px-8 py-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-lg font-bold">
                                    📢 Appeler Suivant
                                </button>
                            </form>
                            <?php elseif(!$counter->isOpen()): ?>
                            <p class="text-orange-600 font-medium">Guichet fermé - Ouvrez le guichet pour appeler</p>
                            <?php else: ?>
                            <p class="text-red-600 font-medium">Aucun service assigné à ce guichet</p>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- File d'attente -->
                <div class="bg-white rounded-xl shadow">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="font-semibold text-slate-900">File d'Attente</h3>
                    </div>
                    <div class="divide-y divide-slate-200">
                        <?php $__empty_1 = true; $__currentLoopData = $waitingTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="px-6 py-3 flex justify-between items-center hover:bg-slate-50 transition-colors">
                            <div>
                                <span class="font-medium text-slate-900"><?php echo e($ticket->number); ?></span>
                                <span class="ml-2 text-sm text-slate-500">
                                    En attente depuis <?php echo e($ticket->created_at->diffForHumans()); ?>

                                </span>
                                <?php if($ticket->guest_name): ?>
                                    <span class="ml-2 text-sm text-slate-600">• <?php echo e($ticket->guest_name); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                    En attente
                                </span>
                                <button onclick="recallTicket(<?php echo e($ticket->id); ?>)" 
                                        class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition-colors">
                                    📞 Rappeler
                                </button>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-6 py-8 text-center text-slate-500">
                            Aucun ticket en attente
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Colonne latérale - File d'attente -->
            <div class="space-y-6">
                <!-- Statut du guichet -->
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-slate-600">Statut</span>
                        <span class="px-3 py-1 rounded-full text-sm font-medium <?php echo e($counter->isOpen() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e($counter->isOpen() ? 'Ouvert' : 'Fermé'); ?>

                        </span>
                    </div>
                    
                    <!-- Actions du guichet -->
                    <div class="space-y-3">
                        <?php if($counter->isOpen()): ?>
                            <form method="POST" action="<?php echo e(route('company.agent.counter.close', [$company, $counter])); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                                    Fermer le guichet
                                </button>
                            </form>
                            
                            <form method="POST" action="<?php echo e(route('company.agent.counter.pause', [$company, $counter])); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 font-medium">
                                    Mettre en pause
                                </button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="<?php echo e(route('company.agent.counter.open', [$company, $counter])); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                                    Ouvrir le guichet
                                </button>
                            </form>
                        <?php endif; ?>
                        
                        <?php if($counter->isPaused()): ?>
                            <form method="POST" action="<?php echo e(route('company.agent.counter.resume', [$company, $counter])); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                                    Reprendre le service
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Tickets en attente -->
                <div class="bg-white rounded-xl shadow">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h3 class="font-semibold text-slate-900">File d'Attente</h3>
                        <p class="text-sm text-slate-500"><?php echo e($waitingTickets->count()); ?> ticket(s) en attente</p>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        <?php $__empty_1 = true; $__currentLoopData = $waitingTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="px-6 py-3 border-b border-slate-100 flex justify-between items-center">
                            <span class="font-medium text-slate-900"><?php echo e($ticket->number); ?></span>
                            <span class="text-sm text-slate-500">
                                <?php echo e($ticket->created_at->diffForHumans()); ?>

                            </span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="px-6 py-8 text-center text-slate-500">
                            Aucun ticket en attente
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Rafraîchissement automatique de la file d'attente
let refreshInterval;

function startAutoRefresh() {
    refreshInterval = setInterval(() => {
        refreshQueue();
    }, 5000); // Rafraîchir toutes les 5 secondes
}

function refreshQueue() {
    fetch(window.location.href, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newQueue = doc.querySelector('.divide-y.divide-slate-200');
        const currentQueue = document.querySelector('.divide-y.divide-slate-200');
        
        if (newQueue && currentQueue) {
            currentQueue.innerHTML = newQueue.innerHTML;
        }
        
        // Mettre à jour le compteur de tickets en attente
        const newCount = doc.querySelector('p.text-sm.text-slate-500');
        const currentCount = document.querySelector('p.text-sm.text-slate-500');
        if (newCount && currentCount) {
            currentCount.textContent = newCount.textContent;
        }
    })
    .catch(error => {
        console.log('Erreur lors du rafraîchissement:', error);
    });
}

// Fonction pour rappeler un ticket
function recallTicket(ticketId) {
    if (confirm('Voulez-vous vraiment rappeler ce ticket ?')) {
        fetch(`/api/tickets/${ticketId}/recall`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Ticket rappelé avec succès !');
                refreshQueue();
            } else {
                alert('Erreur lors du rappel: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Erreur lors du rappel du ticket');
        });
    }
}

// Démarrer le rafraîchissement automatique
document.addEventListener('DOMContentLoaded', function() {
    startAutoRefresh();
});

// Arrêter le rafraîchissement quand on quitte la page
window.addEventListener('beforeunload', function() {
    if (refreshInterval) {
        clearInterval(refreshInterval);
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.modern-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views/company/agent/counter.blade.php ENDPATH**/ ?>