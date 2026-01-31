<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureFlag;
use App\Models\FeatureEnvironment;
use App\Models\FeatureUserOverride;
use App\Models\User;
use App\Services\FeatureFlagService;
use App\Enums\FeatureFlagStatus;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FeatureFlagController extends Controller
{
    use AuthorizesRequests;

    public function __construct(
        private FeatureFlagService $featureFlagService
    ) {}

    public function index()
    {
        $this->authorize('viewAny', FeatureFlag::class);

        $flags = FeatureFlag::with(['environments', 'userOverrides.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.feature-flags.index', compact('flags'));
    }

    public function create()
    {
        $this->authorize('create', FeatureFlag::class);
        
        return view('admin.feature-flags.create', [
            'environments' => ['development', 'staging', 'production'],
            'statuses' => FeatureFlagStatus::cases(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', FeatureFlag::class);

        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:feature_flags',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,archived',
            'global_enabled' => 'boolean',
            'percentage_rollout' => 'integer|min:0|max:100',
            'environments' => 'array',
            'environments.*' => 'boolean',
        ]);

        $flag = $this->featureFlagService->createFlag([
            ...$validated,
            'created_by' => auth()->id(),
        ]);

        if ($request->has('environments')) {
            foreach ($request->environments as $env => $enabled) {
                FeatureEnvironment::create([
                    'feature_flag_id' => $flag->id,
                    'environment' => $env,
                    'enabled' => (bool) $enabled,
                ]);
            }
        }

        return redirect()->route('admin.feature-flags.index')
            ->with('success', 'Feature flag created successfully.');
    }

    public function show(FeatureFlag $featureFlag)
    {
        $this->authorize('view', $featureFlag);

        $featureFlag->load(['environments', 'userOverrides.user']);
        
        return view('admin.feature-flags.show', compact('featureFlag'));
    }

    public function edit(FeatureFlag $featureFlag)
    {
        $this->authorize('update', $featureFlag);

        $featureFlag->load('environments');
        
        return view('admin.feature-flags.edit', [
            'featureFlag' => $featureFlag,
            'environments' => ['development', 'staging', 'production'],
            'statuses' => FeatureFlagStatus::cases(),
        ]);
    }

    public function update(Request $request, FeatureFlag $featureFlag)
    {
        $this->authorize('update', $featureFlag);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive,archived',
            'global_enabled' => 'boolean',
            'percentage_rollout' => 'integer|min:0|max:100',
            'environments' => 'array',
            'environments.*' => 'boolean',
        ]);

        $this->featureFlagService->updateFlag($featureFlag, $validated);

        if ($request->has('environments')) {
            foreach ($request->environments as $env => $enabled) {
                FeatureEnvironment::updateOrCreate(
                    [
                        'feature_flag_id' => $featureFlag->id,
                        'environment' => $env,
                    ],
                    ['enabled' => (bool) $enabled]
                );
            }
        }

        return redirect()->route('admin.feature-flags.index')
            ->with('success', 'Feature flag updated successfully.');
    }

    public function destroy(FeatureFlag $featureFlag)
    {
        $this->authorize('delete', $featureFlag);

        $this->featureFlagService->deleteFlag($featureFlag);

        return redirect()->route('admin.feature-flags.index')
            ->with('success', 'Feature flag deleted successfully.');
    }

    public function overrides(FeatureFlag $featureFlag)
    {
        $this->authorize('manageOverrides', $featureFlag);

        $overrides = $featureFlag->userOverrides()->with('user')->paginate(20);
        $users = User::select('id', 'name', 'email')->get();

        return view('admin.feature-flags.overrides', compact('featureFlag', 'overrides', 'users'));
    }

    public function storeOverride(Request $request, FeatureFlag $featureFlag)
    {
        $this->authorize('manageOverrides', $featureFlag);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'enabled' => 'required|boolean',
        ]);

        FeatureUserOverride::updateOrCreate(
            [
                'feature_flag_id' => $featureFlag->id,
                'user_id' => $validated['user_id'],
            ],
            ['enabled' => $validated['enabled']]
        );

        $this->featureFlagService->clearCache($featureFlag->key);

        return redirect()->back()->with('success', 'User override created successfully.');
    }

    public function destroyOverride(FeatureFlag $featureFlag, FeatureUserOverride $override)
    {
        $this->authorize('manageOverrides', $featureFlag);

        $override->delete();
        $this->featureFlagService->clearCache($featureFlag->key);

        return redirect()->back()->with('success', 'User override removed successfully.');
    }
}