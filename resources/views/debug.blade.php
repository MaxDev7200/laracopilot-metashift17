<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Debug Dashboard</h1>
            
            <!-- System Status -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-700 mb-4">System Status</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-100 border border-green-400 rounded-lg p-4">
                        <p class="text-green-800 font-semibold">✓ Laravel Running</p>
                        <p class="text-sm text-green-600">Version {{ app()->version() }}</p>
                    </div>
                    <div class="bg-{{ $dbConnected ? 'green' : 'red' }}-100 border border-{{ $dbConnected ? 'green' : 'red' }}-400 rounded-lg p-4">
                        <p class="text-{{ $dbConnected ? 'green' : 'red' }}-800 font-semibold">{{ $dbConnected ? '✓' : '✗' }} Database</p>
                        <p class="text-sm text-{{ $dbConnected ? 'green' : 'red' }}-600">{{ $dbConnected ? 'Connected' : 'Not Connected' }}</p>
                    </div>
                    <div class="bg-blue-100 border border-blue-400 rounded-lg p-4">
                        <p class="text-blue-800 font-semibold">Environment</p>
                        <p class="text-sm text-blue-600">{{ config('app.env') }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Database Tables -->
            @if($dbConnected)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Database Tables</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Table Name</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase">Row Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tables as $table => $count)
                            <tr class="border-t">
                                <td class="px-6 py-4 font-mono text-sm">{{ $table }}</td>
                                <td class="px-6 py-4 text-sm font-semibold">{{ $count }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            
            <!-- Recent Logs -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-700 mb-4">Recent Laravel Logs</h2>
                @if(!empty($logs))
                <div class="bg-gray-900 text-green-400 p-4 rounded font-mono text-sm overflow-x-auto max-h-96">
                    @foreach($logs as $log)
                    <div class="mb-2">{{ $log }}</div>
                    @endforeach
                </div>
                @else
                <p class="text-gray-600">No recent logs found</p>
                @endif
            </div>
            
            <!-- Quick Links -->
            <div>
                <h2 class="text-xl font-bold text-gray-700 mb-4">Quick Links</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('home') }}" class="bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition text-center font-semibold">
                        Homepage
                    </a>
                    <a href="{{ route('admin.login') }}" class="bg-indigo-600 text-white px-4 py-3 rounded-lg hover:bg-indigo-700 transition text-center font-semibold">
                        Admin Login
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="bg-purple-600 text-white px-4 py-3 rounded-lg hover:bg-purple-700 transition text-center font-semibold">
                        Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
