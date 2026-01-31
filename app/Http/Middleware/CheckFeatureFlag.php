<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\FeatureFlagService;
use Symfony\Component\HttpFoundation\Response;

class CheckFeatureFlag
{
    protected $featureFlagService;

    public function __construct(FeatureFlagService $featureFlagService)
    {
        $this->featureFlagService = $featureFlagService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $flagKey): Response
    {
        $userId = auth()->id();
        
        if (!$this->featureFlagService->isEnabled($flagKey, $userId)) {
            abort(403, "Feature '{$flagKey}' is not available.");
        }

        return $next($request);
    }
}