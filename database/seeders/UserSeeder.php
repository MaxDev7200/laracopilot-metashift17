<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@featureflags.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Create test users
        User::create([
            'name' => 'John Developer',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jane Tester',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Create additional sample users
        User::factory()->count(10)->create();
    }
}