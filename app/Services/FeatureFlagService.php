<?php

namespace App\Services;

use App\Models\FeatureFlag;
use App\Models\FeatureEnvironment;
use App\Models\FeatureUserOverride;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class FeatureFlagService
{
    protected $cachePrefix = 'feature_flag:';
    protected $cacheTTL = 3600; // 1 hour

    /**
     * Check if a feature flag is enabled
     * 
     * @param string $key Feature flag key
     * @param int|null $userId User ID for override checking
     * @param string|null $environment Override environment (defaults to current)
     * @return bool
     */
    public function isEnabled(string $key, ?int $userId = null, ?string $environment = null): bool
    {
        $environment = $environment ?? config('app.env');
        
        // Check cache first
        $cacheKey = $this->getCacheKey($key, $userId, $environment);
        
        return Cache::remember($cacheKey, $this->cacheTTL, function () use ($key, $userId, $environment) {
            return $this->checkFeatureFlag($key, $userId, $environment);
        });
    }

    /**
     * Core logic to check feature flag status
     */
    protected function checkFeatureFlag(string $key, ?int $userId, string $environment): bool
    {
        // Get the feature flag
        $flag = FeatureFlag::where('key', $key)->first();
        
        if (!$flag) {
            Log::warning("Feature flag not found: {$key}");
            return false;
        }

        // Check if flag is globally disabled
        if (!$flag->is_active) {
            return false;
        }

        // Priority 1: Check user-specific override
        if ($userId) {
            $userOverride = FeatureUserOverride::where('feature_flag_id', $flag->id)
                ->where('user_id', $userId)
                ->first();
            
            if ($userOverride) {
                return $userOverride->is_enabled;
            }
        }

        // Priority 2: Check environment-specific settings
        $envSetting = FeatureEnvironment::where('feature_flag_id', $flag->id)
            ->where('environment', $environment)
            ->first();
        
        if (!$envSetting) {
            // No environment setting, use global flag status
            return $flag->is_active;
        }

        if (!$envSetting->is_enabled) {
            return false;
        }

        // Priority 3: Check rollout percentage
        if ($envSetting->rollout_percentage < 100) {
            return $this->isInRollout($key, $userId, $envSetting->rollout_percentage);
        }

        return true;
    }

    /**
     * Determine if user/request is in rollout percentage
     */
    protected function isInRollout(string $key, ?int $userId, int $percentage): bool
    {
        if ($percentage <= 0) {
            return false;
        }
        
        if ($percentage >= 100) {
            return true;
        }

        // Use user ID for consistent rollout (same user always gets same result)
        // If no user, use session ID or IP address for consistency
        $identifier = $userId ?? $this->getRequestIdentifier();
        
        // Create a hash from flag key + identifier for deterministic rollout
        $hash = crc32($key . ':' . $identifier);
        $bucket = $hash % 100;
        
        return $bucket < $percentage;
    }

    /**
     * Get a consistent identifier for anonymous requests
     */
    protected function getRequestIdentifier(): string
    {
        // Try session ID first
        if (session()->getId()) {
            return session()->getId();
        }
        
        // Fallback to IP address
        return request()->ip() ?? 'default';
    }

    /**
     * Check if flag is disabled (opposite of isEnabled)
     */
    public function isDisabled(string $key, ?int $userId = null, ?string $environment = null): bool
    {
        return !$this->isEnabled($key, $userId, $environment);
    }

    /**
     * Get all enabled flags for current environment
     */
    public function getAllEnabled(?int $userId = null, ?string $environment = null): array
    {
        $environment = $environment ?? config('app.env');
        $flags = FeatureFlag::where('is_active', true)->get();
        
        $enabled = [];
        foreach ($flags as $flag) {
            if ($this->isEnabled($flag->key, $userId, $environment)) {
                $enabled[] = $flag->key;
            }
        }
        
        return $enabled;
    }

    /**
     * Force enable a flag for a specific user
     */
    public function enableForUser(string $key, int $userId): bool
    {
        $flag = FeatureFlag::where('key', $key)->first();
        
        if (!$flag) {
            return false;
        }

        FeatureUserOverride::updateOrCreate(
            [
                'feature_flag_id' => $flag->id,
                'user_id' => $userId
            ],
            [
                'is_enabled' => true
            ]
        );

        // Clear cache for this user
        $this->clearCacheForUser($key, $userId);
        
        return true;
    }

    /**
     * Force disable a flag for a specific user
     */
    public function disableForUser(string $key, int $userId): bool
    {
        $flag = FeatureFlag::where('key', $key)->first();
        
        if (!$flag) {
            return false;
        }

        FeatureUserOverride::updateOrCreate(
            [
                'feature_flag_id' => $flag->id,
                'user_id' => $userId
            ],
            [
                'is_enabled' => false
            ]
        );

        // Clear cache for this user
        $this->clearCacheForUser($key, $userId);
        
        return true;
    }

    /**
     * Remove user override (let environment settings take over)
     */
    public function removeUserOverride(string $key, int $userId): bool
    {
        $flag = FeatureFlag::where('key', $key)->first();
        
        if (!$flag) {
            return false;
        }

        FeatureUserOverride::where('feature_flag_id', $flag->id)
            ->where('user_id', $userId)
            ->delete();

        // Clear cache for this user
        $this->clearCacheForUser($key, $userId);
        
        return true;
    }

    /**
     * Clear all feature flag caches
     */
    public function clearAllCache(): void
    {
        Cache::flush();
        Log::info('All feature flag caches cleared');
    }

    /**
     * Clear cache for specific flag
     */
    public function clearCacheForFlag(string $key): void
    {
        $environments = ['local', 'development', 'staging', 'production'];
        
        foreach ($environments as $env) {
            Cache::forget($this->getCacheKey($key, null, $env));
        }
        
        Log::info("Cache cleared for flag: {$key}");
    }

    /**
     * Clear cache for specific user
     */
    protected function clearCacheForUser(string $key, int $userId): void
    {
        $environments = ['local', 'development', 'staging', 'production'];
        
        foreach ($environments as $env) {
            Cache::forget($this->getCacheKey($key, $userId, $env));
        }
    }

    /**
     * Generate cache key
     */
    protected function getCacheKey(string $key, ?int $userId, string $environment): string
    {
        $userPart = $userId ? "user:{$userId}" : 'global';
        return "{$this->cachePrefix}{$key}:{$environment}:{$userPart}";
    }

    /**
     * Get detailed flag information for debugging
     */
    public function getDebugInfo(string $key, ?int $userId = null): array
    {
        $environment = config('app.env');
        $flag = FeatureFlag::where('key', $key)->first();
        
        if (!$flag) {
            return ['error' => 'Flag not found'];
        }

        $envSetting = FeatureEnvironment::where('feature_flag_id', $flag->id)
            ->where('environment', $environment)
            ->first();

        $userOverride = null;
        if ($userId) {
            $userOverride = FeatureUserOverride::where('feature_flag_id', $flag->id)
                ->where('user_id', $userId)
                ->first();
        }

        return [
            'flag_key' => $key,
            'globally_active' => $flag->is_active,
            'environment' => $environment,
            'environment_enabled' => $envSetting ? $envSetting->is_enabled : null,
            'rollout_percentage' => $envSetting ? $envSetting->rollout_percentage : null,
            'user_override' => $userOverride ? $userOverride->is_enabled : null,
            'final_result' => $this->isEnabled($key, $userId),
            'user_id' => $userId,
            'request_identifier' => $this->getRequestIdentifier()
        ];
    }
}