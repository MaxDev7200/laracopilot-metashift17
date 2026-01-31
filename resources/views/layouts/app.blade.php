<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feature Flag Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z"/>
                    </svg>
                    <a href="{{ route('home') }}" class="text-2xl font-bold">Feature Flag Manager</a>
                </div>
                <div class="flex space-x-6">
                    <a href="{{ route('home') }}" class="hover:text-indigo-200 transition">Home</a>
                    <a href="{{ route('admin.login') }}" class="hover:text-indigo-200 transition">Admin</a>
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
                <h3 class="text-lg font-bold mb-4">Feature Flag Manager</h3>
                <p class="text-gray-400 text-sm">Advanced feature flag management for modern applications</p>
            </div>
            <div>
                <h4 class="font-bold mb-4">Features</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li>Environment Management</li>
                    <li>User Overrides</li>
                    <li>Real-time Toggles</li>
                    <li>Analytics Dashboard</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Resources</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li>Documentation</li>
                    <li>API Reference</li>
                    <li>Support</li>
                    <li>GitHub</li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Contact</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li>support@featureflags.com</li>
                    <li>1-800-FEATURES</li>
                    <li>San Francisco, CA</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 py-6 text-center text-sm">
            <p>© {{ date('Y') }} Feature Flag Manager. All rights reserved.</p>
            <p class="mt-2">Made with ❤️ by <a href="https://laracopilot.com/" target="_blank" class="hover:underline">LaraCopilot</a></p>
        </div>
    </footer>
</body>
</html>
