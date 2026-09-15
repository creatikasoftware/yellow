<?php

namespace Tests\Unit\Support;

use App\Support\PageContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_returns_defaults_when_nothing_is_stored(): void
    {
        $home = PageContent::get('home');

        $this->assertSame('Honouring Visionaries', $home['hero_eyebrow']);
        $this->assertSame(['Recognize Excellence', 'Inspire Talent', 'Build Opportunities', 'Create Impact'], $home['info_box_items']);
    }

    public function test_set_then_get_round_trips_scalar_values(): void
    {
        PageContent::set('home', ['hero_eyebrow' => 'Custom Eyebrow']);

        $this->assertSame('Custom Eyebrow', PageContent::get('home')['hero_eyebrow']);
    }

    public function test_set_then_get_round_trips_array_values_as_json(): void
    {
        PageContent::set('home', ['info_box_items' => ['One', 'Two']]);

        $this->assertSame(['One', 'Two'], PageContent::get('home')['info_box_items']);
    }

    public function test_set_ignores_keys_that_are_not_declared_in_defaults(): void
    {
        PageContent::set('home', ['not_a_real_field' => 'should be ignored']);

        $this->assertArrayNotHasKey('not_a_real_field', PageContent::get('home'));
        $this->assertDatabaseMissing('settings', ['key' => 'home.not_a_real_field']);
    }

    public function test_pages_are_isolated_from_each_other(): void
    {
        PageContent::set('home', ['hero_eyebrow' => 'Home Eyebrow']);
        PageContent::set('about', ['hero_eyebrow' => 'About Eyebrow']);

        $this->assertSame('Home Eyebrow', PageContent::get('home')['hero_eyebrow']);
        $this->assertSame('About Eyebrow', PageContent::get('about')['hero_eyebrow']);
    }
}
