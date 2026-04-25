<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$kernel->bootstrap();

echo "=== VÉRIFICATION DES UTILISATEURS EN BASE DE DONNÉES ===" . PHP_EOL;

try {
    // Récupérer tous les utilisateurs
    $users = \App\Models\User::withTrashed()->get();
    
    if ($users->isEmpty()) {
        echo "Aucun utilisateur trouvé en base de données." . PHP_EOL;
        exit;
    }
    
    echo PHP_EOL . "Liste des utilisateurs (" . $users->count() . "):" . PHP_EOL;
    echo str_repeat("-", 80) . PHP_EOL;
    echo sprintf("%-5s %-25s %-30s %-15s %-20s %-10s" . PHP_EOL, 
        "ID", "Nom", "Email", "Rôle", "Créé le", "Statut");
    echo str_repeat("-", 80) . PHP_EOL;
    
    foreach ($users as $user) {
        $status = $user->deleted_at ? 'Supprimé' : 'Actif';
        echo sprintf("%-5d %-25s %-30s %-15s %-20s %-10s" . PHP_EOL,
            $user->id,
            substr($user->name, 0, 24),
            substr($user->email, 0, 29),
            $user->global_role ?? 'N/A',
            $user->created_at->format('Y-m-d'),
            $status
        );
    }
    
    echo str_repeat("-", 80) . PHP_EOL;
    echo PHP_EOL . "Statistiques:" . PHP_EOL;
    echo "- Total: " . $users->count() . " utilisateurs" . PHP_EOL;
    echo "- Actifs: " . $users->where('deleted_at', null)->count() . PHP_EOL;
    echo "- Supprimés: " . $users->where('deleted_at', '!=', null)->count() . PHP_EOL;
    echo "- Super Admin: " . $users->where('global_role', 'super_admin')->count() . PHP_EOL;
    echo "- Company Admin: " . $users->where('global_role', 'company_admin')->count() . PHP_EOL;
    echo "- Agents: " . $users->where('global_role', 'agent')->count() . PHP_EOL;
    echo "- Clients: " . $users->where('global_role', 'client')->count() . PHP_EOL;
    
    echo PHP_EOL . "Voulez-vous supprimer des utilisateurs? (y/n): ";
    $handle = fopen("php://stdin", "r");
    $response = trim(fgets($handle));
    fclose($handle);
    
    if (strtolower($response) === 'y') {
        echo PHP_EOL . "Options de suppression:" . PHP_EOL;
        echo "1. Supprimer tous les utilisateurs sauf le Super Admin" . PHP_EOL;
        echo "2. Supprimer les utilisateurs supprimés (soft delete)" . PHP_EOL;
        echo "3. Supprimer un utilisateur spécifique (par ID)" . PHP_EOL;
        echo "4. Supprimer tous les utilisateurs (DANGER!)" . PHP_EOL;
        echo "0. Annuler" . PHP_EOL;
        echo PHP_EOL . "Choix: ";
        
        $handle = fopen("php://stdin", "r");
        $choice = trim(fgets($handle));
        fclose($handle);
        
        switch ($choice) {
            case '1':
                echo PHP_EOL . "Suppression de tous les utilisateurs sauf le Super Admin..." . PHP_EOL;
                $deletedCount = \App\Models\User::where('global_role', '!=', 'super_admin')->delete();
                echo $deletedCount . " utilisateurs supprimés." . PHP_EOL;
                break;
                
            case '2':
                echo PHP_EOL . "Suppression définitive des utilisateurs déjà supprimés..." . PHP_EOL;
                $forceDeletedCount = \App\Models\User::onlyTrashed()->forceDelete();
                echo $forceDeletedCount . " utilisateurs supprimés définitivement." . PHP_EOL;
                break;
                
            case '3':
                echo PHP_EOL . "ID de l'utilisateur à supprimer: ";
                $handle = fopen("php://stdin", "r");
                $userId = trim(fgets($handle));
                fclose($handle);
                
                $userToDelete = \App\Models\User::find($userId);
                if ($userToDelete) {
                    if ($userToDelete->global_role === 'super_admin') {
                        echo "ERREUR: Impossible de supprimer un Super Admin." . PHP_EOL;
                    } else {
                        $userToDelete->delete();
                        echo "Utilisateur " . $userToDelete->name . " supprimé." . PHP_EOL;
                    }
                } else {
                    echo "ERREUR: Utilisateur non trouvé." . PHP_EOL;
                }
                break;
                
            case '4':
                echo PHP_EOL . "ATTENTION! Cela va supprimer TOUS les utilisateurs y compris le Super Admin!" . PHP_EOL;
                echo "Êtes-vous absolument sûr? (tapez 'DELETE ALL'): ";
                $handle = fopen("php://stdin", "r");
                $confirm = trim(fgets($handle));
                fclose($handle);
                
                if ($confirm === 'DELETE ALL') {
                    $allDeletedCount = \App\Models\User::getQuery()->delete();
                    echo $allDeletedCount . " utilisateurs supprimés." . PHP_EOL;
                } else {
                    echo "Opération annulée." . PHP_EOL;
                }
                break;
                
            case '0':
                echo "Opération annulée." . PHP_EOL;
                break;
                
            default:
                echo "Choix invalide." . PHP_EOL;
        }
    }
    
} catch (\Exception $e) {
    echo "ERREUR: " . $e->getMessage() . PHP_EOL;
    echo PHP_EOL . "Trace:" . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
}
