<?php

namespace Database\Seeders;

use App\Models\Speaker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SpeakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $speakers = [
            ['name' => 'Rajiv Malhotra', 'role' => 'Business Leader'],
            ['name' => 'Priya Sharma', 'role' => 'Entrepreneur'],
            ['name' => 'Amit Verma', 'role' => 'Innovation Expert'],
            ['name' => 'Neha Kapoor', 'role' => 'Social Activist'],
            ['name' => 'Arjun Mehta', 'role' => 'Technology Leader'],
            ['name' => 'Kavya Rao', 'role' => 'Educationist'],
            ['name' => 'Rohan Gupta', 'role' => 'Investor'],
            ['name' => 'Ananya Singh', 'role' => 'Founder & CEO'],
        ];

        foreach ($speakers as $index => $speaker) {
            $isRajiv = $speaker['name'] === 'Rajiv Malhotra';

            Speaker::create([
                'name' => $speaker['name'],
                'slug' => Str::slug($speaker['name']),
                'role' => $speaker['role'],
                'tagline' => $isRajiv ? 'Business Leader · Keynote Speaker · Mentor' : null,
                'bio' => $isRajiv
                    ? 'Rajiv Malhotra is presented as a business leader and keynote speaker focused on leadership, growth and organizational transformation.'
                    : null,
                'expertise' => $isRajiv ? ['Leadership', 'Strategy', 'Innovation'] : null,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
