<?php

namespace Tests\Feature\Admin;

use App\Models\GalleryItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryItemCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        Storage::fake('public');
    }

    public function test_admin_can_add_a_gallery_image(): void
    {
        $image = UploadedFile::fake()->create('photo.jpg', 10, 'image/jpeg');

        $response = $this->actingAs($this->admin)->post(route('admin.gallery.store'), [
            'image' => $image,
            'caption' => 'Award Night',
            'is_featured' => '1',
        ]);

        $response->assertRedirect(route('admin.gallery.index'));

        $item = GalleryItem::where('caption', 'Award Night')->firstOrFail();
        $this->assertTrue($item->is_featured);
        Storage::disk('public')->assertExists($item->image);
    }

    public function test_image_is_required_on_create(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.gallery.store'), [
            'caption' => 'No Image',
        ]);

        $response->assertSessionHasErrors('image');
    }

    public function test_image_is_optional_on_update(): void
    {
        $item = GalleryItem::factory()->create(['image' => 'gallery/existing.jpg', 'caption' => 'Old Caption']);

        $response = $this->actingAs($this->admin)->put(route('admin.gallery.update', $item), [
            'caption' => 'New Caption',
        ]);

        $response->assertRedirect(route('admin.gallery.index'));
        $item->refresh();
        $this->assertSame('New Caption', $item->caption);
        $this->assertSame('gallery/existing.jpg', $item->image);
    }

    public function test_admin_can_delete_a_gallery_item(): void
    {
        $item = GalleryItem::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.gallery.destroy', $item));

        $response->assertRedirect(route('admin.gallery.index'));
        $this->assertDatabaseMissing('gallery_items', ['id' => $item->id]);
    }
}
