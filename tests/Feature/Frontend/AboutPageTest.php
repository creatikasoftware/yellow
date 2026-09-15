<?php

namespace Tests\Feature\Frontend;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AboutPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_about_page_loads_successfully(): void
    {
        $response = $this->get(route('about'));

        $response->assertOk();
        $response->assertViewIs('frontend.about');
        $response->assertSee('Celebrating People');
    }
}
