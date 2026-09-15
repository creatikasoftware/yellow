<?php

namespace Database\Seeders;

use App\Models\GalleryItem;
use Illuminate\Database\Seeder;

class GalleryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * The source design shows 11 gallery tiles (1 large + 4 small in the first
     * grid, 6 more below) with no captions or real photos — all placeholders.
     */
    public function run(): void
    {
        GalleryItem::create([
            'is_featured' => true,
            'sort_order' => 1,
        ]);

        for ($i = 2; $i <= 11; $i++) {
            GalleryItem::create([
                'is_featured' => false,
                'sort_order' => $i,
            ]);
        }
    }
}
