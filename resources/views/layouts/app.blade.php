<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Feature Flag Manager') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                    </svg>
                    <h1 class="text-2xl font-bold">Feature Flag Manager</h1>
                </div>
                <div class="space-x-4">
                    <a href="{{ route('home') }}" class="hover:text-indigo-200 transition">Home</a>
                    <a href="{{ route('admin.login') }}" class="bg-white text-indigo-600 px-4 py-2 rounded-lg hover:bg-indigo-50 transition font-semibold">Admin Panel</a>
                </div>
            </div>
        </div>
    </nav>
    
    <main>
        @yield('content')
    </main>
    
    <footer class="bg-gray-800 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-lg font-bold mb-4">Feature Flags</h3>
                <p class="text-gray-400">Manage feature rollouts with confidence</p>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Features</h4>
                <ul class="space-y-2 text-gray-400">
                    <li>Environment Control</li>
                    <li>Gradual Rollouts</li>
                    <li>User Overrides</li>
                    <li>Real-time Toggling</li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Resources</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="/debug" class="hover:text-white">Debug Logs</a></li>
                    <li><a href="{{ route('admin.login') }}" class="hover:text-white">Admin Login</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold mb-4">Support</h4>
                <ul class="space-y-2 text-gray-400">
                    <li>Documentation</li>
                    <li>API Reference</li>
                    <li>Help Center</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 py-6 text-center text-sm text-gray-400">
            <p>© {{ date('Y') }} Feature Flag Manager. All rights reserved.</p>
            <p class="mt-2">Made with ❤️ by <a href="https://laracopilot.com/" target="_blank" class="text-indigo-400 hover:underline">LaraCopilot</a></p>
        </div>
    </footer>
</body>
</html>
