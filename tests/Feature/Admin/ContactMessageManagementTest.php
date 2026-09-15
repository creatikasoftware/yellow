<?php

namespace Tests\Feature\Admin;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactMessageManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_view_messages_index(): void
    {
        ContactMessage::factory()->create(['name' => 'Curious Person']);

        $response = $this->actingAs($this->admin)->get(route('admin.contact-messages.index'));

        $response->assertOk();
        $response->assertSee('Curious Person');
    }

    public function test_viewing_a_message_marks_it_as_read(): void
    {
        $message = ContactMessage::factory()->create(['status' => 'unread']);

        $response = $this->actingAs($this->admin)->get(route('admin.contact-messages.show', $message));

        $response->assertOk();
        $this->assertSame('read', $message->fresh()->status);
    }

    public function test_viewing_an_already_read_message_does_not_change_its_status(): void
    {
        $message = ContactMessage::factory()->create(['status' => 'archived']);

        $this->actingAs($this->admin)->get(route('admin.contact-messages.show', $message));

        $this->assertSame('archived', $message->fresh()->status);
    }

    public function test_admin_can_delete_a_message(): void
    {
        $message = ContactMessage::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.contact-messages.destroy', $message));

        $response->assertRedirect(route('admin.contact-messages.index'));
        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_non_admin_cannot_manage_messages(): void
    {
        $user = User::factory()->create();
        $message = ContactMessage::factory()->create();

        $this->actingAs($user)->get(route('admin.contact-messages.index'))->assertForbidden();
        $this->actingAs($user)->delete(route('admin.contact-messages.destroy', $message))->assertForbidden();
    }
}
