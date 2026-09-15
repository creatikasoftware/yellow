<?php

namespace Tests\Feature\Frontend;

use App\Models\Speaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SpeakersTest extends TestCase
{
    use RefreshDatabase;

    public function test_speakers_index_lists_all_speakers(): void
    {
        Speaker::factory()->create(['name' => 'Jane Speaker']);

        $response = $this->get(route('speakers.index'));

        $response->assertOk();
        $response->assertSee('Jane Speaker');
    }

    public function test_speaker_profile_shows_bio_when_present(): void
    {
        $speaker = Speaker::factory()->create([
            'name' => 'Detailed Speaker',
            'bio' => 'A very specific biography.',
            'expertise' => ['Leadership', 'Strategy'],
        ]);

        $response = $this->get(route('speakers.show', $speaker));

        $response->assertOk();
        $response->assertSee('Detailed Speaker');
        $response->assertSee('A very specific biography.');
        $response->assertSee('Leadership');
    }

    public function test_speaker_profile_omits_bio_section_when_absent(): void
    {
        $speaker = Speaker::factory()->create(['bio' => null, 'expertise' => null]);

        $response = $this->get(route('speakers.show', $speaker));

        $response->assertOk();
        $response->assertDontSee('About The Speaker');
        $response->assertDontSee('Areas of Expertise');
    }

    public function test_unknown_speaker_slug_returns_404(): void
    {
        $response = $this->get('/speakers/does-not-exist');

        $response->assertNotFound();
    }
}
