<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateTestData extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "Création des données de test...\n";

        // Créer une entreprise de test
        $company = Company::firstOrCreate(
            ['slug' => 'test-company'],
            [
                'name' => 'Entreprise Test',
                'address' => '123 Rue de Test, 75000 Paris',
                'phone' => '+33 1 23 45 67 89',
                'email' => 'contact@test-company.com',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        echo "Entreprise créée: {$company->name} (ID: {$company->id})\n";

        // Créer un utilisateur agent de test
        $agentUser = User::firstOrCreate(
            ['email' => 'agent@test-company.com'],
            [
                'name' => 'Agent Test',
                'password' => Hash::make('password123'),
                'global_role' => 'user',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        echo "Utilisateur agent créé: {$agentUser->name} (ID: {$agentUser->id})\n";

        // Attacher l'agent à l'entreprise
        $agentUser->companies()->syncWithoutDetaching([
            $company->id => [
                'role' => 'agent',
                'is_default' => true,
                'counter_id' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        echo "Agent attaché à l'entreprise avec le rôle 'agent'\n";

        // Créer un utilisateur admin de test
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@test-company.com'],
            [
                'name' => 'Admin Test',
                'password' => Hash::make('password123'),
                'global_role' => 'user',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        echo "Utilisateur admin créé: {$adminUser->name} (ID: {$adminUser->id})\n";

        // Attacher l'admin à l'entreprise
        $adminUser->companies()->syncWithoutDetaching([
            $company->id => [
                'role' => 'company_admin',
                'is_default' => true,
                'counter_id' => null,
                'last_login_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        echo "Admin attaché à l'entreprise avec le rôle 'company_admin'\n";

        // Vérifier les relations
        echo "\n=== VÉRIFICATION DES RELATIONS ===\n";
        
        $agentTest = User::with('companies')->find($agentUser->id);
        echo "Agent {$agentTest->name}:\n";
        foreach ($agentTest->companies as $comp) {
            $role = $agentTest->companyRole($comp);
            $isAgent = $agentTest->isAgentInCompany($comp);
            echo "  - Entreprise: {$comp->name} (Rôle: {$role}, Agent: " . ($isAgent ? 'OUI' : 'NON') . ")\n";
        }

        $adminTest = User::with('companies')->find($adminUser->id);
        echo "\nAdmin {$adminTest->name}:\n";
        foreach ($adminTest->companies as $comp) {
            $role = $adminTest->companyRole($comp);
            $isAdmin = $adminTest->isCompanyAdmin($comp);
            echo "  - Entreprise: {$comp->name} (Rôle: {$role}, Admin: " . ($isAdmin ? 'OUI' : 'NON') . ")\n";
        }

        echo "\n=== DONNÉES DE TEST CRÉÉES ===\n";
        echo "Agent: agent@test-company.com / password123\n";
        echo "Admin: admin@test-company.com / password123\n";
        echo "Entreprise ID: {$company->id}\n";
        echo "URL Dashboard Agent: http://127.0.0.1:8000/company/{$company->id}/agent\n";
        echo "URL Dashboard Admin: http://127.0.0.1:8000/company/{$company->id}/admin\n";
    }
}
