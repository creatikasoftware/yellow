<?php

namespace Tests\Unit\Models;

use App\Models\Registration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_name_combines_first_and_last_name(): void
    {
        $registration = Registration::factory()->create(['first_name' => 'Jane', 'last_name' => 'Doe']);

        $this->assertSame('Jane Doe', $registration->full_name);
    }

    public function test_full_name_handles_a_missing_last_name(): void
    {
        $registration = Registration::factory()->create(['first_name' => 'Jane', 'last_name' => null]);

        $this->assertSame('Jane', $registration->full_name);
    }
}
