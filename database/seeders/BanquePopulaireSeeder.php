<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Service;
use App\Models\Counter;

class BanquePopulaireSeeder extends Seeder
{
    public function run()
    {
        // Trouver ou créer l'entreprise
        $company = Company::firstOrCreate(
            ['slug' => 'banque-populaire'],
            [
                'name' => 'Banque Populaire',
                'address' => '123 Rue de la République, 75001 Paris',
                'phone' => '01 23 45 67 89',
                'email' => 'contact@banque-populaire.fr',
                'website' => 'https://www.banque-populaire.fr',
                'status' => 'active'
            ]
        );

        echo "Entreprise trouvée/créée: {$company->name} (ID: {$company->id})\n";
        
        // Supprimer les services existants pour éviter les doublons
        $company->services()->delete();
        echo "Services existants supprimés\n";

        // Créer les services
        $services = [
            [
                'name' => 'Guichet Retraits',
                'prefix' => 'RET',
                'description' => 'Retraits d\'espèces jusqu\'à 5000',
                'estimated_service_time' => 5,
                'status' => 'active',
                'max_daily_tickets' => 50
            ],
            [
                'name' => 'Guichet Dépôts', 
                'prefix' => 'DEP',
                'description' => 'Dépôts et versements',
                'estimated_service_time' => 8,
                'status' => 'active',
                'max_daily_tickets' => 40
            ],
            [
                'name' => 'Conseiller Client',
                'prefix' => 'CON', 
                'description' => 'Conseils bancaires et ouverture comptes',
                'estimated_service_time' => 15,
                'status' => 'active',
                'max_daily_tickets' => 30
            ],
            [
                'name' => 'Crédits',
                'prefix' => 'CRE',
                'description' => 'Demandes de crédits et prêts personnels',
                'estimated_service_time' => 20,
                'status' => 'active',
                'max_daily_tickets' => 25
            ]
        ];

        foreach ($services as $serviceData) {
            $service = $company->services()->create($serviceData);
            echo "Service créé: {$service->name} ({$service->prefix})\n";
        }

        // Créer les guichets
        $counters = [
            ['name' => 'Guichet 1', 'number' => '1'],
            ['name' => 'Guichet 2', 'number' => '2'], 
            ['name' => 'Guichet 3', 'number' => '3'],
            ['name' => 'Conseiller 1', 'number' => '4'],
            ['name' => 'Conseiller 2', 'number' => '5'],
        ];

        foreach ($counters as $counterData) {
            $counter = $company->counters()->create($counterData);
            echo "Guichet créé: {$counter->name}\n";
        }

        echo "\n=== BANQUE POPULAIRE CRÉÉE AVEC SUCCÈS ===\n";
        echo "URL publique: http://127.0.0.1:8001/company/{$company->id}/public\n";
        echo "URL client: http://127.0.0.1:8001/client\n";
    }
}
