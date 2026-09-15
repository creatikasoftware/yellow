<?php

namespace Tests\Feature\Frontend;

use App\Models\NewsArticle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_news_index_lists_published_articles(): void
    {
        NewsArticle::factory()->create(['title' => 'Past Announcement', 'published_at' => now()->subDay()]);
        NewsArticle::factory()->create(['title' => 'Future Announcement', 'published_at' => now()->addWeek()]);

        $response = $this->get(route('news.index'));

        $response->assertOk();
        $response->assertSee('Past Announcement');
        $response->assertDontSee('Future Announcement');
    }

    public function test_news_detail_page_shows_body(): void
    {
        $article = NewsArticle::factory()->create([
            'title' => 'A Detailed Article',
            'body' => "First paragraph.\n\nSecond paragraph.",
        ]);

        $response = $this->get(route('news.show', $article));

        $response->assertOk();
        $response->assertSee('A Detailed Article');
        $response->assertSee('First paragraph.');
        $response->assertSee('Second paragraph.');
    }

    public function test_unknown_news_slug_returns_404(): void
    {
        $response = $this->get('/news/does-not-exist');

        $response->assertNotFound();
    }
}
