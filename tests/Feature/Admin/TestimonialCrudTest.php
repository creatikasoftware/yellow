<?php

namespace Tests\Feature\Admin;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TestimonialCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_create_a_testimonial(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.testimonials.store'), [
            'name' => 'Happy Client',
            'quote' => 'Wonderful experience.',
            'rating' => 5,
        ]);

        $response->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseHas('testimonials', ['name' => 'Happy Client']);
    }

    public function test_name_quote_and_rating_are_required(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.testimonials.store'), []);

        $response->assertSessionHasErrors(['name', 'quote', 'rating']);
    }

    public function test_marking_a_testimonial_as_featured_unfeatures_all_others(): void
    {
        $currentlyFeatured = Testimonial::factory()->featured()->create();
        $other = Testimonial::factory()->create();

        $this->actingAs($this->admin)->put(route('admin.testimonials.update', $other), [
            'name' => $other->name,
            'quote' => $other->quote,
            'rating' => 5,
            'is_featured' => '1',
        ]);

        $this->assertTrue($other->fresh()->is_featured);
        $this->assertFalse($currentlyFeatured->fresh()->is_featured);
    }

    public function test_admin_can_delete_a_testimonial(): void
    {
        $testimonial = Testimonial::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.testimonials.destroy', $testimonial));

        $response->assertRedirect(route('admin.testimonials.index'));
        $this->assertDatabaseMissing('testimonials', ['id' => $testimonial->id]);
    }
}
