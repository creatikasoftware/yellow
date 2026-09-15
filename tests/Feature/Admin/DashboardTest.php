<?php

namespace Tests\Feature\Admin;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_shows_accurate_counts(): void
    {
        $admin = User::factory()->admin()->create();
        Event::factory()->count(3)->create();
        Registration::factory()->count(2)->create(['status' => 'pending']);
        Registration::factory()->create(['status' => 'confirmed']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewHas('stats', function ($stats) {
            return $stats['events'] === 3
                && $stats['registrations'] === 3
                && $stats['pending_registrations'] === 2;
        });
    }
}
