<?php

namespace Tests\Feature\Admin;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PartnerCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        Storage::fake('public');
    }

    public function test_admin_can_create_a_text_only_partner(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.partners.store'), [
            'name' => 'Acme Corp',
        ]);

        $response->assertRedirect(route('admin.partners.index'));
        $this->assertDatabaseHas('partners', ['name' => 'Acme Corp', 'logo' => null]);
    }

    public function test_admin_can_create_a_partner_with_a_logo(): void
    {
        $logo = UploadedFile::fake()->create('logo.png', 10, 'image/png');

        $this->actingAs($this->admin)->post(route('admin.partners.store'), [
            'name' => 'Logo Corp',
            'logo' => $logo,
        ]);

        $partner = Partner::where('name', 'Logo Corp')->firstOrFail();
        Storage::disk('public')->assertExists($partner->logo);
    }

    public function test_name_is_required(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.partners.store'), []);

        $response->assertSessionHasErrors('name');
    }

    public function test_admin_can_delete_a_partner_and_its_logo(): void
    {
        $partner = Partner::factory()->create(['logo' => 'partners/logo.png']);
        Storage::disk('public')->put('partners/logo.png', 'fake');

        $this->actingAs($this->admin)->delete(route('admin.partners.destroy', $partner));

        $this->assertDatabaseMissing('partners', ['id' => $partner->id]);
        Storage::disk('public')->assertMissing('partners/logo.png');
    }
}
