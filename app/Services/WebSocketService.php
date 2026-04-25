<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WebSocketService
{
    private $host;
    private $port;
    
    public function __construct()
    {
        $this->host = env('WEBSOCKET_HOST', '127.0.0.1');
        $this->port = env('WEBSOCKET_PORT', 6001);
    }
    
    /**
     * Diffuser un message à tous les clients WebSocket
     */
    public function broadcast(string $event, array $data, string $channel = null): bool
    {
        try {
            $payload = [
                'event' => $event,
                'channel' => $channel,
                'data' => json_encode($data)
            ];
            
            $response = Http::post("http://{$this->host}:{$this->port}/broadcast", $payload);
            
            return $response->successful();
        } catch (\Exception $e) {
            \Log::error('WebSocket broadcast failed: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Diffuser un événement de ticket appelé
     */
    public function broadcastTicketCalled($ticket): bool
    {
        return $this->broadcast('ticket.called', [
            'ticket' => [
                'id' => $ticket->id,
                'number' => $ticket->number,
                'service' => $ticket->service?->name,
                'counter' => $ticket->counter?->name,
                'counter_number' => $ticket->counter?->number,
                'agent' => $ticket->agent?->name,
                'called_at' => $ticket->called_at?->toIso8601String(),
            ]
        ], 'company.' . $ticket->company_id);
    }
    
    /**
     * Diffuser un événement de ticket servi
     */
    public function broadcastTicketServed($ticket): bool
    {
        return $this->broadcast('ticket.served', [
            'ticket' => [
                'id' => $ticket->id,
                'number' => $ticket->number,
                'service' => $ticket->service?->name,
                'served_at' => $ticket->served_at?->toIso8601String(),
            ]
        ], 'company.' . $ticket->company_id);
    }
    
    /**
     * Diffuser un événement de changement de statut
     */
    public function broadcastTicketStatusChanged($ticket, string $from, string $to): bool
    {
        return $this->broadcast('ticket.status.changed', [
            'ticket' => [
                'id' => $ticket->id,
                'number' => $ticket->number,
                'from_status' => $from,
                'to_status' => $to,
                'updated_at' => $ticket->updated_at->toIso8601String(),
            ]
        ], 'company.' . $ticket->company_id);
    }
}
