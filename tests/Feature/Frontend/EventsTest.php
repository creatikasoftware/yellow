<?php

namespace Tests\Feature\Frontend;

use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use RefreshDatabase;

    public function test_events_index_lists_published_events(): void
    {
        Event::factory()->create(['title' => 'Published Conference']);
        Event::factory()->draft()->create(['title' => 'Draft Conference']);

        $response = $this->get(route('events.index'));

        $response->assertOk();
        $response->assertSee('Published Conference');
        $response->assertDontSee('Draft Conference');
    }

    public function test_event_detail_page_shows_agenda_and_highlights(): void
    {
        $event = Event::factory()->create([
            'title' => 'Detailed Event',
            'highlights' => ['Highlight A', 'Highlight B'],
        ]);
        $event->agendaItems()->create([
            'time' => '10:00 AM',
            'title' => 'Opening Session',
            'sort_order' => 1,
        ]);

        $response = $this->get(route('events.show', $event));

        $response->assertOk();
        $response->assertSee('Detailed Event');
        $response->assertSee('Highlight A');
        $response->assertSee('Opening Session');
    }

    public function test_event_detail_page_hides_agenda_section_when_there_are_no_items(): void
    {
        $event = Event::factory()->create(['title' => 'Bare Event']);

        $response = $this->get(route('events.show', $event));

        $response->assertOk();
        $response->assertDontSee('Program at a Glance');
    }

    public function test_draft_event_detail_page_returns_404(): void
    {
        $event = Event::factory()->draft()->create();

        $response = $this->get(route('events.show', $event));

        $response->assertNotFound();
    }

    public function test_unknown_event_slug_returns_404(): void
    {
        $response = $this->get('/events/does-not-exist');

        $response->assertNotFound();
    }
}
