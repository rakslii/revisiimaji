@extends('pages.admin.layouts.app')

@section('title', 'Admin Users')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Header dengan Breadcrumb -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <nav class="flex mb-3" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">
                                <i class="fas fa-home mr-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="inline-flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('admin.settings.index') }}" class="text-gray-700 hover:text-blue-600">
                                Settings
                            </a>
                        </li>
                        <li aria-current="page" class="inline-flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-blue-600 font-medium">Admin Users</span>
                        </li>
                    </ol>
                </nav>
                
                <h1 class="text-2xl font-bold text-gray-900">Admin Users</h1>
                <p class="text-gray-600 mt-1">Manage administrator and staff accounts</p>
            </div>
            
            <a href="{{ route('admin.settings.admin-users.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                <i class="fas fa-plus mr-2"></i>Add New User
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b flex justify-between items-center">
            <div class="text-sm text-gray-600">
                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
            </div>
            <div>
                <input type="text" 
                       placeholder="Search users..." 
                       class="border border-gray-300 rounded-lg px-3 py-1 text-sm">
            </div>
        </div>
        
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full {{ $user->role == 'admin' ? 'bg-purple-100' : 'bg-blue-100' }} flex items-center justify-center mr-3">
                                    <span class="{{ $user->role == 'admin' ? 'text-purple-600' : 'text-blue-600' }} font-semibold">
                                        {{ substr($user->name, 0, 1) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    @if($user->phone)
                                        <div class="text-xs text-gray-400">
                                            <i class="fas fa-phone mr-1"></i>{{ $user->phone }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                @if($user->role == 'admin')
                                    <i class="fas fa-crown mr-1"></i>
                                @else
                                    <i class="fas fa-user-tie mr-1"></i>
                                @endif
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas fa-circle mr-1 text-xs"></i>
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.settings.admin-users.edit', $user->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 transition-colors"
                                   title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if($user->id != auth()->id())
                                    <form action="{{ route('admin.settings.admin-users.destroy', $user->id) }}" 
                                          method="POST" 
                                          class="inline"
                                          onsubmit="return confirm('Delete {{ $user->name }}? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-900 transition-colors"
                                                title="Delete User">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-400 cursor-not-allowed" title="Cannot delete yourself">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-users text-4xl mb-4 text-gray-300"></i>
                            <p class="text-lg">No admin users found</p>
                            <p class="text-sm mt-2">Click "Add New User" to create your first admin account</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-6 py-4 border-t bg-gray-50">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection