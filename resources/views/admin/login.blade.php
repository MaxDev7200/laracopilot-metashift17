<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Feature Flag Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-500 via-purple-600 to-pink-500 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 6a3 3 0 013-3h10a1 1 0 01.8 1.6L14.25 8l2.55 3.4A1 1 0 0116 13H6a1 1 0 00-1 1v3a1 1 0 11-2 0V6z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Admin Login</h1>
            <p class="text-gray-600 mt-2">Feature Flag Manager</p>
        </div>
        
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-sm font-semibold text-blue-900 mb-2">Test Credentials:</p>
            <div class="space-y-1 text-sm text-blue-800">
                <p><strong>Admin:</strong> admin@featureflags.com / admin123</p>
                <p><strong>Manager:</strong> manager@featureflags.com / manager123</p>
                <p><strong>Developer:</strong> developer@featureflags.com / dev123</p>
            </div>
        </div>
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif
        
        <form action="/admin/login" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2">Email</label>
                <input type="email" name="email" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="admin@featureflags.com">
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Password</label>
                <input type="password" name="password" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="••••••••">
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-700 text-white py-3 rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-800 transition shadow-lg">
                Login to Admin Panel
            </button>
        </form>
        
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-indigo-600 hover:underline text-sm">← Back to Home</a>
        </div>
    </div>
</body>
</html>
