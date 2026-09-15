<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Award>
 */
class AwardFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'icon' => 'bi-trophy',
            'short_description' => fake()->sentence(),
            'long_description' => fake()->paragraph(),
            'image' => null,
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
