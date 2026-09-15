<?php

namespace Tests\Unit\Models;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_slug_is_auto_generated_from_title_when_not_provided_at_all(): void
    {
        $service = Service::create(['title' => 'Full Event Production']);

        $this->assertSame('full-event-production', $service->slug);
    }

    public function test_slug_is_slugified_even_when_explicitly_provided(): void
    {
        $service = Service::create(['title' => 'X', 'slug' => 'Not A Clean Slug!!']);

        $this->assertSame('not-a-clean-slug', $service->slug);
    }

    public function test_published_scope_excludes_drafts(): void
    {
        Service::factory()->create(['status' => true]);
        Service::factory()->draft()->create();

        $this->assertSame(1, Service::published()->count());
    }

    public function test_featured_scope_only_returns_featured_services(): void
    {
        Service::factory()->featured()->create();
        Service::factory()->create(['featured' => false]);

        $this->assertSame(1, Service::featured()->count());
    }

    public function test_ordered_scope_sorts_by_sort_order_then_title(): void
    {
        Service::factory()->create(['title' => 'B Service', 'sort_order' => 1]);
        Service::factory()->create(['title' => 'A Service', 'sort_order' => 1]);
        Service::factory()->create(['title' => 'Z Service', 'sort_order' => 0]);

        $titles = Service::ordered()->pluck('title')->toArray();

        $this->assertSame(['Z Service', 'A Service', 'B Service'], $titles);
    }

    public function test_meta_title_falls_back_to_title(): void
    {
        $service = Service::factory()->create(['title' => 'Fallback Title', 'meta_title' => null]);

        $this->assertSame('Fallback Title', $service->meta_title_or_fallback);
    }

    public function test_meta_title_uses_explicit_value_when_set(): void
    {
        $service = Service::factory()->create(['title' => 'Title', 'meta_title' => 'Custom SEO Title']);

        $this->assertSame('Custom SEO Title', $service->meta_title_or_fallback);
    }

    public function test_meta_description_falls_back_to_short_description(): void
    {
        $service = Service::factory()->create(['short_description' => 'Short teaser.', 'meta_description' => null]);

        $this->assertSame('Short teaser.', $service->meta_description_or_fallback);
    }

    public function test_route_key_name_is_slug(): void
    {
        $service = Service::factory()->create();

        $this->assertSame('slug', $service->getRouteKeyName());
    }

    public function test_status_and_featured_are_cast_to_booleans(): void
    {
        $service = Service::factory()->create(['status' => 1, 'featured' => 0]);

        $this->assertIsBool($service->fresh()->status);
        $this->assertIsBool($service->fresh()->featured);
    }
}
