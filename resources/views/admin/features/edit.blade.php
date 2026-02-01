@extends('layouts.admin')

@section('title', 'Edit Feature Flag')
@section('page-title', 'Edit Feature Flag')

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
        <form action="{{ route('admin.features.update', $flag->id) }}" method="POST">
            @csrf
            @method('PUT')

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
                        value="{{ old('key', $flag->key) }}"
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
                        value="{{ old('name', $flag->name) }}"
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
                    >{{ old('description', $flag->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Global Active Toggle -->
                <div class="mb-4">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $flag->is_active) ? 'checked' : '' }} class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
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

                @php
                    $envSettings = $flag->environments->keyBy('environment');
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($environments as $env)
                        @php
                            $setting = $envSettings->get($env);
                        @endphp
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
                                    <input type="checkbox" name="env_{{ $env }}_enabled" value="1" {{ old('env_' . $env . '_enabled', $setting ? $setting->is_enabled : false) ? 'checked' : '' }} class="sr-only peer">
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
                                        value="{{ old('env_' . $env . '_percentage', $setting ? $setting->rollout_percentage : 100) }}"
                                        class="flex-1 h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer slider"
                                        oninput="document.getElementById('{{ $env }}_value').textContent = this.value + '%'"
                                    >
                                    <span id="{{ $env }}_value" class="text-sm font-bold text-indigo-600 min-w-[45px] text-right">{{ old('env_' . $env . '_percentage', $setting ? $setting->rollout_percentage : 100) }}%</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Percentage of users who will see this feature</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <form action="{{ route('admin.features.destroy', $flag->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this feature flag? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 border border-red-300 text-red-600 rounded-lg font-semibold hover:bg-red-50 transition duration-300 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        Delete Flag
                    </button>
                </form>

                <div class="flex space-x-4">
                    <a href="{{ route('admin.features.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition duration-300">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition duration-300 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        Update Feature Flag
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Flag Stats -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-indigo-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <div class="text-xs text-gray-500 font-semibold">Created</div>
                    <div class="text-sm text-gray-800">{{ $flag->created_at->format('M d, Y g:i A') }}</div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-8 h-8 text-purple-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <div class="text-xs text-gray-500 font-semibold">Last Updated</div>
                    <div class="text-sm text-gray-800">{{ $flag->updated_at->format('M d, Y g:i A') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Helper Info -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
            </svg>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-2">Usage in Code:</p>
                <code class="bg-blue-100 px-2 py-1 rounded">feature('{{ $flag->key }}')</code> - PHP helper<br>
                <code class="bg-blue-100 px-2 py-1 rounded mt-1 inline-block">@feature('{{ $flag->key }}') ... @endfeature</code> - Blade directive<br>
                <code class="bg-blue-100 px-2 py-1 rounded mt-1 inline-block">Feature::isEnabled('{{ $flag->key }}')</code> - Facade
            </div>
        </div>
    </div>
</div>
@endsection
