<?php

namespace Tests\Feature\Admin;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_view_registrations_index(): void
    {
        Registration::factory()->create(['first_name' => 'Pending Person']);

        $response = $this->actingAs($this->admin)->get(route('admin.registrations.index'));

        $response->assertOk();
        $response->assertSee('Pending Person');
    }

    public function test_index_can_be_filtered_by_status(): void
    {
        Registration::factory()->create(['first_name' => 'Confirmed Person', 'status' => 'confirmed']);
        Registration::factory()->create(['first_name' => 'Pending Person', 'status' => 'pending']);

        $response = $this->actingAs($this->admin)->get(route('admin.registrations.index', ['status' => 'confirmed']));

        $response->assertOk();
        $response->assertSee('Confirmed Person');
        $response->assertDontSee('Pending Person');
    }

    public function test_admin_can_view_a_single_registration(): void
    {
        $registration = Registration::factory()->create(['first_name' => 'Detail Person']);

        $response = $this->actingAs($this->admin)->get(route('admin.registrations.show', $registration));

        $response->assertOk();
        $response->assertSee('Detail Person');
    }

    public function test_admin_can_update_registration_status(): void
    {
        $registration = Registration::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin)->put(route('admin.registrations.update', $registration), [
            'status' => 'confirmed',
        ]);

        $response->assertRedirect();
        $this->assertSame('confirmed', $registration->fresh()->status);
    }

    public function test_status_must_be_a_valid_value(): void
    {
        $registration = Registration::factory()->create();

        $response = $this->actingAs($this->admin)->put(route('admin.registrations.update', $registration), [
            'status' => 'not-a-real-status',
        ]);

        $response->assertSessionHasErrors('status');
    }

    public function test_admin_can_delete_a_registration(): void
    {
        $registration = Registration::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.registrations.destroy', $registration));

        $response->assertRedirect(route('admin.registrations.index'));
        $this->assertDatabaseMissing('registrations', ['id' => $registration->id]);
    }

    public function test_non_admin_cannot_manage_registrations(): void
    {
        $user = User::factory()->create();
        $registration = Registration::factory()->create();

        $this->actingAs($user)->get(route('admin.registrations.index'))->assertForbidden();
        $this->actingAs($user)->put(route('admin.registrations.update', $registration), ['status' => 'confirmed'])->assertForbidden();
    }
}
