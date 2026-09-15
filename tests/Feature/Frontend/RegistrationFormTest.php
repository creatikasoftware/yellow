<?php

namespace Tests\Feature\Frontend;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_loads_successfully(): void
    {
        $response = $this->get(route('registration'));

        $response->assertOk();
    }

    public function test_submitting_a_valid_registration_persists_it(): void
    {
        $event = Event::factory()->create(['title' => 'Target Event']);

        $response = $this->post(route('registration.store'), [
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'john@example.com',
            'phone' => '9998887777',
            'organization' => 'Acme Corp',
            'registration_type' => 'Delegate',
            'event_slug' => $event->slug,
            'agreed_terms' => '1',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('registrations', [
            'first_name' => 'John',
            'email' => 'john@example.com',
            'event_id' => $event->id,
            'status' => 'pending',
            'agreed_terms' => true,
        ]);
    }

    public function test_registration_without_an_event_is_general(): void
    {
        $this->post(route('registration.store'), [
            'first_name' => 'Jane',
            'email' => 'jane2@example.com',
            'phone' => '1112223333',
        ]);

        $this->assertDatabaseHas('registrations', [
            'first_name' => 'Jane',
            'event_id' => null,
        ]);
    }

    public function test_first_name_email_and_phone_are_required(): void
    {
        $response = $this->post(route('registration.store'), []);

        $response->assertSessionHasErrors(['first_name', 'email', 'phone']);
        $this->assertDatabaseCount('registrations', 0);
    }

    public function test_unknown_event_slug_is_rejected(): void
    {
        $response = $this->post(route('registration.store'), [
            'first_name' => 'John',
            'email' => 'john3@example.com',
            'phone' => '9998887777',
            'event_slug' => 'does-not-exist',
        ]);

        $response->assertSessionHasErrors(['event_slug']);
    }

    public function test_featured_event_registrations_are_tagged_as_homepage_widget_source(): void
    {
        $event = Event::factory()->featured()->create();

        $this->post(route('registration.store'), [
            'first_name' => 'Alex',
            'email' => 'alex@example.com',
            'phone' => '5556667777',
            'event_slug' => $event->slug,
        ]);

        $this->assertDatabaseHas('registrations', [
            'email' => 'alex@example.com',
            'source' => 'homepage_widget',
        ]);
    }
}
