@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- KPI Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    @php
        $totalFlags = \App\Models\FeatureFlag::count();
        $activeFlags = \App\Models\FeatureFlag::where('is_active', true)->count();
        $currentEnv = config('app.env');
        $enabledInEnv = \App\Models\FeatureFlag::whereHas('environments', function($q) use ($currentEnv) {
            $q->where('environment', $currentEnv)->where('is_enabled', true);
        })->count();
        $totalUsers = \App\Models\User::count();
    @endphp

    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-semibold">Total Flags</p>
                <p class="text-4xl font-bold mt-2">{{ $totalFlags }}</p>
            </div>
            <div class="bg-blue-400 bg-opacity-50 rounded-full p-4">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-semibold">Globally Active</p>
                <p class="text-4xl font-bold mt-2">{{ $activeFlags }}</p>
            </div>
            <div class="bg-green-400 bg-opacity-50 rounded-full p-4">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-semibold">Enabled in {{ ucfirst($currentEnv) }}</p>
                <p class="text-4xl font-bold mt-2">{{ $enabledInEnv }}</p>
            </div>
            <div class="bg-purple-400 bg-opacity-50 rounded-full p-4">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-indigo-100 text-sm font-semibold">Total Users</p>
                <p class="text-4xl font-bold mt-2">{{ $totalUsers }}</p>
            </div>
            <div class="bg-indigo-400 bg-opacity-50 rounded-full p-4">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-lg p-6 mb-8">
    <h3 class="text-xl font-bold mb-4 text-gray-800">Quick Actions</h3>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.features.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
            </svg>
            Create New Flag
        </a>
        <a href="{{ route('admin.features.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-300 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
            </svg>
            Manage Flags
        </a>
        <a href="{{ route('debug') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition duration-300 flex items-center" target="_blank">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            Debug Panel
        </a>
    </div>
</div>

<!-- Recent Flags -->
<div class="bg-white rounded-xl shadow-lg p-6">
    <h3 class="text-xl font-bold mb-4 text-gray-800">Recent Feature Flags</h3>
    @php
        $recentFlags = \App\Models\FeatureFlag::with('environments')->orderBy('created_at', 'desc')->limit(5)->get();
    @endphp

    @if($recentFlags->isEmpty())
        <p class="text-gray-500">No feature flags yet. <a href="{{ route('admin.features.create') }}" class="text-indigo-600 hover:underline">Create your first one</a></p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Flag</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Environment</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentFlags as $flag)
                        @php
                            $envSetting = $flag->environments->where('environment', $currentEnv)->first();
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $flag->name }}</div>
                                <div class="text-sm text-gray-500 font-mono">{{ $flag->key }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($flag->is_active)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($envSetting && $envSetting->is_enabled)
                                    <span class="text-sm text-green-600">✓ Enabled ({{ $envSetting->rollout_percentage }}%)</span>
                                @else
                                    <span class="text-sm text-gray-500">Disabled</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('admin.features.edit', $flag->id) }}" class="text-indigo-600 hover:underline">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
