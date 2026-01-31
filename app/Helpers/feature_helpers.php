<?php

use App\Services\FeatureFlagService;

if (!function_exists('feature')) {
    /**
     * Check if a feature flag is enabled
     * 
     * @param string $key Feature flag key
     * @param int|null $userId Optional user ID
     * @return bool
     */
    function feature(string $key, ?int $userId = null): bool
    {
        return app(FeatureFlagService::class)->isEnabled($key, $userId);
    }
}

if (!function_exists('featureForUser')) {
    /**
     * Check if a feature flag is enabled for specific user
     * 
     * @param string $key Feature flag key
     * @param int $userId User ID
     * @return bool
     */
    function featureForUser(string $key, int $userId): bool
    {
        return app(FeatureFlagService::class)->isEnabled($key, $userId);
    }
}

if (!function_exists('featureDisabled')) {
    /**
     * Check if a feature flag is disabled
     * 
     * @param string $key Feature flag key
     * @param int|null $userId Optional user ID
     * @return bool
     */
    function featureDisabled(string $key, ?int $userId = null): bool
    {
        return app(FeatureFlagService::class)->isDisabled($key, $userId);
    }
}

if (!function_exists('allEnabledFeatures')) {
    /**
     * Get all enabled feature flags
     * 
     * @param int|null $userId Optional user ID
     * @return array
     */
    function allEnabledFeatures(?int $userId = null): array
    {
        return app(FeatureFlagService::class)->getAllEnabled($userId);
    }
}

if (!function_exists('featureDebug')) {
    /**
     * Get debug information for a feature flag
     * 
     * @param string $key Feature flag key
     * @param int|null $userId Optional user ID
     * @return array
     */
    function featureDebug(string $key, ?int $userId = null): array
    {
        return app(FeatureFlagService::class)->getDebugInfo($key, $userId);
    }
}