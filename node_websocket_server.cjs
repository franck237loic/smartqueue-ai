// Serveur WebSocket simple avec Node.js
// Compatible Windows et facile à utiliser

const WebSocket = require('ws');
const http = require('http');

const PORT = 6001;
const HOST = '127.0.0.1';

// Créer le serveur HTTP pour les requêtes REST
const server = http.createServer((req, res) => {
    // Gérer les requêtes POST pour les notifications
    if (req.method === 'POST' && req.url === '/broadcast') {
        let body = '';
        
        req.on('data', chunk => {
            body += chunk.toString();
        });
        
        req.on('end', () => {
            try {
                const data = JSON.parse(body);
                
                // Diffuser à tous les clients WebSocket
                wss.clients.forEach(client => {
                    if (client.readyState === WebSocket.OPEN) {
                        client.send(JSON.stringify(data));
                    }
                });
                
                res.writeHead(200, { 'Content-Type': 'application/json' });
                res.end(JSON.stringify({ success: true, message: 'Message broadcasted' }));
            } catch (error) {
                res.writeHead(400, { 'Content-Type': 'application/json' });
                res.end(JSON.stringify({ success: false, error: 'Invalid JSON' }));
            }
        });
    } else {
        res.writeHead(404, { 'Content-Type': 'application/json' });
        res.end(JSON.stringify({ success: false, error: 'Not found' }));
    }
});

// Créer le serveur WebSocket
const wss = new WebSocket.Server({ server });

console.log(`Serveur WebSocket démarré sur ws://${HOST}:${PORT}`);
console.log(`Serveur HTTP démarré sur http://${HOST}:${PORT}`);

wss.on('connection', (ws, req) => {
    console.log(`Nouveau client connecté depuis ${req.socket.remoteAddress}`);
    
    // Envoyer un message de bienvenue
    ws.send(JSON.stringify({
        type: 'welcome',
        message: 'Connecté au serveur de notifications SmartQueue'
    }));
    
    ws.on('message', (message) => {
        try {
            const data = JSON.parse(message);
            console.log('Message reçu:', data);
            
            // Gérer les messages d'abonnement (compatibilité Pusher)
            if (data.event === 'pusher:subscribe') {
                const channel = data.data?.channel || 'unknown';
                console.log(`Client abonné au channel: ${channel}`);
                
                // Confirmer l'abonnement
                ws.send(JSON.stringify({
                    event: 'pusher_internal:subscription_succeeded',
                    channel: channel,
                    data: '{}'
                }));
            }
        } catch (error) {
            console.log('Message invalide reçu:', message);
        }
    });
    
    ws.on('close', () => {
        console.log('Client déconnecté');
    });
    
    ws.on('error', (error) => {
        console.log('Erreur WebSocket:', error);
    });
});

// Envoyer des notifications de test toutes les 15 secondes
setInterval(() => {
    const testNotification = {
        event: 'ticket.called',
        channel: 'company.2',
        data: JSON.stringify({
            ticket: {
                id: Math.floor(Math.random() * 1000),
                number: 'TEST' + Math.floor(Math.random() * 900 + 100),
                service: 'Test Service',
                counter: 'Test Counter',
                agent: 'Test Agent',
                called_at: new Date().toISOString()
            }
        })
    };
    
    wss.clients.forEach(client => {
        if (client.readyState === WebSocket.OPEN) {
            client.send(JSON.stringify(testNotification));
        }
    });
    
    console.log('Notification de test envoyée');
}, 15000);

// Démarrer le serveur
server.listen(PORT, HOST, () => {
    console.log(`Serveur en écoute sur ${HOST}:${PORT}`);
});
