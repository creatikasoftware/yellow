<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Registration>
 */
class RegistrationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'event_id' => null,
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('##########'),
            'organization' => fake()->company(),
            'industry' => 'Technology',
            'registration_type' => 'Delegate',
            'message' => fake()->sentence(),
            'agreed_terms' => true,
            'source' => 'registration_page',
            'status' => 'pending',
        ];
    }
}
