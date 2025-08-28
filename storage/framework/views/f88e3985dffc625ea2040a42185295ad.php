<?php $__env->startSection('title', 'Customers Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6 min-h-screen">
    <div class="mb-6 flex items-center">
        <span class="mr-2">
            <?php if (isset($component)) { $__componentOriginal7ac833788d87377235d115adad0b6b1f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7ac833788d87377235d115adad0b6b1f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-dashboard','data' => ['name' => 'customers','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'customers','class' => 'w-7 h-7 text-indigo-600 dark:text-yellow-400']); ?>
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
        <h1 class="text-2xl text-gray-900 dark:text-gray-100">Customers</h1>
    </div>

    
    <?php if (isset($component)) { $__componentOriginal3b92e91ca199bcc05fbf8ea1b4f94559 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3b92e91ca199bcc05fbf8ea1b4f94559 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.simple-search','data' => ['placeholder' => 'ID / Name / Email','hint' => 'Search by user id, name or email','width' => 'w-80','autofocus' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.simple-search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'ID / Name / Email','hint' => 'Search by user id, name or email','width' => 'w-80','autofocus' => true]); ?>
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

    <!-- Customers Table -->
    <div class="bg-white dark:bg-[#23263a] shadow overflow-hidden border border-gray-300 dark:border-[#23263a]">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-[#23263a]">
                <thead>
                    <tr class="bg-gray-300 dark:bg-[#232c47]">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Profile</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Joined</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-[#23263a] divide-y divide-gray-200 dark:divide-[#23263a]">
                    <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-300 dark:hover:bg-[#262c47]">
                            <td class="px-6 py-4 text-gray-900 dark:text-gray-100">
                                <?php echo e(($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration); ?>

                            </td>
                            <td class="px-6 py-4">
                                <?php if($customer->profile_image): ?>
                                    <div class="w-10 h-10 rounded-full overflow-hidden shadow border-2 border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                        <img src="<?php echo e(asset('storage/'.$customer->profile_image)); ?>"
                                             alt="Avatar"
                                             class="w-full h-full object-cover object-center" />
                                    </div>
                                <?php else: ?>
                                    <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-300">
                                        <?php echo e(strtoupper(substr($customer->name, 0, 1))); ?>

                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                <?php echo e($customer->name); ?>

                                <?php if(now()->diffInDays($customer->created_at) < 7): ?>
                                    <span class="ml-2 px-2 py-0.5 rounded-full text-xs bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 animate-pulse">
                                        New
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-200"><?php echo e($customer->email); ?></td>
                            <td class="px-6 py-4">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                    <?php echo e($customer->role === 'admin' ? 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300' : 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300'); ?>">
                                    <?php echo e(ucfirst($customer->role)); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="<?php echo e(now()->diffInDays($customer->created_at) < 7 ? 'text-blue-700 dark:text-blue-300' : 'text-gray-600 dark:text-gray-300'); ?>">
                                    <?php echo e($customer->created_at->format('Y-m-d')); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-3">
                                    <?php if (isset($component)) { $__componentOriginal70a2035071353f1201414054627b0022 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal70a2035071353f1201414054627b0022 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-view-button','data' => ['href' => route('admin.customers.show', $customer->id)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-view-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.customers.show', $customer->id))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal70a2035071353f1201414054627b0022)): ?>
<?php $attributes = $__attributesOriginal70a2035071353f1201414054627b0022; ?>
<?php unset($__attributesOriginal70a2035071353f1201414054627b0022); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal70a2035071353f1201414054627b0022)): ?>
<?php $component = $__componentOriginal70a2035071353f1201414054627b0022; ?>
<?php unset($__componentOriginal70a2035071353f1201414054627b0022); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginald756e030c4774b83c500f23dd3d7c0ad = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald756e030c4774b83c500f23dd3d7c0ad = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-edit-button','data' => ['href' => route('admin.customers.edit', $customer->id)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-edit-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.customers.edit', $customer->id))]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.table-delete-button','data' => ['action' => route('admin.customers.destroy', $customer->id)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.table-delete-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['action' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.customers.destroy', $customer->id))]); ?>
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
                            <td colspan="7" class="py-12 text-center text-gray-500 dark:text-gray-300 text-lg">
                                No customers found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-[#23263a] bg-white dark:bg-[#23263a]">
            <?php echo e($customers->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/customers/index.blade.php ENDPATH**/ ?>