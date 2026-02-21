<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-semibold text-gray-900">Team Members</h2>
        <button onclick="openModal('teamModal')"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center">
            <i class="fas fa-plus mr-2"></i>Add Team Member
        </button>
    </div>
    
    <?php if($teamMembers->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $teamMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    // Decode social links jika masih string
                    $socialLinks = $member->social_links;
                    if (is_string($socialLinks)) {
                        $socialLinks = json_decode($socialLinks, true) ?? [];
                    }
                    if (!is_array($socialLinks)) {
                        $socialLinks = [];
                    }
                ?>
                
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- Header with Gradient - FIXED -->
                    <div class="h-20 relative" style="background: linear-gradient(135deg, #193497, #1e40af);">
                        <div class="absolute top-3 right-3">
                            <span class="px-2 py-1 text-xs rounded-full <?php echo e($member->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo e($member->is_active ? 'Active' : 'Inactive'); ?>

                            </span>
                        </div>
                    </div>
                    
                    <!-- Body -->
                    <div class="p-4 pt-0">
                        <!-- Avatar - FIXED -->
                        <div class="w-16 h-16 rounded-xl mx-auto -mt-8 mb-4 flex items-center justify-center text-white font-bold text-xl"
                             style="background: linear-gradient(135deg, #193497, #1e40af);">
                            <?php if($member->image_url): ?>
                                <img src="<?php echo e($member->image_url); ?>" 
                                     alt="<?php echo e($member->name); ?>"
                                     class="w-full h-full object-cover rounded-xl">
                            <?php else: ?>
                                <?php echo e($member->avatar_initials); ?>

                            <?php endif; ?>
                        </div>
                        
                        <div class="text-center">
                            <h3 class="font-bold text-gray-900"><?php echo e($member->name); ?></h3>
                            <p class="text-sm text-blue-600 mb-3"><?php echo e($member->position); ?></p>
                            
                            <?php if($member->bio): ?>
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2"><?php echo e($member->bio); ?></p>
                            <?php endif; ?>
                            
                            <!-- Social Links -->
                            <?php if(!empty($socialLinks) && is_array($socialLinks)): ?>
                                <div class="flex justify-center space-x-3 mb-4">
                                    <?php $__currentLoopData = $socialLinks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $platform => $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(!empty($link)): ?>
                                            <a href="<?php echo e($link); ?>" 
                                               target="_blank"
                                               class="text-gray-400 hover:text-blue-600">
                                                <i class="fab fa-<?php echo e($platform); ?>"></i>
                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Actions -->
                            <div class="flex justify-between items-center pt-4 border-t">
                                <span class="text-xs text-gray-400">Order: <?php echo e($member->order); ?></span>
                                <div class="flex space-x-2">
                                    <button onclick='editTeamMember(<?php echo json_encode($member, 15, 512) ?>)'
                                            class="text-green-600 hover:text-green-800">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form action="<?php echo e(route('admin.settings.about-us.team-members.destroy', $member->id)); ?>" 
                                          method="POST"
                                          onsubmit="return confirm('Delete <?php echo e($member->name); ?>?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="text-center py-12">
            <div class="inline-block p-4 bg-gray-100 rounded-full mb-4">
                <i class="fas fa-users text-gray-400 text-4xl"></i>
            </div>
            <p class="text-gray-500 mb-6">Add your team members to showcase on the about us page</p>
            <button onclick="openModal('teamModal')"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center mx-auto">
                <i class="fas fa-plus mr-2"></i>Add Team Member
            </button>
        </div>
    <?php endif; ?>
</div><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/about-us/tabs/team.blade.php ENDPATH**/ ?>