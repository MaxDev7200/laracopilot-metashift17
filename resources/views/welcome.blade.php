@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-6">Advanced Feature Flag Management</h1>
        <p class="text-xl mb-8 text-indigo-100">Control feature releases, A/B testing, and progressive rollouts with confidence</p>
        <div class="flex justify-center space-x-4">
            <a href="{{ route('admin.login') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-indigo-50 transition shadow-lg">Access Admin Panel</a>
            <a href="#features" class="border-2 border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition">Learn More</a>
        </div>
    </div>
</div>

<div id="features" class="max-w-7xl mx-auto px-4 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Powerful Feature Management</h2>
        <p class="text-gray-600">Everything you need to manage feature flags across your applications</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
            <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Environment Control</h3>
            <p class="text-gray-600">Manage feature flags across development, staging, and production environments independently</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">User Overrides</h3>
            <p class="text-gray-600">Enable or disable features for specific users or user groups for targeted testing</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
            <div class="bg-pink-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Real-time Toggles</h3>
            <p class="text-gray-600">Instantly enable or disable features without deploying new code or restarting services</p>
        </div>
    </div>
</div>

<div class="bg-gray-50 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Current System Stats</h2>
            <p class="text-gray-600">Live metrics from your feature flag system</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="text-5xl font-bold text-indigo-600 mb-2">{{ $totalFeatures }}</div>
                <div class="text-gray-600 font-medium">Total Feature Flags</div>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="text-5xl font-bold text-green-600 mb-2">{{ $activeFeatures }}</div>
                <div class="text-gray-600 font-medium">Active Features</div>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 py-16">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">How It Works</h2>
        <p class="text-gray-600">Simple, powerful feature flag management in three steps</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center">
            <div class="bg-indigo-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Create Feature Flags</h3>
            <p class="text-gray-600">Define feature flags with unique keys and descriptions for your application features</p>
        </div>
        
        <div class="text-center">
            <div class="bg-purple-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Configure Environments</h3>
            <p class="text-gray-600">Set different states for development, staging, and production environments</p>
        </div>
        
        <div class="text-center">
            <div class="bg-pink-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Deploy & Monitor</h3>
            <p class="text-gray-600">Toggle features in real-time and monitor usage across your application</p>
        </div>
    </div>
</div>

<div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Get Started?</h2>
        <p class="text-xl mb-8 text-indigo-100">Take control of your feature releases today</p>
        <a href="{{ route('admin.login') }}" class="bg-white text-indigo-600 px-8 py-3 rounded-lg font-semibold hover:bg-indigo-50 transition shadow-lg inline-block">Access Admin Panel</a>
    </div>
</div>
@endsection
