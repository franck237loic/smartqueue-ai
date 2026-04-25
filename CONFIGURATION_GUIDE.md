# 🚀 Guide de Configuration - SmartQueue AI Système Intelligent

## 📋 Table des Matières
1. [Configuration SMS Twilio](#configuration-sms-twilio)
2. [Configuration WebSocket Pusher](#configuration-websocket-pusher)
3. [Configuration Laravel Echo](#configuration-laravel-echo)
4. [Configuration Scheduler](#configuration-scheduler)
5. [Fichiers Sonores](#fichiers-sonores)
6. [Tests et Validation](#tests-et-validation)

---

## 📱 Configuration SMS Twilio

### 1. Créer un compte Twilio
- Allez sur [https://www.twilio.com](https://www.twilio.com)
- Créez un compte gratuit
- Vérifiez votre numéro de téléphone
- Obtenez votre `Account SID` et `Auth Token`

### 2. Obtenir un numéro de téléphone
- Dans le dashboard Twilio, achetez un numéro de téléphone
- Choisissez un numéro local pour votre pays
- Notez le numéro obtenu

### 3. Configurer le `.env`
```bash
# Copiez votre .env.example en .env
cp .env.example .env

# Ajoutez vos credentials Twilio
TWILIO_SID=votre_account_sid
TWILIO_AUTH_TOKEN=votre_auth_token
TWILIO_PHONE_NUMBER=+33612345678
TWILIO_ENABLED=true
```

### 4. Tester l'envoi SMS
```bash
php artisan tinker
>>> $sms = app(App\Services\SMSService::class);
>>> $sms->send('+33612345678', 'Test SMS SmartQueue');
```

---

## 🌐 Configuration WebSocket Pusher

### 1. Créer un compte Pusher
- Allez sur [https://pusher.com](https://pusher.com)
- Créez un compte gratuit
- Créez une nouvelle application
- Notez les clés obtenues

### 2. Configurer le `.env`
```bash
# Ajoutez vos credentials Pusher
PUSHER_APP_ID=votre_app_id
PUSHER_APP_KEY=votre_app_key
PUSHER_APP_SECRET=votre_app_secret
PUSHER_APP_CLUSTER=mt1
BROADCAST_DRIVER=pusher
```

### 3. Configurer Vite pour Echo
Dans `vite.config.js`:
```javascript
export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/smartqueue-echo.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
});
```

---

## 🔧 Configuration Laravel Echo

### 1. Inclure Echo dans votre layout
Dans votre layout principal (`resources/views/layouts/modern-sidebar.blade.php`):
```html
<!-- Avant la fermeture du </head> -->
@if(config('broadcasting.default') === 'pusher')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
@endif
```

### 2. Importer Echo dans votre dashboard
Dans `resources/views/company/agent/dashboard.blade.php`:
```javascript
// Ajouter après les autres scripts
<script src="{{ asset('js/smartqueue-echo.js') }}" defer></script>
```

### 3. Utiliser les channels Echo
```javascript
// S'abonner aux notifications de l'entreprise
window.SmartQueueEcho.company({{ $company->id }}, {
    ticketCalled: (data) => {
        console.log('Ticket appelé:', data);
        showToast('Ticket appelé: ' + data.ticket.number, 'success');
        playSound('ticketCalledSound');
    },
    ticketUpdated: (data) => {
        console.log('Ticket mis à jour:', data);
        // Gérer les mises à jour en temps réel
    }
});
```

---

## ⏰ Configuration Scheduler

### 1. Démarrer le worker Laravel
```bash
# Pour développement (terminal séparé)
php artisan queue:work

# Pour production
php artisan queue:work --daemon
```

### 2. Démarrer le scheduler
```bash
# Pour développement
php artisan schedule:work

# Pour production (crontab)
* * * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

### 3. Vérifier les tâches planifiées
```bash
php artisan schedule:list
```

---

## 🔊 Fichiers Sonores

### 1. Remplacer les fichiers placeholders
Les fichiers actuels sont des placeholders. Remplacez-les par de vrais fichiers MP3 :

- `public/sounds/ticket-called.mp3` - Son d'appel de ticket
- `public/sounds/preparation-alert.mp3` - Son de pré-notification  
- `public/sounds/ticket-absent.mp3` - Son d'absence

### 2. Sources de sons gratuits
- [Zapsplat](https://www.zapsplat.com/)
- [FreeSound](https://freesound.org/)
- [SoundJay](https://www.soundjay.com/)

### 3. Sons recommandés
- **Ticket appelé** : Bell ding-dong (~2 secondes)
- **Pré-notification** : Gentle chime (~1 seconde)
- **Absence** : Soft whoosh alert (~1 seconde)

---

## 🧪 Tests et Validation

### 1. Tester le dashboard
```bash
# Démarrer le serveur de développement
php artisan serve

# Accéder au dashboard
http://127.0.0.1:8000/company/1/agent
```

### 2. Tester les notifications SMS
```bash
# Créer un ticket avec numéro de téléphone
# Appeler le ticket
# Vérifier la réception du SMS
```

### 3. Tester les WebSocket
- Ouvrez les outils de développement du navigateur
- Vérifiez l'onglet Network > WS
- Appeler un ticket et vérifiez les messages WebSocket

### 4. Tester l'ETA intelligent
- Créez plusieurs tickets dans différents services
- Vérifiez les prédictions de temps d'attente
- Comparez avec les temps réels

### 5. Tester le timer d'absence
- Appelez un ticket
- Attendez la durée configurée (défaut: 3 minutes)
- Vérifiez que le ticket est marqué absent automatiquement

---

## 🔧 Dépannage

### Problèmes courants

#### SMS ne s'envoient pas
```bash
# Vérifier la configuration
php artisan tinker
>>> config('services.twilio.enabled');
>>> config('services.twilio.sid');
>>> config('services.twilio.from');

# Vérifier les logs
tail -f storage/logs/laravel.log | grep SMS
```

#### WebSocket ne se connecte pas
```bash
# Vérifier la configuration Pusher
php artisan tinker
>>> config('broadcasting.default');
>>> config('services.pusher.key');

# Vérifier les channels autorisés
php artisan route:list --name=broadcasting
```

#### Scheduler ne fonctionne pas
```bash
# Vérifier les tâches
php artisan schedule:list

# Tester manuellement
php artisan smartqueue:process-notifications
php artisan smartqueue:update-performance-stats
```

---

## 📊 Monitoring

### 1. Logs Laravel
```bash
# Logs en temps réel
tail -f storage/logs/laravel.log

# Filtrer par type
tail -f storage/logs/laravel.log | grep "SMS"
tail -f storage/logs/laravel.log | grep "WebSocket"
```

### 2. Performance
- Utilisez Laravel Telescope pour le debugging
- Surveillez les temps de réponse des API
- Vérifiez l'utilisation mémoire du scheduler

### 3. Notifications
- Testez les scénarios de charge
- Vérifiez la livraison des SMS
- Validez les temps de réception WebSocket

---

## 🚀 Déploiement

### 1. Variables d'environnement de production
```bash
# .env.production
APP_ENV=production
APP_DEBUG=false
TWILIO_ENABLED=true
BROADCAST_DRIVER=pusher
```

### 2. Optimisations
```bash
# Optimiser le chargement automatique
php artisan optimize

# Mettre en cache la configuration
php artisan config:cache

# Mettre en cache les routes
php artisan route:cache
```

### 3. Supervisor (recommandé)
```ini
# /etc/supervisor/conf.d/smartqueue-worker.conf
[program:smartqueue-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/your/project/artisan queue:work --sleep=1 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
numprocs=1
user=www-data
```

---

## 🎯 Prochaines Étapes

1. **Configurer Twilio** pour activer les SMS
2. **Configurer Pusher** pour activer les WebSocket
3. **Télécharger les vrais fichiers sonores**
4. **Tester toutes les fonctionnalités**
5. **Déployer en production** avec Supervisor

---

## 📞 Support

En cas de problème :
1. Vérifiez les logs Laravel
2. Testez les configurations avec `php artisan tinker`
3. Consultez la documentation officielle :
   - [Twilio PHP SDK](https://www.twilio.com/docs/libraries/reference/twilio-php/)
   - [Laravel Broadcasting](https://laravel.com/docs/broadcasting)
   - [Pusher JavaScript](https://pusher.com/docs/channels/library_auth_reference)

---

**🎉 Votre système SmartQueue AI est maintenant prêt !**
