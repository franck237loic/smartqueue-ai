# Guide d'Installation - SmartQueue AI

## Prérequis

Avant de cloner et d'installer le projet, assurez-vous d'avoir les éléments suivants installés sur votre machine :

### Logiciels requis
- **PHP 8.2** ou supérieur
- **Composer** (gestionnaire de dépendances PHP)
- **Node.js 18+** et **npm** (pour les assets frontend)
- **MySQL** ou **PostgreSQL** (base de données)
- **Git** (pour cloner le repository)

### Extensions PHP requises
- php-cli
- php-xml
- php-mbstring
- php-curl
- php-zip
- php-bcmath
- php-mysql (si vous utilisez MySQL)
- php-pgsql (si vous utilisez PostgreSQL)

---

## Étapes d'Installation

### 1. Cloner le Repository

```bash
git clone https://github.com/franck237loic/smartqueue-ai.git
cd smartqueue-ai
```

### 2. Installer les Dépendances PHP

```bash
composer install
```

### 3. Configurer l'Environnement

```bash
# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 4. Configurer la Base de Données

Modifiez le fichier `.env` avec vos informations de base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartqueue_ai
DB_USERNAME=votre_nom_utilisateur
DB_PASSWORD=votre_mot_de_passe
```

### 5. Exécuter les Migrations

```bash
php artisan migrate
```

### 6. Installer les Dépendances Frontend

```bash
npm install
```

### 7. Compiler les Assets

```bash
npm run build
```

### 8. Créer un Utilisateur (Optionnel)

```bash
php artisan tinker
```

Puis dans tinker :
```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@example.com';
$user->password = bcrypt('password');
$user->save();
```

---

## Configuration Supplémentaire

### Services Externes

Le projet utilise plusieurs services externes. Configurez-les dans votre fichier `.env` :

#### Pusher (WebSocket)
```env
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1
```

#### Twilio (SMS)
```env
TWILIO_ACCOUNT_SID=your_account_sid
TWILIO_AUTH_TOKEN=your_auth_token
TWILIO_PHONE_NUMBER=your_phone_number
```

#### Mail (pour les notifications)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

---

## Démarrer l'Application

### Option 1: Développement (Recommandé)

Utilisez le script composer pour démarrer tous les services :

```bash
composer run dev
```

Cette commande démarre :
- Le serveur Laravel (port 8000)
- Le worker de queue
- Les logs en temps réel
- Vite pour le développement frontend

### Option 2: Manuellement

Dans des terminaux séparés :

```bash
# Terminal 1: Serveur Laravel
php artisan serve

# Terminal 2: Worker de queue
php artisan queue:listen --tries=1 --timeout=0

# Terminal 3: Frontend (si développement)
npm run dev
```

---

## Accéder à l'Application

Une fois démarrée, vous pouvez accéder à l'application via :

- **URL principale** : http://localhost:8000
- **Documentation API** : http://localhost:8000/api/documentation

---

## Dépannage

### Problèmes Communs

#### 1. Erreur de permissions sur storage
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

#### 2. Erreur de clé d'application
```bash
php artisan key:generate
php artisan config:clear
php artisan cache:clear
```

#### 3. Erreur de migration
```bash
php artisan migrate:fresh --seed
```

#### 4. Problèmes avec npm
```bash
rm -rf node_modules
npm install
npm run build
```

#### 5. Problèmes avec composer
```bash
rm -rf vendor
composer install
```

### Vérification

Pour vérifier que tout fonctionne correctement :

```bash
# Vérifier l'installation de Laravel
php artisan --version

# Vérifier la connexion à la base de données
php artisan tinker
> \DB::connection()->getPdo();
```

---

## Structure du Projet

```
smartqueue-ai/
├── app/                    # Logique de l'application
├── bootstrap/              # Fichiers de démarrage
├── config/                 # Fichiers de configuration
├── database/               # Migrations et seeders
├── public/                 # Point d'entrée web
├── resources/              # Vues et assets frontend
├── routes/                 # Routes de l'application
├── storage/                # Fichiers générés
├── tests/                  # Tests unitaires
├── vendor/                 # Dépendances Composer
├── node_modules/           # Dépendances Node.js
└── .env                    # Configuration environnement
```

---

## Fonctionnalités Principales

- 🎫 **Gestion de files d'attente** intelligente
- 👥 **Multi-entreprises** avec isolation des données
- 📱 **Notifications temps réel** via WebSocket
- 📊 **Tableaux de bord** statistiques
- 🔄 **Workflow de tickets** complet
- 📱 **Interface responsive** moderne
- 🔔 **Notifications SMS** (Twilio)
- 📈 **Analytics** et rapports

---

## Support

Si vous rencontrez des problèmes :

1. Vérifiez les logs dans `storage/logs/laravel.log`
2. Assurez-vous que toutes les dépendances sont installées
3. Vérifiez votre configuration `.env`
4. Consultez la documentation Laravel officielle

---

## Déploiement en Production

Pour un déploiement en production, n'oubliez pas de :

1. `php artisan config:cache`
2. `php artisan route:cache`
3. `php artisan view:cache`
4. `npm run build` (mode production)
5. Configurer un serveur web (Apache/Nginx)
6. Mettre en place HTTPS
7. Configurer les tâches cron pour le scheduler
