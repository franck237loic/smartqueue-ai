<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Counter;
use App\Models\Company;

class AssignAgentToCountersSeeder extends Seeder
{
    public function run()
    {
        echo "=== ASSIGNATION AGENT AUX GUICHETS ===\n";

        // Récupérer l'agent
        $agent = User::where('email', 'agent@smartqueue.ai')->first();
        if (!$agent) {
            echo "Agent non trouvé!\n";
            return;
        }

        // Récupérer la Banque Populaire
        $company = Company::find(2);
        if (!$company) {
            echo "Banque Populaire non trouvée!\n";
            return;
        }

        // Récupérer tous les guichets de la Banque Populaire
        $counters = Counter::where('company_id', $company->id)->get();
        echo "Guichets trouvés: {$counters->count()}\n";

        foreach ($counters as $counter) {
            // Assigner l'agent au guichet
            $counter->update(['user_id' => $agent->id]);
            echo "Agent assigné au guichet: {$counter->name}\n";
        }

        echo "\n=== ASSIGNATION TERMINÉE ===\n";
        echo "L'agent peut maintenant utiliser tous les guichets!\n";
        echo "URL: http://127.0.0.1:8001/company/2/agent\n";
    }
}
