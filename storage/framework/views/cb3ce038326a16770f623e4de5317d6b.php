<?php $__env->startSection('title', 'Suivi Ticket ' . $ticket->number); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-dark-900 to-dark-800 py-8 px-4">
    <div class="max-w-md mx-auto">
        <!-- Ticket Display -->
        <div class="bg-gradient-to-br from-brand-600 to-purple-600 rounded-3xl p-8 mb-6 text-center shadow-2xl shadow-brand-500/30">
            <p class="text-white/70 text-sm mb-2">Votre numéro</p>
            <h1 class="text-6xl font-bold text-white mb-2 ticket-number"><?php echo e($ticket->number); ?></h1>
            <p class="text-white/70"><?php echo e($ticket->service->name); ?></p>
        </div>

        <!-- Status Card -->
        <div class="bg-dark-800/50 border border-dark-700 rounded-2xl p-6 mb-4">
            <div class="flex items-center justify-between mb-4">
                <span class="text-dark-400">Statut</span>
                <span id="statusBadge" class="px-3 py-1 rounded-full text-sm font-medium status-badge">
                    <?php echo e($status['status']); ?>

                </span>
            </div>
            
            <div class="flex items-center justify-between mb-4">
                <span class="text-dark-400">Position</span>
                <span id="position" class="text-2xl font-bold text-white">
                    <?php echo e($status['position'] ?? '-'); ?>

                </span>
            </div>

            <div class="flex items-center justify-between">
                <span class="text-dark-400">Temps estimé</span>
                <span id="waitTime" class="text-brand-400 font-medium">
                    <?php if($status['position']): ?>
                        ~<?php echo e(ceil($status['estimated_wait_seconds'] / 60)); ?> min
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </span>
            </div>
        </div>

        <!-- Called Info (hidden by default) -->
        <div id="calledInfo" class="bg-green-500/10 border border-green-500/30 rounded-2xl p-6 mb-4 hidden">
            <div class="text-center">
                <p class="text-green-400 font-medium mb-2">C'est votre tour !</p>
                <p class="text-white text-lg">
                    Rendez-vous au <span id="counterName" class="font-bold text-green-400"></span>
                </p>
            </div>
        </div>

        <!-- Notifications -->
        <div id="notification" class="hidden mb-4 p-4 rounded-xl text-center"></div>

        <!-- Actions -->
        <div class="flex gap-3">
            <button onclick="refreshStatus()" 
                    class="flex-1 px-4 py-3 bg-dark-700 hover:bg-dark-600 text-white rounded-xl transition-colors flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Actualiser
            </button>
            
            <form method="POST" action="<?php echo e(route('tickets.cancel', ['company' => $company, 'ticket' => $ticket])); ?>" 
                  class="flex-1" id="cancelForm">
                <?php echo csrf_field(); ?>
                <button type="submit" 
                        class="w-full px-4 py-3 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-xl transition-colors"
                        onclick="return confirm('Annuler ce ticket ?')">
                    Annuler
                </button>
            </form>
        </div>

        <!-- QR Code for easy access -->
        <div class="mt-8 text-center">
            <p class="text-dark-500 text-sm mb-2">Gardez cette page ouverte pour suivre votre ticket</p>
            <p class="text-dark-600 text-xs">Ticket créé à <?php echo e($ticket->created_at->format('H:i')); ?></p>
        </div>
    </div>
</div>

<style>
    .status-WAITING { background: rgba(234, 179, 8, 0.2); color: #eab308; }
    .status-CALLED { background: rgba(34, 197, 94, 0.2); color: #22c55e; }
    .status-SERVING { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
    .status-SERVED { background: rgba(107, 114, 128, 0.2); color: #9ca3af; }
    .status-CANCELLED { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
    .status-MISSED_TEMP { background: rgba(249, 115, 22, 0.2); color: #f97316; }
    
    @keyframes pulse-ring {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(1.1); opacity: 0; }
    }
    
    .ticket-called {
        animation: pulse-ring 1s ease-out infinite;
    }
</style>

<script>
    const ticketId = <?php echo e($ticket->id); ?>;
    const companyId = <?php echo e($company->id); ?>;
    let lastStatus = '<?php echo e($status['status']); ?>';
    let audioContext = null;

    // Web Speech API pour annonce vocale
    function speakTicket(number, counter) {
        if ('speechSynthesis' in window) {
            const text = `Ticket ${number}, guichet ${counter}`;
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'fr-FR';
            utterance.rate = 0.9;
            utterance.pitch = 1;
            
            // Répéter 3 fois
            for (let i = 0; i < 3; i++) {
                setTimeout(() => {
                    speechSynthesis.speak(utterance);
                }, i * 3000);
            }
        }
    }

    // Mettre à jour l'affichage
    function updateDisplay(data) {
        const ticket = data.ticket;
        
        // Mettre à jour position
        document.getElementById('position').textContent = ticket.position || '-';
        
        // Mettre à jour temps d'attente
        const waitTimeEl = document.getElementById('waitTime');
        if (ticket.position) {
            const minutes = Math.ceil(ticket.estimated_wait_seconds / 60);
            waitTimeEl.textContent = `~${minutes} min`;
        } else {
            waitTimeEl.textContent = '-';
        }
        
        // Mettre à jour statut
        const statusBadge = document.getElementById('statusBadge');
        statusBadge.className = `px-3 py-1 rounded-full text-sm font-medium status-${ticket.status}`;
        statusBadge.textContent = formatStatus(ticket.status);
        
        // Afficher info guichet si appelé
        const calledInfo = document.getElementById('calledInfo');
        if (ticket.status === 'CALLED' || ticket.status === 'SERVING') {
            calledInfo.classList.remove('hidden');
            document.getElementById('counterName').textContent = ticket.counter?.name || 'Guichet';
            document.querySelector('.ticket-number').classList.add('ticket-called');
            
            // Annonce vocale si nouveau statut
            if (lastStatus !== 'CALLED' && ticket.status === 'CALLED') {
                speakTicket(ticket.number, ticket.counter?.name || '1');
            }
        } else {
            calledInfo.classList.add('hidden');
            document.querySelector('.ticket-number').classList.remove('ticket-called');
        }
        
        lastStatus = ticket.status;
        
        // Notifications
        if (ticket.position === 5) {
            showNotification('Plus que 5 personnes avant vous', 'warning');
        } else if (ticket.position === 3) {
            showNotification('Plus que 3 personnes, préparez-vous !', 'warning');
        } else if (ticket.position === 1) {
            showNotification('Vous êtes le prochain !', 'success');
        }
    }

    function formatStatus(status) {
        const labels = {
            'WAITING': 'En attente',
            'CALLED': 'Appelé',
            'SERVING': 'En service',
            'SERVED': 'Servi',
            'CANCELLED': 'Annulé',
            'MISSED_TEMP': 'Absent'
        };
        return labels[status] || status;
    }

    function showNotification(message, type) {
        const notif = document.getElementById('notification');
        notif.textContent = message;
        notif.className = `mb-4 p-4 rounded-xl text-center ${
            type === 'success' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400'
        }`;
        notif.classList.remove('hidden');
        
        setTimeout(() => {
            notif.classList.add('hidden');
        }, 5000);
    }

    // Rafraîchir le statut
    async function refreshStatus() {
        try {
            const response = await fetch(`/api/companies/${companyId}/tickets/${ticketId}/status`);
            const data = await response.json();
            updateDisplay(data);
        } catch (error) {
            console.error('Erreur:', error);
        }
    }

    // Auto-refresh toutes les 10 secondes
    setInterval(refreshStatus, 10000);

    // Laravel Reverb / WebSocket
    if (typeof window.Echo !== 'undefined') {
        window.Echo.channel(`ticket.${ticketId}`)
            .listen('.ticket.status.changed', (e) => {
                refreshStatus();
            });
            
        window.Echo.channel(`company.${companyId}`)
            .listen('.ticket.called', (e) => {
                // Vérifier si c'est notre ticket
                if (e.ticket.id === ticketId) {
                    refreshStatus();
                }
            });
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\tickets\client\track.blade.php ENDPATH**/ ?>