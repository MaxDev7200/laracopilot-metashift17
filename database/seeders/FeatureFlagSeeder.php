<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeatureFlag;
use App\Models\FeatureEnvironment;

class FeatureFlagSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample feature flags
        $features = [
            [
                'name' => 'new_dashboard',
                'key' => 'new_dashboard',
                'description' => 'Enable new redesigned dashboard interface with enhanced analytics',
                'enabled' => true,
            ],
            [
                'name' => 'dark_mode',
                'key' => 'dark_mode',
                'description' => 'Allow users to toggle dark mode theme across the application',
                'enabled' => true,
            ],
            [
                'name' => 'payment_gateway_v2',
                'key' => 'payment_gateway_v2',
                'description' => 'New payment processing system with multiple gateway support',
                'enabled' => false,
            ],
            [
                'name' => 'advanced_search',
                'key' => 'advanced_search',
                'description' => 'Enhanced search functionality with filters and AI-powered suggestions',
                'enabled' => true,
            ],
            [
                'name' => 'email_notifications',
                'key' => 'email_notifications',
                'description' => 'Send email notifications for important user actions and updates',
                'enabled' => true,
            ],
            [
                'name' => 'api_v3',
                'key' => 'api_v3',
                'description' => 'Latest API version with GraphQL support and improved performance',
                'enabled' => false,
            ],
            [
                'name' => 'two_factor_auth',
                'key' => 'two_factor_auth',
                'description' => 'Two-factor authentication using SMS or authenticator apps',
                'enabled' => true,
            ],
            [
                'name' => 'social_login',
                'key' => 'social_login',
                'description' => 'Login with Google, Facebook, GitHub and other OAuth providers',
                'enabled' => false,
            ],
            [
                'name' => 'real_time_chat',
                'key' => 'real_time_chat',
                'description' => 'Live chat support system with WebSocket connections',
                'enabled' => false,
            ],
            [
                'name' => 'export_reports',
                'key' => 'export_reports',
                'description' => 'Export data and reports to PDF, Excel, and CSV formats',
                'enabled' => true,
            ],
            [
                'name' => 'mobile_app_sync',
                'key' => 'mobile_app_sync',
                'description' => 'Synchronize data between web and mobile applications',
                'enabled' => true,
            ],
            [
                'name' => 'beta_features',
                'key' => 'beta_features',
                'description' => 'Access to experimental beta features for testing',
                'enabled' => false,
            ],
            [
                'name' => 'analytics_dashboard',
                'key' => 'analytics_dashboard',
                'description' => 'Comprehensive analytics and reporting dashboard with charts',
                'enabled' => true,
            ],
            [
                'name' => 'file_sharing',
                'key' => 'file_sharing',
                'description' => 'Upload and share files with team members and external users',
                'enabled' => true,
            ],
            [
                'name' => 'ai_assistant',
                'key' => 'ai_assistant',
                'description' => 'AI-powered virtual assistant for user support and automation',
                'enabled' => false,
            ],
        ];

        foreach ($features as $feature) {
            $flag = FeatureFlag::create($feature);

            // Create environment-specific settings
            $environments = ['development', 'staging', 'production'];
            
            foreach ($environments as $index => $env) {
                FeatureEnvironment::create([
                    'feature_flag_id' => $flag->id,
                    'environment' => $env,
                    'enabled' => $env === 'development' ? true : ($env === 'staging' ? $flag->enabled : ($flag->enabled && rand(0, 1) === 1)),
                    'rollout_percentage' => $env === 'production' ? rand(0, 100) : 100,
                ]);
            }
        }
    }
}