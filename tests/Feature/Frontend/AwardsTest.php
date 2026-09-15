<?php

namespace Tests\Feature\Frontend;

use App\Models\Award;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AwardsTest extends TestCase
{
    use RefreshDatabase;

    public function test_awards_index_lists_all_categories(): void
    {
        Award::factory()->create(['name' => 'Business Excellence']);

        $response = $this->get(route('awards.index'));

        $response->assertOk();
        $response->assertSee('Business Excellence');
    }

    public function test_award_detail_page_shows_long_description(): void
    {
        $award = Award::factory()->create([
            'name' => 'Innovation Award',
            'long_description' => 'A very specific long description.',
        ]);

        $response = $this->get(route('awards.show', $award));

        $response->assertOk();
        $response->assertSee('Innovation Award');
        $response->assertSee('A very specific long description.');
    }

    public function test_unknown_award_slug_returns_404(): void
    {
        $response = $this->get('/awards/does-not-exist');

        $response->assertNotFound();
    }
}
