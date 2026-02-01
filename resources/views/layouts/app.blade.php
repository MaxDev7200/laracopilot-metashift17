<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Feature Flag Manager')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-gradient-to-r from-indigo-600 to-purple-700 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-white text-xl font-bold flex items-center">
                        <svg class="w-8 h-8 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                        Feature Flag Manager
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-white hover:text-gray-200 transition duration-300">Home</a>
                    <a href="{{ route('debug') }}" class="text-white hover:text-gray-200 transition duration-300">Debug</a>
                    <a href="{{ route('admin.login') }}" class="bg-white text-indigo-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">Admin Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-7xl mx-auto px-4 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <h3 class="text-lg font-bold mb-4">Feature Flags</h3>
                <p class="text-gray-400 text-sm">Manage and control features across environments with ease.</p>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-4">Features</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="#" class="hover:text-white">Environment Control</a></li>
                    <li><a href="#" class="hover:text-white">Gradual Rollouts</a></li>
                    <li><a href="#" class="hover:text-white">User Overrides</a></li>
                    <li><a href="#" class="hover:text-white">Real-time Toggle</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-4">Documentation</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="#" class="hover:text-white">Getting Started</a></li>
                    <li><a href="#" class="hover:text-white">API Reference</a></li>
                    <li><a href="#" class="hover:text-white">Best Practices</a></li>
                    <li><a href="#" class="hover:text-white">FAQ</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-4">Support</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="#" class="hover:text-white">Contact Us</a></li>
                    <li><a href="#" class="hover:text-white">Community</a></li>
                    <li><a href="#" class="hover:text-white">GitHub</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-700 py-6 text-center text-sm">
            <p>© {{ date('Y') }} Feature Flag Manager. All rights reserved.</p>
            <p class="mt-2">Made with ❤️ by <a href="https://laracopilot.com/" target="_blank" class="hover:underline text-indigo-400">LaraCopilot</a></p>
        </div>
    </footer>
</body>
</html>
