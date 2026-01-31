<?php

namespace App\Http\Controllers;

use App\Models\FeatureFlag;
use App\Models\FeatureEnvironment;
use Illuminate\Http\Request;

class FeatureFlagController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $flags = FeatureFlag::with('environments')->orderBy('created_at', 'desc')->paginate(15);
        
        // Dashboard view uses this same method
        if (request()->routeIs('admin.dashboard')) {
            $totalFlags = FeatureFlag::count();
            $enabledFlags = FeatureFlag::where('enabled', true)->count();
            $disabledFlags = FeatureFlag::where('enabled', false)->count();
            $recentFlags = FeatureFlag::with('environments')->orderBy('created_at', 'desc')->limit(10)->get();
            
            return view('admin.dashboard', compact('totalFlags', 'enabledFlags', 'disabledFlags', 'recentFlags'));
        }
        
        return view('admin.features.index', compact('flags'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.features.create');
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:feature_flags,key',
            'description' => 'nullable|string',
            'enabled' => 'nullable|boolean',
        ]);

        $validated['enabled'] = $request->has('enabled');

        $flag = FeatureFlag::create($validated);

        // Create environment settings
        $environments = $request->input('environments', []);
        foreach (['development', 'staging', 'production'] as $env) {
            FeatureEnvironment::create([
                'feature_flag_id' => $flag->id,
                'environment' => $env,
                'enabled' => isset($environments[$env]['enabled']),
                'rollout_percentage' => $environments[$env]['rollout_percentage'] ?? 100,
            ]);
        }

        return redirect()->route('admin.flags.index')->with('success', 'Feature flag created successfully!');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $flag = FeatureFlag::with('environments')->findOrFail($id);
        return view('admin.features.edit', compact('flag'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $flag = FeatureFlag::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:255|unique:feature_flags,key,' . $id,
            'description' => 'nullable|string',
            'enabled' => 'nullable|boolean',
        ]);

        $validated['enabled'] = $request->has('enabled');

        $flag->update($validated);

        // Update environment settings
        $environments = $request->input('environments', []);
        foreach ($flag->environments as $env) {
            $env->update([
                'enabled' => isset($environments[$env->environment]['enabled']),
                'rollout_percentage' => $environments[$env->environment]['rollout_percentage'] ?? 100,
            ]);
        }

        return redirect()->route('admin.flags.index')->with('success', 'Feature flag updated successfully!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $flag = FeatureFlag::findOrFail($id);
        $flag->delete();

        return redirect()->route('admin.flags.index')->with('success', 'Feature flag deleted successfully!');
    }

    public function toggle($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $flag = FeatureFlag::findOrFail($id);
        $flag->enabled = !$flag->enabled;
        $flag->save();

        return redirect()->back()->with('success', 'Feature flag toggled successfully!');
    }
}