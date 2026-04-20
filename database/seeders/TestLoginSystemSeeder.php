<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;

class TestLoginSystemSeeder extends Seeder
{
    public function run()
    {
        echo "=== PRÉPARATION AU TEST DU SYSTÈME DE LOGIN ===\n\n";

        // 1. Vérifier l'état actuel des utilisateurs de test
        echo "1. UTILISATEURS DE TEST DISPONIBLES:\n";
        
        $testUsers = [
            'admin@smartqueue.ai' => 'Super Admin',
            'company@smartqueue.ai' => 'Admin Entreprise',
            'agent@smartqueue.ai' => 'Agent',
        ];
        
        foreach ($testUsers as $email => $role) {
            $user = User::where('email', $email)->first();
            if ($user) {
                echo "   - {$role}: {$user->name} ({$user->email}) - Role: {$user->global_role}\n";
                
                // Vérifier les entreprises associées
                $companies = $user->companies()->get();
                echo "     * Entreprises accessibles: " . $companies->count() . "\n";
                foreach ($companies as $company) {
                    echo "       - {$company->name} ({$company->pivot->role})\n";
                }
            } else {
                echo "   - ERREUR: {$role} non trouvé\n";
            }
        }

        // 2. Vérifier les entreprises disponibles
        echo "\n2. ENTREPRISES DISPONIBLES:\n";
        $companies = Company::where('status', 'active')->get();
        echo "   - Nombre d'entreprises actives: " . $companies->count() . "\n";
        
        foreach ($companies as $company) {
            echo "   - {$company->name} (ID: {$company->id})\n";
        }

        // 3. Instructions de test détaillées
        echo "\n3. INSTRUCTIONS DE TEST COMPLÈTES:\n";
        echo "   ======================================\n";
        echo "   ÉTAPE 1: TEST SUPER ADMIN\n";
        echo "   - URL: http://127.0.0.1:8000/login\n";
        echo "   - Email: admin@smartqueue.ai\n";
        echo "   - Mot de passe: password\n";
        echo "   - Rôle: Super Admin\n";
        echo "   - Champ entreprise: doit être masqué automatiquement\n";
        echo "   - Redirection attendue: /super-admin\n";
        echo "   - Dashboard: Super Admin avec statistiques globales\n\n";
        
        echo "   ÉTAPE 2: TEST ADMIN ENTREPRISE\n";
        echo "   - URL: http://127.0.0.1:8000/login\n";
        echo "   - Email: company@smartqueue.ai\n";
        echo "   - Mot de passe: password\n";
        echo "   - Rôle: Admin Entreprise\n";
        echo "   - Champ entreprise: visible, sélection obligatoire\n";
        echo "   - Entreprise: SmartQueue Demo\n";
        echo "   - Redirection attendue: /company/1/admin/dashboard\n";
        echo "   - Dashboard: Admin Entreprise avec gestion\n\n";
        
        echo "   ÉTAPE 3: TEST AGENT\n";
        echo "   - URL: http://127.0.0.1:8000/login\n";
        echo "   - Email: agent@smartqueue.ai\n";
        echo "   - Mot de passe: password\n";
        echo "   - Rôle: Agent\n";
        echo "   - Champ entreprise: visible, sélection obligatoire\n";
        echo "   - Entreprise: Banque Populaire\n";
        echo "   - Redirection attendue: /company/2/agent/dashboard\n";
        echo "   - Dashboard: Agent avec guichets et services\n\n";

        // 4. Points de vérification
        echo "4. POINTS DE VÉRIFICATION CRITIQUES:\n";
        echo "   ======================================\n";
        echo "   Pour chaque test, vérifiez:\n";
        echo "   - [ ] Le champ entreprise s'affiche/masque correctement\n";
        echo "   - [ ] La validation du formulaire fonctionne\n";
        echo "   - [ ] La redirection est correcte\n";
        echo "   - [ ] Le dashboard s'affiche sans erreur\n";
        echo "   - [ ] Les données sont présentes dans le dashboard\n";
        echo "   - [ ] L'accès aux bonnes sections est autorisé\n";
        echo "   - [ ] L'accès aux sections non autorisées est bloqué\n\n";

        // 5. Dépannage
        echo "5. DÉPANNAGE EN CAS D'ERREUR:\n";
        echo "   ================================\n";
        echo "   Si erreur 403:\n";
        echo "   - Vérifiez le middleware approprié\n";
        echo "   - Vérifiez les permissions utilisateur\n";
        echo "   - Vérifiez la relation utilisateur-entreprise\n\n";
        
        echo "   Si erreur de redirection:\n";
        echo "   - Vérifiez la logique dans AuthController\n";
        echo "   - Vérifiez les noms de routes\n";
        echo "   - Vérifiez les paramètres de redirection\n\n";
        
        echo "   Si erreur d'affichage:\n";
        echo "   - Vérifiez les vues correspondantes\n";
        echo "   - Vérifiez les données passées aux vues\n";
        echo "   - Vérifiez les erreurs JavaScript\n\n";

        echo "=== PRÊT POUR LES TESTS ===\n";
        echo "   Lancez le serveur: php artisan serve --port=8000\n";
        echo "   Suivez les instructions ci-dessus\n";
        echo "   Notez les résultats pour chaque test\n\n";
    }
}
