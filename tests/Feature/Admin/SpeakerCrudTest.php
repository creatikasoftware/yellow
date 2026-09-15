<?php

namespace Tests\Feature\Admin;

use App\Models\Speaker;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpeakerCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_create_a_speaker_with_multiline_expertise(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.speakers.store'), [
            'name' => 'Nina Rao',
            'role' => 'Educationist',
            'expertise' => "Curriculum Design\nPublic Speaking",
        ]);

        $response->assertRedirect(route('admin.speakers.index'));

        $speaker = Speaker::where('name', 'Nina Rao')->firstOrFail();
        $this->assertSame(['Curriculum Design', 'Public Speaking'], $speaker->expertise);
        $this->assertSame('nina-rao', $speaker->slug);
    }

    public function test_expertise_is_null_when_left_blank(): void
    {
        $this->actingAs($this->admin)->post(route('admin.speakers.store'), [
            'name' => 'No Expertise Speaker',
        ]);

        $speaker = Speaker::where('name', 'No Expertise Speaker')->firstOrFail();
        $this->assertNull($speaker->expertise);
    }

    public function test_name_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.speakers.store'), []);

        $response->assertSessionHasErrors('name');
    }

    public function test_admin_can_delete_a_speaker(): void
    {
        $speaker = Speaker::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.speakers.destroy', $speaker));

        $response->assertRedirect(route('admin.speakers.index'));
        $this->assertDatabaseMissing('speakers', ['id' => $speaker->id]);
    }
}
