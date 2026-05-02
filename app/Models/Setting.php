<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'description'];

    protected $casts = [
        'value' => 'string',
    ];

    /**
     * Obtenir la valeur d'un paramètre
     */
    public static function get(string $key, $default = null)
    {
        $cacheKey = "setting_{$key}";
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }

            return match ($setting->type) {
                'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
                'integer' => (int) $setting->value,
                'float' => (float) $setting->value,
                'json' => json_decode($setting->value, true),
                'array' => json_decode($setting->value, true),
                default => $setting->value,
            };
        });
    }

    /**
     * Définir la valeur d'un paramètre
     */
    public static function set(string $key, $value, string $type = 'string', string $description = null): void
    {
        $serializedValue = match ($type) {
            'boolean' => $value ? '1' : '0',
            'json', 'array' => json_encode($value),
            default => (string) $value,
        };

        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $serializedValue,
                'type' => $type,
                'description' => $description,
            ]
        );

        // Invalider le cache
        Cache::forget("setting_{$key}");
    }

    /**
     * Supprimer un paramètre
     */
    public static function remove(string $key): bool
    {
        $deleted = static::where('key', $key)->delete();
        
        if ($deleted) {
            Cache::forget("setting_{$key}");
        }
        
        return $deleted;
    }

    /**
     * Obtenir tous les paramètres sous forme de tableau
     */
    public static function allAsArray(): array
    {
        $settings = [];
        
        static::all()->each(function ($setting) use (&$settings) {
            $settings[$setting->key] = match ($setting->type) {
                'boolean' => filter_var($setting->value, FILTER_VALIDATE_BOOLEAN),
                'integer' => (int) $setting->value,
                'float' => (float) $setting->value,
                'json', 'array' => json_decode($setting->value, true),
                default => $setting->value,
            };
        });
        
        return $settings;
    }

    /**
     * Initialiser les paramètres par défaut
     */
    public static function initializeDefaults(): void
    {
        $defaults = [
            'app_name' => ['SmartQueue AI', 'string', 'Nom de l\'application'],
            'default_email' => ['noreply@smartqueue.ai', 'string', 'Email par défaut'],
            'timezone' => ['UTC', 'string', 'Fuseau horaire par défaut'],
            'default_locale' => ['fr', 'string', 'Langue par défaut'],
            'max_wait_time' => [30, 'integer', 'Temps d\'attente maximal (minutes)'],
            'avg_service_time' => [5, 'integer', 'Temps de service moyen (minutes)'],
            'daily_ticket_limit' => [1000, 'integer', 'Limite de tickets par jour'],
            'auto_notifications' => [true, 'boolean', 'Notifications automatiques'],
            'min_password_length' => [8, 'integer', 'Longueur minimale du mot de passe'],
            'session_lifetime' => [8, 'integer', 'Durée de session (heures)'],
            'enable_2fa' => [false, 'boolean', 'Activer 2FA'],
            'enable_activity_log' => [true, 'boolean', 'Journal d\'activité'],
            'mail_driver' => ['smtp', 'string', 'Driver email'],
            'mail_host' => ['smtp.gmail.com', 'string', 'Hôte SMTP'],
            'mail_port' => [587, 'integer', 'Port SMTP'],
            'mail_encryption' => ['tls', 'string', 'Chiffrement SMTP'],
        ];

        foreach ($defaults as $key => [$value, $type, $description]) {
            if (!static::where('key', $key)->exists()) {
                static::set($key, $value, $type, $description);
            }
        }
    }
}
