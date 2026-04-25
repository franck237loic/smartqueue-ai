<?php $__env->startSection('title', 'Affichage Public - ' . $company->name); ?>

<?php $__env->startSection('content'); ?>
<script src="https://cdn.tailwindcss.com"></script>
<div class="min-h-screen bg-gradient-to-br from-dark-900 to-dark-800 p-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-8 py-6">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-2"><?php echo e($company->name); ?></h1>
            <p class="text-dark-400 text-lg">Système de file d'attente</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Display: Currently Called -->
            <div class="lg:col-span-2 space-y-4">
                <h2 class="text-2xl font-bold text-white mb-4 flex items-center gap-2">
                    <span class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></span>
                    Tickets appelés
                </h2>
                
                <div id="calledTickets" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php $__empty_1 = true; $__currentLoopData = $calledTickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $called): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="ticket-card bg-gradient-to-br from-brand-600/20 to-purple-600/20 border-2 border-brand-500/50 rounded-2xl p-6 animate-pulse-call">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-4xl font-bold text-brand-400"><?php echo e($called['number']); ?></span>
                                <span class="px-3 py-1 bg-brand-500/20 text-brand-400 rounded-full text-sm">
                                    <?php echo e($called['status'] === 'SERVING' ? 'En service' : 'Appelé'); ?>

                                </span>
                            </div>
                            <div class="text-white">
                                <p class="text-lg"><?php echo e($called['service']); ?></p>
                                <p class="text-2xl font-semibold text-green-400 mt-2">
                                    Guichet: <?php echo e($called['counter']); ?>

                                </p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full text-center py-12 bg-dark-800/50 rounded-2xl border border-dark-700">
                            <p class="text-dark-400 text-xl">Aucun ticket en cours</p>
                            <p class="text-dark-500 mt-2">En attente de l'appel suivant...</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Audio announcement indicator -->
                <div id="audioIndicator" class="hidden bg-green-500/10 border border-green-500/30 rounded-xl p-4 flex items-center justify-center gap-3">
                    <svg class="w-6 h-6 text-green-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                    </svg>
                    <span class="text-green-400 font-medium">Annonce en cours...</span>
                </div>
            </div>

            <!-- Side: Queue Status -->
            <div class="space-y-4">
                <h2 class="text-xl font-bold text-white mb-4">État des files</h2>
                
                <div class="bg-dark-800/50 border border-dark-700 rounded-2xl p-4 space-y-4">
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between py-3 border-b border-dark-700 last:border-0">
                            <div>
                                <p class="text-white font-medium"><?php echo e($service->name); ?></p>
                                <p class="text-dark-400 text-sm"><?php echo e($service->waiting_count); ?> en attente</p>
                            </div>
                            <div class="text-right">
                                <?php
                                    $lastCalled = \App\Models\Ticket::where('service_id', $service->id)
                                        ->whereIn('status', ['CALLED', 'SERVING'])
                                        ->orderBy('called_at', 'desc')
                                        ->first();
                                ?>
                                <?php if($lastCalled): ?>
                                    <p class="text-brand-400 font-bold"><?php echo e($lastCalled->number); ?></p>
                                    <p class="text-dark-500 text-xs">En cours</p>
                                <?php else: ?>
                                    <p class="text-dark-500 text-sm">-</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Clock -->
                <div class="bg-dark-800/50 border border-dark-700 rounded-2xl p-4 text-center">
                    <p id="clock" class="text-3xl font-bold text-white font-mono">--:--</p>
                    <p id="date" class="text-dark-400 mt-1">--/--/----</p>
                </div>

                <!-- Instructions -->
                <div class="bg-dark-800/50 border border-dark-700 rounded-2xl p-4">
                    <h3 class="text-white font-medium mb-3">Comment ça marche ?</h3>
                    <ol class="text-dark-400 text-sm space-y-2 list-decimal list-inside">
                        <li>Prenez un ticket au distributeur</li>
                        <li>Attendez votre numéro sur l'écran</li>
                        <li>Rendez-vous au guichet indiqué</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes pulse-call {
        0%, 100% { 
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
            transform: scale(1);
        }
        50% { 
            box-shadow: 0 0 40px rgba(59, 130, 246, 0.5);
            transform: scale(1.02);
        }
    }
    
    .animate-pulse-call {
        animation: pulse-call 2s ease-in-out infinite;
    }
    
    .ticket-card {
        transition: all 0.3s ease;
    }
    
    .ticket-card:hover {
        transform: translateY(-4px);
    }
</style>

<script>
    const companyId = <?php echo e($company->id); ?>;
    let lastTickets = [];

    // Clock
    function updateClock() {
        const now = new Date();
        document.getElementById('clock').textContent = now.toLocaleTimeString('fr-FR', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
        document.getElementById('date').textContent = now.toLocaleDateString('fr-FR', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Text to speech
    function announceTicket(number, counter, service) {
        if (!('speechSynthesis' in window)) return;
        
        const text = `Ticket ${number}, ${counter}`;
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'fr-FR';
        utterance.rate = 0.85;
        utterance.pitch = 1;
        utterance.volume = 1;
        
        // Show indicator
        const indicator = document.getElementById('audioIndicator');
        indicator.classList.remove('hidden');
        
        let count = 0;
        const maxRepetitions = 3;
        
        function speak() {
            if (count < maxRepetitions) {
                const u = new SpeechSynthesisUtterance(text);
                u.lang = 'fr-FR';
                u.rate = 0.85;
                u.pitch = 1;
                u.onend = () => {
                    count++;
                    if (count < maxRepetitions) {
                        setTimeout(speak, 1000);
                    } else {
                        indicator.classList.add('hidden');
                    }
                };
                speechSynthesis.speak(u);
            }
        }
        
        speak();
    }

    // Check for new tickets and announce
    function checkNewTickets(tickets) {
        const newTicketIds = tickets.map(t => t.number);
        const oldTicketIds = lastTickets.map(t => t.number);
        
        // Find newly called tickets
        for (const ticket of tickets) {
            if (!oldTicketIds.includes(ticket.number) && ticket.status === 'CALLED') {
                // New ticket called - announce it
                setTimeout(() => {
                    announceTicket(ticket.number, ticket.counter, ticket.service);
                }, 500);
            }
        }
        
        lastTickets = tickets;
    }

    // Refresh display
    async function refreshDisplay() {
        try {
            const response = await fetch(`/api/companies/${companyId}/tickets/currently-called`);
            const data = await response.json();
            
            checkNewTickets(data.tickets);
            
            // Update DOM if needed
            // (Optional: could dynamically update instead of full reload)
        } catch (error) {
            console.error('Error refreshing:', error);
        }
    }

    // Auto refresh every 5 seconds
    setInterval(refreshDisplay, 5000);

    // WebSocket
    if (typeof window.Echo !== 'undefined') {
        window.Echo.channel(`company.${companyId}`)
            .listen('.ticket.called', (e) => {
                // Announce new ticket
                setTimeout(() => {
                    announceTicket(e.ticket.number, e.ticket.counter, e.ticket.service);
                }, 500);
                
                // Refresh display after short delay
                setTimeout(() => location.reload(), 3000);
            })
            .listen('.ticket.status.changed', (e) => {
                // Refresh if ticket served or cancelled
                setTimeout(() => location.reload(), 1000);
            })
            .listen('.ticket.created', (e) => {
                // Update queue counts (optional)
            });
    }

    // Full page reload every 30 seconds to ensure sync
    setInterval(() => {
        location.reload();
    }, 30000);
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\tickets\public\display.blade.php ENDPATH**/ ?>