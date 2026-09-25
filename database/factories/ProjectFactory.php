<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    public function definition(): array
    {
        $title = Str::title($this->faker->unique()->words(2, true));

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'summary' => $this->faker->sentence(14),
            'description' => $this->faker->paragraphs(3, true),
            'role' => 'Frontend Developer',
            'tech_stack' => $this->faker->randomElements(['Laravel', 'React', 'Next.js', 'Flutter', 'MySQL'], 2),
            'year' => (int) $this->faker->year(),
            'is_featured' => false,
            'is_published' => true,
        ];
    }

    public function unpublished(): static
    {
        return $this->state(['is_published' => false]);
    }

    public function featured(): static
    {
        return $this->state(['is_featured' => true]);
    }
}
