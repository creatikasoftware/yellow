<?php

namespace Tests\Feature\Admin;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        Storage::fake('public');
    }

    public function test_admin_can_view_events_index(): void
    {
        Event::factory()->create(['title' => 'Listed Event']);

        $response = $this->actingAs($this->admin)->get(route('admin.events.index'));

        $response->assertOk();
        $response->assertSee('Listed Event');
    }

    public function test_admin_can_create_an_event_with_image_and_agenda(): void
    {
        $image = UploadedFile::fake()->create('event.jpg', 10, 'image/jpeg');

        $response = $this->actingAs($this->admin)->post(route('admin.events.store'), [
            'title' => 'Brand New Event',
            'slug' => '',
            'summary' => 'A summary',
            'description' => 'A description',
            'highlights' => "Point one\nPoint two",
            'starts_at' => now()->addMonth()->format('Y-m-d'),
            'location' => 'Test City',
            'status' => 'published',
            'registration_open' => '1',
            'is_featured' => '0',
            'image' => $image,
            'agenda_time' => ['10:00 AM', '11:00 AM'],
            'agenda_title' => ['Opening', 'Panel'],
            'agenda_description' => ['', ''],
        ]);

        $response->assertRedirect(route('admin.events.index'));

        $event = Event::where('title', 'Brand New Event')->firstOrFail();
        $this->assertSame('brand-new-event', $event->slug);
        $this->assertSame(['Point one', 'Point two'], $event->highlights);
        $this->assertCount(2, $event->agendaItems);
        Storage::disk('public')->assertExists($event->image);
    }

    public function test_slug_is_auto_generated_when_left_blank_even_if_the_field_is_omitted_entirely(): void
    {
        // Regression test: previously crashed with "Undefined array key slug"
        // when the slug field was not present in the request at all.
        $response = $this->actingAs($this->admin)->post(route('admin.events.store'), [
            'title' => 'No Slug Field Event',
            'starts_at' => now()->addMonth()->format('Y-m-d'),
            'status' => 'published',
        ]);

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseHas('events', ['slug' => 'no-slug-field-event']);
    }

    public function test_creating_an_event_requires_title_and_start_date(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.events.store'), []);

        $response->assertSessionHasErrors(['title', 'starts_at', 'status']);
        $this->assertDatabaseCount('events', 0);
    }

    public function test_admin_can_update_an_event_and_agenda_is_fully_replaced(): void
    {
        $event = Event::factory()->create(['title' => 'Original Title']);
        $event->agendaItems()->create(['time' => '09:00 AM', 'title' => 'Old Session', 'sort_order' => 1]);

        $response = $this->actingAs($this->admin)->put(route('admin.events.update', $event), [
            'title' => 'Updated Title',
            'starts_at' => $event->starts_at->format('Y-m-d'),
            'status' => 'published',
            'agenda_time' => ['02:00 PM'],
            'agenda_title' => ['New Session'],
            'agenda_description' => [''],
        ]);

        $response->assertRedirect(route('admin.events.index'));

        $event->refresh();
        $this->assertSame('Updated Title', $event->title);
        $this->assertCount(1, $event->agendaItems);
        $this->assertSame('New Session', $event->agendaItems->first()->title);
    }

    public function test_updating_an_event_with_a_new_image_deletes_the_old_one(): void
    {
        $event = Event::factory()->create(['image' => 'events/old.jpg']);
        Storage::disk('public')->put('events/old.jpg', 'fake-content');

        $newImage = UploadedFile::fake()->create('new.jpg', 10, 'image/jpeg');

        $this->actingAs($this->admin)->put(route('admin.events.update', $event), [
            'title' => $event->title,
            'starts_at' => $event->starts_at->format('Y-m-d'),
            'status' => 'published',
            'image' => $newImage,
        ]);

        Storage::disk('public')->assertMissing('events/old.jpg');
        $event->refresh();
        Storage::disk('public')->assertExists($event->image);
    }

    public function test_admin_can_delete_an_event_and_its_image_and_agenda_items(): void
    {
        $event = Event::factory()->create(['image' => 'events/to-delete.jpg']);
        Storage::disk('public')->put('events/to-delete.jpg', 'fake-content');
        $event->agendaItems()->create(['time' => '09:00 AM', 'title' => 'Session', 'sort_order' => 1]);

        $response = $this->actingAs($this->admin)->delete(route('admin.events.destroy', $event));

        $response->assertRedirect(route('admin.events.index'));
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
        $this->assertDatabaseMissing('event_agenda_items', ['event_id' => $event->id]);
        Storage::disk('public')->assertMissing('events/to-delete.jpg');
    }

    public function test_non_admin_cannot_manage_events(): void
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $this->actingAs($user)->get(route('admin.events.index'))->assertForbidden();
        $this->actingAs($user)->post(route('admin.events.store'), [])->assertForbidden();
        $this->actingAs($user)->delete(route('admin.events.destroy', $event))->assertForbidden();
        $this->assertDatabaseHas('events', ['id' => $event->id]);
    }
}
