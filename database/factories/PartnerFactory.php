<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'logo' => null,
            'website_url' => fake()->url(),
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
