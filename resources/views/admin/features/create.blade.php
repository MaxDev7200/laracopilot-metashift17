@extends('layouts.admin')

@section('title', 'Create Feature Flag')
@section('page-title', 'Create Feature Flag')

@section('content')
<div class="max-w-4xl">
    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('admin.features.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center">
            <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
            </svg>
            Back to Feature Flags
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.features.store') }}" method="POST">
            @csrf

            <!-- Basic Information Section -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    Basic Information
                </h3>

                <!-- Flag Key -->
                <div class="mb-4">
                    <label for="key" class="block text-sm font-bold text-gray-700 mb-2">Flag Key *</label>
                    <input 
                        type="text" 
                        name="key" 
                        id="key" 
                        value="{{ old('key') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono @error('key') border-red-500 @enderror" 
                        placeholder="new_feature_name"
                        required
                    >
                    <p class="text-xs text-gray-500 mt-1">Unique identifier (use snake_case, e.g., dark_mode, new_dashboard)</p>
                    @error('key')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Flag Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Display Name *</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-500 @enderror" 
                        placeholder="New Feature Name"
                        required
                    >
                    <p class="text-xs text-gray-500 mt-1">Human-readable name shown in admin panel</p>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                    <textarea 
                        name="description" 
                        id="description" 
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('description') border-red-500 @enderror" 
                        placeholder="Describe what this feature does and when to use it..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Global Active Toggle -->
                <div class="mb-4">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <span class="ml-3 text-sm font-bold text-gray-700">Globally Active</span>
                    </label>
                    <p class="text-xs text-gray-500 mt-1 ml-8">Master switch - flag must be active to work in any environment</p>
                </div>
            </div>

            <hr class="my-8">

            <!-- Environment Settings Section -->
            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd"></path>
                    </svg>
                    Environment Settings
                </h3>
                <p class="text-sm text-gray-600 mb-6">Configure how this flag behaves in each environment</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($environments as $env)
                        <div class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 transition duration-200">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-bold text-gray-800 capitalize flex items-center">
                                    @if($env === 'local')
                                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                                    @elseif($env === 'development')
                                        <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                    @elseif($env === 'staging')
                                        <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                                    @else
                                        <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                    @endif
                                    {{ ucfirst($env) }}
                                </h4>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="env_{{ $env }}_enabled" value="1" {{ old('env_' . $env . '_enabled', $env === 'local' || $env === 'development') ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                </label>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-2">Rollout Percentage</label>
                                <div class="flex items-center space-x-3">
                                    <input 
                                        type="range" 
                                        name="env_{{ $env }}_percentage" 
                                        min="0" 
                                        max="100" 
                                        step="5" 
                                        value="{{ old('env_' . $env . '_percentage', 100) }}"
                                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                                        oninput="document.getElementById('{{ $env }}_value').textContent = this.value + '%'"
                                    >
                                    <span id="{{ $env }}_value" class="text-sm font-bold text-indigo-600 min-w-[45px] text-right">{{ old('env_' . $env . '_percentage', 100) }}%</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Percentage of users who will see this feature</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.features.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition duration-300">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition duration-300 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    Create Feature Flag
                </button>
            </div>
        </form>
    </div>

    <!-- Helper Info -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-2">Usage in Code:</p>
                <code class="bg-blue-100 px-2 py-1 rounded">feature('your_flag_key')</code> - PHP helper<br>
                <code class="bg-blue-100 px-2 py-1 rounded mt-1 inline-block">@feature('your_flag_key') ... @endfeature</code> - Blade directive
            </div>
        </div>
    </div>
</div>
@endsection
