

<?php $__env->startSection('title', 'Edit Online Store'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-6 max-w-6xl">
    <!-- Header dengan Breadcrumb -->
    <div class="mb-6">
        <nav class="flex mb-3" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>Dashboard
                    </a>
                </li>
                <li class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="<?php echo e(route('admin.settings.index')); ?>" class="text-gray-700 hover:text-blue-600">
                        Settings
                    </a>
                </li>
                <li class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <a href="<?php echo e(route('admin.settings.online-stores.index')); ?>" class="text-gray-700 hover:text-blue-600">
                        Online Stores
                    </a>
                </li>
                <li aria-current="page" class="inline-flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-blue-600 font-medium">Edit Store</span>
                </li>
            </ol>
        </nav>
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Online Store</h1>
                <p class="text-gray-600 mt-1">Update store information for <?php echo e($store->name); ?></p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <a href="<?php echo e($store->url); ?>" 
                   target="_blank"
                   class="text-blue-600 hover:text-blue-800 flex items-center px-3 py-1.5 bg-blue-50 rounded-lg"
                   title="Visit Store">
                    <i class="fas fa-external-link-alt mr-2"></i>
                    Visit Store
                </a>
                <a href="<?php echo e(route('admin.settings.online-stores.index')); ?>" 
                   class="text-gray-600 hover:text-gray-900 flex items-center px-3 py-1.5 bg-gray-50 rounded-lg">
                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-400 mr-3"></i>
                <div class="text-green-700">
                    <p class="font-medium">Success</p>
                    <p><?php echo e(session('success')); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-400 mr-3"></i>
                <div class="text-red-700">
                    <p class="font-medium">Error</p>
                    <p><?php echo e(session('error')); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Column -->
        <div class="lg:col-span-2">
            <!-- Update Form -->
            <form action="<?php echo e(route('admin.settings.online-stores.update', $store->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
                    <div class="px-6 py-4 bg-gray-50 border-b">
                        <h2 class="text-lg font-medium text-gray-900">Store Information</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Store Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Store Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="name" 
                                       value="<?php echo e(old('name', $store->name)); ?>"
                                       required
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Store URL -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Store URL <span class="text-red-500">*</span>
                                </label>
                                <input type="url" 
                                       name="url" 
                                       value="<?php echo e(old('url', $store->url)); ?>"
                                       required
                                       class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <?php $__errorArgs = ['url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Platform -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Platform Type <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <?php $__currentLoopData = $platforms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <label class="flex items-center p-4 border rounded-lg cursor-pointer transition-all duration-200 hover:bg-gray-50 hover:border-blue-300 <?php echo e(old('platform', $store->platform) == $key ? 'border-blue-400 bg-blue-50 ring-2 ring-blue-100' : 'border-gray-300'); ?>">
                                            <input type="radio" 
                                                   name="platform" 
                                                   value="<?php echo e($key); ?>" 
                                                   <?php echo e(old('platform', $store->platform) == $key ? 'checked' : ''); ?>

                                                   class="mr-3 text-blue-600 focus:ring-blue-500">
                                            <div class="flex items-center">
                                                <?php if($key == 'ecommerce'): ?>
                                                    <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                                                        <i class="fas fa-shopping-cart text-purple-600"></i>
                                                    </div>
                                                <?php elseif($key == 'social_media'): ?>
                                                    <div class="w-8 h-8 rounded-lg bg-pink-100 flex items-center justify-center mr-3">
                                                        <i class="fas fa-hashtag text-pink-600"></i>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                                                        <i class="fas fa-store text-green-600"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div>
                                                    <div class="font-medium"><?php echo e(ucfirst($key)); ?></div>
                                                    <div class="text-xs text-gray-500 mt-1"><?php echo e(Str::limit($label, 25)); ?></div>
                                                </div>
                                            </div>
                                        </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <?php $__errorArgs = ['platform'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <textarea name="description" 
                                          rows="3"
                                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"><?php echo e(old('description', $store->description)); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Icon Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Icon <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="icon_class" 
                                            required
                                            class="w-full border border-gray-300 rounded-lg px-4 py-3 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors appearance-none">
                                        <option value="">Select an icon</option>
                                        <?php $__currentLoopData = $iconOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($value); ?>" <?php echo e(old('icon_class', $store->icon_class) == $value ? 'selected' : ''); ?>>
                                                <?php echo e($label); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                                        <i class="fas fa-chevron-down text-gray-400"></i>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['icon_class'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Color Scheme Section -->
                            <div class="bg-gray-50 rounded-xl p-5">
                                <label class="block text-lg font-medium text-gray-900 mb-4">
                                    <i class="fas fa-palette mr-2 text-blue-500"></i>
                                    Color Scheme <span class="text-red-500">*</span>
                                </label>
                                
                                <!-- Custom Colors Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Main Color -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Main Color
                                        </label>
                                        <div class="flex items-center space-x-3">
                                            <div class="relative">
                                                <input type="color" 
                                                       name="color_picker" 
                                                       value="<?php echo e(old('color', $store->color)); ?>"
                                                       class="w-12 h-12 cursor-pointer rounded-lg border border-gray-300">
                                            </div>
                                            <input type="text" 
                                                   name="color" 
                                                   value="<?php echo e(old('color', $store->color)); ?>"
                                                   required
                                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm">
                                        </div>
                                        <?php $__errorArgs = ['color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                    <!-- Gradient From -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Gradient Start
                                        </label>
                                        <div class="flex items-center space-x-3">
                                            <div class="relative">
                                                <input type="color" 
                                                       name="gradient_from_picker" 
                                                       value="<?php echo e(old('gradient_from', $store->gradient_from)); ?>"
                                                       class="w-12 h-12 cursor-pointer rounded-lg border border-gray-300">
                                            </div>
                                            <input type="text" 
                                                   name="gradient_from" 
                                                   value="<?php echo e(old('gradient_from', $store->gradient_from)); ?>"
                                                   required
                                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm">
                                        </div>
                                        <?php $__errorArgs = ['gradient_from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    
                                    <!-- Gradient To -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Gradient End
                                        </label>
                                        <div class="flex items-center space-x-3">
                                            <div class="relative">
                                                <input type="color" 
                                                       name="gradient_to_picker" 
                                                       value="<?php echo e(old('gradient_to', $store->gradient_to)); ?>"
                                                       class="w-12 h-12 cursor-pointer rounded-lg border border-gray-300">
                                            </div>
                                            <input type="text" 
                                                   name="gradient_to" 
                                                   value="<?php echo e(old('gradient_to', $store->gradient_to)); ?>"
                                                   required
                                                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm">
                                        </div>
                                        <?php $__errorArgs = ['gradient_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <!-- Live Preview -->
                                <div class="mt-6 pt-5 border-t border-gray-200">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">
                                        <i class="fas fa-eye mr-2 text-blue-500"></i>
                                        Live Preview
                                    </label>
                                    <div class="flex flex-col sm:flex-row items-center gap-4 p-4 bg-white rounded-xl border border-gray-200">
                                        <div class="w-20 h-20 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0"
                                             id="colorPreview"
                                             style="background: linear-gradient(135deg, <?php echo e(old('gradient_from', $store->gradient_from)); ?>, <?php echo e(old('gradient_to', $store->gradient_to)); ?>);">
                                            <i class="<?php echo e(old('icon_class', $store->icon_class)); ?> text-white text-2xl" id="iconPreview"></i>
                                        </div>
                                        <div class="flex-1 text-center sm:text-left">
                                            <h4 class="font-bold text-gray-900 text-lg"><?php echo e($store->name); ?></h4>
                                            <p class="text-sm text-gray-500 mt-1">
                                                <i class="fas fa-link mr-1 text-gray-400"></i>
                                                <?php echo e($store->display_url); ?>

                                            </p>
                                            <div class="flex flex-wrap gap-2 mt-2 justify-center sm:justify-start">
                                                <span class="px-2.5 py-1 text-xs rounded-full <?php echo e($store->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                                    <?php echo e($store->is_active ? 'Active' : 'Inactive'); ?>

                                                </span>
                                                <span class="px-2.5 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                                    <?php echo e($store->platform_label); ?>

                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Store Username -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-user mr-2 text-gray-400"></i>
                                        Store Username
                                    </label>
                                    <input type="text" 
                                           name="store_username" 
                                           value="<?php echo e(old('store_username', $store->store_username)); ?>"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <?php $__errorArgs = ['store_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <!-- Store ID -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-id-card mr-2 text-gray-400"></i>
                                        Store ID
                                    </label>
                                    <input type="text" 
                                           name="store_id" 
                                           value="<?php echo e(old('store_id', $store->store_id)); ?>"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <?php $__errorArgs = ['store_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Order & Status -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Display Order -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-sort-numeric-down mr-2 text-gray-400"></i>
                                        Display Order
                                    </label>
                                    <input type="number" 
                                           name="order" 
                                           value="<?php echo e(old('order', $store->order)); ?>"
                                           min="0"
                                           step="1"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <p class="text-xs text-gray-500 mt-2">Lower numbers appear first in the list</p>
                                </div>
                                
                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class="fas fa-power-off mr-2 text-gray-400"></i>
                                        Status
                                    </label>
                                    <div class="grid grid-cols-2 gap-3">
                                        <label class="flex items-center justify-center p-3 border rounded-lg cursor-pointer transition-all duration-200 <?php echo e(old('is_active', $store->is_active) == 1 ? 'border-green-400 bg-green-50 ring-2 ring-green-100' : 'border-gray-300 hover:bg-gray-50'); ?>">
                                            <input type="radio" 
                                                   name="is_active" 
                                                   value="1" 
                                                   <?php echo e(old('is_active', $store->is_active) == 1 ? 'checked' : ''); ?>

                                                   class="mr-2 text-green-600 focus:ring-green-500">
                                            <div class="flex items-center">
                                                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                                <span class="font-medium text-green-700">Active</span>
                                            </div>
                                        </label>
                                        <label class="flex items-center justify-center p-3 border rounded-lg cursor-pointer transition-all duration-200 <?php echo e(old('is_active', $store->is_active) == 0 ? 'border-red-400 bg-red-50 ring-2 ring-red-100' : 'border-gray-300 hover:bg-gray-50'); ?>">
                                            <input type="radio" 
                                                   name="is_active" 
                                                   value="0" 
                                                   <?php echo e(old('is_active', $store->is_active) == 0 ? 'checked' : ''); ?>

                                                   class="mr-2 text-red-600 focus:ring-red-500">
                                            <div class="flex items-center">
                                                <i class="fas fa-times-circle text-red-500 mr-2"></i>
                                                <span class="font-medium text-red-700">Inactive</span>
                                            </div>
                                        </label>
                                    </div>
                                    <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="text-red-500 text-sm mt-2"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Footer -->
                    <div class="px-6 py-4 bg-gray-50 border-t flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-clock mr-2"></i>
                            Last updated: <?php echo e($store->updated_at->format('d/m/Y H:i')); ?>

                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="<?php echo e(route('admin.settings.online-stores.index')); ?>" 
                               class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 hover:border-gray-400 transition-colors duration-200 flex items-center">
                                <i class="fas fa-times mr-2"></i>
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center shadow-sm hover:shadow-md">
                                <i class="fas fa-save mr-2"></i>
                                Update Store
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sidebar Column -->
        <div class="space-y-6">
            <!-- Store Preview Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-5 py-4 bg-gradient-to-r from-blue-500 to-purple-600">
                    <h3 class="text-lg font-medium text-white flex items-center">
                        <i class="fas fa-store mr-2"></i>
                        Store Preview
                    </h3>
                </div>
                
                <div class="p-5">
                    <div class="flex flex-col items-center mb-5">
                        <div class="w-24 h-24 rounded-2xl flex items-center justify-center mb-4 shadow-xl"
                             style="background: linear-gradient(135deg, <?php echo e($store->gradient_from); ?>, <?php echo e($store->gradient_to); ?>);">
                            <i class="<?php echo e($store->icon_class); ?> text-white text-3xl"></i>
                        </div>
                        <div class="text-center">
                            <h4 class="font-bold text-gray-900 text-xl"><?php echo e($store->name); ?></h4>
                            <p class="text-sm text-gray-500 mt-1 flex items-center justify-center">
                                <i class="fas fa-globe mr-1.5"></i>
                                <?php echo e($store->display_url); ?>

                            </p>
                        </div>
                    </div>

                    <!-- Store Details -->
                    <div class="space-y-3.5 mb-5">
                        <div class="flex justify-between items-center p-2.5 rounded-lg bg-gray-50">
                            <div class="flex items-center">
                                <i class="fas fa-calendar text-gray-400 mr-3"></i>
                                <span class="text-sm text-gray-600">Created</span>
                            </div>
                            <span class="text-sm font-medium"><?php echo e($store->created_at->format('d M Y')); ?></span>
                        </div>
                        
                        <div class="flex justify-between items-center p-2.5 rounded-lg bg-gray-50">
                            <div class="flex items-center">
                                <i class="fas fa-sort-numeric-down text-gray-400 mr-3"></i>
                                <span class="text-sm text-gray-600">Display Order</span>
                            </div>
                            <span class="text-sm font-medium bg-blue-100 text-blue-800 px-2.5 py-1 rounded-full">#<?php echo e($store->order); ?></span>
                        </div>
                        
                        <?php if($store->store_username): ?>
                            <div class="flex justify-between items-center p-2.5 rounded-lg bg-gray-50">
                                <div class="flex items-center">
                                    <i class="fas fa-at text-gray-400 mr-3"></i>
                                    <span class="text-sm text-gray-600">Username</span>
                                </div>
                                <span class="text-sm font-medium"><?php echo e($store->store_username); ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($store->store_id): ?>
                            <div class="flex justify-between items-center p-2.5 rounded-lg bg-gray-50">
                                <div class="flex items-center">
                                    <i class="fas fa-fingerprint text-gray-400 mr-3"></i>
                                    <span class="text-sm text-gray-600">Store ID</span>
                                </div>
                                <span class="text-sm font-medium font-mono"><?php echo e($store->store_id); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Test Link Button -->
                    <a href="<?php echo e($store->url); ?>" 
                       target="_blank"
                       class="w-full bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 text-blue-700 px-4 py-3 rounded-lg flex items-center justify-center transition-all duration-200 border border-blue-200 hover:border-blue-300">
                        <i class="fas fa-external-link-alt mr-3"></i>
                        Test Store Link
                    </a>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-lg shadow overflow-hidden border border-red-100">
                <div class="px-5 py-4 bg-gradient-to-r from-red-50 to-red-100 border-b border-red-200">
                    <h3 class="text-lg font-medium text-red-800 flex items-center">
                        <i class="fas fa-bolt mr-2"></i>
                        Quick Actions
                    </h3>
                </div>
                
                <div class="p-5">
                    <div class="space-y-3">
                        <!-- Toggle Status -->
                        <form action="<?php echo e(route('admin.settings.online-stores.toggle-status', $store->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('POST'); ?>
                            <button type="submit" 
                                    class="w-full <?php echo e($store->is_active ? 'bg-red-50 hover:bg-red-100 text-red-700 border-red-200' : 'bg-green-50 hover:bg-green-100 text-green-700 border-green-200'); ?> px-4 py-3 rounded-lg flex items-center justify-center transition-colors duration-200 border">
                                <i class="fas fa-power-off mr-3"></i>
                                <?php echo e($store->is_active ? 'Deactivate Store' : 'Activate Store'); ?>

                            </button>
                        </form>
                        
                        <!-- Delete -->
                        <form action="<?php echo e(route('admin.settings.online-stores.destroy', $store->id)); ?>" 
                              method="POST"
                              onsubmit="return confirm('Are you sure you want to delete <?php echo e($store->name); ?>? This action cannot be undone!')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" 
                                    class="w-full bg-red-50 hover:bg-red-100 text-red-700 px-4 py-3 rounded-lg flex items-center justify-center transition-colors duration-200 border border-red-200">
                                <i class="fas fa-trash mr-3"></i>
                                Delete Store
                            </button>
                        </form>
                        
                        <!-- Duplicate -->
                        <a href="<?php echo e(route('admin.settings.online-stores.create')); ?>?duplicate=<?php echo e($store->id); ?>"
                           class="block w-full bg-blue-50 hover:bg-blue-100 text-blue-700 px-4 py-3 rounded-lg flex items-center justify-center transition-colors duration-200 border border-blue-200">
                            <i class="fas fa-copy mr-3"></i>
                            Duplicate Store
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Custom scrollbar for select */
    select::-webkit-scrollbar {
        width: 8px;
    }
    
    select::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    select::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    
    select::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    
    /* Smooth transitions */
    input, select, textarea, button {
        transition: all 0.2s ease-in-out;
    }
    
    /* Color picker enhancement */
    input[type="color"] {
        -webkit-appearance: none;
        border: none;
        border-radius: 8px;
        overflow: hidden;
    }
    
    input[type="color"]::-webkit-color-swatch-wrapper {
        padding: 0;
    }
    
    input[type="color"]::-webkit-color-swatch {
        border: none;
        border-radius: 6px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get DOM elements
    const colorPicker = document.querySelector('input[name="color_picker"]');
    const colorInput = document.querySelector('input[name="color"]');
    const gradientFromPicker = document.querySelector('input[name="gradient_from_picker"]');
    const gradientFromInput = document.querySelector('input[name="gradient_from"]');
    const gradientToPicker = document.querySelector('input[name="gradient_to_picker"]');
    const gradientToInput = document.querySelector('input[name="gradient_to"]');
    const iconSelect = document.querySelector('select[name="icon_class"]');
    
    // Preview elements
    const colorPreview = document.getElementById('colorPreview');
    const iconPreview = document.getElementById('iconPreview');
    
    // Sync color pickers with text inputs
    function syncColorPicker(inputElement, pickerElement) {
        inputElement.addEventListener('input', function() {
            pickerElement.value = this.value;
            updatePreview();
        });
        
        pickerElement.addEventListener('input', function() {
            inputElement.value = this.value;
            updatePreview();
        });
    }
    
    // Initialize color sync
    syncColorPicker(colorInput, colorPicker);
    syncColorPicker(gradientFromInput, gradientFromPicker);
    syncColorPicker(gradientToInput, gradientToPicker);
    
    // Update icon preview
    iconSelect.addEventListener('change', function() {
        iconPreview.className = this.value + ' text-white text-2xl';
    });
    
    // Update preview function
    function updatePreview() {
        const from = gradientFromInput.value || '<?php echo e($store->gradient_from); ?>';
        const to = gradientToInput.value || '<?php echo e($store->gradient_to); ?>';
        if (colorPreview) {
            colorPreview.style.background = `linear-gradient(135deg, ${from}, ${to})`;
        }
    }
    
    // Initialize preview
    updatePreview();
    
    // Form validation enhancement
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('border-red-500', 'ring-2', 'ring-red-200');
                    isValid = false;
                } else {
                    field.classList.remove('border-red-500', 'ring-2', 'ring-red-200');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields marked with *');
            }
        });
    }
    
    // Add input validation feedback
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('border-red-500');
            } else {
                this.classList.remove('border-red-500');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('border-red-500');
            }
        });
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('pages.admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/online-stores/edit.blade.php ENDPATH**/ ?>