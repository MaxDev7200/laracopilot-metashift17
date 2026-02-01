@extends('layouts.admin')

@section('title', 'Feature Flags')
@section('page-title', 'Feature Flags')

@section('content')
<!-- Header Actions -->
<div class="flex justify-between items-center mb-6">
    <div>
        <p class="text-gray-600">Manage feature flags across all environments</p>
    </div>
    <a href="{{ route('admin.features.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300 flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
        </svg>
        Create New Flag
    </a>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    @php
        $currentEnv = config('app.env');
        $totalFlags = $flags->count();
        $activeFlags = $flags->where('is_active', true)->count();
        $enabledInEnv = $flags->filter(function($flag) use ($currentEnv) {
            $envSetting = $flag->environments->where('environment', $currentEnv)->first();
            return $envSetting && $envSetting->is_enabled;
        })->count();
        $partialRollout = $flags->filter(function($flag) use ($currentEnv) {
            $envSetting = $flag->environments->where('environment', $currentEnv)->first();
            return $envSetting && $envSetting->is_enabled && $envSetting->rollout_percentage < 100;
        })->count();
    @endphp

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <div class="text-gray-500 text-sm font-semibold">Total Flags</div>
        <div class="text-3xl font-bold text-gray-800 mt-2">{{ $totalFlags }}</div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <div class="text-gray-500 text-sm font-semibold">Globally Active</div>
        <div class="text-3xl font-bold text-gray-800 mt-2">{{ $activeFlags }}</div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
        <div class="text-gray-500 text-sm font-semibold">Enabled in {{ ucfirst($currentEnv) }}</div>
        <div class="text-3xl font-bold text-gray-800 mt-2">{{ $enabledInEnv }}</div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
        <div class="text-gray-500 text-sm font-semibold">Partial Rollout</div>
        <div class="text-3xl font-bold text-gray-800 mt-2">{{ $partialRollout }}</div>
    </div>
</div>

<!-- Feature Flags Table -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    @if($flags->isEmpty())
        <div class="p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">No Feature Flags Yet</h3>
            <p class="text-gray-500 mb-6">Get started by creating your first feature flag</p>
            <a href="{{ route('admin.features.create') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                Create Your First Flag
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Flag Details</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Global Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Environment Status</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($flags as $flag)
                        @php
                            $envSettings = $flag->environments->keyBy('environment');
                        @endphp
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $flag->name }}</div>
                                        <div class="text-xs font-mono text-gray-500 mt-1">{{ $flag->key }}</div>
                                        @if($flag->description)
                                            <div class="text-xs text-gray-600 mt-1">{{ Str::limit($flag->description, 60) }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.features.toggle', $flag->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="relative inline-flex items-center">
                                        <div class="relative inline-block w-14 h-7 rounded-full transition duration-200 {{ $flag->is_active ? 'bg-green-500' : 'bg-gray-300' }}">
                                            <div class="absolute left-1 top-1 w-5 h-5 bg-white rounded-full transition-transform duration-200 {{ $flag->is_active ? 'transform translate-x-7' : '' }}"></div>
                                        </div>
                                        <span class="ml-3 text-sm font-semibold {{ $flag->is_active ? 'text-green-600' : 'text-gray-500' }}">
                                            {{ $flag->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach(['local', 'development', 'staging', 'production'] as $env)
                                        @php
                                            $setting = $envSettings->get($env);
                                            $isEnabled = $setting && $setting->is_enabled;
                                            $percentage = $setting ? $setting->rollout_percentage : 0;
                                        @endphp
                                        <div class="flex items-center space-x-1">
                                            <span class="text-xs font-semibold text-gray-600">{{ substr($env, 0, 3) }}:</span>
                                            @if($isEnabled)
                                                <span class="px-2 py-1 text-xs font-bold rounded bg-green-100 text-green-700">{{ $percentage }}%</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-bold rounded bg-gray-100 text-gray-500">OFF</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end items-center space-x-3">
                                    <a href="{{ route('admin.features.edit', $flag->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold text-sm transition duration-150">
                                        <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.features.destroy', $flag->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this flag? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold text-sm transition duration-150">
                                            <svg class="w-5 h-5 inline" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Environment Legend -->
<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <div class="flex items-start">
        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
        </svg>
        <div class="text-sm text-blue-800">
            <p class="font-semibold mb-1">Environment Abbreviations:</p>
            <p><strong>loc</strong> = local, <strong>dev</strong> = development, <strong>sta</strong> = staging, <strong>pro</strong> = production</p>
            <p class="mt-1">Percentages show rollout rates. <strong>OFF</strong> means disabled in that environment.</p>
        </div>
    </div>
</div>
@endsection
