@extends('layouts.app')

@section('title', 'Debug - Feature Flag Manager')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Feature Flag Debug Panel</h1>
        <p class="text-gray-600 mb-8">View all feature flags and their current status in the <span class="font-semibold text-indigo-600">{{ config('app.env') }}</span> environment.</p>

        @php
            $flags = \App\Models\FeatureFlag::with('environments')->get();
            $currentEnv = config('app.env');
        @endphp

        @if($flags->isEmpty())
            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-6 py-4 rounded-lg">
                <p class="font-semibold">No feature flags found</p>
                <p class="text-sm mt-1">Run <code class="bg-yellow-100 px-2 py-1 rounded">php artisan db:seed</code> to create sample flags</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Flag Key</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Global Active</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ ucfirst($currentEnv) }} Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rollout %</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Final Result</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($flags as $flag)
                            @php
                                $envSetting = $flag->environments->where('environment', $currentEnv)->first();
                                $isEnabled = feature($flag->key);
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">{{ $flag->key }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $flag->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($flag->is_active)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($envSetting && $envSetting->is_enabled)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Enabled</span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">Disabled</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $envSetting ? $envSetting->rollout_percentage : 0 }}%
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($isEnabled)
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-500 text-white">✓ ENABLED</span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-500 text-white">✗ DISABLED</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Summary Stats -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-6">
                    <div class="text-sm text-indigo-600 font-semibold">Total Flags</div>
                    <div class="text-3xl font-bold text-indigo-900 mt-2">{{ $flags->count() }}</div>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                    <div class="text-sm text-green-600 font-semibold">Currently Enabled</div>
                    <div class="text-3xl font-bold text-green-900 mt-2">{{ $flags->filter(fn($f) => feature($f->key))->count() }}</div>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                    <div class="text-sm text-purple-600 font-semibold">Environment</div>
                    <div class="text-3xl font-bold text-purple-900 mt-2">{{ ucfirst($currentEnv) }}</div>
                </div>
            </div>

            <!-- Test Commands -->
            <div class="mt-8 bg-gray-50 border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Test Commands</h3>
                <div class="space-y-2 text-sm">
                    <p><code class="bg-gray-800 text-green-400 px-3 py-1 rounded">php artisan feature:list</code> - List all flags</p>
                    <p><code class="bg-gray-800 text-green-400 px-3 py-1 rounded">php artisan feature:check flag_key</code> - Check specific flag</p>
                    <p><code class="bg-gray-800 text-green-400 px-3 py-1 rounded">php artisan feature:enable flag_key userId</code> - Enable for user</p>
                    <p><code class="bg-gray-800 text-green-400 px-3 py-1 rounded">php artisan feature:cache:clear</code> - Clear cache</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
