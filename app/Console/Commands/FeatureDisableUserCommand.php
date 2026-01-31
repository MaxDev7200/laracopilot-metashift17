<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FeatureFlagService;
use App\Models\User;

class FeatureDisableUserCommand extends Command
{
    protected $signature = 'feature:disable {key} {userId}';
    protected $description = 'Disable a feature flag for a specific user';

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

        if ($service->disableForUser($key, $userId)) {
            $this->info("✓ Feature '{$key}' disabled for user {$userId} ({$user->email})");
            return 0;
        } else {
            $this->error("✗ Failed to disable feature '{$key}'. Flag may not exist.");
            return 1;
        }
    }
}