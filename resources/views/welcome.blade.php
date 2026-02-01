@extends('layouts.app')

@section('title', 'Home - Feature Flag Manager')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white">
    <div class="max-w-7xl mx-auto px-4 py-20 text-center">
        <h1 class="text-5xl font-bold mb-6">Feature Flag Manager</h1>
        <p class="text-xl mb-8 text-indigo-100">Control feature rollouts across environments with confidence and precision</p>
        <div class="flex justify-center space-x-4">
            <a href="{{ route('admin.login') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-bold text-lg hover:bg-gray-100 transition duration-300 transform hover:scale-105">
                Get Started
            </a>
            <a href="{{ route('debug') }}" class="bg-indigo-500 text-white px-8 py-3 rounded-lg font-bold text-lg hover:bg-indigo-400 transition duration-300 transform hover:scale-105">
                View Demo
            </a>
        </div>
    </div>
</div>

<!-- Features Grid -->
<div class="max-w-7xl mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Powerful Feature Management</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Feature 1 -->
        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition duration-300">
            <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">Environment Control</h3>
            <p class="text-gray-600">Configure different flag states for local, staging, and production environments independently.</p>
        </div>

        <!-- Feature 2 -->
        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition duration-300">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">Gradual Rollouts</h3>
            <p class="text-gray-600">Roll out features to a percentage of users with deterministic distribution algorithms.</p>
        </div>

        <!-- Feature 3 -->
        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition duration-300">
            <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">User Overrides</h3>
            <p class="text-gray-600">Enable or disable features for specific users, overriding environment settings.</p>
        </div>

        <!-- Feature 4 -->
        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition duration-300">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">Real-time Toggle</h3>
            <p class="text-gray-600">Enable or disable features instantly without deploying new code.</p>
        </div>

        <!-- Feature 5 -->
        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition duration-300">
            <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11 4a1 1 0 10-2 0v4a1 1 0 102 0V7zm-3 1a1 1 0 10-2 0v3a1 1 0 102 0V8zM8 9a1 1 0 00-2 0v2a1 1 0 102 0V9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">Performance Cached</h3>
            <p class="text-gray-600">Built-in caching layer ensures fast flag checks with minimal database queries.</p>
        </div>

        <!-- Feature 6 -->
        <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition duration-300">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3.293 1.293a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414-1.414L7.586 10 5.293 7.707a1 1 0 010-1.414zM11 12a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">Developer Friendly</h3>
            <p class="text-gray-600">Simple API with helpers, Blade directives, facades, and Artisan commands.</p>
        </div>
    </div>
</div>

<!-- Code Examples Section -->
<div class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Simple to Use</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- PHP Example -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800">In Controllers</h3>
                <pre class="bg-gray-900 text-green-400 p-4 rounded-lg overflow-x-auto text-sm"><code>if (feature('dark_mode')) {
    return view('dashboard.dark');
} else {
    return view('dashboard.light');
}</code></pre>
            </div>

            <!-- Blade Example -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800">In Blade Templates</h3>
                <pre class="bg-gray-900 text-green-400 p-4 rounded-lg overflow-x-auto text-sm"><code>@feature('beta_features')
    &lt;div&gt;Beta Content&lt;/div&gt;
@else
    &lt;div&gt;Standard Content&lt;/div&gt;
@endfeature</code></pre>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white py-16">
    <div class="max-w-4xl mx-auto text-center px-4">
        <h2 class="text-4xl font-bold mb-6">Ready to Take Control?</h2>
        <p class="text-xl mb-8 text-indigo-100">Start managing your features with confidence today</p>
        <a href="{{ route('admin.login') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition duration-300 transform hover:scale-105 inline-block">
            Access Admin Panel
        </a>
    </div>
</div>
@endsection
