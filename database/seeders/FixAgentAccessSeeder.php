<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class FixAgentAccessSeeder extends Seeder
{
    public function run()
    {
        echo "=== RÉPARATION ACCÈS AGENT ===\n";

        // Récupérer l'agent
        $agent = User::where('email', 'agent@smartqueue.ai')->first();
        if (!$agent) {
            echo "Agent non trouvé!\n";
            return;
        }

        // Récupérer la Banque Populaire (ID 2)
        $company = Company::find(2);
        if (!$company) {
            echo "Banque Populaire non trouvée!\n";
            return;
        }

        echo "Agent ID: {$agent->id}\n";
        echo "Company ID: {$company->id}\n";

        // Supprimer toutes les assignations existantes
        DB::table('company_user')->where('user_id', $agent->id)->delete();
        echo "Anciennes assignations supprimées\n";

        // Créer la nouvelle assignation
        DB::table('company_user')->insert([
            'user_id' => $agent->id,
            'company_id' => $company->id,
            'role' => 'agent',
            'is_default' => true,
            'last_login_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        echo "Nouvelle assignation créée\n";

        // Mettre à jour current_company_id
        $agent->update(['current_company_id' => $company->id]);
        echo "Current company ID mis à jour\n";

        // Vérifier l'accès
        $companies = DB::table('company_user')
            ->where('user_id', $agent->id)
            ->get();
        
        echo "Assignations de l'agent:\n";
        foreach ($companies as $c) {
            echo "- Company ID: {$c->company_id}, Role: {$c->role}\n";
        }

        echo "\n=== RÉPARATION TERMINÉE ===\n";
        echo "URL agent: http://127.0.0.1:8001/company/{$company->id}/agent\n";
        echo "Testez maintenant l'accès!\n";
    }
}
