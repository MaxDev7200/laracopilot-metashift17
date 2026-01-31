<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Feature Flag Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md">
        <div class="text-center mb-8">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-full p-4 w-20 h-20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Admin Login</h1>
            <p class="text-gray-600">Feature Flag Manager</p>
        </div>
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
            <p class="font-semibold text-blue-900 mb-2">Test Credentials:</p>
            <div class="text-sm text-blue-800 space-y-1">
                <p><strong>Email:</strong> admin@featureflags.com</p>
                <p><strong>Password:</strong> admin123</p>
            </div>
        </div>
        
        <form action="{{ route('admin.login') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Email Address</label>
                <input type="email" name="email" value="{{ old('email', 'admin@featureflags.com') }}" 
                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-indigo-500 transition" 
                    required autofocus>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Password</label>
                <input type="password" name="password" value="admin123"
                    class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-indigo-500 transition" 
                    required>
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-bold py-3 rounded-lg hover:from-indigo-700 hover:to-purple-800 transition transform hover:scale-105">
                Login to Admin Panel
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <a href="{{ route('home') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">
                ← Back to Homepage
            </a>
        </div>
    </div>
</body>
</html>
