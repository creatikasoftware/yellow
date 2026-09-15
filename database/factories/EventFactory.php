<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'summary' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'highlights' => [fake()->sentence(), fake()->sentence()],
            'starts_at' => fake()->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
            'start_time' => '09:00 AM',
            'end_time' => '05:00 PM',
            'location' => fake()->city().', India',
            'format' => 'Conference & Awards',
            'expected_attendees' => '200+ Attendees',
            'image' => null,
            'brochure_path' => null,
            'registration_open' => true,
            'is_featured' => false,
            'status' => 'published',
        ];
    }

    public function draft(): static
    {
        return $this->state(fn () => ['status' => 'draft']);
    }

    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }
}
