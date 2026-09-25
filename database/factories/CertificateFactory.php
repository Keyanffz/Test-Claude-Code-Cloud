<?php

namespace Database\Factories;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Certificate>
 */
class CertificateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'issuer' => $this->faker->company(),
            'issued_at' => $this->faker->dateTimeBetween('-2 years'),
            'url' => $this->faker->url(),
        ];
    }
}
