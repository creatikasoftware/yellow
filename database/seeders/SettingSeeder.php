<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Small, frequently-edited bits of copy that repeat across every page
     * (footer contact block, social links) or drive the homepage stat strips.
     * Larger page copy (hero headlines, about text) stays in Blade views since
     * it is structural to the design rather than day-to-day editable content.
     */
    public function run(): void
    {
        Setting::set('site.contact_address', '123, Business Avenue, New Delhi, India - 110001');
        Setting::set('site.contact_phone', '+91 98765 43210');
        Setting::set('site.contact_email', 'info@yellowaward.in');

        Setting::set('site.social_facebook', '#');
        Setting::set('site.social_twitter', '#');
        Setting::set('site.social_linkedin', '#');
        Setting::set('site.social_instagram', '#');
        Setting::set('site.social_youtube', '#');

        Setting::set('home.stats', json_encode([
            ['value' => '5000+', 'label' => 'Nominations'],
            ['value' => '1000+', 'label' => 'Award Winners'],
            ['value' => '50+', 'label' => 'Industry Categories'],
            ['value' => '10+', 'label' => 'Cities Across India'],
        ]));

        Setting::set('testimonials.trust_stats', json_encode([
            ['value' => '500+', 'label' => 'Brands & Organisations'],
            ['value' => '10K+', 'label' => 'Delegates & Leaders'],
            ['value' => '50+', 'label' => 'Industry Events'],
            ['value' => '4.9/5', 'label' => 'Average Experience Rating'],
        ]));
    }
}
