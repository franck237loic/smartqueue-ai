<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi de Ticket - SmartQueue AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes blink {
            0%, 50%, 100% { opacity: 1; }
            25%, 75% { opacity: 0.5; }
        }
        .pulse-animation { animation: pulse 2s infinite; }
        .slide-animation { animation: slideIn 0.5s ease-out; }
        .blink-animation { animation: blink 1s infinite; }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .called-gradient {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }
        .soon-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
        }
        .next-gradient {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <header class="gradient-bg text-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-ticket-alt text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">SmartQueue</h1>
                        <p class="text-white/80">Suivi de Ticket à Distance</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-white/80">Votre Position</p>
                    <p class="font-mono font-bold text-3xl" id="currentPosition">-</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Ticket Info Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8 slide-animation">
            <div class="text-center">
                <div class="mb-6">
                    <div class="inline-block bg-gradient-to-r from-blue-500 to-purple-600 text-white px-6 py-3 rounded-full text-lg font-bold">
                        <?php echo e($ticket->number); ?>

                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-500 text-sm">Service</p>
                        <p class="text-lg font-bold text-gray-800"><?php echo e($ticket->service->name); ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-500 text-sm">Entreprise</p>
                        <p class="text-lg font-bold text-gray-800"><?php echo e($ticket->company->name); ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-500 text-sm">Statut</p>
                        <p class="text-lg font-bold" id="ticketStatus">
                            <?php echo e($ticket->status === 'CALLED' ? 'APPELÉ' : 'EN ATTENTE'); ?>

                        </p>
                    </div>
                </div>

                <!-- Status Display -->
                <div id="statusDisplay" class="mb-8">
                    <?php if($ticket->status === 'CALLED'): ?>
                    <div class="called-gradient text-white p-6 rounded-xl pulse-animation">
                        <div class="flex items-center justify-center space-x-3">
                            <i class="fas fa-bullhorn text-4xl blink-animation"></i>
                            <div>
                                <h2 class="text-2xl font-bold">📢 VOTRE TICKET EST APPELÉ !</h2>
                                <p class="text-lg">Présentez-vous au guichet immédiatement</p>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="bg-blue-100 text-blue-800 p-6 rounded-xl">
                        <div class="flex items-center justify-center space-x-3">
                            <i class="fas fa-clock text-3xl"></i>
                            <div>
                                <h2 class="text-xl font-bold">En attente</h2>
                                <p class="text-lg">Votre ticket sera appelé bientôt</p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>Progression</span>
                        <span id="progressText">Position: <?php echo e($ticket->getPosition()); ?></span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div id="progressBar" class="bg-gradient-to-r from-blue-500 to-purple-600 h-4 rounded-full transition-all duration-500" 
                             style="width: <?php echo e(max(10, 100 - ($ticket->getPosition() * 10))); ?>%"></div>
                    </div>
                </div>

                <!-- Notifications History -->
                <div class="bg-gray-50 p-6 rounded-xl">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">
                        <i class="fas fa-bell mr-2"></i>Notifications Reçues
                    </h3>
                    <div id="notificationsList" class="space-y-2 text-left">
                        <?php if($ticket->progressive_notifications): ?>
                            <?php $__currentLoopData = $ticket->progressive_notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white p-3 rounded-lg border-l-4 border-blue-500">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">
                                        <?php echo e($notification['type'] === 'soon' ? '🕐 Bientôt votre tour' : 
                                           ($notification['type'] === 'next' ? '⚡ Votre tour approche' : '📢 Ticket appelé')); ?>

                                    </span>
                                    <span class="text-xs text-gray-400">
                                        <?php echo e(\Carbon\Carbon::parse($notification['sent_at'])->format('H:i')); ?>

                                    </span>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p class="text-gray-500 text-sm">Aucune notification reçue pour le moment</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <?php if($ticket->status === 'CALLED'): ?>
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8 slide-animation">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">🎯 Répondez à l'appel</h3>
                
                <?php if($ticket->hasClientResponded()): ?>
                <div class="bg-green-50 border-2 border-green-200 rounded-xl p-6">
                    <div class="flex items-center justify-center space-x-3">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        <div>
                            <h4 class="text-lg font-bold text-green-800">Réponse enregistrée</h4>
                            <p class="text-green-600"><?php echo e($ticket->getClientResponseStatus()); ?></p>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="space-y-4">
                    <p class="text-gray-600 text-lg">Cliquez sur le bouton ci-dessous pour répondre à l'appel :</p>
                    
                    <a href="/ticket/<?php echo e($ticket->id); ?>/respond?code=<?php echo e($ticket->client_response_code); ?>" 
                       class="inline-block bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl text-lg font-bold transition-all duration-200 transform hover:scale-105 shadow-xl">
                        <i class="fas fa-thumbs-up mr-2"></i>
                        ✅ J'accepte - Je viens au guichet
                    </a>
                    
                    <div class="text-sm text-gray-500 mt-4">
                        <p>Ou répondez par SMS si vous avez reçu le lien</p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Instructions -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6">
            <div class="flex items-start space-x-3">
                <div class="bg-blue-100 p-2 rounded-lg mt-1">
                    <i class="fas fa-info text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-blue-800 mb-2">Instructions de suivi à distance</h3>
                    <ul class="text-blue-700 space-y-1 text-sm">
                        <li>• Cette page s'actualise automatiquement toutes les 30 secondes</li>
                        <li>• Vous recevrez des notifications SMS/Email pour les mises à jour importantes</li>
                        <li>• "Bientôt votre tour" : Il reste 3 personnes ou moins devant vous</li>
                        <li>• "Votre tour approche" : Vous êtes le prochain dans la queue</li>
                        <li>• "Ticket appelé" : Présentez-vous immédiatement au guichet</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Auto-refresh indicator -->
        <div class="text-center mt-6">
            <p class="text-gray-500 text-sm">Cette page s'actualise automatiquement</p>
            <div class="inline-flex items-center space-x-2 mt-2">
                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div>
                <span class="text-gray-600 text-sm">Prochaine mise à jour dans <span id="countdown">30</span>s</span>
            </div>
        </div>
    </main>

    <script>
        let countdown = 30;
        let ticketId = <?php echo e($ticket->id); ?>;
        let companyId = <?php echo e($ticket->company->id); ?>;

        // Auto-refresh countdown
        function updateCountdown() {
            document.getElementById('countdown').textContent = countdown;
            countdown--;
            
            if (countdown < 0) {
                countdown = 30;
                refreshTicketStatus();
            }
        }

        // Refresh ticket status
        async function refreshTicketStatus() {
            try {
                const response = await fetch(`/company/${companyId}/ticket/${ticketId}/status`);
                const data = await response.json();
                
                if (data.ticket) {
                    updateTicketDisplay(data.ticket);
                }
            } catch (error) {
                console.error('Erreur lors du rafraîchissement:', error);
            }
        }

        // Update ticket display
        function updateTicketDisplay(ticketData) {
            // Update position
            const position = ticketData.position || 1;
            document.getElementById('currentPosition').textContent = position;
            document.getElementById('progressText').textContent = `Position: ${position}`;
            
            // Update progress bar
            const progressBar = document.getElementById('progressBar');
            const progressWidth = Math.max(10, 100 - (position * 10));
            progressBar.style.width = progressWidth + '%';
            
            // Update status
            const status = ticketData.status;
            const statusElement = document.getElementById('ticketStatus');
            const statusDisplay = document.getElementById('statusDisplay');
            
            if (status === 'CALLED') {
                statusElement.textContent = 'APPELÉ';
                statusDisplay.innerHTML = `
                    <div class="called-gradient text-white p-6 rounded-xl pulse-animation">
                        <div class="flex items-center justify-center space-x-3">
                            <i class="fas fa-bullhorn text-4xl blink-animation"></i>
                            <div>
                                <h2 class="text-2xl font-bold">📢 VOTRE TICKET EST APPELÉ !</h2>
                                <p class="text-lg">Présentez-vous au guichet immédiatement</p>
                            </div>
                        </div>
                    </div>
                `;
                
                // Play notification sound
                playNotificationSound();
            } else {
                statusElement.textContent = 'EN ATTENTE';
                statusDisplay.innerHTML = `
                    <div class="bg-blue-100 text-blue-800 p-6 rounded-xl">
                        <div class="flex items-center justify-center space-x-3">
                            <i class="fas fa-clock text-3xl"></i>
                            <div>
                                <h2 class="text-xl font-bold">En attente</h2>
                                <p class="text-lg">Votre ticket sera appelé bientôt</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        }

        // Play notification sound
        function playNotificationSound() {
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

        // Start countdown
        setInterval(updateCountdown, 1000);

        // Initial load
        refreshTicketStatus();

        // Add notification badge when new notification arrives
        function addNotificationBadge(type, message) {
            const notificationsList = document.getElementById('notificationsList');
            const badge = document.createElement('div');
            badge.className = 'bg-yellow-50 p-3 rounded-lg border-l-4 border-yellow-500 slide-animation';
            badge.innerHTML = `
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">
                        🔔 ${message}
                    </span>
                    <span class="text-xs text-gray-400">
                        Maintenant
                    </span>
                </div>
            `;
            
            // Insert at the beginning
            notificationsList.insertBefore(badge, notificationsList.firstChild);
            
            // Remove after 5 seconds
            setTimeout(() => {
                badge.style.opacity = '0';
                setTimeout(() => badge.remove(), 500);
            }, 5000);
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\client\remote-tracking.blade.php ENDPATH**/ ?>