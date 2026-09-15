<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('##########'),
            'subject' => 'General Enquiry',
            'message' => fake()->paragraph(),
            'status' => 'unread',
        ];
    }
}
