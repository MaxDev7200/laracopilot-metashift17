@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-6">Feature Flag Management Made Simple</h1>
        <p class="text-xl mb-8 text-indigo-100">Control feature rollouts, manage environments, and deploy with confidence</p>
        <div class="space-x-4">
            <a href="{{ route('admin.login') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-lg hover:bg-indigo-50 transition font-bold text-lg inline-block">
                Get Started
            </a>
            <a href="/debug" class="bg-indigo-500 text-white px-8 py-4 rounded-lg hover:bg-indigo-400 transition font-bold text-lg inline-block">
                View Debug
            </a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="max-w-7xl mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Powerful Features</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
            <div class="bg-blue-100 rounded-full p-4 w-16 h-16 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">Environment Control</h3>
            <p class="text-gray-600">Manage feature flags across development, staging, and production environments independently</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
            <div class="bg-green-100 rounded-full p-4 w-16 h-16 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">Real-time Toggling</h3>
            <p class="text-gray-600">Enable or disable features instantly with a single click, no deployment required</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
            <div class="bg-purple-100 rounded-full p-4 w-16 h-16 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">Gradual Rollouts</h3>
            <p class="text-gray-600">Control feature visibility with percentage-based rollouts to manage risk</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
            <div class="bg-yellow-100 rounded-full p-4 w-16 h-16 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">User Overrides</h3>
            <p class="text-gray-600">Enable features for specific users or groups for testing and beta access</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
            <div class="bg-red-100 rounded-full p-4 w-16 h-16 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">Safe Deployments</h3>
            <p class="text-gray-600">Test features in production safely, roll back instantly if issues arise</p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition">
            <div class="bg-indigo-100 rounded-full p-4 w-16 h-16 flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold mb-3 text-gray-800">Detailed Logging</h3>
            <p class="text-gray-600">Track all flag changes with comprehensive audit logs and debug tools</p>
        </div>
    </div>
</div>

<!-- Admin Access Section -->
<div class="bg-gray-100 py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Ready to Get Started?</h2>
        <p class="text-xl text-gray-600 mb-8">Access the admin panel to manage your feature flags</p>
        <a href="{{ route('admin.login') }}" class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white px-12 py-4 rounded-lg hover:from-indigo-700 hover:to-purple-800 transition font-bold text-lg inline-block shadow-lg">
            Go to Admin Panel
        </a>
    </div>
</div>
@endsection
