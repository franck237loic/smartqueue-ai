<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Super Admin 2',
            'email' => 'super2@smartqueue.ai',
            'password' => Hash::make('admin2024'),
            'global_role' => 'super_admin',
        ]);

        $this->command->info('Super Admin créé avec succès!');
        $this->command->info('Email: super2@smartqueue.ai');
        $this->command->info('Mot de passe: admin2024');
    }
}
