<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FeatureFlag;
use App\Models\FeatureEnvironment;
use App\Services\FeatureFlagService;

class FeatureListCommand extends Command
{
    protected $signature = 'feature:list {--env=} {--user=}';
    protected $description = 'List all feature flags and their status';

    public function handle(FeatureFlagService $service)
    {
        $environment = $this->option('env') ?? config('app.env');
        $userId = $this->option('user');

        $flags = FeatureFlag::with(['environments' => function ($query) use ($environment) {
            $query->where('environment', $environment);
        }])->get();

        if ($flags->isEmpty()) {
            $this->warn('No feature flags found.');
            return 0;
        }

        $this->info("\n=== Feature Flags ===");
        $this->line("Environment: {$environment}");
        
        if ($userId) {
            $this->line("User ID: {$userId}");
        }
        
        $this->line("");

        $tableData = [];
        
        foreach ($flags as $flag) {
            $isEnabled = $service->isEnabled($flag->key, $userId, $environment);
            $envSetting = $flag->environments->first();
            
            $tableData[] = [
                $flag->key,
                $flag->name,
                $flag->is_active ? '✓' : '✗',
                $envSetting && $envSetting->is_enabled ? '✓' : '✗',
                $envSetting ? $envSetting->rollout_percentage . '%' : 'N/A',
                $isEnabled ? '✓ ENABLED' : '✗ DISABLED',
            ];
        }

        $this->table(
            ['Key', 'Name', 'Global', 'Env', 'Rollout', 'Final Status'],
            $tableData
        );

        $this->line("");
        $this->info("Total flags: " . $flags->count());
        $this->info("Enabled flags: " . collect($tableData)->where(5, '✓ ENABLED')->count());

        return 0;
    }
}