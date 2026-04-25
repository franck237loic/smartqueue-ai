<?php

// Serveur WebSocket simple pour les notifications
require_once 'vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

class NotificationServer implements MessageComponentInterface {
    protected $clients;
    protected $subscriptions;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->subscriptions = [];
        echo "Serveur WebSocket démarré sur ws://127.0.0.1:6001\n";
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo "Nouvelle connexion ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        
        if (isset($data['event']) && $data['event'] === 'pusher:subscribe') {
            // S'abonner à un channel
            $channel = $data['data']['channel'] ?? null;
            if ($channel) {
                if (!isset($this->subscriptions[$channel])) {
                    $this->subscriptions[$channel] = [];
                }
                $this->subscriptions[$channel][] = $from;
                echo "Client {$from->resourceId} abonné à {$channel}\n";
                
                // Envoyer confirmation d'abonnement
                $from->send(json_encode([
                    'event' => 'pusher_internal:subscription_succeeded',
                    'channel' => $channel,
                    'data' => '{}'
                ]));
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        
        // Nettoyer les abonnements
        foreach ($this->subscriptions as $channel => $subscribers) {
            $this->subscriptions[$channel] = array_filter($subscribers, function($sub) use ($conn) {
                return $sub !== $conn;
            });
        }
        
        echo "Connexion fermée ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Erreur: {$e->getMessage()}\n";
        $conn->close();
    }

    // Méthode pour diffuser un message à tous les abonnés d'un channel
    public function broadcast($channel, $event, $data) {
        if (isset($this->subscriptions[$channel])) {
            $message = json_encode([
                'event' => $event,
                'channel' => $channel,
                'data' => json_encode($data)
            ]);
            
            foreach ($this->subscriptions[$channel] as $client) {
                try {
                    $client->send($message);
                    echo "Message envoyé à {$client->resourceId} sur {$channel}\n";
                } catch (\Exception $e) {
                    echo "Erreur envoi message: {$e->getMessage()}\n";
                }
            }
        }
    }
}

// Démarrer le serveur
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new NotificationServer()
        )
    ),
    6001
);

echo "Serveur WebSocket en écoute sur le port 6001...\n";
$server->run();
