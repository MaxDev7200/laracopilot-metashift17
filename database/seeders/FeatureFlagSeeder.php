<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeatureFlag;
use App\Models\FeatureEnvironment;

class FeatureFlagSeeder extends Seeder
{
    public function run(): void
    {
        $flags = [
            [
                'key' => 'dark_mode',
                'name' => 'Dark Mode',
                'description' => 'Enable dark mode theme for the application',
                'is_active' => true,
                'environments' => [
                    'local' => ['enabled' => true, 'percentage' => 100],
                    'development' => ['enabled' => true, 'percentage' => 100],
                    'staging' => ['enabled' => true, 'percentage' => 100],
                    'production' => ['enabled' => true, 'percentage' => 100]
                ]
            ],
            [
                'key' => 'new_dashboard',
                'name' => 'New Dashboard',
                'description' => 'Redesigned dashboard with improved analytics',
                'is_active' => true,
                'environments' => [
                    'local' => ['enabled' => true, 'percentage' => 100],
                    'development' => ['enabled' => true, 'percentage' => 100],
                    'staging' => ['enabled' => true, 'percentage' => 50],
                    'production' => ['enabled' => false, 'percentage' => 0]
                ]
            ],
            [
                'key' => 'beta_features',
                'name' => 'Beta Features',
                'description' => 'Access to beta features for testing',
                'is_active' => true,
                'environments' => [
                    'local' => ['enabled' => true, 'percentage' => 100],
                    'development' => ['enabled' => true, 'percentage' => 100],
                    'staging' => ['enabled' => true, 'percentage' => 25],
                    'production' => ['enabled' => false, 'percentage' => 0]
                ]
            ],
            [
                'key' => 'advanced_analytics',
                'name' => 'Advanced Analytics',
                'description' => 'Advanced analytics and reporting features',
                'is_active' => true,
                'environments' => [
                    'local' => ['enabled' => true, 'percentage' => 100],
                    'development' => ['enabled' => true, 'percentage' => 100],
                    'staging' => ['enabled' => true, 'percentage' => 75],
                    'production' => ['enabled' => true, 'percentage' => 10]
                ]
            ],
            [
                'key' => 'premium_features',
                'name' => 'Premium Features',
                'description' => 'Premium tier features for paid users',
                'is_active' => false,
                'environments' => [
                    'local' => ['enabled' => false, 'percentage' => 0],
                    'development' => ['enabled' => false, 'percentage' => 0],
                    'staging' => ['enabled' => false, 'percentage' => 0],
                    'production' => ['enabled' => false, 'percentage' => 0]
                ]
            ]
        ];

        foreach ($flags as $flagData) {
            $environments = $flagData['environments'];
            unset($flagData['environments']);

            $flag = FeatureFlag::create($flagData);

            foreach ($environments as $env => $settings) {
                FeatureEnvironment::create([
                    'feature_flag_id' => $flag->id,
                    'environment' => $env,
                    'is_enabled' => $settings['enabled'],
                    'rollout_percentage' => $settings['percentage']
                ]);
            }
        }
    }
}