<?php

namespace Database\Factories;

use App\Enums\ExperienceType;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Experience>
 */
class ExperienceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'position' => $this->faker->jobTitle(),
            'organization' => $this->faker->company(),
            'type' => $this->faker->randomElement(ExperienceType::cases()),
            'started_at' => $this->faker->dateTimeBetween('-3 years', '-1 year'),
            'ended_at' => null,
            'description' => $this->faker->sentence(20),
        ];
    }
}
