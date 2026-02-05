@extends('pages.admin.layouts.app')

@section('title', 'Edit Admin User')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header dengan Breadcrumb -->
    <div class="mb-6">
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
                <li class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="{{ route('admin.settings.admin-users.index') }}" class="text-gray-700 hover:text-blue-600">
                        Admin Users
                    </a>
                </li>
                <li aria-current="page" class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-blue-600 font-medium">Edit User</span>
                </li>
            </ol>
        </nav>
        
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit User</h1>
                <p class="text-gray-600 mt-1">Update user information for {{ $user->name }}</p>
            </div>
            
            <a href="{{ route('admin.settings.admin-users.index') }}" 
               class="text-gray-600 hover:text-gray-900 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Column -->
        <div class="lg:col-span-2">
            <!-- Update Form -->
            <form action="{{ route('admin.settings.admin-users.update', $user->id) }}" method="POST" id="updateForm">
                @csrf
                @method('PUT')

                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">User Details</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}"
                                       required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}"
                                       required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="text" 
                                       name="phone" 
                                       value="{{ old('phone', $user->phone) }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('role', $user->role) == 'admin' ? 'border-purple-300 bg-purple-50' : 'border-gray-300' }}">
                                        <input type="radio" 
                                               name="role" 
                                               value="admin" 
                                               {{ old('role', $user->role) == 'admin' ? 'checked' : '' }}
                                               class="mr-3 text-purple-600">
                                        <div>
                                            <div class="font-medium text-purple-700">Administrator</div>
                                            <div class="text-xs text-gray-500">Full access</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('role', $user->role) == 'staff' ? 'border-blue-300 bg-blue-50' : 'border-gray-300' }}">
                                        <input type="radio" 
                                               name="role" 
                                               value="staff" 
                                               {{ old('role', $user->role) == 'staff' ? 'checked' : '' }}
                                               class="mr-3 text-blue-600">
                                        <div>
                                            <div class="font-medium text-blue-700">Staff</div>
                                            <div class="text-xs text-gray-500">Limited access</div>
                                        </div>
                                    </label>
                                </div>
                                @error('role')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password Section -->
                            <div class="md:col-span-2">
                                <div class="border-t pt-6 mt-2">
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Change Password (Optional)</h3>
                                    <p class="text-sm text-gray-500 mb-4">Leave blank to keep current password</p>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                            <input type="password" 
                                                   name="password" 
                                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                            @error('password')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                            <input type="password" 
                                                   name="password_confirmation" 
                                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('status', $user->status) == 'active' ? 'border-green-300 bg-green-50' : 'border-gray-300' }}">
                                        <input type="radio" 
                                               name="status" 
                                               value="active" 
                                               {{ old('status', $user->status) == 'active' ? 'checked' : '' }}
                                               class="mr-3 text-green-600">
                                        <div>
                                            <div class="font-medium text-green-700">Active</div>
                                            <div class="text-xs text-gray-500">Can login and access system</div>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('status', $user->status) == 'inactive' ? 'border-red-300 bg-red-50' : 'border-gray-300' }}">
                                        <input type="radio" 
                                               name="status" 
                                               value="inactive" 
                                               {{ old('status', $user->status) == 'inactive' ? 'checked' : '' }}
                                               class="mr-3 text-red-600">
                                        <div>
                                            <div class="font-medium text-red-700">Inactive</div>
                                            <div class="text-xs text-gray-500">Cannot login to system</div>
                                        </div>
                                    </label>
                                </div>
                                @error('status')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                        <div>
                            <span class="text-sm text-gray-500">Fields marked with <span class="text-red-500">*</span> are required</span>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.settings.admin-users.index') }}" 
                               class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
                                <i class="fas fa-save mr-2"></i>Update User
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar Column -->
        <div>
            <!-- User Info Card -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">User Information</h3>
                    
                    <div class="flex flex-col items-center mb-4">
                        <div class="h-16 w-16 rounded-full {{ $user->role == 'admin' ? 'bg-purple-100' : 'bg-blue-100' }} flex items-center justify-center mb-3">
                            <span class="{{ $user->role == 'admin' ? 'text-purple-600' : 'text-blue-600' }} text-2xl font-bold">
                                {{ substr($user->name, 0, 1) }}
                            </span>
                        </div>
                        <div class="text-center">
                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Account Created</span>
                            <span class="text-sm font-medium">{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Last Updated</span>
                            <span class="text-sm font-medium">{{ $user->updated_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Last Login</span>
                            <span class="text-sm font-medium">
                                @if($user->last_login_at)
                                    {{ $user->last_login_at->diffForHumans() }}
                                @else
                                    Never
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            @if($user->id != auth()->id())
                <div class="bg-white rounded-lg shadow border border-red-200">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-red-700 mb-2">Danger Zone</h3>
                        <p class="text-sm text-gray-600 mb-4">Once you delete a user, there is no going back. Please be certain.</p>
                        
                        <button type="button" 
                                onclick="confirmDelete()"
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 flex items-center justify-center">
                            <i class="fas fa-trash mr-2"></i>Delete User
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- DELETE FORM -->
@if($user->id != auth()->id())
    <form action="{{ route('admin.settings.admin-users.destroy', $user->id) }}" 
          method="POST" 
          id="deleteForm" 
          style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endif

<script>
function confirmDelete() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to delete {{ $user->name }}. This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm').submit();
        }
    });
}
</script>
@endsection

@push('styles')
<style>
    /* Custom styles for radio buttons */
    input[type="radio"]:checked + div {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }
</style>
@endpush