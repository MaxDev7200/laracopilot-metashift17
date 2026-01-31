<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Services\FeatureFlagService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register FeatureFlagService as singleton
        $this->app->singleton('feature-flag-service', function ($app) {
            return new FeatureFlagService();
        });

        $this->app->singleton(FeatureFlagService::class, function ($app) {
            return $app->make('feature-flag-service');
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register custom Blade directives for feature flags
        
        // @feature('flag_key')
        Blade::directive('feature', function ($expression) {
            return "<?php if(app('feature-flag-service')->isEnabled({$expression})): ?>";
        });

        // @endfeature
        Blade::directive('endfeature', function () {
            return '<?php endif; ?>';
        });

        // @featureelse('flag_key')
        Blade::directive('featureelse', function ($expression) {
            return "<?php if(app('feature-flag-service')->isEnabled({$expression})): ?>";
        });

        // @notfeature('flag_key')
        Blade::directive('notfeature', function ($expression) {
            return "<?php if(app('feature-flag-service')->isDisabled({$expression})): ?>";
        });

        // @endnotfeature
        Blade::directive('endnotfeature', function () {
            return '<?php endif; ?>';
        });

        // @featureforuser('flag_key', $userId)
        Blade::directive('featureforuser', function ($expression) {
            return "<?php if(app('feature-flag-service')->isEnabled({$expression})): ?>";
        });

        // @endfeatureforuser
        Blade::directive('endfeatureforuser', function () {
            return '<?php endif; ?>';
        });
    }
}