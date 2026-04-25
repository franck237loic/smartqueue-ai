import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY || process.env.MIX_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: import.meta.env.VITE_PUSHER_HOST || process.env.MIX_PUSHER_HOST,
    wsPort: import.meta.env.VITE_PUSHER_PORT || process.env.MIX_PUSHER_PORT,
    wssPort: import.meta.env.VITE_PUSHER_PORT || process.env.MIX_PUSHER_PORT,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME || process.env.MIX_PUSHER_SCHEME) === 'https',
    enabledTransports: ['ws', 'wss'],
    disableStats: true,
});

// Helper pour s'abonner aux channels
window.SmartQueueEcho = {
    /**
     * S'abonner au channel entreprise
     */
    company(companyId, callbacks = {}) {
        const channel = window.Echo.channel(`company.${companyId}`);
        
        if (callbacks.ticketCalled) {
            channel.listen('ticket.called', callbacks.ticketCalled);
        }
        
        if (callbacks.ticketUpdated) {
            channel.listen('ticket.updated', callbacks.ticketUpdated);
        }
        
        if (callbacks.playSound) {
            channel.listen('sound.play', callbacks.playSound);
        }
        
        if (callbacks.performanceUpdated) {
            channel.listen('performance.updated', callbacks.performanceUpdated);
        }
        
        return channel;
    },

    /**
     * S'abonner au channel service
     */
    service(serviceId, callbacks = {}) {
        const channel = window.Echo.channel(`service.${serviceId}`);
        
        if (callbacks.ticketCalled) {
            channel.listen('ticket.called', callbacks.ticketCalled);
        }
        
        if (callbacks.ticketUpdated) {
            channel.listen('ticket.updated', callbacks.ticketUpdated);
        }
        
        return channel;
    },

    /**
     * S'abonner au channel ticket
     */
    ticket(ticketId, callbacks = {}) {
        const channel = window.Echo.channel(`ticket.${ticketId}`);
        
        if (callbacks.ticketCalled) {
            channel.listen('ticket.called', callbacks.ticketCalled);
        }
        
        if (callbacks.ticketUpdated) {
            channel.listen('ticket.updated', callbacks.ticketUpdated);
        }
        
        return channel;
    },

    /**
     * S'abonner au channel agents
     */
    agents(companyId, callbacks = {}) {
        const channel = window.Echo.channel(`agents.${companyId}`);
        
        if (callbacks.ticketCalled) {
            channel.listen('ticket.called', callbacks.ticketCalled);
        }
        
        if (callbacks.ticketUpdated) {
            channel.listen('ticket.updated', callbacks.ticketUpdated);
        }
        
        return channel;
    },

    /**
     * S'abonner au channel public display
     */
    public(companyId, callbacks = {}) {
        const channel = window.Echo.channel(`public.${companyId}`);
        
        if (callbacks.ticketCalled) {
            channel.listen('ticket.called', callbacks.ticketCalled);
        }
        
        if (callbacks.ticketUpdated) {
            channel.listen('ticket.updated', callbacks.ticketUpdated);
        }
        
        return channel;
    },

    /**
     * S'abonner au channel sounds
     */
    sounds(companyId, callbacks = {}) {
        const channel = window.Echo.channel(`sounds.${companyId}`);
        
        if (callbacks.playSound) {
            channel.listen('sound.play', callbacks.playSound);
        }
        
        return channel;
    },

    /**
     * S'abonner au channel stats
     */
    stats(companyId, callbacks = {}) {
        const channel = window.Echo.channel(`stats.${companyId}`);
        
        if (callbacks.performanceUpdated) {
            channel.listen('performance.updated', callbacks.performanceUpdated);
        }
        
        return channel;
    },

    /**
     * Se désabonner d'un channel
     */
    leave(channelName) {
        window.Echo.leaveChannel(channelName);
    },

    /**
     * Se désabonner de tous les channels
     */
    leaveAll() {
        window.Echo.leaveAllChannels();
    }
};

export default window.Echo;
