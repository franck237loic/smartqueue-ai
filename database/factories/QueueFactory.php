<?php

namespace Database\Factories;

use App\Models\Queue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QueueFactory extends Factory
{
    protected $model = Queue::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Accueil Principal', 'Service Client', 'Support Technique', 'Paiements', 'Consultation']),
            'description' => $this->faker->sentence(),
            'prefix' => $this->faker->randomElement(['A', 'B', 'C', 'S', 'P']),
            'current_number' => 0,
            'status' => $this->faker->randomElement(['active', 'paused', 'closed']),
            'user_id' => User::factory(),
            'estimated_service_time' => $this->faker->numberBetween(3, 15),
            'missed_timeout' => 3,
        ];
    }
}
