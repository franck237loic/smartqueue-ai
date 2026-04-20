<?php $__env->startSection('title', 'Suivi Ticket - ' . $ticket->number); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Suivi de Ticket</h1>
            <p class="text-gray-600">Banque Populaire</p>
        </div>

        <!-- Ticket Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
            <!-- Ticket Number -->
            <div class="text-center mb-8">
                <div class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-2xl p-6 shadow-lg">
                    <div class="text-sm font-medium mb-2">Votre ticket</div>
                    <div class="text-4xl font-bold"><?php echo e($ticket->number); ?></div>
                </div>
            </div>

            <!-- Status & Position -->
            <div class="mb-6">
                <?php if($ticket->isCalled()): ?>
                    <div class="presence-confirmation bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-green-800 mb-4">📢 Votre ticket a été appelé!</h3>
                        <p class="text-green-700 mb-4">Veuillez vous rendre au guichet <?php echo e($ticket->counter->name ?? 'N/A'); ?></p>
                        
                        <form method="POST" action="<?php echo e(route('client.confirm', ['ticket' => $ticket->id])); ?>" class="text-center">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="px-8 py-4 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold text-lg transition-colors duration-200 shadow-lg transform hover:scale-105">
                                ✋ Je suis présent
                            </button>
                        </form>
                    </div>
                <?php elseif($ticket->isWaiting()): ?>
                    <?php
                    $position = $ticket->getPosition();
                    $totalWaiting = \App\Models\Ticket::where('service_id', $ticket->service_id)
                        ->where('status', 'waiting')
                        ->count();
                    $estimatedTime = $ticket->getEstimatedWaitTime();
                    ?>
                    
                    <span class="px-4 py-2 bg-orange-100 text-orange-800 rounded-full font-medium">
                        En attente
                    </span>
                    
                    <!-- Position Complete -->
                    <div class="bg-gradient-to-r from-orange-50 to-yellow-50 rounded-lg p-4 mt-4 border border-orange-200">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-orange-800">Votre position</span>
                            <span class="text-2xl font-bold text-orange-900"><?php echo e($position); ?> / <?php echo e($totalWaiting); ?></span>
                        </div>
                        <div class="w-full bg-orange-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-orange-500 to-yellow-500 h-2 rounded-full" style="width: <?php echo e((($totalWaiting - $position + 1) / $totalWaiting) * 100); ?>%"></div>
                        </div>
                        <p class="text-sm text-orange-700 mt-2">
                            Plus que <?php echo e($position - 1); ?> personne<?php echo e($position > 2 ? 's' : ''); ?> avant vous
                        </p>
                    </div>
                    
                    <!-- Temps d'attente -->
                    <div class="bg-blue-50 rounded-lg p-4 mt-4 border border-blue-200">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-blue-800">Temps estimé</span>
                            <span class="text-xl font-bold text-blue-900"><?php echo e($estimatedTime); ?> minutes</span>
                        </div>
                        <p class="text-sm text-blue-700 mt-1">
                            Environ <?php echo e(round($estimatedTime / 60)); ?>h<?php echo e($estimatedTime % 60); ?>min d'attente
                        </p>
                    </div>
                    
                    <!-- Notifications intelligentes -->
                    <?php if($position <= 3): ?>
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mt-4 animate-pulse">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">
                                        <?php if($position == 1): ?>
                                            C'est votre tour ! Présentez-vous au guichet
                                        <?php elseif($position == 2): ?>
                                            Plus qu'une personne avant vous ! Préparez-vous
                                        <?php else: ?>
                                            Vous êtes dans les 3 prochains ! Restez à proximité
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php elseif($position <= 5): ?>
                        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mt-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-yellow-800">
                                        Votre tour approche ! Préparez vos documents
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                <?php elseif($ticket->isCalled()): ?>
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 animate-pulse">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-lg font-bold text-green-800">APPEL EN COURS !</p>
                                <p class="text-green-700 mt-1">
                                    Présentez-vous au: <span class="font-bold text-green-900"><?php echo e($ticket->counter?->name ?? 'Guichet'); ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php elseif($ticket->isServed()): ?>
                    <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full font-medium">
                        Servi
                    </span>
                <?php elseif($ticket->isPresent()): ?>
                    <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-medium">
                        ✅ Présent confirmé
                    </span>
                <?php elseif($ticket->isMissedTemp()): ?>
                    <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full font-medium">
                        Manqué
                    </span>
                <?php elseif($ticket->isCancelled()): ?>
                    <span class="px-4 py-2 bg-gray-100 text-gray-800 rounded-full font-medium">
                        Annulé
                    </span>
                <?php endif; ?>
            </div>

                <!-- Service info -->
                <div class="bg-slate-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-slate-500">Service</p>
                    <p class="font-medium text-slate-900"><?php echo e($ticket->service?->name ?? '-'); ?></p>
                </div>

                <!-- Actions -->
                <?php if($ticket->isWaiting()): ?>
                <form method="POST" action="<?php echo e(route('company.ticket.cancel', [$company, $ticket])); ?>" onsubmit="return confirm('Annuler ce ticket ?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="w-full py-3 border border-red-300 text-red-600 rounded-lg hover:bg-red-50 font-medium">
                        Annuler le ticket
                    </button>
                </form>
                <?php endif; ?>
            </div>

            <!-- Footer -->
            <div class="bg-slate-50 px-6 py-4 text-center">
                <a href="<?php echo e(route('company.public', $company)); ?>" class="text-blue-600 hover:text-blue-800 text-sm">
                    ← Retour aux services
                </a>
            </div>
        </div>

        <!-- Instructions -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="font-bold text-gray-900 mb-3">Comment suivre votre ticket</h3>
            <div class="space-y-2 text-sm text-gray-600">
                <p>1. <strong>Gardez cette page ouverte</strong> - Elle se met à jour automatiquement</p>
                <p>2. <strong>Écoutez les annonces</strong> - Votre numéro sera appelé</p>
                <p>3. <strong>Surveillez les notifications</strong> - Elles apparaissent quand c'est bientôt votre tour</p>
                <p>4. <strong>Présentez-vous au guichet</strong> - Quand votre ticket est appelé</p>
            </div>
            <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-800">
                    <strong>Dernière mise à jour:</strong> <span id="lastUpdate"><?php echo e(now()->format('H:i:s')); ?></span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript pour auto-rafraîchissement et notifications -->
<script>
let lastPosition = <?php echo e($ticket->getPosition() ?? 0); ?>;
let ticketId = <?php echo e($ticket->id); ?>;

// Son de notification (optionnel)
function playNotificationSound() {
    // Créer un son simple avec Web Audio API
    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
    const oscillator = audioContext.createOscillator();
    const gainNode = audioContext.createGain();
    
    oscillator.connect(gainNode);
    gainNode.connect(audioContext.destination);
    
    oscillator.frequency.value = 800;
    oscillator.type = 'sine';
    
    gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
    gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
    
    oscillator.start(audioContext.currentTime);
    oscillator.stop(audioContext.currentTime + 0.5);
}

// Mettre à jour l'heure de dernière mise à jour
function updateTimestamp() {
    document.getElementById('lastUpdate').textContent = new Date().toLocaleTimeString('fr-FR');
}

// Vérifier le statut du ticket
async function checkTicketStatus() {
    try {
        const response = await fetch(`/company/<?php echo e($company->id); ?>/ticket/${ticketId}/status`);
        const data = await response.json();
        
        if (data.status === 'called') {
            // Jouer un son et montrer une alerte
            playNotificationSound();
            showNotification('C\'est votre tour ! Présentez-vous au guichet', 'success');
            
            // Arrêter le rafraîchissement automatique
            clearInterval(refreshInterval);
            
            // Recharger la page après 2 secondes
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else if (data.position && data.position !== lastPosition) {
            // La position a changé
            const positionDiff = lastPosition - data.position;
            if (positionDiff > 0) {
                showNotification(`Votre position a changé : ${data.position}/${data.total}`, 'info');
            }
            lastPosition = data.position;
            
            // Recharger la page pour mettre à jour l'affichage
            window.location.reload();
        }
        
        updateTimestamp();
    } catch (error) {
        console.error('Erreur lors de la vérification du statut:', error);
    }
}

// Afficher une notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full`;
    
    const colors = {
        'success': 'bg-green-500 text-white',
        'warning': 'bg-yellow-500 text-white',
        'error': 'bg-red-500 text-white',
        'info': 'bg-blue-500 text-white'
    };
    
    notification.classList.add(...colors[type].split(' '));
    notification.innerHTML = `
        <div class="flex items-center">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                ×
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animation d'entrée
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto-suppression après 5 secondes
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// Rafraîchissement automatique toutes les 10 secondes
const refreshInterval = setInterval(checkTicketStatus, 10000);

// Vérification immédiate au chargement
checkTicketStatus();

// Notification si la page perd le focus
document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        checkTicketStatus();
    }
});

// Demander la permission pour les notifications du navigateur (optionnel)
if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
}
</script>

<!-- Refresh info -->
<p class="text-center text-slate-500 text-sm mt-4">
    Cette page se rafraichit automatiquement
</p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views/public/ticket.blade.php ENDPATH**/ ?>