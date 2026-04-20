<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Str;

class ProductionDataSeeder extends Seeder
{
    public function run()
    {
        echo "=== CRÉATION DONNÉES DE PRODUCTION ===\n";

        $company = Company::where('slug', 'banque-populaire')->first();
        if (!$company) {
            echo "Entreprise Banque Populaire non trouvée!\n";
            return;
        }

        echo "Entreprise: {$company->name} (ID: {$company->id})\n";

        // Récupérer les services
        $services = $company->services()->get();
        echo "Services trouvés: {$services->count()}\n";

        // Supprimer les tickets existants pour repartir de zéro
        Ticket::where('company_id', $company->id)->delete();
        echo "Anciens tickets supprimés\n";

        // Créer des noms de clients réalistes
        $firstNames = ['Jean', 'Marie', 'Pierre', 'Sophie', 'Michel', 'Isabelle', 'Philippe', 'Nathalie', 'Alain', 'Catherine', 'Bernard', 'Monique', 'Jacques', 'Françoise', 'Daniel', 'Martine', 'Patrick', 'Sylvie', 'Christophe', 'Laurence', 'David', 'Valérie', 'Éric', 'Caroline', 'Laurent', 'Anne', 'Stéphane', 'Sandrine', 'Nicolas', 'Emmanuelle', 'Olivier', 'Claudine', 'Julien', 'Delphine', 'Sébastien', 'Camille', 'Thierry', 'Hélène', 'Vincent', 'Marion', 'Grégory', 'Sabrina', 'Antoine', 'Élodie', 'Maxime', 'Aurélie', 'Romain', 'Pauline', 'Alexandre', 'Mathilde'];
        
        $lastNames = ['Martin', 'Bernard', 'Dubois', 'Robert', 'Richard', 'Petit', 'Durand', 'Leroy', 'Moreau', 'Simon', 'Laurent', 'Lefebvre', 'David', 'Bertrand', 'Roux', 'Thomas', 'Garnier', 'Robert', 'Girard', 'Bonnet', 'Fournier', 'Chevalier', 'Lopez', 'Nicolas', 'Fontaine', 'Mercier', 'Gauthier', 'Perrin', 'Robin', 'Colin', 'Caron', 'Blanc', 'Marty', 'Guérin', 'Barbier', 'Marchand', 'Ryan', 'Da Silva', 'Meyer', 'Sanchez', 'Dupont', 'Legrand', 'Gilles', 'Gaillard', 'Joly', 'Chevallier'];

        $ticketsCreated = 0;
        $ticketId = 1;

        foreach ($services as $service) {
            echo "\n--- Service: {$service->name} ({$service->prefix}) ---\n";
            
            // Créer entre 10-15 tickets par service
            $ticketsPerService = rand(10, 15);
            
            for ($i = 0; $i < $ticketsPerService; $i++) {
                // Générer un nom de client aléatoire
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                $clientName = "{$firstName} {$lastName}";
                
                // Générer un numéro de téléphone français
                $phoneNumber = '0' . rand(6, 7) . str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT);
                
                // Calculer le numéro de ticket
                $sequence = $i + 1;
                $ticketNumber = $service->prefix . str_pad($sequence, 3, '0', STR_PAD_LEFT);
                
                // Statuts variés pour simuler une file d'attente réelle
                $status = 'waiting';
                if ($i < 2) {
                    $status = 'served'; // Quelques tickets déjà servis
                } elseif ($i < 4) {
                    $status = 'called'; // Quelques tickets en cours d'appel
                }
                
                // Créer le ticket avec un timestamp espacé pour simuler l'arrivée progressive
                $createdAt = now()->subMinutes(rand(5, 120)); // Arrivés entre 5min et 2h avant
                
                $ticket = Ticket::create([
                    'company_id' => $company->id,
                    'service_id' => $service->id,
                    'number' => $ticketNumber,
                    'status' => $status,
                    'client_name' => $clientName,
                    'client_phone' => $phoneNumber,
                    'estimated_wait_time' => $service->estimated_service_time * 60, // en secondes
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
                
                // Calculer et afficher la position
                $position = $this->calculatePosition($ticket);
                
                echo "  Ticket #{$ticket->id}: {$ticket->number} - {$clientName} - Position: {$position} - Statut: {$status}\n";
                
                $ticketsCreated++;
                $ticketId++;
            }
        }

        echo "\n=== RÉSUMÉ ===\n";
        echo "Total tickets créés: {$ticketsCreated}\n";
        echo "Services: {$services->count()}\n";
        echo "Entreprise: {$company->name}\n\n";
        
        // Afficher les statistiques par service
        foreach ($services as $service) {
            $waitingCount = Ticket::where('service_id', $service->id)
                ->where('status', 'waiting')
                ->count();
            
            echo "Service {$service->name}: {$waitingCount} clients en attente\n";
        }
        
        echo "\n=== URLS DE TEST ===\n";
        echo "Page client: http://127.0.0.1:8001/client\n";
        echo "Banque Populaire: http://127.0.0.1:8001/company/{$company->id}/public\n";
        echo "\n=== INSTRUCTIONS CLIENT ===\n";
        echo "1. Le client arrive sur /client\n";
        echo "2. Il choisit 'Banque Populaire'\n";
        echo "3. Il voit les services avec le nombre d'attente\n";
        echo "4. Il prend un ticket avec nom + téléphone\n";
        echo "5. Il voit sa position en temps réel\n";
        echo "6. Il peut suivre son ticket via l'URL directe\n";
    }
    
    private function calculatePosition($ticket)
    {
        return Ticket::where('service_id', $ticket->service_id)
            ->whereIn('status', ['waiting', 'missed_temp'])
            ->where(function ($query) use ($ticket) {
                $query->where('created_at', '<', $ticket->created_at);
            })
            ->count() + 1;
    }
}
