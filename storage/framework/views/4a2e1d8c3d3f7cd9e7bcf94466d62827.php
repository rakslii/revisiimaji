<div class="p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Banner Statistics</h3>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg p-4 text-white">
            <div class="text-sm opacity-90">Total Views</div>
            <div class="text-2xl font-bold"><?php echo e(number_format($banners->sum('views_count'))); ?></div>
        </div>
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg p-4 text-white">
            <div class="text-sm opacity-90">Total Clicks</div>
            <div class="text-2xl font-bold"><?php echo e(number_format($banners->sum('clicks_count'))); ?></div>
        </div>
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg p-4 text-white">
            <div class="text-sm opacity-90">Avg. CTR</div>
            <?php
                $totalViews = $banners->sum('views_count');
                $totalClicks = $banners->sum('clicks_count');
                $avgCtr = $totalViews > 0 ? round(($totalClicks / $totalViews) * 100, 2) : 0;
            ?>
            <div class="text-2xl font-bold"><?php echo e($avgCtr); ?>%</div>
        </div>
    </div>

    <!-- Performance Chart -->
    <div class="bg-white border rounded-lg p-4 mb-6">
        <h4 class="font-medium text-gray-900 mb-4 flex items-center">
            <i class="fas fa-chart-bar text-purple-600 mr-2"></i>
            Banner Performance Overview
        </h4>
        <div style="height: 300px;"> <!-- Fixed height container -->
            <canvas id="bannerChart"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Top Performing Banners -->
        <div class="bg-white border rounded-lg p-4">
            <h4 class="font-medium text-gray-900 mb-3 flex items-center">
                <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                Top Performing Banners
            </h4>
            <div class="space-y-3 max-h-80 overflow-y-auto"> <!-- Added max height and scroll -->
                <?php
                    $topBanners = $banners->sortByDesc('clicks_count')->take(5);
                ?>
                
                <?php $__empty_1 = true; $__currentLoopData = $topBanners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                    <div class="flex items-center flex-1 min-w-0"> <!-- Added min-w-0 -->
                        <div class="w-10 h-10 rounded bg-gray-100 mr-3 overflow-hidden flex-shrink-0">
                            <?php if($banner->image_url): ?>
                                <img src="<?php echo e($banner->image_url); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-medium text-gray-900 truncate"><?php echo e($banner->title ?? 'Untitled'); ?></div>
                            <div class="text-xs text-gray-500">
                                <span class="bg-<?php echo e($banner->type == 'home_banner' ? 'purple' : 'yellow'); ?>-100 text-<?php echo e($banner->type == 'home_banner' ? 'purple' : 'yellow'); ?>-800 px-2 py-0.5 rounded-full">
                                    <?php echo e($banner->type == 'home_banner' ? 'Home Banner' : 'Popup'); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right ml-4 flex-shrink-0">
                        <div class="text-sm font-bold text-gray-900"><?php echo e(number_format($banner->clicks_count)); ?></div>
                        <div class="text-xs text-gray-500">clicks</div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500 text-sm text-center py-4">No data available</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Click Through Rate -->
        <div class="bg-white border rounded-lg p-4">
            <h4 class="font-medium text-gray-900 mb-3 flex items-center">
                <i class="fas fa-percent text-green-600 mr-2"></i>
                Click Through Rate (CTR)
            </h4>
            <div class="space-y-3 max-h-80 overflow-y-auto"> <!-- Added max height and scroll -->
                <?php
                    $ctrBanners = $banners->filter(function($b) { 
                        return $b->views_count > 0; 
                    })->sortByDesc(function($b) { 
                        return ($b->clicks_count / $b->views_count * 100); 
                    })->take(5);
                ?>
                
                <?php $__empty_1 = true; $__currentLoopData = $ctrBanners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $ctr = $banner->views_count > 0 ? round(($banner->clicks_count / $banner->views_count) * 100, 2) : 0;
                    $ctrColor = $ctr > 5 ? 'green' : ($ctr > 2 ? 'yellow' : 'gray');
                ?>
                <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-900 truncate"><?php echo e($banner->title ?? 'Untitled'); ?></div>
                        <div class="text-xs text-gray-500">
                            <span><?php echo e(number_format($banner->views_count)); ?> views</span>
                            <span class="mx-1">•</span>
                            <span><?php echo e(number_format($banner->clicks_count)); ?> clicks</span>
                        </div>
                    </div>
                    <div class="text-right ml-4 flex-shrink-0">
                        <div class="text-sm font-bold text-<?php echo e($ctrColor); ?>-600">
                            <?php echo e($ctr); ?>%
                        </div>
                        <div class="text-xs text-gray-500">CTR</div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500 text-sm text-center py-4">No data available</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Summary Table -->
    <div class="bg-white border rounded-lg overflow-hidden">
        <div class="px-4 py-3 bg-gray-50 border-b">
            <h4 class="font-medium text-gray-900">All Banners Performance</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Banner</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Views</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Clicks</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">CTR</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $ctr = $banner->views_count > 0 ? round(($banner->clicks_count / $banner->views_count) * 100, 2) : 0;
                    ?>
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded bg-gray-100 mr-3 overflow-hidden flex-shrink-0">
                                    <?php if($banner->image_url): ?>
                                        <img src="<?php echo e($banner->image_url); ?>" class="w-full h-full object-cover">
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($banner->title ?? 'Untitled'); ?></div>
                                    <div class="text-xs text-gray-500"><?php echo e(Str::limit($banner->description, 30)); ?></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs rounded-full <?php echo e($banner->type == 'home_banner' ? 'bg-purple-100 text-purple-800' : 'bg-yellow-100 text-yellow-800'); ?>">
                                <?php echo e($banner->type == 'home_banner' ? 'Home Banner' : 'Popup'); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo e(number_format($banner->views_count)); ?></td>
                        <td class="px-6 py-4 text-sm text-gray-900"><?php echo e(number_format($banner->clicks_count)); ?></td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-<?php echo e($ctr > 5 ? 'green' : ($ctr > 2 ? 'yellow' : 'gray')); ?>-600">
                                <?php echo e($ctr); ?>%
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <?php echo $banner->status_badge; ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No banner data available
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('bannerChart')?.getContext('2d');
    if (!ctx) return;
    
    const banners = <?php echo json_encode($banners->sortByDesc('views_count')->take(10), 15, 512) ?>;
    
    if (banners.length === 0) {
        document.getElementById('bannerChart').parentNode.innerHTML = '<p class="text-gray-500 text-center py-8">No data to display</p>';
        return;
    }
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: banners.map(b => {
                let title = b.title || 'Untitled';
                return title.length > 20 ? title.substring(0, 20) + '...' : title;
            }),
            datasets: [
                {
                    label: 'Views',
                    data: banners.map(b => b.views_count),
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 1,
                    borderRadius: 4
                },
                {
                    label: 'Clicks',
                    data: banners.map(b => b.clicks_count),
                    backgroundColor: 'rgba(16, 185, 129, 0.5)',
                    borderColor: 'rgb(16, 185, 129)',
                    borderWidth: 1,
                    borderRadius: 4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 12,
                        padding: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += new Intl.NumberFormat('id-ID').format(context.raw);
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('id-ID', {
                                notation: 'compact',
                                compactDisplay: 'short'
                            }).format(value);
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\laragon\www\revisiimaji\resources\views/pages/admin/settings/banners/tabs/statistics.blade.php ENDPATH**/ ?>