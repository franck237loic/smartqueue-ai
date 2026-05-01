<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket <?php echo e($ticket->number); ?> - SmartQueue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes blink {
            0%, 50%, 100% { opacity: 1; }
            25%, 75% { opacity: 0.5; }
        }
        @keyframes slideIn {
            from { transform: translateY(-20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .pulse-animation { animation: pulse 2s infinite; }
        .blink-animation { animation: blink 1s infinite; }
        .card-animate { animation: slideIn 0.5s ease-out; }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .called-gradient {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
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
                        <p class="text-white/80">Votre Ticket</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-white/80">Numéro</p>
                    <p class="font-mono font-bold text-3xl"><?php echo e($ticket->number); ?></p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Status Card -->
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8 card-animate">
            <div class="text-center">
                <?php if($ticket->status === 'CALLED'): ?>
                <div class="called-gradient text-white p-6 rounded-xl mb-6 pulse-animation">
                    <div class="flex items-center justify-center space-x-3">
                        <i class="fas fa-bullhorn text-4xl blink-animation"></i>
                        <div>
                            <h2 class="text-2xl font-bold">📢 VOTRE TICKET EST APPELÉ !</h2>
                            <p class="text-lg">Présentez-vous au guichet</p>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="bg-blue-100 text-blue-800 p-6 rounded-xl mb-6">
                    <div class="flex items-center justify-center space-x-3">
                        <i class="fas fa-clock text-3xl"></i>
                        <div>
                            <h2 class="text-xl font-bold">En attente</h2>
                            <p class="text-lg">Votre ticket sera appelé bientôt</p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-500 text-sm">Service</p>
                        <p class="text-lg font-bold text-gray-800"><?php echo e($ticket->service->name); ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-500 text-sm">Statut</p>
                        <p class="text-lg font-bold <?php echo e($ticket->status === 'CALLED' ? 'text-orange-600' : 'text-gray-600'); ?>">
                            <?php echo e($ticket->status === 'CALLED' ? 'APPELÉ' : $ticket->status); ?>

                        </p>
                    </div>
                    <?php if($ticket->guest_name): ?>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-500 text-sm">Nom</p>
                        <p class="text-lg font-bold text-gray-800"><?php echo e($ticket->guest_name); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Action Section - Only show when called -->
        <?php if($ticket->status === 'CALLED'): ?>
        <div class="bg-white rounded-xl shadow-lg p-8 mb-8 card-animate">
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
                    <h3 class="text-lg font-bold text-blue-800 mb-2">Instructions</h3>
                    <ul class="text-blue-700 space-y-1 text-sm">
                        <?php if($ticket->status === 'CALLED'): ?>
                        <li>• Votre ticket est appelé - Présentez-vous rapidement</li>
                        <li>• Cliquez sur "J'accepte" pour confirmer votre présence</li>
                        <li>• Si vous êtes en retard, choisissez l'option correspondante</li>
                        <?php else: ?>
                        <li>• Votre ticket est en attente d'appel</li>
                        <li>• Surveillez l'affichage ou attendez la notification SMS</li>
                        <li>• Présentez-vous quand votre numéro sera appelé</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Auto-refresh -->
        <?php if($ticket->status !== 'CALLED'): ?>
        <div class="text-center mt-6">
            <p class="text-gray-500 text-sm">Cette page s'actualise automatiquement</p>
            <div class="inline-flex items-center space-x-2 mt-2">
                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-blue-600"></div>
                <span class="text-gray-600 text-sm">Vérification en cours...</span>
            </div>
        </div>
        <?php endif; ?>
    </main>

    <script>
        // Auto-refresh every 10 seconds if not called
        <?php if($ticket->status !== 'CALLED'): ?>
        setTimeout(() => {
            location.reload();
        }, 10000);
        <?php endif; ?>

        // Play sound if called
        <?php if($ticket->status === 'CALLED'): ?>
        // Create a simple beep sound
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
        <?php endif; ?>
    </script>
</body>
</html>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\client\ticket-display.blade.php ENDPATH**/ ?>