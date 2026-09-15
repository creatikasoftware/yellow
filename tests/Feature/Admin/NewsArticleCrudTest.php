<?php

namespace Tests\Feature\Admin;

use App\Models\NewsArticle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsArticleCrudTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_can_create_an_article(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.news.store'), [
            'title' => 'Nominations Open',
            'excerpt' => 'Short teaser.',
            'body' => 'Full body text.',
            'published_at' => now()->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseHas('news_articles', ['title' => 'Nominations Open', 'slug' => 'nominations-open']);
    }

    public function test_title_and_published_at_are_required(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.news.store'), []);

        $response->assertSessionHasErrors(['title', 'published_at']);
    }

    public function test_admin_can_update_an_article(): void
    {
        $article = NewsArticle::factory()->create(['title' => 'Old Title']);

        $this->actingAs($this->admin)->put(route('admin.news.update', $article), [
            'title' => 'New Title',
            'published_at' => $article->published_at->format('Y-m-d'),
        ]);

        $article->refresh();
        $this->assertSame('New Title', $article->title);
        $this->assertSame('new-title', $article->slug);
    }

    public function test_admin_can_delete_an_article(): void
    {
        $article = NewsArticle::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.news.destroy', $article));

        $response->assertRedirect(route('admin.news.index'));
        $this->assertDatabaseMissing('news_articles', ['id' => $article->id]);
    }
}
