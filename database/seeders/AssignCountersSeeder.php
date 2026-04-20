<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Counter;
use App\Models\Service;

class AssignCountersSeeder extends Seeder
{
    public function run()
    {
        echo "=== ASSIGNATION DES GUICHETS AUX SERVICES ===\n";

        // Récupérer l'entreprise Banque Populaire (ID 2)
        $company = Company::find(2);
        if (!$company) {
            echo "Entreprise Banque Populaire non trouvée!\n";
            return;
        }

        // Récupérer les guichets de l'entreprise
        $counters = Counter::where('company_id', $company->id)->get();
        echo "Guichets trouvés: {$counters->count()}\n";

        // Récupérer les services
        $services = Service::where('company_id', $company->id)->get();
        echo "Services trouvés: {$services->count()}\n";

        if ($counters->isEmpty() || $services->isEmpty()) {
            echo "Pas de guichets ou de services à assigner\n";
            return;
        }

        // Assigner les guichets aux services
        $assignments = [
            ['counter' => 'Guichet 1', 'service' => 'Guichet Retraits'],
            ['counter' => 'Guichet 2', 'service' => 'Guichet Dépôts'],
            ['counter' => 'Guichet 3', 'service' => 'Guichet Retraits'],
            ['counter' => 'Conseiller 1', 'service' => 'Conseiller Client'],
            ['counter' => 'Conseiller 2', 'service' => 'Crédits'],
        ];

        foreach ($assignments as $assignment) {
            $counter = $counters->firstWhere('name', $assignment['counter']);
            $service = $services->firstWhere('name', $assignment['service']);

            if ($counter && $service) {
                $counter->update(['service_id' => $service->id]);
                echo "Assigné: {$counter->name} -> {$service->name}\n";
            } else {
                echo "Non trouvé: {$assignment['counter']} ou {$assignment['service']}\n";
            }
        }

        echo "\n=== ASSIGNATION TERMINÉE ===\n";
        echo "Les guichets sont maintenant prêts pour les agents!\n";
    }
}
