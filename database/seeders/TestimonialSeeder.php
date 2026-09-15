<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Testimonial::create([
            'name' => 'Arjun Mehta',
            'role_company' => 'CEO, FinEdge Capital',
            'quote' => 'The entire experience was exceptional. From the quality of the audience to the professionalism of the team, every detail was thoughtfully executed.',
            'avatar_initials' => 'AM',
            'rating' => 5,
            'is_featured' => true,
            'sort_order' => 1,
        ]);

        $small = [
            [
                'name' => 'Priya Nair',
                'role_company' => 'Founder, GreenPath Solutions',
                'quote' => 'Receiving the award was a career-defining moment. The ceremony was beautifully organised and truly memorable.',
                'avatar_initials' => 'PN',
            ],
            [
                'name' => 'Vikram Singh',
                'role_company' => 'CMO, TechBridge India',
                'quote' => 'Professional team, premium audience and flawless execution. We would definitely recommend the experience.',
                'avatar_initials' => 'VS',
            ],
            [
                'name' => 'Rahul Kapoor',
                'role_company' => 'Director, Nova Ventures',
                'quote' => 'A powerful platform to connect with decision-makers and showcase meaningful achievements.',
                'avatar_initials' => 'RK',
            ],
        ];

        foreach ($small as $index => $testimonial) {
            Testimonial::create([
                ...$testimonial,
                'rating' => 5,
                'is_featured' => false,
                'sort_order' => $index + 2,
            ]);
        }
    }
}
