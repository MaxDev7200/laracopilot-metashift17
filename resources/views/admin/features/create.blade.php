@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800">Create New Feature Flag</h1>
    <p class="text-gray-600 mt-2">Add a new feature flag with environment-specific settings</p>
</div>

<div class="bg-white rounded-lg shadow-lg p-8 max-w-3xl">
    <form action="{{ route('admin.flags.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Flag Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" 
                class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" 
                placeholder="e.g., New Dashboard" required>
            @error('name')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
            <p class="text-sm text-gray-500 mt-1">A human-readable name for the feature</p>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Flag Key *</label>
            <input type="text" name="key" value="{{ old('key') }}" 
                class="w-full border rounded-lg px-4 py-3 font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 @error('key') border-red-500 @enderror" 
                placeholder="e.g., new_dashboard" required>
            @error('key')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
            <p class="text-sm text-gray-500 mt-1">Unique identifier used in code (lowercase, underscores only)</p>
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea name="description" rows="4" 
                class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('description') border-red-500 @enderror" 
                placeholder="Describe what this feature flag controls...">{{ old('description') }}</textarea>
            @error('description')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>
        
        <div class="mb-8">
            <label class="flex items-center">
                <input type="checkbox" name="enabled" value="1" {{ old('enabled') ? 'checked' : '' }} 
                    class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-3 text-gray-700 font-bold">Enable this flag globally</span>
            </label>
            <p class="text-sm text-gray-500 mt-2 ml-8">This sets the default state across all environments</p>
        </div>
        
        <div class="border-t pt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Environment Settings</h3>
            <p class="text-sm text-gray-600 mb-6">Configure flag behavior for each environment</p>
            
            @foreach(['development', 'staging', 'production'] as $env)
            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="font-bold text-gray-800 capitalize">{{ $env }}</h4>
                    <label class="flex items-center">
                        <input type="checkbox" name="environments[{{ $env }}][enabled]" value="1" 
                            {{ $env === 'development' ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Enabled</span>
                    </label>
                </div>
                
                <div>
                    <label class="block text-sm text-gray-700 mb-2">Rollout Percentage</label>
                    <div class="flex items-center">
                        <input type="range" name="environments[{{ $env }}][rollout_percentage]" 
                            min="0" max="100" value="{{ $env === 'production' ? '50' : '100' }}" 
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                            oninput="this.nextElementSibling.value = this.value + '%'">
                        <output class="ml-3 text-sm font-semibold text-gray-700 w-12">{{ $env === 'production' ? '50%' : '100%' }}</output>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Percentage of users who will see this feature</p>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="flex justify-end space-x-4 mt-8 pt-6 border-t">
            <a href="{{ route('admin.flags.index') }}" 
                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-3 rounded-lg transition font-semibold">
                Cancel
            </a>
            <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition font-semibold">
                Create Feature Flag
            </button>
        </div>
    </form>
</div>
@endsection
