<?php

namespace App\Support;

use App\Models\Setting;

/**
 * Admin-editable copy for the Home, About and Contact pages.
 *
 * Each field is stored as a Setting row keyed "{page}.{field}" (e.g.
 * "home.hero_eyebrow"). defaults() is the single source of truth for both
 * the fallback values (so the site renders sensibly even before the CMS
 * seeder has run) and the admin edit form's field list — add a field here
 * and it automatically appears in the admin form and is readable via get().
 *
 * Array-valued fields (repeatable lists) are JSON-encoded in the database
 * and transparently decoded back into arrays by get().
 */
class PageContent
{
    public static function defaults(): array
    {
        return [
            'home' => [
                'hero_eyebrow' => 'Honouring Visionaries',
                'hero_title_line1' => 'Recognizing',
                'hero_title_highlight' => 'Real',
                'hero_title_line2' => 'Achievers',
                'hero_subtitle' => 'A platform to celebrate exceptional talent, inspiring individuals and organizations that create meaningful impact across industries.',
                'hero_cta_primary' => 'Register Now',
                'hero_cta_secondary' => 'Explore Events',
                'about_kicker' => "About Yellow Achiever's Award",
                'about_title' => 'Celebrating Excellence Across Industries',
                'about_body' => "Yellow Achiever's Award is a platform that recognises outstanding achievers, leaders and organisations making a meaningful impact.",
                'about_cta_text' => 'Read More',
                'info_box_items' => ['Recognize Excellence', 'Inspire Talent', 'Build Opportunities', 'Create Impact'],
                'events_kicker' => 'Our Events',
                'events_title' => 'Upcoming Events',
                'awards_kicker' => 'Award Categories',
                'awards_title' => 'Recognizing Achievers in Every Field',
                'speakers_kicker' => 'Our Speakers',
                'speakers_title' => 'Inspiring Leaders',
                'gallery_kicker' => 'Event Gallery',
                'gallery_title' => 'Moments That Inspire',
                'registration_eyebrow' => 'REGISTER NOW',
                'registration_title_line1' => 'Be Part of Our Next',
                'registration_title_highlight' => 'Signature Event',
                'registration_subtitle' => 'Join industry leaders, innovators and changemakers for an unforgettable experience.',
                'testimonials_eyebrow' => 'CLIENT EXPERIENCES',
                'testimonials_title_line1' => 'Trusted by Leaders.',
                'testimonials_title_highlight' => 'Proven by Experience.',
                'testimonials_subtitle' => "Discover what business leaders, speakers and partners say about their experience with Yellow Achiever's Award.",
                'partners_kicker' => 'Our Partners',
            ],
            'about' => [
                'hero_eyebrow' => 'About Us',
                'hero_title_line1' => 'Celebrating People',
                'hero_title_line2' => 'Who Create Impact',
                'hero_subtitle' => "Discover the vision behind Yellow Achiever's Award and our commitment to recognizing excellence.",
                'intro_kicker' => 'Who We Are',
                'intro_title' => 'A Platform Built Around Achievement',
                'intro_body_1' => 'We bring together achievers, business leaders, entrepreneurs, professionals and changemakers through awards, summits and networking experiences.',
                'intro_body_2' => 'Our objective is simple: create visibility for meaningful work, connect people with opportunities and celebrate stories worth sharing.',
                'stat_1_value' => '5000+',
                'stat_1_label' => 'Nominations',
                'stat_2_value' => '1000+',
                'stat_2_label' => 'Winners',
                'values_kicker' => 'Our Values',
                'values_title' => 'What We Stand For',
                'values' => [
                    ['icon' => 'bi-trophy', 'label' => 'Excellence', 'description' => 'Creating meaningful recognition and opportunities for people and organizations.'],
                    ['icon' => 'bi-lightbulb', 'label' => 'Innovation', 'description' => 'Creating meaningful recognition and opportunities for people and organizations.'],
                    ['icon' => 'bi-people', 'label' => 'Community', 'description' => 'Creating meaningful recognition and opportunities for people and organizations.'],
                    ['icon' => 'bi-heart', 'label' => 'Impact', 'description' => 'Creating meaningful recognition and opportunities for people and organizations.'],
                ],
                'cta_title' => 'Be Part of the Next Story',
                'cta_text' => 'Nominate an achiever or register for an upcoming event.',
                'cta_button_text' => 'Register Now',
            ],
            'contact' => [
                'hero_eyebrow' => 'Contact Us',
                'hero_title_line1' => "Let's Create",
                'hero_title_line2' => 'Something Meaningful',
                'hero_subtitle' => 'Talk to our team about events, partnerships, nominations, sponsorships or speaking opportunities.',
                'intro_kicker' => 'Get In Touch',
                'intro_title' => "We'd Love to Hear From You",
            ],
            // Site-wide values shown in the footer (and the contact page's
            // info box) on every page, not just one — kept in their own
            // "site" namespace rather than under "contact" for that reason.
            'site' => [
                'contact_address' => '123, Business Avenue, New Delhi, India - 110001',
                'contact_phone' => '+91 98765 43210',
                'contact_email' => 'info@yellowaward.in',
                'footer_copy' => 'Celebrating achievers, creating opportunities and building a brighter, more inclusive future.',
                'social_facebook' => '#',
                'social_twitter' => '#',
                'social_linkedin' => '#',
                'social_instagram' => '#',
                'social_youtube' => '#',
            ],
        ];
    }

    /**
     * Get all editable fields for a page, merging stored overrides on top
     * of the defaults above.
     */
    public static function get(string $page): array
    {
        $result = [];

        foreach (static::defaults()[$page] ?? [] as $key => $default) {
            $raw = Setting::get("{$page}.{$key}");

            if ($raw === null) {
                $result[$key] = $default;

                continue;
            }

            $result[$key] = is_array($default) ? (json_decode($raw, true) ?? $default) : $raw;
        }

        return $result;
    }

    /**
     * Save a page's editable fields. Only keys that are actually declared
     * in defaults() for this page are persisted.
     */
    public static function set(string $page, array $data): void
    {
        foreach (static::defaults()[$page] ?? [] as $key => $default) {
            if (! array_key_exists($key, $data)) {
                continue;
            }

            $value = $data[$key];
            Setting::set("{$page}.{$key}", is_array($value) ? json_encode(array_values($value)) : $value);
        }
    }
}
