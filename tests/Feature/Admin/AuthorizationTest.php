<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_non_admin_receives_403(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_authenticated_admin_can_access_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
    }

    public function test_admin_access_is_revoked_immediately_when_flag_is_removed_mid_session(): void
    {
        $admin = User::factory()->admin()->create();
        $this->actingAs($admin);

        $this->get(route('admin.dashboard'))->assertOk();

        $admin->update(['is_admin' => false]);

        $this->get(route('admin.dashboard'))->assertForbidden();
    }

    /**
     * @dataProvider adminRouteProvider
     */
    public function test_every_admin_resource_index_is_protected(string $routeName): void
    {
        $response = $this->get(route($routeName));

        $response->assertRedirect(route('login'));
    }

    public static function adminRouteProvider(): array
    {
        return [
            ['admin.events.index'],
            ['admin.awards.index'],
            ['admin.speakers.index'],
            ['admin.gallery.index'],
            ['admin.news.index'],
            ['admin.partners.index'],
            ['admin.testimonials.index'],
            ['admin.registrations.index'],
            ['admin.contact-messages.index'],
        ];
    }
}
