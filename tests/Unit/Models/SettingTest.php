<?php

namespace Tests\Unit\Models;

use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_returns_the_default_when_key_is_missing(): void
    {
        $this->assertSame('fallback', Setting::get('missing.key', 'fallback'));
    }

    public function test_set_then_get_round_trips_the_value(): void
    {
        Setting::set('site.contact_email', 'hello@example.com');

        $this->assertSame('hello@example.com', Setting::get('site.contact_email'));
    }

    public function test_set_overwrites_an_existing_key_rather_than_duplicating_it(): void
    {
        Setting::set('site.contact_email', 'first@example.com');
        Setting::set('site.contact_email', 'second@example.com');

        $this->assertSame('second@example.com', Setting::get('site.contact_email'));
        $this->assertDatabaseCount('settings', 1);
    }
}
