<?php

namespace Tests\Feature\Frontend;

use App\Models\Award;
use App\Models\Event;
use App\Models\GalleryItem;
use App\Models\Partner;
use App\Models\Speaker;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewIs('frontend.home');
    }

    public function test_home_page_renders_with_no_content_at_all(): void
    {
        // The homepage must not blow up when every table is empty —
        // this guards against null-access errors like the one we hit
        // with $featuredEvent during manual testing.
        $response = $this->get(route('home'));

        $response->assertOk();
    }

    public function test_home_page_shows_upcoming_published_events_only(): void
    {
        $shown = Event::factory()->create(['title' => 'Visible Upcoming Event', 'starts_at' => now()->addMonth()]);
        Event::factory()->draft()->create(['title' => 'Hidden Draft Event', 'starts_at' => now()->addMonth()]);
        Event::factory()->create(['title' => 'Hidden Past Event', 'starts_at' => now()->subMonth()]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Visible Upcoming Event');
        $response->assertDontSee('Hidden Draft Event');
        $response->assertDontSee('Hidden Past Event');
    }

    public function test_home_page_events_section_prioritizes_featured_events_over_merely_soonest_ones(): void
    {
        // Regression test: the "Feature on homepage" checkbox promises a
        // spot in this section, but the query used to only take the 3
        // chronologically-soonest events with no regard for the flag —
        // a featured event further out could be squeezed out entirely.
        Event::factory()->create(['title' => 'Soonest Unfeatured A', 'starts_at' => now()->addDays(1)]);
        Event::factory()->create(['title' => 'Soonest Unfeatured B', 'starts_at' => now()->addDays(2)]);
        Event::factory()->create(['title' => 'Soonest Unfeatured C', 'starts_at' => now()->addDays(3)]);
        Event::factory()->featured()->create(['title' => 'Featured But Further Out', 'starts_at' => now()->addDays(30)]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Featured But Further Out');
        $response->assertViewHas('events', fn ($events) => $events->count() === 3
            && $events->contains('title', 'Featured But Further Out'));
    }

    public function test_home_page_shows_featured_event_registration_widget(): void
    {
        $featured = Event::factory()->featured()->create(['title' => 'The Featured Summit']);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('The Featured Summit', false);
        $response->assertSee('Reserve Your Seat');
    }

    public function test_home_page_shows_featured_testimonial_and_small_testimonials(): void
    {
        Testimonial::factory()->featured()->create(['name' => 'Featured Person']);
        Testimonial::factory()->create(['name' => 'Small Testimonial Person']);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Featured Person');
        $response->assertSee('Small Testimonial Person');
    }

    public function test_home_page_gallery_shows_uploaded_images_with_the_featured_one_large(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('gallery/featured.jpg', 'fake');
        GalleryItem::factory()->create(['sort_order' => 1, 'image' => null]);
        $featured = GalleryItem::factory()->create(['sort_order' => 9, 'image' => 'gallery/featured.jpg', 'is_featured' => true]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('gallery/featured.jpg', false);
        $response->assertViewHas('featuredGalleryItem', fn ($item) => $item->is($featured));
    }

    public function test_home_page_shows_awards_speakers_gallery_and_partners(): void
    {
        Award::factory()->create(['name' => 'Sample Award Category']);
        Speaker::factory()->create(['name' => 'Sample Speaker']);
        GalleryItem::factory()->create();
        Partner::factory()->create(['name' => 'Sample Partner Co']);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Sample Award Category');
        $response->assertSee('Sample Speaker');
        $response->assertSee('Sample Partner Co');
    }
}
