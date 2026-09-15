<?php

namespace Tests\Feature\Admin;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ServiceCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        Storage::fake('public');
    }

    // ---- Index / search / filter / pagination ----

    public function test_admin_can_view_services_index(): void
    {
        Service::factory()->create(['title' => 'Listed Service']);

        $response = $this->actingAs($this->admin)->get(route('admin.services.index'));

        $response->assertOk();
        $response->assertSee('Listed Service');
    }

    public function test_admin_can_search_services_by_title(): void
    {
        Service::factory()->create(['title' => 'Corporate Event Management']);
        Service::factory()->create(['title' => 'Wedding Planning']);

        $response = $this->actingAs($this->admin)->get(route('admin.services.index', ['search' => 'Corporate']));

        $response->assertOk();
        $response->assertSee('Corporate Event Management');
        $response->assertDontSee('Wedding Planning');
    }

    public function test_admin_can_filter_services_by_status(): void
    {
        Service::factory()->create(['title' => 'Published One']);
        Service::factory()->draft()->create(['title' => 'Draft One']);

        $response = $this->actingAs($this->admin)->get(route('admin.services.index', ['status' => 'draft']));

        $response->assertOk();
        $response->assertSee('Draft One');
        $response->assertDontSee('Published One');
    }

    public function test_admin_can_filter_services_by_featured(): void
    {
        Service::factory()->featured()->create(['title' => 'Featured One']);
        Service::factory()->create(['title' => 'Regular One']);

        $response = $this->actingAs($this->admin)->get(route('admin.services.index', ['featured' => 'yes']));

        $response->assertOk();
        $response->assertSee('Featured One');
        $response->assertDontSee('Regular One');
    }

    public function test_services_index_paginates_at_fifteen_per_page(): void
    {
        Service::factory()->count(20)->create();

        $response = $this->actingAs($this->admin)->get(route('admin.services.index'));

        $response->assertOk();
        $response->assertViewHas('services', fn ($services) => $services->total() === 20 && $services->count() === 15);
    }

    // ---- Create ----

    public function test_admin_can_create_a_service_with_an_image(): void
    {
        $image = UploadedFile::fake()->create('service.jpg', 500, 'image/jpeg');

        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'title' => 'Corporate Event Management',
            'slug' => '',
            'short_description' => 'We manage corporate events end to end.',
            'description' => 'Full description of the service.',
            'featured_image' => $image,
            'icon' => 'bi-briefcase',
            'sort_order' => 3,
            'featured' => '1',
            'status' => '1',
            'meta_title' => 'Corporate Events | Yellow',
            'meta_description' => 'SEO description.',
            'meta_keywords' => 'corporate, events',
        ]);

        $response->assertRedirect(route('admin.services.index'));

        $service = Service::where('title', 'Corporate Event Management')->firstOrFail();
        $this->assertSame('corporate-event-management', $service->slug);
        $this->assertTrue($service->featured);
        $this->assertTrue($service->status);
        Storage::disk('public')->assertExists($service->featured_image);
    }

    public function test_title_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), []);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseCount('services', 0);
    }

    public function test_slug_is_auto_generated_from_title_when_left_blank(): void
    {
        $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'title' => 'Wedding & Social Events',
        ]);

        $this->assertDatabaseHas('services', ['slug' => 'wedding-social-events']);
    }

    public function test_duplicate_slug_is_rejected_with_a_validation_error(): void
    {
        Service::factory()->create(['slug' => 'taken-slug']);

        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'title' => 'Another Service',
            'slug' => 'taken-slug',
        ]);

        $response->assertSessionHasErrors('slug');
        $this->assertSame(1, Service::where('slug', 'taken-slug')->count());
    }

    public function test_new_service_defaults_to_unfeatured_when_checkbox_is_omitted(): void
    {
        $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'title' => 'Unchecked Featured Service',
        ]);

        $service = Service::where('title', 'Unchecked Featured Service')->firstOrFail();
        $this->assertFalse($service->featured);
    }

    // ---- Image validation ----

    public function test_featured_image_rejects_disallowed_file_types(): void
    {
        $file = UploadedFile::fake()->create('malicious.php', 10, 'application/x-php');

        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'title' => 'Bad Image Service',
            'featured_image' => $file,
        ]);

        $response->assertSessionHasErrors('featured_image');
        $this->assertDatabaseCount('services', 0);
    }

    public function test_featured_image_rejects_oversized_files(): void
    {
        $file = UploadedFile::fake()->create('big.jpg', 3000, 'image/jpeg'); // 3MB > 2MB limit

        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'title' => 'Oversized Image Service',
            'featured_image' => $file,
        ]);

        $response->assertSessionHasErrors('featured_image');
    }

    public function test_featured_image_accepts_a_valid_jpeg_within_the_size_limit(): void
    {
        $file = UploadedFile::fake()->create('ok.jpg', 500, 'image/jpeg');

        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'title' => 'Good Image Service',
            'featured_image' => $file,
        ]);

        $response->assertSessionDoesntHaveErrors('featured_image');
        $this->assertDatabaseHas('services', ['title' => 'Good Image Service']);
    }

    // ---- Update ----

    public function test_admin_can_update_a_service(): void
    {
        $service = Service::factory()->create(['title' => 'Old Title']);

        $response = $this->actingAs($this->admin)->put(route('admin.services.update', $service), [
            'title' => 'New Title',
            'sort_order' => 5,
        ]);

        $response->assertRedirect(route('admin.services.index'));
        $service->refresh();
        $this->assertSame('New Title', $service->title);
        $this->assertSame(5, $service->sort_order);
    }

    public function test_updating_with_a_new_image_deletes_the_old_one(): void
    {
        $service = Service::factory()->create();
        Storage::disk('public')->put('services/old.jpg', 'fake');
        $service->update(['featured_image' => 'services/old.jpg']);

        $newImage = UploadedFile::fake()->create('new.jpg', 400, 'image/jpeg');

        $this->actingAs($this->admin)->put(route('admin.services.update', $service), [
            'title' => $service->title,
            'featured_image' => $newImage,
        ]);

        Storage::disk('public')->assertMissing('services/old.jpg');
        Storage::disk('public')->assertExists($service->fresh()->featured_image);
    }

    public function test_updating_without_a_new_image_keeps_the_existing_one(): void
    {
        $service = Service::factory()->create();
        Storage::disk('public')->put('services/keep.jpg', 'fake');
        $service->update(['featured_image' => 'services/keep.jpg']);

        $this->actingAs($this->admin)->put(route('admin.services.update', $service), [
            'title' => 'Updated Without Image Change',
        ]);

        $this->assertSame('services/keep.jpg', $service->fresh()->featured_image);
    }

    // ---- Delete ----

    public function test_admin_can_delete_a_service_and_its_image(): void
    {
        $service = Service::factory()->create();
        Storage::disk('public')->put('services/to-delete.jpg', 'fake');
        $service->update(['featured_image' => 'services/to-delete.jpg']);

        $response = $this->actingAs($this->admin)->delete(route('admin.services.destroy', $service));

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
        Storage::disk('public')->assertMissing('services/to-delete.jpg');
    }

    // ---- Toggle publish / featured ----

    public function test_admin_can_toggle_a_services_published_status(): void
    {
        $service = Service::factory()->create(['status' => true]);

        $this->actingAs($this->admin)->patch(route('admin.services.toggle-status', $service));
        $this->assertFalse($service->fresh()->status);

        $this->actingAs($this->admin)->patch(route('admin.services.toggle-status', $service));
        $this->assertTrue($service->fresh()->status);
    }

    public function test_admin_can_toggle_a_services_featured_flag(): void
    {
        $service = Service::factory()->create(['featured' => false]);

        $this->actingAs($this->admin)->patch(route('admin.services.toggle-featured', $service));
        $this->assertTrue($service->fresh()->featured);

        $this->actingAs($this->admin)->patch(route('admin.services.toggle-featured', $service));
        $this->assertFalse($service->fresh()->featured);
    }

    // ---- Authorization ----

    public function test_guest_cannot_access_admin_services(): void
    {
        $this->get(route('admin.services.index'))->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_manage_services(): void
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();

        $this->actingAs($user)->get(route('admin.services.index'))->assertForbidden();
        $this->actingAs($user)->post(route('admin.services.store'), ['title' => 'X'])->assertForbidden();
        $this->actingAs($user)->put(route('admin.services.update', $service), ['title' => 'X'])->assertForbidden();
        $this->actingAs($user)->delete(route('admin.services.destroy', $service))->assertForbidden();
        $this->actingAs($user)->patch(route('admin.services.toggle-status', $service))->assertForbidden();
        $this->assertDatabaseHas('services', ['id' => $service->id]);
    }
}
