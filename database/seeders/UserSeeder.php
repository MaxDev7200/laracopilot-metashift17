<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user for testing
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@featureflags.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now()
        ]);

        // Create additional test users
        User::create([
            'name' => 'Test User',
            'email' => 'test@featureflags.com',
            'password' => Hash::make('test123'),
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Demo User',
            'email' => 'demo@featureflags.com',
            'password' => Hash::make('demo123'),
            'email_verified_at' => now()
        ]);
    }
}