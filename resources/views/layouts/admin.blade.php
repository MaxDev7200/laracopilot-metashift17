<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-gradient-to-b from-indigo-700 to-purple-800 text-white flex-shrink-0">
            <div class="p-6">
                <h1 class="text-2xl font-bold">Feature Flags</h1>
                <p class="text-sm text-indigo-200">Admin Panel</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 hover:bg-indigo-600 transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 border-l-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                
                <a href="{{ route('admin.flags.index') }}" class="flex items-center px-6 py-3 hover:bg-indigo-600 transition {{ request()->routeIs('admin.flags.*') ? 'bg-indigo-600 border-l-4 border-white' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                    </svg>
                    Feature Flags
                </a>
                
                <a href="/debug" class="flex items-center px-6 py-3 hover:bg-indigo-600 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Debug Logs
                </a>
            </nav>
            
            <div class="absolute bottom-0 w-64 p-6 border-t border-indigo-600">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center text-lg font-bold">
                        {{ strtoupper(substr(session('admin_user', 'A'), 0, 1)) }}
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold">{{ session('admin_user', 'Admin') }}</p>
                        <p class="text-xs text-indigo-200">{{ session('admin_email', '') }}</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded transition">
                        Logout
                    </button>
                </form>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto">
            <div class="container mx-auto px-6 py-8">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
