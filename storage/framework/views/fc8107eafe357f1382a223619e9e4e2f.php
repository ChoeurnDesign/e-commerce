<?php $__env->startSection('title', 'Reviews Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 min-h-screen">
    <div class="mb-6 flex items-center">
        <span class="mr-2">
            <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'reviews','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'reviews','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7ac833788d87377235d115adad0b6b1f)): ?>
<?php $attributes = $__attributesOriginal7ac833788d87377235d115adad0b6b1f; ?>
<?php unset($__attributesOriginal7ac833788d87377235d115adad0b6b1f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7ac833788d87377235d115adad0b6b1f)): ?>
<?php $component = $__componentOriginal7ac833788d87377235d115adad0b6b1f; ?>
<?php unset($__componentOriginal7ac833788d87377235d115adad0b6b1f); ?>
<?php endif; ?>
        </span>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Reviews</h1>
    </div>

    
    <?php if (isset($component)) { $__componentOriginal3b92e91ca199bcc05fbf8ea1b4f94559 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b92e91ca199bcc05fbf8ea1b4f94559 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.simple-search','data' => ['placeholder' => 'ID / Product / User / Rating / Comment','hint' => 'Search by id, product, user, rating, text','width' => 'w-96','autofocus' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.simple-search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'ID / Product / User / Rating / Comment','hint' => 'Search by id, product, user, rating, text','width' => 'w-96','autofocus' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3b92e91ca199bcc05fbf8ea1b4f94559)): ?>
<?php $attributes = $__attributesOriginal3b92e91ca199bcc05fbf8ea1b4f94559; ?>
<?php unset($__attributesOriginal3b92e91ca199bcc05fbf8ea1b4f94559); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3b92e91ca199bcc05fbf8ea1b4f94559)): ?>
<?php $component = $__componentOriginal3b92e91ca199bcc05fbf8ea1b4f94559; ?>
<?php unset($__componentOriginal3b92e91ca199bcc05fbf8ea1b4f94559); ?>
<?php endif; ?>

    <div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
                <thead>
                    <tr class="bg-gray-300 dark:bg-[#232c47]">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Reviewer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Comment</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                    <?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-300 dark:hover:bg-[#262c47] transition">
                            <td class="px-6 py-4 text-center text-gray-900 dark:text-gray-100">
                                <?php echo e(($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration); ?>

                            </td>
                            <td class="px-6 py-4">
                                <span class="text-indigo-700 dark:text-indigo-300">
                                    <?php echo e($review->product->name ?? '-'); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-200">
                                <?php echo e($review->user->name ?? 'Guest'); ?>

                                <?php if($review->user && $review->user->email): ?>
                                    <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($review->user->email); ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <?php if($i <= $review->rating): ?>
                                            <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'star-filled','class' => 'w-4 h-4 inline-block text-yellow-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'star-filled','class' => 'w-4 h-4 inline-block text-yellow-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $attributes = $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $component = $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
                                        <?php else: ?>
                                            <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'star-empty','class' => 'w-4 h-4 inline-block text-gray-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'star-empty','class' => 'w-4 h-4 inline-block text-gray-300']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $attributes = $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8)): ?>
<?php $component = $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8; ?>
<?php unset($__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8); ?>
<?php endif; ?>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <span class="ml-2 text-gray-800 dark:text-gray-200 font-medium">
                                        <?php echo e($review->rating); ?> / 5
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-800 dark:text-gray-100">
                                <span class="whitespace-pre-line"><?php echo e($review->comment); ?></span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    <?php if (isset($component)) { $__componentOriginald756e030c4774b83c500f23dd3d7c0ad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald756e030c4774b83c500f23dd3d7c0ad = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-edit-button','data' => ['href' => route('admin.reviews.edit', $review)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-edit-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.reviews.edit', $review))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald756e030c4774b83c500f23dd3d7c0ad)): ?>
<?php $attributes = $__attributesOriginald756e030c4774b83c500f23dd3d7c0ad; ?>
<?php unset($__attributesOriginald756e030c4774b83c500f23dd3d7c0ad); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald756e030c4774b83c500f23dd3d7c0ad)): ?>
<?php $component = $__componentOriginald756e030c4774b83c500f23dd3d7c0ad; ?>
<?php unset($__componentOriginald756e030c4774b83c500f23dd3d7c0ad); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal8f15d364f5bcededd1a8e1e23253c652 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8f15d364f5bcededd1a8e1e23253c652 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-delete-button','data' => ['action' => route('admin.reviews.destroy', $review)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-delete-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.reviews.destroy', $review))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8f15d364f5bcededd1a8e1e23253c652)): ?>
<?php $attributes = $__attributesOriginal8f15d364f5bcededd1a8e1e23253c652; ?>
<?php unset($__attributesOriginal8f15d364f5bcededd1a8e1e23253c652); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8f15d364f5bcededd1a8e1e23253c652)): ?>
<?php $component = $__componentOriginal8f15d364f5bcededd1a8e1e23253c652; ?>
<?php unset($__componentOriginal8f15d364f5bcededd1a8e1e23253c652); ?>
<?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="py-12 text-center text-gray-500 dark:text-gray-300 text-lg">
                                No reviews found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-[#23263a] bg-white dark:bg-[#23263a]">
            <?php echo e($reviews->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/reviews/index.blade.php ENDPATH**/ ?>