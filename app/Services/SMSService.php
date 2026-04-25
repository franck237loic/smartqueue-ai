<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class SMSService
{
    private $client;
    private $from;
    private $enabled;

    public function __construct()
    {
        $this->enabled = config('services.twilio.enabled', false);
        
        if ($this->enabled) {
            $this->client = new Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );
            $this->from = config('services.twilio.from');
        }
    }

    /**
     * Envoyer un SMS
     */
    public function send(string $to, string $message): bool
    {
        if (!$this->enabled) {
            Log::info('📱 SMS SIMULATION - Service désactivé', [
                'to' => $to,
                'message' => $message,
                'timestamp' => now()->toISOString(),
                'note' => 'TWILIO_ENABLED=false - Message non envoyé réellement'
            ]);
            
            // Afficher dans la console pour le développement
            if (app()->environment('local')) {
                echo "\n📱 SMS SIMULATION:\n";
                echo "📞 To: {$to}\n";
                echo "💬 Message: {$message}\n";
                echo "⏰ Time: " . now()->format('H:i:s') . "\n";
                echo "🔗 Configurez TWILIO_ENABLED=true pour envoyer réellement\n\n";
            }
            
            return true; // Simuler succès en mode dev
        }

        try {
            $this->client->messages->create(
                $to,
                [
                    'from' => $this->from,
                    'body' => $message,
                ]
            );

            Log::info('SMS sent successfully', [
                'to' => $to,
                'message' => substr($message, 0, 50) . '...'
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('SMS sending failed', [
                'to' => $to,
                'error' => $e->getMessage(),
                'code' => $e->getCode()
            ]);

            return false;
        }
    }

    /**
     * Vérifier si le service est actif
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Valider un numéro de téléphone
     */
    public function validatePhoneNumber(string $phone): string
    {
        // Nettoyer le numéro
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Ajouter le préfixe international si nécessaire
        if (strlen($phone) === 9 && !str_starts_with($phone, '+')) {
            $phone = '+33' . $phone; // France par défaut
        }
        
        return $phone;
    }

    /**
     * Obtenir les informations d'envoi
     */
    public function getDeliveryInfo(string $messageSid): ?array
    {
        if (!$this->enabled) {
            return null;
        }

        try {
            $message = $this->client->messages($messageSid)->fetch();
            
            return [
                'status' => $message->status,
                'error_code' => $message->errorCode,
                'error_message' => $message->errorMessage,
                'date_created' => $message->dateCreated,
                'date_sent' => $message->dateSent,
                'date_updated' => $message->dateUpdated,
            ];

        } catch (\Exception $e) {
            Log::error('Failed to get SMS delivery info', [
                'message_sid' => $messageSid,
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }
}
