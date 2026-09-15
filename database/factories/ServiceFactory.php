<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->words(3, true);

        return [
            'title' => ucwords($title),
            'slug' => Str::slug($title),
            'short_description' => fake()->sentence(),
            'description' => fake()->paragraphs(2, true),
            'featured_image' => null,
            'icon' => 'bi-gear',
            'sort_order' => fake()->numberBetween(1, 50),
            'featured' => false,
            'status' => true,
            'meta_title' => null,
            'meta_description' => null,
            'meta_keywords' => null,
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status' => false]);
    }

    public function featured(): static
    {
        return $this->state(fn () => ['featured' => true]);
    }
}
