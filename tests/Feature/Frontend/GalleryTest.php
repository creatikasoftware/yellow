<?php

namespace Tests\Feature\Frontend;

use App\Models\GalleryItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_gallery_page_loads_successfully(): void
    {
        GalleryItem::factory()->count(5)->create();

        $response = $this->get(route('gallery.index'));

        $response->assertOk();
        $response->assertViewIs('frontend.gallery.index');
    }

    public function test_gallery_page_loads_with_no_items(): void
    {
        $response = $this->get(route('gallery.index'));

        $response->assertOk();
    }

    public function test_uploaded_images_actually_render_as_img_tags(): void
    {
        // Regression test: x-gallery-card used to be a static placeholder
        // that never received the item at all, so no uploaded image could
        // ever appear on the page regardless of what was in the database.
        Storage::fake('public');
        Storage::disk('public')->put('gallery/photo.jpg', 'fake-image-content');
        GalleryItem::factory()->create(['image' => 'gallery/photo.jpg', 'caption' => 'Award Night']);

        $response = $this->get(route('gallery.index'));

        $response->assertOk();
        $response->assertSee('gallery/photo.jpg', false);
        $response->assertSee('Award Night', false);
    }

    public function test_items_without_an_image_fall_back_to_the_placeholder_box(): void
    {
        GalleryItem::factory()->create(['image' => null]);

        $response = $this->get(route('gallery.index'));

        $response->assertOk();
        $response->assertSee('gallery-box', false);
    }

    public function test_the_item_marked_featured_gets_the_large_slot_even_if_not_first_by_sort_order(): void
    {
        // Regression test: the large/featured tile used to be picked purely
        // by sort_order position, completely ignoring the is_featured flag.
        Storage::fake('public');
        Storage::disk('public')->put('gallery/featured.jpg', 'fake');
        GalleryItem::factory()->create(['sort_order' => 1, 'image' => null]);
        $featured = GalleryItem::factory()->create(['sort_order' => 5, 'image' => 'gallery/featured.jpg', 'is_featured' => true]);

        $response = $this->get(route('gallery.index'));

        $response->assertOk();
        $response->assertViewHas('featuredItem', fn ($item) => $item->is($featured));
    }
}
