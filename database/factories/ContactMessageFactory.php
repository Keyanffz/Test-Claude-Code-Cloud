<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'message' => $this->faker->paragraph(),
            'ip_address' => $this->faker->ipv4(),
        ];
    }

    public function read(): static
    {
        return $this->state(['read_at' => now()]);
    }
}
