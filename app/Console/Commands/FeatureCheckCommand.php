<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FeatureFlagService;
use App\Models\User;

class FeatureCheckCommand extends Command
{
    protected $signature = 'feature:check {key} {--user=} {--env=}';
    protected $description = 'Check if a feature flag is enabled';

    public function handle(FeatureFlagService $service)
    {
        $key = $this->argument('key');
        $userId = $this->option('user');
        $environment = $this->option('env');

        // Validate user if provided
        if ($userId) {
            $user = User::find($userId);
            if (!$user) {
                $this->error("User with ID {$userId} not found.");
                return 1;
            }
        }

        $isEnabled = $service->isEnabled($key, $userId, $environment);
        $debugInfo = $service->getDebugInfo($key, $userId);

        $this->info("\n=== Feature Flag Check ===");
        $this->line("Flag Key: {$key}");
        $this->line("Environment: " . ($environment ?? config('app.env')));
        
        if ($userId) {
            $this->line("User ID: {$userId}");
        }

        $this->line("\n--- Result ---");
        
        if ($isEnabled) {
            $this->info("✓ ENABLED");
        } else {
            $this->error("✗ DISABLED");
        }

        $this->line("\n--- Debug Information ---");
        $this->table(
            ['Property', 'Value'],
            [
                ['Globally Active', $debugInfo['globally_active'] ? 'Yes' : 'No'],
                ['Environment', $debugInfo['environment']],
                ['Environment Enabled', $debugInfo['environment_enabled'] === null ? 'Not Set' : ($debugInfo['environment_enabled'] ? 'Yes' : 'No')],
                ['Rollout Percentage', $debugInfo['rollout_percentage'] ?? 'N/A'],
                ['User Override', $debugInfo['user_override'] === null ? 'None' : ($debugInfo['user_override'] ? 'Enabled' : 'Disabled')],
                ['Request Identifier', $debugInfo['request_identifier']],
            ]
        );

        return 0;
    }
}