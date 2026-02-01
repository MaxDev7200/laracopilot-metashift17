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

        $flags = FeatureFlag::with('environments')->orderBy('created_at', 'desc')->get();
        return view('admin.features.index', compact('flags'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $environments = ['local', 'development', 'staging', 'production'];
        return view('admin.features.create', compact('environments'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:feature_flags,key',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $flag = FeatureFlag::create($validated);

        // Create environment settings
        $environments = ['local', 'development', 'staging', 'production'];
        foreach ($environments as $env) {
            FeatureEnvironment::create([
                'feature_flag_id' => $flag->id,
                'environment' => $env,
                'is_enabled' => $request->input("env_{$env}_enabled", false),
                'rollout_percentage' => $request->input("env_{$env}_percentage", 100)
            ]);
        }

        return redirect()->route('admin.features.index')->with('success', 'Feature flag created successfully!');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $flag = FeatureFlag::with('environments')->findOrFail($id);
        $environments = ['local', 'development', 'staging', 'production'];
        return view('admin.features.edit', compact('flag', 'environments'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $flag = FeatureFlag::findOrFail($id);

        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:feature_flags,key,' . $id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $flag->update($validated);

        // Update environment settings
        $environments = ['local', 'development', 'staging', 'production'];
        foreach ($environments as $env) {
            FeatureEnvironment::updateOrCreate(
                [
                    'feature_flag_id' => $flag->id,
                    'environment' => $env
                ],
                [
                    'is_enabled' => $request->input("env_{$env}_enabled", false),
                    'rollout_percentage' => $request->input("env_{$env}_percentage", 100)
                ]
            );
        }

        // Clear cache for this flag
        app(\App\Services\FeatureFlagService::class)->clearCacheForFlag($flag->key);

        return redirect()->route('admin.features.index')->with('success', 'Feature flag updated successfully!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $flag = FeatureFlag::findOrFail($id);
        $flagKey = $flag->key;
        
        $flag->delete();

        // Clear cache for this flag
        app(\App\Services\FeatureFlagService::class)->clearCacheForFlag($flagKey);

        return redirect()->route('admin.features.index')->with('success', 'Feature flag deleted successfully!');
    }

    public function toggle($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $flag = FeatureFlag::findOrFail($id);
        $flag->is_active = !$flag->is_active;
        $flag->save();

        // Clear cache for this flag
        app(\App\Services\FeatureFlagService::class)->clearCacheForFlag($flag->key);

        return redirect()->back()->with('success', 'Feature flag toggled successfully!');
    }
}