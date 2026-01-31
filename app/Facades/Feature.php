<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isEnabled(string $key, ?int $userId = null, ?string $environment = null)
 * @method static bool isDisabled(string $key, ?int $userId = null, ?string $environment = null)
 * @method static array getAllEnabled(?int $userId = null, ?string $environment = null)
 * @method static bool enableForUser(string $key, int $userId)
 * @method static bool disableForUser(string $key, int $userId)
 * @method static bool removeUserOverride(string $key, int $userId)
 * @method static void clearAllCache()
 * @method static void clearCacheForFlag(string $key)
 * @method static array getDebugInfo(string $key, ?int $userId = null)
 * 
 * @see \App\Services\FeatureFlagService
 */
class Feature extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'feature-flag-service';
    }
}