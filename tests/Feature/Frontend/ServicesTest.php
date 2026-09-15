<?php

namespace Tests\Feature\Frontend;

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServicesTest extends TestCase
{
    use RefreshDatabase;

    public function test_services_index_lists_published_services(): void
    {
        Service::factory()->create(['title' => 'Published Service']);
        Service::factory()->draft()->create(['title' => 'Draft Service']);

        $response = $this->get(route('services.index'));

        $response->assertOk();
        $response->assertSee('Published Service');
        $response->assertDontSee('Draft Service');
    }

    public function test_services_index_handles_zero_services_gracefully(): void
    {
        $response = $this->get(route('services.index'));

        $response->assertOk();
    }

    public function test_services_index_paginates(): void
    {
        Service::factory()->count(12)->create();

        $response = $this->get(route('services.index'));

        $response->assertOk();
        $response->assertViewHas('services', fn ($services) => $services->total() === 12 && $services->count() === 9);
    }

    public function test_service_detail_page_loads_by_slug(): void
    {
        $service = Service::factory()->create([
            'title' => 'Corporate Event Management',
            'slug' => 'corporate-event-management',
            'description' => 'Full details about the service.',
        ]);

        $response = $this->get('/services/corporate-event-management');

        $response->assertOk();
        $response->assertSee('Corporate Event Management');
        $response->assertSee('Full details about the service.');
        $response->assertViewHas('service', fn ($viewService) => $viewService->is($service));
    }

    public function test_unpublished_service_returns_404_even_with_a_valid_slug(): void
    {
        $service = Service::factory()->draft()->create(['slug' => 'hidden-service']);

        $response = $this->get(route('services.show', $service));

        $response->assertNotFound();
    }

    public function test_unknown_service_slug_returns_404(): void
    {
        $response = $this->get('/services/does-not-exist');

        $response->assertNotFound();
    }

    public function test_related_services_exclude_the_current_service_and_drafts(): void
    {
        $service = Service::factory()->create(['title' => 'Main Service']);
        $related = Service::factory()->create(['title' => 'Related Service']);
        Service::factory()->draft()->create(['title' => 'Hidden Related Service']);

        $response = $this->get(route('services.show', $service));

        $response->assertOk();
        $response->assertViewHas('relatedServices', function ($relatedServices) use ($service, $related) {
            return ! $relatedServices->contains('id', $service->id)
                && $relatedServices->contains('id', $related->id);
        });
    }

    public function test_seo_meta_tags_fall_back_sensibly_when_seo_fields_are_empty(): void
    {
        $service = Service::factory()->create([
            'title' => 'SEO Fallback Service',
            'short_description' => 'A short teaser used as the fallback description.',
            'meta_title' => null,
            'meta_description' => null,
        ]);

        $response = $this->get(route('services.show', $service));

        $response->assertOk();
        $response->assertSee('SEO Fallback Service | Yellow', false);
        $response->assertSee('A short teaser used as the fallback description.', false);
    }

    public function test_seo_meta_tags_use_explicit_values_when_provided(): void
    {
        $service = Service::factory()->create([
            'meta_title' => 'Custom SEO Title',
            'meta_description' => 'Custom SEO description.',
            'meta_keywords' => 'events, awards, services',
        ]);

        $response = $this->get(route('services.show', $service));

        $response->assertOk();
        $response->assertSee('Custom SEO Title | Yellow', false);
        $response->assertSee('Custom SEO description.', false);
        $response->assertSee('events, awards, services', false);
    }
}
