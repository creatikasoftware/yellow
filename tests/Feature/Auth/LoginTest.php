<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_loads_successfully(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
    }

    public function test_already_authenticated_admin_is_redirected_away_from_login_page(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('login'));

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_can_log_in_with_correct_credentials(): void
    {
        $admin = User::factory()->admin()->create(['password' => bcrypt('correct-password')]);

        $response = $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'correct-password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_login_fails_with_incorrect_password(): void
    {
        $admin = User::factory()->admin()->create(['password' => bcrypt('correct-password')]);

        $response = $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_fails_for_a_non_admin_user_and_logs_them_back_out(): void
    {
        $user = User::factory()->create(['password' => bcrypt('correct-password')]);

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'correct-password',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_admin_can_log_out(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
