@extends('pages.admin.layouts.app')

@section('title', 'Create Admin User')

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
                    <span class="text-blue-600 font-medium">Create New User</span>
                </li>
            </ol>
        </nav>
        
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create New User</h1>
                <p class="text-gray-600 mt-1">Add a new administrator or staff account</p>
            </div>
            
            <a href="{{ route('admin.settings.admin-users.index') }}" 
               class="text-gray-600 hover:text-gray-900 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Back to List
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow">
        <form action="{{ route('admin.settings.admin-users.store') }}" method="POST">
            @csrf

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}"
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
                               value="{{ old('email') }}"
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
                               value="{{ old('phone') }}"
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
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('role', 'admin') == 'admin' ? 'border-blue-300 bg-blue-50' : 'border-gray-300' }}">
                                <input type="radio" 
                                       name="role" 
                                       value="admin" 
                                       {{ old('role', 'admin') == 'admin' ? 'checked' : '' }}
                                       class="mr-3 text-blue-600">
                                <div>
                                    <div class="font-medium">Administrator</div>
                                    <div class="text-xs text-gray-500">Full access</div>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('role') == 'staff' ? 'border-blue-300 bg-blue-50' : 'border-gray-300' }}">
                                <input type="radio" 
                                       name="role" 
                                       value="staff" 
                                       {{ old('role') == 'staff' ? 'checked' : '' }}
                                       class="mr-3 text-blue-600">
                                <div>
                                    <div class="font-medium">Staff</div>
                                    <div class="text-xs text-gray-500">Limited access</div>
                                </div>
                            </label>
                        </div>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               name="password" 
                               required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               name="password_confirmation" 
                               required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('status', 'active') == 'active' ? 'border-green-300 bg-green-50' : 'border-gray-300' }}">
                                <input type="radio" 
                                       name="status" 
                                       value="active" 
                                       {{ old('status', 'active') == 'active' ? 'checked' : '' }}
                                       class="mr-3 text-green-600">
                                <div>
                                    <div class="font-medium text-green-700">Active</div>
                                    <div class="text-xs text-gray-500">Can login and access system</div>
                                </div>
                            </label>
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 {{ old('status') == 'inactive' ? 'border-red-300 bg-red-50' : 'border-gray-300' }}">
                                <input type="radio" 
                                       name="status" 
                                       value="inactive" 
                                       {{ old('status') == 'inactive' ? 'checked' : '' }}
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
                        <i class="fas fa-save mr-2"></i>Create User
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection