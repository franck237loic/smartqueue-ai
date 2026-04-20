<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Counter;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Créer le Super Admin (ou récupérer s'il existe)
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@smartqueue.ai'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'global_role' => 'super_admin',
            ]
        );

        // Créer une entreprise (ou récupérer si existe)
        $company = Company::firstOrCreate(
            ['slug' => 'smartqueue-demo'],
            [
                'name' => 'SmartQueue Demo',
                'email' => 'contact@smartqueue.ai',
                'phone' => '+33 1 23 45 67 89',
                'address' => '123 Rue de Paris, 75000 Paris',
                'status' => 'active',
            ]
        );

        // Créer l'admin de l'entreprise
        $companyAdmin = User::firstOrCreate(
            ['email' => 'company@smartqueue.ai'],
            [
                'name' => 'Admin Entreprise',
                'password' => Hash::make('password'),
                'global_role' => 'user',
                'current_company_id' => $company->id,
            ]
        );

        // Attacher l'admin à l'entreprise si pas déjà fait
        if (!$companyAdmin->companies()->where('company_id', $company->id)->exists()) {
            $companyAdmin->companies()->attach($company->id, [
                'role' => 'company_admin',
                'is_default' => true,
            ]);
        }

        // Créer un agent
        $agent = User::firstOrCreate(
            ['email' => 'agent@smartqueue.ai'],
            [
                'name' => 'Agent Service',
                'password' => Hash::make('password'),
                'global_role' => 'user',
                'current_company_id' => $company->id,
            ]
        );

        if (!$agent->companies()->where('company_id', $company->id)->exists()) {
            $agent->companies()->attach($company->id, [
                'role' => 'agent',
                'is_default' => true,
            ]);
        }

        // Créer des services
        $serviceAccueil = Service::firstOrCreate(
            ['company_id' => $company->id, 'prefix' => 'A'],
            [
                'name' => 'Accueil Principal',
                'description' => 'Accueil et orientation des clients',
                'estimated_service_time' => 5,
                'missed_timeout' => 5,
                'max_daily_tickets' => 200,
                'status' => 'active',
            ]
        );

        $serviceClient = Service::firstOrCreate(
            ['company_id' => $company->id, 'prefix' => 'B'],
            [
                'name' => 'Service Client',
                'description' => 'Service client et support',
                'estimated_service_time' => 10,
                'missed_timeout' => 5,
                'max_daily_tickets' => 100,
                'status' => 'active',
            ]
        );

        // Créer des guichets
        $counter1 = Counter::firstOrCreate(
            ['company_id' => $company->id, 'number' => 'G1'],
            [
                'service_id' => $serviceAccueil->id,
                'user_id' => $agent->id,
                'name' => 'Guichet 1',
                'location' => 'Hall principal',
                'status' => 'open',
                'is_active' => true,
            ]
        );

        $counter2 = Counter::firstOrCreate(
            ['company_id' => $company->id, 'number' => 'G2'],
            [
                'service_id' => $serviceClient->id,
                'user_id' => $agent->id,
                'name' => 'Guichet 2',
                'location' => 'Zone service client',
                'status' => 'closed',
                'is_active' => true,
            ]
        );

        // Créer des tickets
        for ($i = 1; $i <= 5; $i++) {
            Ticket::create([
                'company_id' => $company->id,
                'service_id' => $serviceAccueil->id,
                'number' => $serviceAccueil->prefix . now()->format('Ymd') . str_pad($i, 3, '0', STR_PAD_LEFT),
                'status' => 'waiting',
                'estimated_wait_time' => $i * 5,
            ]);
        }

        for ($i = 1; $i <= 3; $i++) {
            Ticket::create([
                'company_id' => $company->id,
                'service_id' => $serviceClient->id,
                'number' => $serviceClient->prefix . now()->format('Ymd') . str_pad($i + 10, 3, '0', STR_PAD_LEFT),
                'status' => 'waiting',
                'estimated_wait_time' => $i * 10,
            ]);
        }

        // Tickets servis
        for ($i = 1; $i <= 10; $i++) {
            Ticket::create([
                'company_id' => $company->id,
                'service_id' => $serviceAccueil->id,
                'counter_id' => $counter1->id,
                'agent_id' => $agent->id,
                'number' => $serviceAccueil->prefix . now()->subDays(1)->format('Ymd') . str_pad($i, 3, '0', STR_PAD_LEFT),
                'status' => 'served',
                'called_at' => now()->subDays(1)->subHours(2),
                'served_at' => now()->subDays(1)->subHours(1),
                'actual_service_time' => 5,
            ]);
        }

        // Afficher les informations de test
        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('=== DONNÉES DE TEST CRÉÉES AVEC SUCCÈS ===');
        $this->command->info('========================================');
        $this->command->info("Entreprise ID: {$company->id}");
        $this->command->info("Entreprise: {$company->name}");
        $this->command->info('');
        $this->command->info('--- SUPER ADMIN ---');
        $this->command->info('Email: admin@smartqueue.ai');
        $this->command->info('Password: password');
        $this->command->info('URL: http://127.0.0.1:8000/super-admin');
        $this->command->info('');
        $this->command->info('--- ADMIN ENTREPRISE ---');
        $this->command->info('Email: company@smartqueue.ai');
        $this->command->info('Password: password');
        $this->command->info("URL: http://127.0.0.1:8000/company/{$company->id}/admin");
        $this->command->info('');
        $this->command->info('--- AGENT ---');
        $this->command->info('Email: agent@smartqueue.ai');
        $this->command->info('Password: password');
        $this->command->info("URL: http://127.0.0.1:8000/company/{$company->id}/agent");
        $this->command->info('');
        $this->command->info('========================================');
    }
}
