@extends('layouts.app')

@section('title', 'Agent - Gestion des Tickets')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark-900 to-dark-800">
    <!-- Top Bar -->
    <div class="bg-dark-800/50 border-b border-dark-700 p-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h1 class="text-xl font-bold text-white">Guichet: {{ $counter->name }}</h1>
                <span class="px-3 py-1 bg-brand-600/20 text-brand-400 rounded-full text-sm">
                    {{ $counter->status === 'open' ? 'Disponible' : 'Occupé' }}
                </span>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-dark-400">{{ auth()->user()->name }}</span>
                <a href="{{ route('logout') }}" class="text-red-400 hover:text-red-300 text-sm">
                    Déconnexion
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Current Ticket -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Current Ticket Card -->
                <div class="bg-dark-800/50 border border-dark-700 rounded-2xl p-8">
                    @if($currentTicket)
                        <div class="text-center mb-6">
                            <p class="text-dark-400 mb-2">Ticket en cours</p>
                            <h2 class="text-5xl font-bold text-brand-400 mb-2">{{ $currentTicket->number }}</h2>
                            <p class="text-white">{{ $currentTicket->service->name }}</p>
                            @if($currentTicket->guest_name)
                                <p class="text-dark-400 mt-2">{{ $currentTicket->guest_name }}</p>
                            @endif
                        </div>

                        <!-- Timer -->
                        <div class="flex justify-center mb-6">
                            <div class="bg-dark-900 rounded-xl px-6 py-3">
                                <span id="timer" class="text-2xl font-mono text-white">00:00</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="grid grid-cols-3 gap-3">
                            @if($currentTicket->isCalled())
                                <button onclick="markServing({{ $currentTicket->id }})"
                                        class="px-4 py-3 bg-blue-500/20 hover:bg-blue-500/30 text-blue-400 rounded-xl transition-colors">
                                    En service
                                </button>
                            @endif
                            
                            <button onclick="markServed({{ $currentTicket->id }})"
                                    class="px-4 py-3 bg-green-500/20 hover:bg-green-500/30 text-green-400 rounded-xl transition-colors">
                                Servi
                            </button>
                            
                            <button onclick="markMissed({{ $currentTicket->id }})"
                                    class="px-4 py-3 bg-orange-500/20 hover:bg-orange-500/30 text-orange-400 rounded-xl transition-colors">
                                Absent
                            </button>
                        </div>

                        <div class="mt-4 flex justify-center">
                            <button onclick="callAgain({{ $currentTicket->id }})"
                                    class="px-4 py-2 text-brand-400 hover:text-brand-300 text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/>
                                </svg>
                                Rappeler
                            </button>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-dark-400 mb-6">Aucun ticket en cours</p>
                            
                            <button onclick="callNext()" id="callNextBtn"
                                    class="px-8 py-4 bg-gradient-to-r from-brand-600 to-purple-600 hover:from-brand-500 hover:to-purple-500 text-white rounded-xl text-lg font-medium transition-all shadow-lg shadow-brand-500/30">
                                Appeler suivant
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Service Selection for Call -->
                @if(!$currentTicket)
                    <div class="bg-dark-800/50 border border-dark-700 rounded-2xl p-6">
                        <h3 class="text-white font-medium mb-4">Sélectionner un service</h3>
                        <div class="flex flex-wrap gap-3">
                            @foreach($counter->services as $service)
                                <button onclick="selectService({{ $service->id }})" 
                                        id="service-btn-{{ $service->id }}"
                                        class="service-btn px-4 py-2 bg-dark-700 hover:bg-dark-600 text-white rounded-lg transition-colors {{ $loop->first ? 'ring-2 ring-brand-500' : '' }}">
                                    {{ $service->name }}
                                    @php
                                        $count = \App\Models\Ticket::where('service_id', $service->id)
                                            ->where('status', 'WAITING')
                                            ->count();
                                    @endphp
                                    <span class="ml-2 text-xs text-dark-400">({{ $count }})</span>
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right: Queue -->
            <div class="space-y-6">
                <!-- Stats -->
                <div class="bg-dark-800/50 border border-dark-700 rounded-2xl p-6">
                    <h3 class="text-white font-medium mb-4">File d'attente</h3>
                    
                    @foreach($queue as $serviceId => $tickets)
                        @php $service = \App\Models\Service::find($serviceId); @endphp
                        @if($service)
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-dark-400 text-sm">{{ $service->name }}</span>
                                    <span class="text-brand-400 font-medium">{{ count($tickets) }}</span>
                                </div>
                                
                                <div class="space-y-2 max-h-40 overflow-y-auto">
                                    @foreach(array_slice($tickets, 0, 5) as $item)
                                        <div class="flex items-center justify-between bg-dark-900/50 rounded-lg px-3 py-2">
                                            <span class="text-white font-medium">{{ $item['ticket']['number'] }}</span>
                                            <span class="text-dark-500 text-sm">#{{ $item['position'] }}</span>
                                        </div>
                                    @endforeach
                                    
                                    @if(count($tickets) > 5)
                                        <p class="text-dark-500 text-sm text-center py-2">
                                            +{{ count($tickets) - 5 }} autres
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Recent History -->
                <div class="bg-dark-800/50 border border-dark-700 rounded-2xl p-6">
                    <h3 class="text-white font-medium mb-4">Historique récent</h3>
                    
                    @php
                        $recentTickets = \App\Models\Ticket::where('counter_id', $counter->id)
                            ->whereDate('created_at', today())
                            ->whereIn('status', ['SERVED', 'CANCELLED', 'MISSED_TEMP'])
                            ->orderBy('updated_at', 'desc')
                            ->limit(5)
                            ->get();
                    @endphp
                    
                    <div class="space-y-2">
                        @forelse($recentTickets as $ticket)
                            <div class="flex items-center justify-between bg-dark-900/50 rounded-lg px-3 py-2">
                                <div>
                                    <span class="text-white font-medium">{{ $ticket->number }}</span>
                                    <span class="text-dark-500 text-xs ml-2">{{ $ticket->service->name }}</span>
                                </div>
                                <span class="text-xs px-2 py-1 rounded {{ $ticket->status === 'SERVED' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' }}">
                                    {{ $ticket->status === 'SERVED' ? 'Servi' : 'Absent' }}
                                </span>
                            </div>
                        @empty
                            <p class="text-dark-500 text-sm">Aucun ticket aujourd'hui</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedServiceId = {{ $counter->services->first()?->id ?? 'null' }};
    let currentTicketId = {{ $currentTicket?->id ?? 'null' }};
    let callStartTime = {{ $currentTicket?->called_at ? $currentTicket->called_at->timestamp * 1000 : 'null' }};
    let timerInterval = null;

    // Timer
    function startTimer() {
        if (timerInterval) clearInterval(timerInterval);
        
        timerInterval = setInterval(() => {
            if (!callStartTime) return;
            
            const elapsed = Math.floor((Date.now() - callStartTime) / 1000);
            const minutes = Math.floor(elapsed / 60).toString().padStart(2, '0');
            const seconds = (elapsed % 60).toString().padStart(2, '0');
            
            const timerEl = document.getElementById('timer');
            if (timerEl) {
                timerEl.textContent = `${minutes}:${seconds}`;
            }
        }, 1000);
    }

    if (callStartTime) startTimer();

    // Select service
    function selectService(serviceId) {
        selectedServiceId = serviceId;
        
        // Update UI
        document.querySelectorAll('.service-btn').forEach(btn => {
            btn.classList.remove('ring-2', 'ring-brand-500');
        });
        document.getElementById(`service-btn-${serviceId}`).classList.add('ring-2', 'ring-brand-500');
    }

    // Call next ticket
    async function callNext() {
        const btn = document.getElementById('callNextBtn');
        btn.disabled = true;
        btn.textContent = 'Appel en cours...';
        
        try {
            const response = await fetch('{{ route('company.agent.call', 2) }}', { // TODO: Utiliser $company dynamique après tests
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    counter_id: {{ $counter->id }},
                    service_id: selectedServiceId
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Reload page to show new ticket
                location.reload();
            } else {
                alert(data.error || 'Erreur lors de l\'appel');
                btn.disabled = false;
                btn.textContent = 'Appeler suivant';
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Erreur réseau');
            btn.disabled = false;
            btn.textContent = 'Appeler suivant';
        }
    }

    // Mark serving
    async function markServing(ticketId) {
        try {
            const response = await fetch(`/company/{{ $company->id }}/tickets/${ticketId}/serving`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (response.ok) location.reload();
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Mark served
    async function markServed(ticketId) {
        if (!confirm('Confirmer que le ticket est servi ?')) return;
        
        try {
            const response = await fetch(`/company/{{ $company->id }}/tickets/${ticketId}/served`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            if (response.ok) location.reload();
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Mark missed
    async function markMissed(ticketId) {
        if (!confirm('Marquer comme absent ?')) return;
        
        try {
            const response = await fetch(`/company/{{ $company->id }}/tickets/${ticketId}/missed`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (response.ok) {
                if (data.requeued) {
                    alert('Client absent - Ticket remis en file (absence ' + data.missed_count + '/3)');
                } else {
                    alert('Client absent - Ticket annulé (3 absences)');
                }
                location.reload();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Call again (announce)
    function callAgain(ticketId) {
        // Emit event for audio announcement
        if (typeof window.Echo !== 'undefined') {
            // Trigger re-announce via broadcast
        }
        
        // Local audio
        speakTicket(currentTicketNumber, '{{ $counter->name }}');
    }

    // Text to speech
    function speakTicket(number, counter) {
        if ('speechSynthesis' in window) {
            const text = `Ticket ${number}, ${counter}`;
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'fr-FR';
            utterance.rate = 0.9;
            utterance.pitch = 1;
            
            for (let i = 0; i < 3; i++) {
                setTimeout(() => {
                    speechSynthesis.speak(utterance);
                }, i * 2500);
            }
        }
    }

    // WebSocket listeners
    if (typeof window.Echo !== 'undefined') {
        window.Echo.channel('company.{{ $company->id }}')
            .listen('.ticket.created', (e) => {
                // Refresh queue display
                location.reload();
            })
            .listen('.ticket.status.changed', (e) => {
                // Refresh if relevant
                if (e.ticket_id === currentTicketId) {
                    location.reload();
                }
            });
        
        // Écouter les confirmations de présence client
        window.Echo.private('agent-dashboard.{{ $company->id }}')
            .listen('.client.present', (e) => {
                console.log('Client presence confirmed:', e);
                
                // Notification sonore
                playNotificationSound();
                
                // Notification visuelle
                showClientPresenceNotification(e);
                
                // Mettre à jour l'interface si c'est le ticket actuel
                if (e.ticket_id === currentTicketId) {
                    updateCurrentTicketStatus(e);
                }
                
                // Mettre à jour les statistiques
                updateStats();
            })
            .listen('.ticket.recalled', (e) => {
                console.log('Ticket rappelé:', e);
                
                // Notification sonore pour le rappel
                playRecallSound(e.recall.count);
                
                // Notification visuelle pour l'agent
                showRecallNotification(e);
                
                // Mettre à jour l'interface
                if (e.ticket.id === currentTicketId) {
                    updateRecallStatus(e);
                }
            })
            .listen('.queue.position.updated', (e) => {
                console.log('Position mise à jour:', e);
                
                // Mettre à jour la file d'attente
                updateQueueDisplay();
            });
    }
    
    // Fonction de notification sonore
    function playNotificationSound() {
        try {
            const audio = new Audio('/sounds/agent-notification.mp3');
            audio.play().catch(e => console.log('Erreur lecture son agent:', e));
        } catch (error) {
            console.log('Erreur son:', error);
        }
    }
    
    // Fonction de son pour les rappels
    function playRecallSound(recallCount) {
        try {
            const soundFile = recallCount > 1 ? '/sounds/preparation-alert.mp3' : '/sounds/ticket-called.mp3';
            const audio = new Audio(soundFile);
            audio.play().catch(e => console.log('Erreur lecture son rappel:', e));
        } catch (error) {
            console.log('Erreur son rappel:', error);
        }
    }
    
    // Fonction de notification visuelle
    function showClientPresenceNotification(data) {
        // Créer une notification temporaire
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full';
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Client Présent!</p>
                    <p class="text-sm">Ticket ${data.ticket_number} - ${data.client_name}</p>
                </div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animation d'entrée
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
            notification.classList.add('translate-x-0');
        }, 100);
        
        // Retrait automatique après 5 secondes
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 5000);
    }
    
    // Mettre à jour le statut du ticket actuel
    function updateCurrentTicketStatus(data) {
        const statusElement = document.getElementById('currentTicketStatus');
        if (statusElement) {
            statusElement.innerHTML = `
                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-medium">
                    ✅ Présent confirmé
                </span>
            `;
        }
        
        // Mettre à jour l'heure de présence
        const presentAtElement = document.getElementById('presentAt');
        if (presentAtElement) {
            presentAtElement.textContent = data.present_at;
        }
    }
    
    // Mettre à jour les statistiques
    function updateStats() {
        // Recharger les statistiques sans recharger toute la page
        fetch('/company/{{ $company->id }}/stats')
            .then(response => response.json())
            .then(data => {
                // Mettre à jour les compteurs
                const servedElement = document.getElementById('servedCount');
                if (servedElement) servedElement.textContent = data.served_today;
                
                const missedElement = document.getElementById('missedCount');
                if (missedElement) missedElement.textContent = data.missed_today;
            })
            .catch(error => console.error('Error updating stats:', error));
    }
    
    // Fonction pour afficher la notification de rappel
    function showRecallNotification(data) {
        const notification = document.createElement('div');
        const urgencyClass = data.urgency === 'critical' ? 'bg-red-500' : (data.urgency === 'high' ? 'bg-orange-500' : 'bg-yellow-500');
        notification.className = `fixed top-4 right-4 ${urgencyClass} text-white px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full`;
        notification.innerHTML = `
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Rappel Ticket</p>
                    <p class="text-sm">${data.ticket.number} - ${data.ticket.client_name}</p>
                    <p class="text-xs">${data.recall.count > 1 ? `${data.recall.count}ème rappel` : 'Premier rappel'}</p>
                </div>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animation d'entrée
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
            notification.classList.add('translate-x-0');
        }, 100);
        
        // Retrait automatique après 6 secondes
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    document.body.removeChild(notification);
                }
            }, 300);
        }, 6000);
    }
    
    // Mettre à jour le statut de rappel
    function updateRecallStatus(data) {
        const statusElement = document.getElementById('currentTicketStatus');
        if (statusElement) {
            const urgencyClass = data.urgency === 'critical' ? 'bg-red-100 text-red-800' : (data.urgency === 'high' ? 'bg-orange-100 text-orange-800' : 'bg-yellow-100 text-yellow-800');
            statusElement.innerHTML = `
                <span class="px-4 py-2 ${urgencyClass} rounded-full font-medium">
                    🔄 Rappel (${data.recall.count})
                </span>
            `;
        }
    }
    
    // Mettre à jour l'affichage de la file d'attente
    function updateQueueDisplay() {
        // Rafraîchir la liste des tickets en attente
        fetch('/company/{{ $company->id }}/waiting-tickets')
            .then(response => response.json())
            .then(data => {
                const queueElement = document.getElementById('waitingQueue');
                if (queueElement && data.tickets) {
                    // Mettre à jour le compteur
                    const countElement = document.getElementById('waitingCount');
                    if (countElement) {
                        countElement.textContent = data.tickets.length;
                    }
                    
                    // Mettre à jour la liste (si nécessaire)
                    // Cette logique peut être étendue selon les besoins
                }
            })
            .catch(error => console.error('Error updating queue:', error));
    }
</script>
@endsection
