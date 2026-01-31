<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FeatureFlagService;
use App\Models\User;

class FeatureEnableUserCommand extends Command
{
    protected $signature = 'feature:enable {key} {userId}';
    protected $description = 'Enable a feature flag for a specific user';

    public function handle(FeatureFlagService $service)
    {
        $key = $this->argument('key');
        $userId = $this->argument('userId');

        // Validate user
        $user = User::find($userId);
        if (!$user) {
            $this->error("User with ID {$userId} not found.");
            return 1;
        }

        if ($service->enableForUser($key, $userId)) {
            $this->info("✓ Feature '{$key}' enabled for user {$userId} ({$user->email})");
            return 0;
        } else {
            $this->error("✗ Failed to enable feature '{$key}'. Flag may not exist.");
            return 1;
        }
    }
}