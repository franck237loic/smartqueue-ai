<?php $__env->startSection('title', 'Prise de Ticket - SmartQueue AI'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header avec navigation -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8">
            <div class="px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Prise de Ticket</h1>
                        <p class="text-sm text-gray-500">Sélectionnez une file d'attente</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="<?php echo e(route('dashboard')); ?>" class="text-gray-500 hover:text-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne gauche: Liste des files -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Files d'attente disponibles</h2>
                            <span class="text-sm text-gray-500"><?php echo e($queues->count()); ?> file(s)</span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <?php if($queues->count() > 0): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php $__currentLoopData = $queues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="border border-gray-200 rounded-xl p-5 hover:border-blue-300 hover:shadow-lg transition-all duration-300 cursor-pointer group"
                                         onclick="selectQueue(<?php echo e($queue->id); ?>, '<?php echo e($queue->name); ?>')">
                                        <div class="flex items-start space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors text-lg"><?php echo e($queue->name); ?></h3>
                                                <p class="text-gray-600 text-sm mt-1"><?php echo e($queue->description); ?></p>
                                                
                                                <div class="flex items-center justify-between mt-3">
                                                    <div class="flex items-center space-x-2">
                                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                                            <?php echo e($queue->isActive() ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                                                            <?php echo e($queue->status); ?>

                                                        </span>
                                                        <span class="text-xs text-gray-500">Préfixe: <?php echo e($queue->prefix); ?></span>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="text-sm font-semibold text-blue-600"><?php echo e($queue->waitingTickets()->count()); ?></div>
                                                        <div class="text-xs text-gray-500">en attente</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Aucune file d'attente disponible</h3>
                                <p class="text-gray-600 mb-4">Il n'y a actuellement aucune file d'attente active.</p>
                                <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Retour au dashboard
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Colonne droite: Panneau de confirmation -->
            <div class="lg:col-span-1">
                <div id="confirmationPanel" class="sticky top-8">
                    <!-- État initial -->
                    <div id="initialState" class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border border-blue-200 p-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Prêt à prendre votre ticket ?</h3>
                            <p class="text-gray-600 text-sm">Sélectionnez une file d'attente dans la liste pour commencer</p>
                        </div>
                    </div>

                    <!-- Formulaire de confirmation (caché par défaut) -->
                    <div id="confirmationForm" class="hidden bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                            <h3 class="text-white font-semibold">Confirmer la prise de ticket</h3>
                        </div>
                        
                        <div class="p-6">
                            <!-- File sélectionnée -->
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="text-blue-800 font-medium">File sélectionnée</p>
                                        <p id="selectedQueueName" class="text-blue-900 font-semibold text-lg"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Informations supplémentaires -->
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Ticket suivant</span>
                                    <span id="nextTicketNumber" class="font-mono font-semibold text-gray-900">---</span>
                                </div>
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Temps d'attente estimé</span>
                                    <span class="font-semibold text-gray-900">~15 min</span>
                                </div>
                                <div class="flex items-center justify-between py-2">
                                    <span class="text-gray-600">Personnes en attente</span>
                                    <span id="waitingCount" class="font-semibold text-gray-900">0</span>
                                </div>
                            </div>

                            <!-- Formulaire -->
                            <form method="POST" action="<?php echo e(route('tickets.store')); ?>" class="space-y-4">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="queue_id" id="queue_id" value="">
                                
                                <div class="grid grid-cols-2 gap-3">
                                    <button type="submit" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white py-3 px-4 rounded-xl font-medium hover:from-blue-600 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Confirmer
                                    </button>
                                    <button type="button" onclick="cancelSelection()" class="bg-gray-200 text-gray-800 py-3 px-4 rounded-xl font-medium hover:bg-gray-300 transition-all duration-200 flex items-center justify-center">
                                        Annuler
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Aide -->
                    <div class="mt-6 bg-gray-50 rounded-xl p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Besoin d'aide ?</h4>
                        <ul class="space-y-2 text-sm text-gray-600">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Sélectionnez une file d'attente
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Confirmez votre choix
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Prenez votre ticket
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectQueue(queueId, queueName) {
    document.getElementById('queue_id').value = queueId;
    document.getElementById('selectedQueueName').textContent = queueName;
    
    // Mettre à jour les informations
    updateQueueInfo(queueId);
    
    // Afficher le formulaire de confirmation
    document.getElementById('initialState').classList.add('hidden');
    document.getElementById('confirmationForm').classList.remove('hidden');
    
    // Scroll vers le panneau de confirmation
    document.getElementById('confirmationPanel').scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function updateQueueInfo(queueId) {
    // Simuler la mise à jour des informations (vous pouvez faire un appel AJAX ici)
    document.getElementById('nextTicketNumber').textContent = 'T' + new Date().getFullYear().toString().slice(-2) + String(new Date().getMonth() + 1).padStart(2, '0') + String(new Date().getDate()).padStart(2, '0') + '001';
    
    // Mettre à jour le nombre de personnes en attente
    fetch(`/api/queues/${queueId}/waiting-count`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('waitingCount').textContent = data.count || '0';
        })
        .catch(error => {
            console.error('Erreur:', error);
            document.getElementById('waitingCount').textContent = '?';
        });
}

function cancelSelection() {
    document.getElementById('queue_id').value = '';
    document.getElementById('selectedQueueName').textContent = '';
    
    // Revenir à l'état initial
    document.getElementById('confirmationForm').classList.add('hidden');
    document.getElementById('initialState').classList.remove('hidden');
}

// Animation au chargement
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter une animation subtile aux cartes
    const cards = document.querySelectorAll('.group');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\tickets\create.blade.php ENDPATH**/ ?>