<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FeatureFlagService;

class FeatureCacheClearCommand extends Command
{
    protected $signature = 'feature:cache:clear {--flag=}';
    protected $description = 'Clear feature flag cache';

    public function handle(FeatureFlagService $service)
    {
        $flagKey = $this->option('flag');

        if ($flagKey) {
            $service->clearCacheForFlag($flagKey);
            $this->info("✓ Cache cleared for flag: {$flagKey}");
        } else {
            $service->clearAllCache();
            $this->info('✓ All feature flag caches cleared');
        }

        return 0;
    }
}