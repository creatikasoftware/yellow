<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Support\PageContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageContentTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    // ---- Home ----

    public function test_admin_can_view_home_page_editor(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pages.home'));

        $response->assertOk();
        $response->assertSee('Honouring Visionaries');
    }

    public function test_admin_can_update_home_page_content(): void
    {
        $payload = $this->validHomePayload(['hero_eyebrow' => 'A Brand New Eyebrow']);

        $response = $this->actingAs($this->admin)->put(route('admin.pages.home.update'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('status');
        $this->assertSame('A Brand New Eyebrow', PageContent::get('home')['hero_eyebrow']);
    }

    public function test_updated_home_content_appears_on_the_live_homepage(): void
    {
        $this->actingAs($this->admin)->put(route('admin.pages.home.update'), $this->validHomePayload([
            'hero_title_line1' => 'Totally Different Heading',
        ]));

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Totally Different Heading');
    }

    public function test_home_info_box_items_are_parsed_from_newline_separated_textarea(): void
    {
        $this->actingAs($this->admin)->put(route('admin.pages.home.update'), $this->validHomePayload([
            'info_box_items' => "First Item\nSecond Item\nThird Item",
        ]));

        $this->assertSame(['First Item', 'Second Item', 'Third Item'], PageContent::get('home')['info_box_items']);
    }

    public function test_home_page_editor_requires_all_fields(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.pages.home.update'), []);

        $response->assertSessionHasErrors(['hero_eyebrow', 'hero_title_line1', 'about_kicker']);
    }

    public function test_non_admin_cannot_view_or_update_home_page_editor(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.pages.home'))->assertForbidden();
        $this->actingAs($user)->put(route('admin.pages.home.update'), $this->validHomePayload())->assertForbidden();
    }

    // ---- About ----

    public function test_admin_can_view_about_page_editor(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pages.about'));

        $response->assertOk();
        $response->assertSee('Celebrating People');
    }

    public function test_admin_can_update_about_page_content_including_values_repeater(): void
    {
        $payload = $this->validAboutPayload([
            'value_icon' => ['bi-star', 'bi-heart'],
            'value_label' => ['Trust', 'Care'],
            'value_description' => ['We are trustworthy.', 'We care deeply.'],
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.pages.about.update'), $payload);

        $response->assertRedirect();
        $values = PageContent::get('about')['values'];
        $this->assertCount(2, $values);
        $this->assertSame('Trust', $values[0]['label']);
        $this->assertSame('bi-heart', $values[1]['icon']);
    }

    public function test_about_values_repeater_skips_rows_with_a_blank_label(): void
    {
        $payload = $this->validAboutPayload([
            'value_icon' => ['bi-star', 'bi-heart'],
            'value_label' => ['Trust', ''],
            'value_description' => ['We are trustworthy.', 'Should be skipped.'],
        ]);

        $this->actingAs($this->admin)->put(route('admin.pages.about.update'), $payload);

        $this->assertCount(1, PageContent::get('about')['values']);
    }

    public function test_updated_about_content_appears_on_the_live_about_page(): void
    {
        $this->actingAs($this->admin)->put(route('admin.pages.about.update'), $this->validAboutPayload([
            'intro_title' => 'A Wildly Different Intro Title',
        ]));

        $response = $this->get(route('about'));

        $response->assertOk();
        $response->assertSee('A Wildly Different Intro Title');
    }

    public function test_non_admin_cannot_view_or_update_about_page_editor(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.pages.about'))->assertForbidden();
        $this->actingAs($user)->put(route('admin.pages.about.update'), $this->validAboutPayload())->assertForbidden();
    }

    // ---- Contact ----

    public function test_admin_can_view_contact_page_editor(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pages.contact'));

        $response->assertOk();
        $response->assertSee('info@yellowaward.in');
    }

    public function test_admin_can_update_contact_details_and_they_appear_on_the_contact_page_and_footer(): void
    {
        $payload = $this->validContactPayload([
            'contact_email' => 'new-address@example.com',
            'contact_phone' => '+91 00000 00000',
        ]);

        $this->actingAs($this->admin)->put(route('admin.pages.contact.update'), $payload);

        $contactPage = $this->get(route('contact'));
        $contactPage->assertOk();
        $contactPage->assertSee('new-address@example.com');

        $homePage = $this->get(route('home'));
        $homePage->assertOk();
        $homePage->assertSee('new-address@example.com'); // footer is shared across pages
    }

    public function test_contact_editor_requires_a_valid_email(): void
    {
        $payload = $this->validContactPayload(['contact_email' => 'not-an-email']);

        $response = $this->actingAs($this->admin)->put(route('admin.pages.contact.update'), $payload);

        $response->assertSessionHasErrors('contact_email');
    }

    public function test_non_admin_cannot_view_or_update_contact_page_editor(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('admin.pages.contact'))->assertForbidden();
        $this->actingAs($user)->put(route('admin.pages.contact.update'), $this->validContactPayload())->assertForbidden();
    }

    // ---- Helpers ----

    private function validHomePayload(array $overrides = []): array
    {
        return array_merge(PageContent::defaults()['home'], [
            'info_box_items' => "Recognize Excellence\nInspire Talent\nBuild Opportunities\nCreate Impact",
        ], $overrides);
    }

    private function validAboutPayload(array $overrides = []): array
    {
        $defaults = PageContent::defaults()['about'];
        unset($defaults['values']);

        return array_merge($defaults, [
            'value_icon' => ['bi-trophy'],
            'value_label' => ['Excellence'],
            'value_description' => ['Doing great work.'],
        ], $overrides);
    }

    private function validContactPayload(array $overrides = []): array
    {
        $defaults = PageContent::defaults()['contact'];

        return array_merge($defaults, [
            'contact_address' => '123, Business Avenue, New Delhi, India - 110001',
            'contact_phone' => '+91 98765 43210',
            'contact_email' => 'info@yellowaward.in',
            'footer_copy' => 'Celebrating achievers, creating opportunities and building a brighter, more inclusive future.',
            'social_facebook' => '#',
            'social_twitter' => '#',
            'social_linkedin' => '#',
            'social_instagram' => '#',
            'social_youtube' => '#',
        ], $overrides);
    }
}
