<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeatureFlag;
use App\Models\FeatureEnvironment;

class FeatureFlagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flags = [
            [
                'key' => 'dark_mode',
                'name' => 'Dark Mode',
                'description' => 'Enable dark theme UI for users',
                'is_active' => true,
                'environments' => [
                    'local' => ['enabled' => true, 'percentage' => 100],
                    'development' => ['enabled' => true, 'percentage' => 100],
                    'staging' => ['enabled' => true, 'percentage' => 50],
                    'production' => ['enabled' => false, 'percentage' => 0],
                ]
            ],
            [
                'key' => 'new_dashboard',
                'name' => 'New Dashboard',
                'description' => 'Redesigned dashboard with enhanced analytics',
                'is_active' => true,
                'environments' => [
                    'local' => ['enabled' => true, 'percentage' => 100],
                    'development' => ['enabled' => true, 'percentage' => 100],
                    'staging' => ['enabled' => true, 'percentage' => 100],
                    'production' => ['enabled' => true, 'percentage' => 25],
                ]
            ],
            [
                'key' => 'beta_features',
                'name' => 'Beta Features Access',
                'description' => 'Access to experimental beta features',
                'is_active' => true,
                'environments' => [
                    'local' => ['enabled' => true, 'percentage' => 100],
                    'development' => ['enabled' => true, 'percentage' => 100],
                    'staging' => ['enabled' => true, 'percentage' => 100],
                    'production' => ['enabled' => true, 'percentage' => 10],
                ]
            ],
            [
                'key' => 'advanced_search',
                'name' => 'Advanced Search',
                'description' => 'Enhanced search with filters and suggestions',
                'is_active' => true,
                'environments' => [
                    'local' => ['enabled' => true, 'percentage' => 100],
                    'development' => ['enabled' => true, 'percentage' => 100],
                    'staging' => ['enabled' => true, 'percentage' => 75],
                    'production' => ['enabled' => true, 'percentage' => 50],
                ]
            ],
            [
                'key' => 'api_v2',
                'name' => 'API Version 2',
                'description' => 'New API endpoints with improved performance',
                'is_active' => false,
                'environments' => [
                    'local' => ['enabled' => true, 'percentage' => 100],
                    'development' => ['enabled' => true, 'percentage' => 100],
                    'staging' => ['enabled' => false, 'percentage' => 0],
                    'production' => ['enabled' => false, 'percentage' => 0],
                ]
            ],
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
                    'rollout_percentage' => $settings['percentage'],
                ]);
            }
        }

        $this->command->info('Created ' . count($flags) . ' feature flags with environment settings.');
    }
}