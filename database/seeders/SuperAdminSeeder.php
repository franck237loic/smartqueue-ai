<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@smartqueue.ai'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'global_role' => 'super_admin',
            ]
        );
    }
}
