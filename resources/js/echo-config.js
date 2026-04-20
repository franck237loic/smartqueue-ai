import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

/**
 * SmartQueue Audio Call System
 * Gère l'appel vocal des tickets avec synthèse vocale
 */
class SmartQueueAudio {
    constructor() {
        this.synth = window.speechSynthesis;
        this.audioQueue = [];
        this.isPlaying = false;
    }

    /**
     * Appeler un ticket vocalement
     * @param {string} number - Numéro du ticket
     * @param {string} counter - Nom du guichet
     */
    callTicket(number, counter) {
        const text = `Ticket ${number}, présentez-vous au ${counter}`;
        this.speak(text);
    }

    /**
     * Synthèse vocale
     * @param {string} text - Texte à prononcer
     */
    speak(text) {
        if (!this.synth) {
            console.warn('Synthèse vocale non supportée');
            return;
        }

        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'fr-FR';
        utterance.rate = 0.9;
        utterance.pitch = 1;
        utterance.volume = 1;

        this.synth.speak(utterance);
    }

    /**
     * Jouer un son de notification
     */
    playNotificationSound() {
        const audio = new Audio('/sounds/notification.mp3');
        audio.play().catch(e => console.log('Audio play failed:', e));
    }
}

/**
 * SmartQueue Real-time Display
 * Gère l'affichage temps réel des appels
 */
class SmartQueueDisplay {
    constructor(companyId) {
        this.companyId = companyId;
        this.audio = new SmartQueueAudio();
        this.initEcho();
    }

    /**
     * Initialiser Laravel Echo
     */
    initEcho() {
        // Écouter le canal de l'entreprise
        window.Echo.channel(`company.${this.companyId}`)
            .listen('.ticket.called', (event) => {
                this.handleTicketCalled(event.ticket);
            })
            .listen('.ticket.served', (event) => {
                this.handleTicketServed(event.ticket);
            });
    }

    /**
     * Gérer l'appel d'un ticket
     */
    handleTicketCalled(ticket) {
        console.log('Ticket appelé:', ticket);

        // Jouer le son de notification
        this.audio.playNotificationSound();

        // Appel vocal après un court délai
        setTimeout(() => {
            this.audio.callTicket(ticket.number, ticket.counter);
        }, 500);

        // Mettre à jour l'affichage si la fonction existe
        if (window.updateDisplay) {
            window.updateDisplay(ticket);
        }
    }

    /**
     * Gérer un ticket servi
     */
    handleTicketServed(ticket) {
        console.log('Ticket servi:', ticket);

        // Mettre à jour l'affichage si la fonction existe
        if (window.removeFromDisplay) {
            window.removeFromDisplay(ticket.id);
        }
    }
}

// Exporter pour utilisation
window.SmartQueueAudio = SmartQueueAudio;
window.SmartQueueDisplay = SmartQueueDisplay;

export { SmartQueueAudio, SmartQueueDisplay };
