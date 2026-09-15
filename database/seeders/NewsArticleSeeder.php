<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => "Nominations Open for Yellow Achiever's Award 2026",
                'published_at' => '2026-01-10',
                'body' => "Nominations are now open for the 2026 edition of the Yellow Achiever's Award. The program aims to bring visibility to individuals and organizations creating meaningful impact across industries.\n\nEligible nominees can submit their details through the registration and nomination process. Selected finalists will be invited to the award ceremony and related networking experiences.",
            ],
            ['title' => 'Leadership Summit Announced', 'published_at' => '2026-01-05'],
            ['title' => 'Celebrating the Winners', 'published_at' => '2025-12-28'],
            ['title' => 'Meet Our New Industry Jury', 'published_at' => '2025-12-15'],
            ['title' => 'Applications Open Across Categories', 'published_at' => '2025-12-08'],
            ['title' => "Yellow Achiever's Award Returns in 2026", 'published_at' => '2025-12-01'],
        ];

        foreach ($articles as $article) {
            NewsArticle::create([
                'title' => $article['title'],
                'slug' => Str::slug($article['title']),
                'excerpt' => 'Read the latest update and discover what is happening across our community.',
                'body' => $article['body'] ?? null,
                'published_at' => $article['published_at'],
            ]);
        }
    }
}
