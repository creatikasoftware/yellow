<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = ['TATA', 'Infosys', 'Reliance', 'HCL', 'Wipro', 'Adani'];

        foreach ($partners as $index => $name) {
            Partner::create([
                'name' => $name,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
