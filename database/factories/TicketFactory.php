<?php

namespace Database\Factories;

use App\Models\Queue;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['waiting', 'called', 'served', 'missed']);
        $calledAt = in_array($status, ['called', 'served', 'missed']) ? $this->faker->dateTimeBetween('-1 hour', 'now') : null;
        $servedAt = in_array($status, ['served']) ? $this->faker->dateTimeBetween($calledAt, 'now') : null;

        return [
            'queue_id' => Queue::factory(),
            'number' => $this->faker->bothify('?###'),
            'status' => $status,
            'called_at' => $calledAt,
            'served_at' => $servedAt,
            'agent_id' => in_array($status, ['called', 'served', 'missed']) ? User::factory() : null,
            'client_name' => $this->faker->optional()->name(),
            'client_phone' => $this->faker->optional()->phoneNumber(),
            'estimated_wait_time' => $this->faker->optional()->numberBetween(5, 60),
            'actual_service_time' => $servedAt ? $this->faker->numberBetween(3, 20) : null,
        ];
    }

    public function waiting(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'waiting',
            'called_at' => null,
            'served_at' => null,
            'agent_id' => null,
            'actual_service_time' => null,
        ]);
    }

    public function called(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'called',
            'called_at' => now(),
            'served_at' => null,
            'agent_id' => User::factory(),
            'actual_service_time' => null,
        ]);
    }

    public function served(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'served',
            'called_at' => now()->subMinutes(10),
            'served_at' => now(),
            'agent_id' => User::factory(),
            'actual_service_time' => 10,
        ]);
    }
}
