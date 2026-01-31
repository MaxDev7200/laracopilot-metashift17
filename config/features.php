<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Feature Flag Cache TTL
    |--------------------------------------------------------------------------
    |
    | The time-to-live (in seconds) for feature flag cache entries.
    | Default: 3600 (1 hour)
    |
    */

    'cache_ttl' => env('FEATURE_FLAG_CACHE_TTL', 3600),

    /*
    |--------------------------------------------------------------------------
    | Feature Flag Cache Prefix
    |--------------------------------------------------------------------------
    |
    | The prefix used for all feature flag cache keys.
    |
    */

    'cache_prefix' => env('FEATURE_FLAG_CACHE_PREFIX', 'feature_flag:'),

    /*
    |--------------------------------------------------------------------------
    | Default Environment
    |--------------------------------------------------------------------------
    |
    | The default environment to use when checking feature flags.
    | Usually matches APP_ENV.
    |
    */

    'default_environment' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Supported Environments
    |--------------------------------------------------------------------------
    |
    | List of environments that can have feature flag settings.
    |
    */

    'environments' => [
        'local',
        'development',
        'staging',
        'production',
    ],

    /*
    |--------------------------------------------------------------------------
    | Enable Logging
    |--------------------------------------------------------------------------
    |
    | Log feature flag checks and changes for debugging.
    |
    */

    'enable_logging' => env('FEATURE_FLAG_LOGGING', false),

    /*
    |--------------------------------------------------------------------------
    | Default Rollout Percentage
    |--------------------------------------------------------------------------
    |
    | Default percentage for gradual rollouts when creating new flags.
    |
    */

    'default_rollout_percentage' => 100,

];