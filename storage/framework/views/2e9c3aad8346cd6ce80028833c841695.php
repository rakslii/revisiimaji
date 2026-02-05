

<?php $__env->startSection('title', 'Edit Admin User'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Admin User</h1>
        <p class="text-gray-600">Update user information</p>
    </div>

    <!-- Messages -->
    <?php if(session('success')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow p-6">
        <form action="<?php echo e(route('admin.settings.admin-users.update', $user->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="space-y-4">
                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" 
                           name="name" 
                           value="<?php echo e(old('name', $user->name)); ?>"
                           required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" 
                           name="email" 
                           value="<?php echo e(old('email', $user->email)); ?>"
                           required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" 
                           name="phone" 
                           value="<?php echo e(old('phone', $user->phone)); ?>"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <!-- Password (Optional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">New Password (Leave blank to keep current)</label>
                    <input type="password" 
                           name="password" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                    <input type="password" 
                           name="password_confirmation" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="role" 
                                   value="admin" 
                                   <?php echo e(old('role', $user->role) == 'admin' ? 'checked' : ''); ?>

                                   class="mr-2">
                            <span>Administrator</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="role" 
                                   value="staff" 
                                   <?php echo e(old('role', $user->role) == 'staff' ? 'checked' : ''); ?>

                                   class="mr-2">
                            <span>Staff</span>
                        </label>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <div class="flex space-x-4">
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="status" 
                                   value="active" 
                                   <?php echo e(old('status', $user->status) == 'active' ? 'checked' : ''); ?>

                                   class="mr-2">
                            <span>Active</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" 
                                   name="status" 
                                   value="inactive" 
                                   <?php echo e(old('status', $user->status) == 'inactive' ? 'checked' : ''); ?>

                                   class="mr-2">
                            <span>Inactive</span>
                        </label>
                    </div>
                </div>

                <!-- User Info -->
                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-medium mb-4">User Information</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <div class="text-gray-500">Created</div>
                            <div><?php echo e($user->created_at->format('M d, Y')); ?></div>
                        </div>
                        <div>
                            <div class="text-gray-500">Last Updated</div>
                            <div><?php echo e($user->updated_at->format('M d, Y')); ?></div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="pt-6 flex justify-between items-center">
                    <div class="flex space-x-4">
                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            Update User
                        </button>
                        <a href="<?php echo e(route('admin.settings.admin-users.index')); ?>" 
                           class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400">
                            Cancel
                        </a>
                    </div>
                    
                    <?php if($user->id != auth()->id()): ?>
                        <form action="<?php echo e(route('admin.settings.admin-users.destroy', $user->id)); ?>" 
                              method="POST"
                              onsubmit="return confirm('Delete <?php echo e($user->name); ?>?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                                Delete User
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/admin-users/edit.blade.php ENDPATH**/ ?>