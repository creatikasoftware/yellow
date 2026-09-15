<?php

namespace Database\Seeders;

use App\Models\Award;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AwardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Business Excellence', 'icon' => 'bi-bar-chart-line'],
            ['name' => 'Education Leadership', 'icon' => 'bi-mortarboard'],
            ['name' => 'Healthcare Innovation', 'icon' => 'bi-heart-pulse'],
            ['name' => 'Women Empowerment', 'icon' => 'bi-award'],
            ['name' => 'Social Impact', 'icon' => 'bi-people'],
            ['name' => 'Young Achievers', 'icon' => 'bi-person-hearts'],
            ['name' => 'Technology Innovation', 'icon' => 'bi-cpu'],
            ['name' => 'Sustainability Leadership', 'icon' => 'bi-globe'],
        ];

        foreach ($categories as $index => $category) {
            Award::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'short_description' => 'Recognizing outstanding contribution and measurable impact.',
                'long_description' => $category['name'] === 'Business Excellence'
                    ? 'This category celebrates organizations and individuals demonstrating strong leadership, innovation, customer value and sustainable growth.'
                    : null,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
