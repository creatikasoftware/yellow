<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeds one admin login for local development. Change this password
     * (or delete/replace the user) before deploying anywhere real.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@yellowaward.in'],
            [
                'name' => 'Yellow Achiever\'s Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
