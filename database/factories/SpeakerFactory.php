<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Speaker>
 */
class SpeakerFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->name();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'role' => fake()->jobTitle(),
            'tagline' => fake()->sentence(),
            'bio' => fake()->paragraph(),
            'expertise' => [fake()->word(), fake()->word()],
            'photo' => null,
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
