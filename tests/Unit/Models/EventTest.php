<?php

namespace Tests\Unit\Models;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_scope_excludes_drafts(): void
    {
        Event::factory()->create(['status' => 'published']);
        Event::factory()->draft()->create();

        $this->assertSame(1, Event::published()->count());
    }

    public function test_upcoming_scope_excludes_past_events(): void
    {
        $later = Event::factory()->create(['starts_at' => now()->addMonth()]);
        $sooner = Event::factory()->create(['starts_at' => now()->addWeek()]);
        Event::factory()->create(['starts_at' => now()->subWeek()]);

        $upcoming = Event::upcoming()->get();

        $this->assertCount(2, $upcoming);
        $this->assertTrue($upcoming->contains($later));
        $this->assertTrue($upcoming->contains($sooner));
    }

    public function test_upcoming_scope_does_not_impose_an_order(): void
    {
        // Deliberately no built-in ordering — different callers want
        // different priorities (soonest-first vs featured-first), so the
        // scope only filters; callers chain their own orderBy().
        $later = Event::factory()->create(['starts_at' => now()->addMonth()]);
        $sooner = Event::factory()->create(['starts_at' => now()->addWeek()]);

        $upcoming = Event::upcoming()->orderBy('starts_at')->get();

        $this->assertTrue($upcoming->first()->is($sooner));
        $this->assertTrue($upcoming->last()->is($later));
    }

    public function test_highlights_are_cast_to_an_array(): void
    {
        $event = Event::factory()->create(['highlights' => ['One', 'Two']]);

        $this->assertIsArray($event->fresh()->highlights);
        $this->assertSame(['One', 'Two'], $event->fresh()->highlights);
    }

    public function test_route_key_name_is_slug(): void
    {
        $event = Event::factory()->create();

        $this->assertSame('slug', $event->getRouteKeyName());
    }
}
