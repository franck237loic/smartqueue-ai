<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réponse Ticket - SmartQueue</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes slideIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        .pulse-animation { animation: pulse 2s infinite; }
        .card-animate { animation: slideIn 0.3s ease-out; }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
                        <p class="text-white/80">Réponse au ticket</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-white/80">Référence</p>
                    <p class="font-mono font-bold">{{ $ticket->number }}</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Ticket Info Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 card-animate">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>
                    Informations du Ticket
                </h2>
                <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-sm font-semibold">
                    {{ $ticket->service->name }}
                </span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500 text-sm">Numéro de ticket</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $ticket->number }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Statut actuel</p>
                    <p class="text-lg font-semibold {{ $ticket->status === 'CALLED' ? 'text-orange-600' : 'text-gray-600' }}">
                        {{ $ticket->status === 'CALLED' ? 'APPELÉ' : $ticket->status }}
                    </p>
                </div>
                @if($ticket->guest_name)
                <div>
                    <p class="text-gray-500 text-sm">Nom du client</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $ticket->guest_name }}</p>
                </div>
                @endif
                <div>
                    <p class="text-gray-500 text-sm">Heure d'appel</p>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $ticket->called_at ? $ticket->called_at->format('H:i') : '--:--' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Response Status -->
        @if($ticket->hasClientResponded())
        <div class="bg-green-50 border-2 border-green-200 rounded-xl p-6 mb-6 card-animate">
            <div class="flex items-center space-x-3">
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-green-800">Réponse enregistrée</h3>
                    <p class="text-green-600">{{ $ticket->getClientResponseStatus() }}</p>
                    @if($ticket->client_response_at)
                    <p class="text-sm text-green-500">
                        Réponse envoyée à {{ $ticket->client_response_at->format('H:i') }}
                    </p>
                    @endif
                </div>
            </div>
        </div>
        @else
        <!-- Response Options -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-reply mr-2 text-purple-600"></i>
                    Votre Réponse
                </h2>
                <div class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm font-semibold pulse-animation">
                    En attente de réponse
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Accepter/Coming Option -->
                <button onclick="respondToTicket('coming')" class="bg-green-600 hover:bg-green-700 text-white p-6 rounded-xl transition-all duration-200 transform hover:scale-105 text-left border-4 border-green-700 shadow-xl">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 p-3 rounded-lg">
                            <i class="fas fa-check-circle text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">✅ Accepter</h3>
                            <p class="text-green-100 text-sm">Je viens au guichet maintenant</p>
                        </div>
                    </div>
                </button>

                <!-- Delayed Option -->
                <button onclick="showDelayedModal()" class="bg-yellow-600 hover:bg-yellow-700 text-white p-6 rounded-xl transition-all duration-200 transform hover:scale-105 text-left">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 p-3 rounded-lg">
                            <i class="fas fa-clock text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Je suis en retard</h3>
                            <p class="text-yellow-100 text-sm">J'ai besoin de quelques minutes</p>
                        </div>
                    </div>
                </button>

                <!-- Need Help Option -->
                <button onclick="respondToTicket('need_help')" class="bg-blue-600 hover:bg-blue-700 text-white p-6 rounded-xl transition-all duration-200 transform hover:scale-105 text-left">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 p-3 rounded-lg">
                            <i class="fas fa-hands-helping text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Besoin d'aide</h3>
                            <p class="text-blue-100 text-sm">J'ai besoin d'assistance</p>
                        </div>
                    </div>
                </button>

                <!-- Not Coming Option -->
                <button onclick="respondToTicket('not_coming')" class="bg-red-600 hover:bg-red-700 text-white p-6 rounded-xl transition-all duration-200 transform hover:scale-105 text-left">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white/20 p-3 rounded-lg">
                            <i class="fas fa-times-circle text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Je ne viens pas</h3>
                            <p class="text-red-100 text-sm">Annuler mon ticket</p>
                        </div>
                    </div>
                </button>
            </div>
        </div>
        @endif

        <!-- Instructions -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-6">
            <div class="flex items-start space-x-3">
                <div class="bg-blue-100 p-2 rounded-lg mt-1">
                    <i class="fas fa-info text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-blue-800 mb-2">Instructions</h3>
                    <ul class="text-blue-700 space-y-1 text-sm">
                        <li>• Votre ticket a été appelé par un agent</li>
                        <li>• Répondez rapidement pour optimiser le temps d'attente</li>
                        <li>• Si vous êtes en retard, indiquez le temps nécessaire</li>
                        <li>• En cas de problème, demandez de l'aide</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <!-- Delayed Modal -->
    <div id="delayedModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-xl p-6 m-4 max-w-md w-full">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Temps de retard</h3>
            <p class="text-gray-600 mb-4">Combien de minutes avez-vous besoin ?</p>
            
            <div class="grid grid-cols-3 gap-2 mb-4">
                <button onclick="respondDelayed(5)" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-lg text-center">5 min</button>
                <button onclick="respondDelayed(10)" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-lg text-center">10 min</button>
                <button onclick="respondDelayed(15)" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-lg text-center">15 min</button>
                <button onclick="respondDelayed(20)" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-lg text-center">20 min</button>
                <button onclick="respondDelayed(30)" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-lg text-center">30 min</button>
                <button onclick="respondDelayed(45)" class="bg-gray-100 hover:bg-gray-200 p-3 rounded-lg text-center">45 min</button>
            </div>
            
            <div class="flex space-x-2">
                <button onclick="hideDelayedModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg">
                    Annuler
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-full transition-transform duration-300 z-50">
        <div class="flex items-center space-x-2">
            <i class="fas fa-check-circle"></i>
            <span id="toast-message">Réponse envoyée</span>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-3">
            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
            <span>Envoi en cours...</span>
        </div>
    </div>

    <script>
        // Show toast notification
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            
            toastMessage.textContent = message;
            toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg transform transition-transform duration-300 z-50 ${
                type === 'success' ? 'bg-green-600 text-white' : 
                type === 'error' ? 'bg-red-600 text-white' : 
                type === 'warning' ? 'bg-orange-600 text-white' :
                'bg-blue-600 text-white'
            }`;
            
            toast.style.transform = 'translateY(0)';
            
            setTimeout(() => {
                toast.style.transform = 'translateY(100%)';
            }, 3000);
        }

        // Show/hide loading
        function setLoading(show) {
            const loading = document.getElementById('loading');
            if (show) {
                loading.classList.remove('hidden');
            } else {
                loading.classList.add('hidden');
            }
        }

        // Show delayed modal
        function showDelayedModal() {
            document.getElementById('delayedModal').classList.remove('hidden');
        }

        // Hide delayed modal
        function hideDelayedModal() {
            document.getElementById('delayedModal').classList.add('hidden');
        }

        // Respond to ticket
        async function respondToTicket(response) {
            setLoading(true);
            try {
                const response_data = await fetch(`/api/client/tickets/{{ $ticket->id }}/respond`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        response: response
                    })
                });

                const data = await response_data.json();
                
                if (response_data.ok) {
                    showToast(data.message, 'success');
                    // Reload page after 2 seconds to show updated status
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showToast(data.message || 'Erreur lors de l\'envoi', 'error');
                }
            } catch (error) {
                showToast('Erreur de communication', 'error');
                console.error('Error:', error);
            } finally {
                setLoading(false);
            }
        }

        // Respond with delay
        async function respondDelayed(delayMinutes) {
            setLoading(true);
            hideDelayedModal();
            
            try {
                const response_data = await fetch(`/api/client/tickets/{{ $ticket->id }}/respond`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        response: 'delayed',
                        delay_minutes: delayMinutes
                    })
                });

                const data = await response_data.json();
                
                if (response_data.ok) {
                    showToast(data.message, 'success');
                    // Reload page after 2 seconds to show updated status
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showToast(data.message || 'Erreur lors de l\'envoi', 'error');
                }
            } catch (error) {
                showToast('Erreur de communication', 'error');
                console.error('Error:', error);
            } finally {
                setLoading(false);
            }
        }

        // Auto-refresh every 30 seconds
        setInterval(() => {
            location.reload();
        }, 30000);
    </script>
</body>
</html>
