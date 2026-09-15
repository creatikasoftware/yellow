<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role_company' => fake()->jobTitle().', '.fake()->company(),
            'quote' => fake()->paragraph(),
            'avatar_initials' => fake()->lexify('??'),
            'photo' => null,
            'rating' => 5,
            'is_featured' => false,
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }
}
