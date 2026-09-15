<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\EventAgendaItem>
 */
class EventAgendaItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'time' => '10:00 AM',
            'title' => fake()->sentence(3),
            'description' => fake()->sentence(),
            'sort_order' => 1,
        ];
    }
}
