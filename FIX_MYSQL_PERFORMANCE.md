# 🔧 FIX Performance MySQL - Timeout Errors

## Problème
Les requêtes SQL prennent 6-22 secondes (timeout > 60s)

## Solutions

### Option 1: Réparer MySQL (Recommandé)

Ouvrir `c:\Users\FranckDev\smartqueue-ai\.env` et vérifier:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smartqueue
DB_USERNAME=root
DB_PASSWORD=
```

**Ensuite exécuter dans MySQL:**
```sql
-- Optimiser les tables
OPTIMIZE TABLE companies, company_user, users, sessions;

-- Vérifier les index
SHOW INDEX FROM company_user;

-- Ajouter les index manquants
ALTER TABLE company_user ADD INDEX idx_user_id (user_id);
ALTER TABLE company_user ADD INDEX idx_is_default (is_default);
ALTER TABLE company_user ADD INDEX idx_user_default (user_id, is_default);
```

### Option 2: Utiliser SQLite (Tests rapides)

Modifier `.env`:
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

Puis exécuter:
```bash
touch database/database.sqlite
php artisan migrate:fresh --seed
```

### Option 3: Augmenter timeouts (Contournement)

Déjà appliqué dans AuthController (300s max).

---

## Vérifier MySQL tourne:
```powershell
Get-Process mysqld
```

Si pas de résultat, démarrer XAMPP/WAMP ou MySQL.
