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
                        
                        <form id="confirmPresenceForm" method="POST" action="<?php echo e(route('client.confirm', ['ticket' => $ticket->id])); ?>" class="text-center">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="px-8 py-4 bg-green-600 text-white rounded-lg hover:bg-green-700 font-bold text-lg transition-colors duration-200 shadow-lg transform hover:scale-105">
                                &#x270b; Je suis présent
                            </button>
                        </form>
                        
                        <!-- Messages d'erreur -->
                        <div id="errorMessage" class="hidden mt-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700"></div>
                        <div id="successMessage" class="hidden mt-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700"></div>
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

// Gestion du formulaire de confirmation de présence
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('confirmPresenceForm');
    const errorMessage = document.getElementById('errorMessage');
    const successMessage = document.getElementById('successMessage');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // ARRÊTER IMMÉDIATEMENT LA SONNERIE
            stopCallSound();
            
            // Logs de debug
            console.log('=== DEBUG FORMULAIRE PRÉSENCE ===');
            console.log('URL action:', form.action);
            console.log('Méthode:', form.method);
            console.log('FormData:', new FormData(form));
            
            // Désactiver le bouton pendant la soumission
            const submitButton = form.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = 'Envoi en cours...';
            
            // Cacher les messages précédents
            errorMessage.classList.add('hidden');
            successMessage.classList.add('hidden');
            
            // Soumettre le formulaire avec fetch
            fetch(form.action, {
                method: form.method,
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (response.ok) {
                    return response.text();
                } else if (response.status === 419) {
                    throw new Error('CSRF token expiré. Veuillez rafraîchir la page.');
                } else if (response.status === 404) {
                    throw new Error('Route non trouvée. Veuillez contacter l\'administrateur.');
                } else if (response.status === 500) {
                    throw new Error('Erreur serveur. Veuillez réessayer plus tard.');
                } else if (response.status === 403) {
                    throw new Error('Accès refusé. Vous n\'avez pas les permissions nécessaires.');
                } else {
                    // Lire le contenu de la réponse pour plus de détails
                    return response.text().then(text => {
                        if (text.includes('Page Expired')) {
                            throw new Error('CSRF token expiré. Veuillez rafraîchir la page.');
                        } else if (text.includes('Not Found')) {
                            throw new Error('Route non trouvée. Veuillez contacter l\'administrateur.');
                        } else {
                            throw new Error(`Erreur ${response.status}: ${response.statusText}`);
                        }
                    });
                }
            })
            .then(html => {
                console.log('Response HTML:', html);
                
                // Afficher le message de succès
                successMessage.textContent = 'Présence confirmée avec succès!';
                successMessage.classList.remove('hidden');
                
                // Rafraîchir la page après 2 secondes
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            })
            .catch(error => {
                console.error('Erreur formulaire:', error);
                
                // Afficher le message d'erreur
                errorMessage.textContent = error.message;
                errorMessage.classList.remove('hidden');
                
                // Réactiver le bouton
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
                
                // Gestion spécifique des erreurs
                if (error.message.includes('CSRF')) {
                    setTimeout(() => {
                        if (confirm('Le token de sécurité a expiré. Voulez-vous rafraîchir la page?')) {
                            window.location.reload();
                        }
                    }, 1000);
                } else if (error.message.includes('Route non trouvée')) {
                    // Erreur 404 - souvent causée par une session perdue
                    setTimeout(() => {
                        if (confirm('Session expirée ou problème de route. Voulez-vous rafraîchir la page?')) {
                            window.location.reload();
                        }
                    }, 1000);
                } else if (error.message.includes('Erreur serveur')) {
                    // Erreur 500 - proposer de réessayer
                    setTimeout(() => {
                        if (confirm('Erreur serveur. Voulez-vous réessayer?')) {
                            // Réessayer automatiquement
                            form.dispatchEvent(new Event('submit'));
                        }
                    }, 1000);
                }
            });
        });
    }
});

// Variables globales pour la gestion du son
window.currentCallAudio = null;
window.callTimeoutId = null;
window.callStartTime = null;
const CALL_DURATION = 120000; // 2 minutes en millisecondes

// WebSocket listeners pour le temps réel
if (typeof window.Echo !== 'undefined') {
    // Écouter les appels de tickets
    window.Echo.private('ticket.<?php echo e($ticket->id); ?>')
        .listen('.ticket.called', (e) => {
            console.log('Ticket appelé:', e);
            
            // Démarrer la sonnerie continue
            startCallSound();
            
            // Afficher la popup d'appel
            showTicketCallPopup(e);
            
            // Mettre à jour l'interface
            updateTicketStatus('CALLED');
            
            // Démarrer le timer d'absence
            startAbsenceTimer();
        })
        .listen('.ticket.recalled', (e) => {
            console.log('Ticket rappelé:', e);
            
            // Arrêter le son précédent et redémarrer
            stopCallSound();
            startCallSound();
            
            // Afficher la popup de rappel
            showRecallPopup(e);
            
            // Redémarrer le timer d'absence
            startAbsenceTimer();
        })
        .listen('.ticket.timeout', (e) => {
            console.log('Ticket timeout:', e);
            
            // Arrêter la sonnerie
            stopCallSound();
            
            // Afficher la notification de timeout
            showTimeoutNotification(e);
            
            // Mettre à jour le statut
            updateTicketStatus('WAITING');
        });
    
    // Écouter les mises à jour de position
    window.Echo.private('ticket.<?php echo e($ticket->id); ?>')
        .listen('.queue.position.updated', (e) => {
            console.log('Position mise à jour:', e);
            
            // Jouer un son si la position avance
            if (e.sound) {
                playSound('/sounds/client-notification.mp3');
            }
            
            // Mettre à jour l'affichage de la position
            updatePositionDisplay(e.position.new, e.estimated_wait_time);
            
            // Afficher une notification si la position avance
            if (e.position.advancing) {
                showPositionNotification(e);
            }
        });
}

// Fonction pour démarrer la sonnerie continue
function startCallSound() {
    // Arrêter toute sonnerie précédente
    stopCallSound();
    
    try {
        // Créer l'audio en boucle
        window.currentCallAudio = new Audio('/sounds/ticket-called.mp3');
        window.currentCallAudio.loop = true;
        window.currentCallAudio.volume = 0.8;
        
        // Forcer le preload pour éviter les problèmes de chargement
        window.currentCallAudio.preload = 'auto';
        
        // Enregistrer l'heure de début
        window.callStartTime = Date.now();
        
        // Events de debug pour la boucle
        let loopCount = 0;
        let lastCurrentTime = 0;
        
        window.currentCallAudio.addEventListener('loadeddata', () => {
            console.log('Audio chargé, durée:', window.currentCallAudio.duration + 's');
        });
        
        window.currentCallAudio.addEventListener('play', () => {
            console.log('▶️ Sonnerie démarrée, boucle:', window.currentCallAudio.loop);
            updateSoundIndicator(true);
        });
        
        window.currentCallAudio.addEventListener('timeupdate', () => {
            // Détecter les redémarrages de boucle
            if (window.currentCallAudio && !isNaN(window.currentCallAudio.currentTime) && window.currentCallAudio.currentTime < lastCurrentTime) {
                loopCount++;
                console.log('🔄 Boucle #' + loopCount + ' - Temps: ' + window.currentCallAudio.currentTime.toFixed(2) + 's');
            }
            lastCurrentTime = (window.currentCallAudio && !isNaN(window.currentCallAudio.currentTime)) ? window.currentCallAudio.currentTime : 0;
        });
        
        window.currentCallAudio.addEventListener('ended', () => {
            console.log('⏹️ Audio terminé, redémarrage automatique (boucle:', window.currentCallAudio.loop + ')');
            // Forcer le redémarrage si la boucle ne fonctionne pas
            if (window.currentCallAudio && window.currentCallAudio.loop && window.currentCallAudio.currentTime === 0) {
                setTimeout(() => {
                    if (window.currentCallAudio && window.currentCallAudio.paused) {
                        window.currentCallAudio.play().catch(e => console.log('Erreur redémarrage boucle:', e));
                    }
                }, 100);
            }
        });
        
        window.currentCallAudio.addEventListener('error', (e) => {
            console.log('❌ Erreur audio:', e);
            stopCallSound();
        });
        
        // Jouer la sonnerie avec plusieurs tentatives si nécessaire
        const playAudio = () => {
            window.currentCallAudio.play().then(() => {
                console.log('✅ Sonnerie démarrée avec succès');
            }).catch(error => {
                console.log('❌ Erreur lecture, tentative 2:', error);
                // Deuxième tentative après un court délai
                setTimeout(() => {
                    if (window.currentCallAudio) {
                        window.currentCallAudio.play().catch(e2 => {
                            console.log('❌ Erreur lecture, tentative 3:', e2);
                            // Troisième tentative avec interaction utilisateur
                            if (confirm('Cliquez sur OK pour activer les notifications sonores')) {
                                window.currentCallAudio.play().catch(e3 => {
                                    console.log('❌ Erreur finale:', e3);
                                });
                            }
                        });
                    }
                }, 500);
            });
        };
        
        // Démarrer la lecture
        playAudio();
        
        // Programmer l'arrêt automatique après 2 minutes
        window.callTimeoutId = setTimeout(() => {
            stopCallSound();
            console.log('⏹️ Sonnerie arrêtée après 2 minutes (timeout)');
        }, CALL_DURATION);
        
        console.log('🔊 Sonnerie configurée pour 2 minutes en boucle');
        
    } catch (error) {
        console.log('❌ Erreur démarrage sonnerie:', error);
        stopCallSound();
    }
}

// Fonction pour arrêter la sonnerie
function stopCallSound() {
    // Arrêter le timer
    if (window.callTimeoutId) {
        clearTimeout(window.callTimeoutId);
        window.callTimeoutId = null;
    }
    
    // Arrêter l'intervalle de boucle alternative
    if (window.callLoopInterval) {
        clearInterval(window.callLoopInterval);
        window.callLoopInterval = null;
    }
    
    // Arrêter l'audio
    if (window.currentCallAudio) {
        window.currentCallAudio.pause();
        window.currentCallAudio.currentTime = 0;
        window.currentCallAudio = null;
    }
    
    // Réinitialiser les variables
    window.callStartTime = null;
    
    // Mettre à jour l'indicateur visuel
    updateSoundIndicator(false);
    
    console.log('🔇 Sonnerie arrêtée');
}

// Fonction pour mettre à jour l'indicateur de son
function updateSoundIndicator(isPlaying) {
    // Créer ou mettre à jour l'indicateur visuel
    let indicator = document.getElementById('soundIndicator');
    if (!indicator) {
        indicator = document.createElement('div');
        indicator.id = 'soundIndicator';
        indicator.style.cssText = 'position: fixed; top: 20px; right: 20px; width: 20px; height: 20px; border-radius: 50%; z-index: 9999;';
        document.body.appendChild(indicator);
    }
    
    if (isPlaying) {
        indicator.style.background = '#28a745';
        indicator.style.animation = 'pulse 1s infinite';
        indicator.title = 'Sonnerie active';
    } else {
        indicator.style.background = '#6c757d';
        indicator.style.animation = 'none';
        indicator.title = 'Sonnerie inactive';
    }
}

// Ajouter le style d'animation si nécessaire
if (!document.getElementById('pulseAnimation')) {
    const style = document.createElement('style');
    style.id = 'pulseAnimation';
    style.textContent = `
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
    `;
    document.head.appendChild(style);
}

// Fonction pour démarrer le timer d'absence
function startAbsenceTimer() {
    // Afficher le compte à rebours
    showAbsenceCountdown();
}

// Fonction pour afficher le compte à rebours d'absence
function showAbsenceCountdown() {
    const countdownElement = document.getElementById('absenceCountdown');
    if (!countdownElement) {
        // Créer l'élément s'il n'existe pas
        const countdownDiv = document.createElement('div');
        countdownDiv.id = 'absenceCountdown';
        countdownDiv.className = 'fixed top-4 left-4 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg z-50';
        countdownDiv.innerHTML = `
            <div class="text-center">
                <p class="font-bold">⏰ Temps restant</p>
                <p class="text-2xl font-bold" id="countdownTimer">2:00</p>
                <p class="text-sm">Cliquez sur "Présent" pour confirmer</p>
            </div>
        `;
        document.body.appendChild(countdownDiv);
    }
    
    let remainingTime = CALL_DURATION;
    const timerElement = document.getElementById('countdownTimer');
    
    const countdownInterval = setInterval(() => {
        if (remainingTime <= 0 || !window.currentCallAudio) {
            clearInterval(countdownInterval);
            if (countdownElement.parentNode) {
                countdownElement.parentNode.removeChild(countdownElement);
            }
            return;
        }
        
        remainingTime -= 1000;
        const minutes = Math.floor(remainingTime / 60000);
        const seconds = Math.floor((remainingTime % 60000) / 1000);
        timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        // Changer la couleur quand il reste moins de 30 secondes
        if (remainingTime <= 30000) {
            countdownElement.className = 'fixed top-4 left-4 bg-red-600 text-white px-6 py-4 rounded-lg shadow-lg z-50 animate-pulse';
        }
    }, 1000);
}

// Fonction pour afficher la notification de timeout
function showTimeoutNotification(data) {
    const notification = document.createElement('div');
    notification.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    notification.innerHTML = `
        <div class="bg-white rounded-lg p-8 max-w-md mx-4 transform scale-100">
            <div class="text-center">
                <div class="mb-6">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Temps écoulé</h2>
                    <p class="text-gray-600 mb-4">${data.timeout.message}</p>
                    <div class="bg-yellow-100 rounded-lg p-4 mb-6">
                        <p class="text-sm text-gray-600">Nouvelle position</p>
                        <p class="text-xl font-semibold text-gray-900">${data.timeout.new_position}</p>
                    </div>
                </div>
                <button onclick="this.closest('.fixed').remove()" class="w-full bg-red-600 text-white py-3 px-6 rounded-lg hover:bg-red-700 transition-colors">
                    J'ai compris
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Fermeture automatique après 8 secondes
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 8000);
}

// Fonction pour jouer les sons
function playSound(soundFile) {
    try {
        const audio = new Audio(soundFile);
        audio.play().catch(e => console.log('Erreur lecture son:', e));
    } catch (error) {
        console.log('Erreur son:', error);
    }
}

// Fonction pour afficher la popup d'appel
function showTicketCallPopup(data) {
    const popup = document.createElement('div');
    popup.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    popup.innerHTML = `
        <div class="bg-white rounded-lg p-8 max-w-md mx-4 transform scale-100 animate-pulse">
            <div class="text-center">
                <div class="mb-6">
                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Votre numéro est appelé!</h2>
                    <div class="text-4xl font-bold text-blue-600 mb-2">${data.ticket.number}</div>
                    <p class="text-gray-600 mb-4">Merci de vous présenter au guichet</p>
                    <div class="bg-gray-100 rounded-lg p-4 mb-6">
                        <p class="text-sm text-gray-600">Guichet</p>
                        <p class="text-xl font-semibold text-gray-900">${data.ticket.counter || 'En attente'}</p>
                    </div>
                </div>
                <button onclick="this.closest('.fixed').remove()" class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                    J'ai compris
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(popup);
    
    // Fermeture automatique après 10 secondes
    setTimeout(() => {
        if (popup.parentNode) {
            popup.remove();
        }
    }, 10000);
}

// Fonction pour afficher la popup de rappel
function showRecallPopup(data) {
    const popup = document.createElement('div');
    popup.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    popup.innerHTML = `
        <div class="bg-white rounded-lg p-8 max-w-md mx-4 transform scale-100 animate-pulse">
            <div class="text-center">
                <div class="mb-6">
                    <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">${data.message}</h2>
                    <div class="text-4xl font-bold text-orange-600 mb-2">${data.ticket.number}</div>
                    <p class="text-gray-600 mb-4">Merci de vous présenter immédiatement</p>
                    <div class="bg-orange-100 rounded-lg p-4 mb-6">
                        <p class="text-sm text-gray-600">Guichet</p>
                        <p class="text-xl font-semibold text-gray-900">${data.ticket.counter || 'En attente'}</p>
                    </div>
                </div>
                <button onclick="this.closest('.fixed').remove()" class="w-full bg-orange-600 text-white py-3 px-6 rounded-lg hover:bg-orange-700 transition-colors">
                    J'ai compris
                </button>
            </div>
        </div>
    `;
    
    document.body.appendChild(popup);
    
    // Fermeture automatique après 8 secondes
    setTimeout(() => {
        if (popup.parentNode) {
            popup.remove();
        }
    }, 8000);
}

// Fonction pour afficher la notification de position
function showPositionNotification(data) {
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 translate-x-full';
    notification.innerHTML = `
        <div class="flex items-center space-x-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
            <div>
                <p class="font-semibold">Votre numéro avance!</p>
                <p class="text-sm">Position: ${data.position.new} - ETA: ${data.estimated_wait_time} min</p>
            </div>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animation d'entrée
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
        notification.classList.add('translate-x-0');
    }, 100);
    
    // Retrait automatique après 4 secondes
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 4000);
}

// Fonction pour mettre à jour le statut du ticket
function updateTicketStatus(status) {
    const statusElement = document.getElementById('ticketStatus');
    if (statusElement) {
        const statusColors = {
            'WAITING': 'bg-yellow-100 text-yellow-800',
            'CALLED': 'bg-blue-100 text-blue-800',
            'PRESENT': 'bg-green-100 text-green-800',
            'SERVING': 'bg-purple-100 text-purple-800',
            'SERVED': 'bg-gray-100 text-gray-800'
        };
        
        const statusTexts = {
            'WAITING': 'En attente',
            'CALLED': 'Appelé',
            'PRESENT': 'Présent',
            'SERVING': 'En service',
            'SERVED': 'Servi'
        };
        
        statusElement.className = `px-4 py-2 rounded-full font-medium ${statusColors[status] || 'bg-gray-100 text-gray-800'}`;
        statusElement.textContent = statusTexts[status] || status;
    }
}

// Fonction pour mettre à jour l'affichage de la position
function updatePositionDisplay(position, waitTime) {
    const positionElement = document.getElementById('queuePosition');
    const waitElement = document.getElementById('estimatedWait');
    
    if (positionElement) {
        positionElement.textContent = position;
    }
    
    if (waitElement) {
        waitElement.textContent = waitTime + ' min';
    }
}

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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\FurtherMarket\smartqueue-ai\resources\views\public\ticket.blade.php ENDPATH**/ ?>