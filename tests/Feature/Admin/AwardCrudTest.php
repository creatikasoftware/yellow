<?php

namespace Tests\Feature\Admin;

use App\Models\Award;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AwardCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_create_an_award_category(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.awards.store'), [
            'name' => 'Sustainability Leadership',
            'icon' => 'bi-globe',
            'short_description' => 'Recognizing eco-conscious leadership.',
        ]);

        $response->assertRedirect(route('admin.awards.index'));
        $this->assertDatabaseHas('awards', [
            'name' => 'Sustainability Leadership',
            'slug' => 'sustainability-leadership',
        ]);
    }

    public function test_name_and_icon_are_required(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.awards.store'), []);

        $response->assertSessionHasErrors(['name', 'icon']);
    }

    public function test_admin_can_update_an_award_category_without_changing_the_slug(): void
    {
        $award = Award::factory()->create(['name' => 'Original', 'slug' => 'original']);

        $this->actingAs($this->admin)->put(route('admin.awards.update', $award), [
            'name' => 'Original',
            'slug' => 'original',
            'icon' => 'bi-star',
            'short_description' => 'Updated description',
        ]);

        $award->refresh();
        $this->assertSame('original', $award->slug);
        $this->assertSame('Updated description', $award->short_description);
    }

    public function test_admin_can_delete_an_award_category(): void
    {
        $award = Award::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.awards.destroy', $award));

        $response->assertRedirect(route('admin.awards.index'));
        $this->assertDatabaseMissing('awards', ['id' => $award->id]);
    }
}
