<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\NewsArticle>
 */
class NewsArticleFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->sentence(),
            'body' => fake()->paragraphs(3, true),
            'image' => null,
            'published_at' => fake()->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
        ];
    }
}
