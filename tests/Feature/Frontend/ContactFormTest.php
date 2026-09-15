<?php

namespace Tests\Feature\Frontend;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_page_loads_successfully(): void
    {
        $response = $this->get(route('contact'));

        $response->assertOk();
    }

    public function test_submitting_a_valid_enquiry_persists_it_and_flashes_success(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '9998887777',
            'subject' => 'Sponsorship',
            'message' => 'I would like to sponsor an event.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'subject' => 'Sponsorship',
            'status' => 'unread',
        ]);
    }

    public function test_name_email_and_message_are_required(): void
    {
        $response = $this->post(route('contact.store'), []);

        $response->assertSessionHasErrors(['name', 'email', 'message']);
        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_email_must_be_a_valid_email_address(): void
    {
        $response = $this->post(route('contact.store'), [
            'name' => 'Jane Doe',
            'email' => 'not-an-email',
            'message' => 'Hello there.',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_old_input_is_repopulated_after_validation_failure(): void
    {
        $response = $this->from(route('contact'))->post(route('contact.store'), [
            'name' => 'Jane Doe',
            'email' => 'not-an-email',
            'message' => 'Hello there.',
        ]);

        $response->assertRedirect(route('contact'));
        $followUp = $this->get(route('contact'));
        $followUp->assertSee('Jane Doe');
    }
}
