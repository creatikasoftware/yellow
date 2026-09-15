<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingSeeder::class,
            EventSeeder::class,
            AwardSeeder::class,
            SpeakerSeeder::class,
            GalleryItemSeeder::class,
            NewsArticleSeeder::class,
            PartnerSeeder::class,
            TestimonialSeeder::class,
        ]);
    }
}
