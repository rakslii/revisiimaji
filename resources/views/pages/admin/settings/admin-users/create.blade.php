@extends('pages.admin.layouts.app')

@section('title', 'Create Admin User')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Create New Admin User</h1>
        <p class="text-gray-600">Add a new administrator or staff account</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.settings.admin-users.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name') }}"
                           required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone (Optional)</label>
                    <input type="text" 
                           name="phone" 
                           value="{{ old('phone') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" 
                           name="password" 
                           required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input type="password" 
                           name="password_confirmation" 
                           required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="role" value="admin" checked class="mr-2">
                            <span>Administrator</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="role" value="staff" class="mr-2">
                            <span>Staff</span>
                        </label>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" name="status" value="active" checked class="mr-2">
                            <span>Active</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="status" value="inactive" class="mr-2">
                            <span>Inactive</span>
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="pt-6 flex space-x-4">
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Create User
                    </button>
                    <a href="{{ route('admin.settings.admin-users.index') }}" 
                       class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                        Cancel
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection