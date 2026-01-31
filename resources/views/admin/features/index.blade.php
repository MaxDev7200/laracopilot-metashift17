@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Feature Flags</h1>
            <p class="text-gray-600 mt-2">Manage all feature flags across environments</p>
        </div>
        <a href="{{ route('admin.flags.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition font-semibold">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Flag
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ session('success') }}
        </div>
    </div>
@endif

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Flag Name</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Key</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Environments</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($flags as $flag)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($flag->name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900">{{ $flag->name }}</div>
                                <div class="text-xs text-gray-500">ID: {{ $flag->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <code class="text-sm bg-gray-100 px-3 py-1 rounded font-mono">{{ $flag->key }}</code>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('admin.flags.toggle', $flag->id) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="relative inline-flex items-center h-7 rounded-full w-12 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 {{ $flag->enabled ? 'bg-blue-600' : 'bg-gray-300' }}">
                                <span class="sr-only">Toggle flag</span>
                                <span class="inline-block w-5 h-5 transform bg-white rounded-full shadow transition-transform {{ $flag->enabled ? 'translate-x-6' : 'translate-x-1' }}"></span>
                            </button>
                        </form>
                        <span class="ml-2 text-xs font-semibold {{ $flag->enabled ? 'text-green-600' : 'text-gray-500' }}">
                            {{ $flag->enabled ? 'ON' : 'OFF' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @foreach($flag->environments as $env)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold
                                    @if($env->environment === 'development') bg-blue-100 text-blue-800
                                    @elseif($env->environment === 'staging') bg-yellow-100 text-yellow-800
                                    @elseif($env->environment === 'production') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($env->environment) }}: {{ $env->enabled ? '✓' : '✗' }}
                                    @if($env->rollout_percentage < 100)
                                        ({{ $env->rollout_percentage }}%)
                                    @endif
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-600 max-w-xs">
                            {{ Str::limit($flag->description, 80) }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.flags.edit', $flag->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold mr-3">
                            Edit
                        </a>
                        <form action="{{ route('admin.flags.destroy', $flag->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this flag? This action cannot be undone.')" class="text-red-600 hover:text-red-900 font-semibold">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                            </svg>
                            <p class="text-xl font-semibold text-gray-700 mb-2">No feature flags found</p>
                            <p class="text-gray-500 mb-6">Create your first feature flag to get started</p>
                            <a href="{{ route('admin.flags.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition font-semibold inline-flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create First Flag
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($flags->hasPages())
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        {{ $flags->links() }}
    </div>
    @endif
</div>
@endsection
