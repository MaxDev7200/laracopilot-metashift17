<?php

namespace App\Http\Controllers;

use App\Models\FeatureFlag;
use App\Models\FeatureEnvironment;
use Illuminate\Http\Request;

class FeatureFlagController extends Controller
{
    public function dashboard()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $totalFeatures = FeatureFlag::count();
        $enabledFeatures = FeatureFlag::where('is_enabled', true)->count();
        $disabledFeatures = FeatureFlag::where('is_enabled', false)->count();
        $totalEnvironments = FeatureEnvironment::count();
        
        $recentFeatures = FeatureFlag::with('environments')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalFeatures',
            'enabledFeatures',
            'disabledFeatures',
            'totalEnvironments',
            'recentFeatures'
        ));
    }
    
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $features = FeatureFlag::with('environments')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.features.index', compact('features'));
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
            'name' => 'required|string|max:255|unique:feature_flags',
            'key' => 'required|string|max:255|unique:feature_flags',
            'description' => 'nullable|string',
            'is_enabled' => 'boolean'
        ]);
        
        $validated['is_enabled'] = $request->has('is_enabled');
        
        FeatureFlag::create($validated);
        
        return redirect()->route('admin.features.index')
            ->with('success', 'Feature flag created successfully!');
    }
    
    public function edit($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $feature = FeatureFlag::findOrFail($id);
        return view('admin.features.edit', compact('feature'));
    }
    
    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $feature = FeatureFlag::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:feature_flags,name,' . $id,
            'key' => 'required|string|max:255|unique:feature_flags,key,' . $id,
            'description' => 'nullable|string',
            'is_enabled' => 'boolean'
        ]);
        
        $validated['is_enabled'] = $request->has('is_enabled');
        
        $feature->update($validated);
        
        return redirect()->route('admin.features.index')
            ->with('success', 'Feature flag updated successfully!');
    }
    
    public function destroy($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        FeatureFlag::findOrFail($id)->delete();
        
        return redirect()->route('admin.features.index')
            ->with('success', 'Feature flag deleted successfully!');
    }
    
    public function toggle($id)
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }
        
        $feature = FeatureFlag::findOrFail($id);
        $feature->is_enabled = !$feature->is_enabled;
        $feature->save();
        
        return redirect()->route('admin.features.index')
            ->with('success', 'Feature flag toggled successfully!');
    }
}