<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $award2026 = Event::create([
            'title' => "Yellow Achiever's Award 2026",
            'slug' => 'yellow-achievers-award-2026',
            'summary' => 'An inspiring gathering of leaders, achievers and industry voices.',
            'description' => "The Yellow Achiever's Award brings together exceptional individuals and organizations for an evening of recognition, conversations and meaningful connections.",
            'highlights' => [
                'Opening keynote and leadership conversation',
                'Award ceremony across multiple categories',
                'Industry networking and curated interactions',
                'Media and partner engagement',
            ],
            'starts_at' => now()->addWeeks(4)->toDateString(),
            'location' => 'New Delhi, India',
            'format' => 'Conference & Awards',
            'registration_open' => true,
            'is_featured' => false,
            'status' => 'published',
        ]);

        $award2026->agendaItems()->createMany([
            ['time' => '05:00 PM', 'title' => 'Guest Arrival & Networking', 'description' => 'Registration and welcome networking.', 'sort_order' => 1],
            ['time' => '06:00 PM', 'title' => 'Leadership Keynote', 'description' => 'Insights from a leading industry voice.', 'sort_order' => 2],
            ['time' => '07:00 PM', 'title' => 'Award Ceremony', 'description' => 'Celebrating outstanding achievers.', 'sort_order' => 3],
            ['time' => '08:30 PM', 'title' => 'Networking Dinner', 'description' => null, 'sort_order' => 4],
        ]);

        // Featured on the homepage "Reserve Your Seat" widget — reconciles the richer
        // spotlight copy from index.html with the "Leadership Summit 2026" listing
        // that appears in events/index.html.
        Event::create([
            'title' => "Yellow Achiever's Leadership Summit 2026",
            'slug' => 'leadership-summit-2026',
            'summary' => 'An inspiring gathering of leaders, achievers and industry voices.',
            'starts_at' => now()->addWeeks(22)->toDateString(),
            'start_time' => '09:00 AM',
            'end_time' => '06:00 PM IST',
            'location' => 'Mumbai, Maharashtra',
            'expected_attendees' => '500+ Expected Attendees',
            'registration_open' => true,
            'is_featured' => true,
            'status' => 'published',
        ]);

        Event::create([
            'title' => 'Business Excellence Forum 2026',
            'slug' => 'business-excellence-forum-2026',
            'summary' => 'An inspiring gathering of leaders, achievers and industry voices.',
            'starts_at' => now()->addWeeks(10)->toDateString(),
            'location' => 'Bengaluru, India',
            'registration_open' => true,
            'status' => 'published',
        ]);

        Event::create([
            'title' => 'Women Leadership Forum 2026',
            'slug' => 'women-leadership-forum-2026',
            'summary' => 'An inspiring gathering of leaders, achievers and industry voices.',
            'starts_at' => now()->addWeeks(14)->toDateString(),
            'location' => 'Pune, India',
            'registration_open' => true,
            'status' => 'published',
        ]);

        Event::create([
            'title' => 'Young Achievers Summit 2026',
            'slug' => 'young-achievers-summit-2026',
            'summary' => 'An inspiring gathering of leaders, achievers and industry voices.',
            'starts_at' => now()->addWeeks(18)->toDateString(),
            'location' => 'Hyderabad, India',
            'registration_open' => true,
            'status' => 'published',
        ]);

        Event::create([
            'title' => 'Innovation & Impact Awards',
            'slug' => 'innovation-impact-awards',
            'summary' => 'An inspiring gathering of leaders, achievers and industry voices.',
            'starts_at' => now()->addWeeks(23)->toDateString(),
            'location' => 'Chennai, India',
            'registration_open' => true,
            'status' => 'published',
        ]);
    }
}
