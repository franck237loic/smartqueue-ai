<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test SMS - SmartQueue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-sms text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Test SMS</h1>
                        <p class="text-gray-600">Vérification du système d'envoi de SMS</p>
                    </div>
                </div>
            </div>

            <!-- Configuration Status -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-cog mr-2"></i>Configuration SMS
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Twilio Activé</p>
                        <p class="text-lg font-bold <?php echo e(config('services.twilio.enabled') ? 'text-green-600' : 'text-red-600'); ?>">
                            <?php echo e(config('services.twilio.enabled') ? '✅ OUI' : '❌ NON'); ?>

                        </p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500">Numéro Twilio</p>
                        <p class="text-lg font-mono text-gray-800">
                            <?php echo e(config('services.twilio.from') ?: 'Non configuré'); ?>

                        </p>
                    </div>
                </div>

                <?php if(!config('services.twilio.enabled')): ?>
                <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-4 mt-4">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-exclamation-triangle text-yellow-600 mt-1"></i>
                        <div>
                            <h3 class="font-bold text-yellow-800">SMS non configuré</h3>
                            <p class="text-yellow-700 text-sm mt-1">
                                Le service SMS est désactivé. Les messages seront seulement simulés dans les logs.
                            </p>
                            <p class="text-yellow-600 text-xs mt-2">
                                Pour activer: TWILIO_ENABLED=true et TWILIO_PHONE_NUMBER=votre_numero
                            </p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Test Form -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-flask mr-2"></i>Test d'envoi
                </h2>
                
                <form method="POST" action="<?php echo e(route('admin.sms.test.send')); ?>" class="space-y-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Numéro de téléphone
                        </label>
                        <input type="tel" name="phone" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="+33612345678" 
                               value="<?php echo e(old('phone', '+33612345678')); ?>" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Message
                        </label>
                        <textarea name="message" rows="3" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Message de test..." required><?php echo e(old('message', 'SmartQueue: Test d\'envoi SMS - ' . now()->format('H:i:s'))); ?></textarea>
                    </div>
                    
                    <div class="flex space-x-4">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i>Envoyer le test
                        </button>
                        
                        <button type="button" onclick="testTicketCall()" 
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            <i class="fas fa-ticket-alt mr-2"></i>Simuler appel ticket
                        </button>
                    </div>
                </form>
            </div>

            <!-- Recent SMS Logs -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-history mr-2"></i>Logs SMS récents
                </h2>
                
                <div id="smsLogs" class="space-y-2">
                    <div class="text-gray-500 text-center py-4">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>Aucun log SMS récent</p>
                    </div>
                </div>
                
                <button onclick="refreshLogs()" 
                        class="mt-4 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>Rafraîchir
                </button>
            </div>
        </div>
    </div>

    <script>
        function testTicketCall() {
            fetch('/api/test/ticket-call', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    phone: document.querySelector('input[name="phone"]').value,
                    message: 'Test appel ticket depuis interface admin'
                })
            })
            .then(response => response.json())
            .then(data => {
                alert('Test d\'appel ticket envoyé! Vérifiez les logs.');
                refreshLogs();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erreur lors du test');
            });
        }

        function refreshLogs() {
            fetch('/api/sms-logs')
            .then(response => response.json())
            .then(data => {
                const logsContainer = document.getElementById('smsLogs');
                if (data.logs && data.logs.length > 0) {
                    logsContainer.innerHTML = data.logs.map(log => `
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="text-sm font-mono text-gray-800">${log.to}</p>
                                    <p class="text-sm text-gray-600 mt-1">${log.message}</p>
                                </div>
                                <div class="text-right ml-4">
                                    <p class="text-xs text-gray-500">${log.time}</p>
                                    <span class="inline-block px-2 py-1 text-xs rounded-full ${log.sent ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}">
                                        ${log.sent ? 'Envoyé' : 'Simulé'}
                                    </span>
                                </div>
                            </div>
                        </div>
                    `).join('');
                } else {
                    logsContainer.innerHTML = `
                        <div class="text-gray-500 text-center py-4">
                            <i class="fas fa-inbox text-4xl mb-2"></i>
                            <p>Aucun log SMS récent</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error fetching logs:', error);
            });
        }

        // Auto-refresh logs every 10 seconds
        setInterval(refreshLogs, 10000);
        
        // Initial load
        refreshLogs();
    </script>
</body>
</html>
<?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\admin\sms-test.blade.php ENDPATH**/ ?>