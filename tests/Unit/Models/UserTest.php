<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_is_admin_reflects_the_is_admin_column(): void
    {
        $admin = User::factory()->admin()->create();
        $regular = User::factory()->create();

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($regular->isAdmin());
    }
}
