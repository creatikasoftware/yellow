<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\GalleryItem>
 */
class GalleryItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'image' => null,
            'caption' => fake()->sentence(4),
            'event_id' => null,
            'is_featured' => false,
            'sort_order' => fake()->numberBetween(1, 20),
        ];
    }
}
