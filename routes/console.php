<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('setup', function () {
    $this->info('🚀 Setting up Feature Flag Manager...');
    
    $this->info('\n📦 Running migrations...');
    $this->call('migrate:fresh');
    
    $this->info('\n🌱 Seeding database...');
    $this->call('db:seed');
    
    $this->info('\n🔗 Creating storage link...');
    $this->call('storage:link');
    
    $this->info('\n✅ Setup complete!');
    $this->info('\n📝 Admin Login Credentials:');
    $this->info('   Email: admin@featureflags.com');
    $this->info('   Password: admin123');
    $this->info('\n🌐 Access the app at: http://localhost:8000');
    $this->info('🔍 Debug page at: http://localhost:8000/debug');
})->purpose('Set up the application with migrations and seeders');