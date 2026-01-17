

<?php $__env->startSection('title', 'Seller Product Images'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-8 space-y-8">
    <div class="flex items-center justify-between flex-wrap gap-3">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Your Product Images</h1>
        <?php if(session('success')): ?>
            <div class="px-3 py-1.5 rounded bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
    </div>

    <?php if($errors->any()): ?>
        <div class="mb-4 text-red-700 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded p-3">
            <ul class="list-disc ml-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="text-sm"><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white dark:bg-[#23263a] rounded-xl border border-gray-200 dark:border-[#2b3150] p-6 space-y-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Upload Main Images</h2>
        <form action="<?php echo e(route('seller.images.uploadMain')); ?>" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-start gap-3">
            <?php echo csrf_field(); ?>
            <input type="file" name="main_images[]" multiple required class="text-sm">
            <button type="submit" class="inline-flex items-center px-4 py-2 rounded bg-indigo-600 hover:bg-indigo-700 text-white text-sm shadow">
                Upload Main Images
            </button>
        </form>
    </div>

    <div class="bg-white dark:bg-[#23263a] rounded-xl border border-gray-200 dark:border-[#2b3150] p-6 space-y-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Upload Gallery Images</h2>
        <form action="<?php echo e(route('seller.images.uploadGallery')); ?>" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-start gap-3">
            <?php echo csrf_field(); ?>
            <input type="file" name="gallery_images[]" multiple required class="text-sm">
            <button type="submit" class="inline-flex items-center px-4 py-2 rounded bg-indigo-600 hover:bg-indigo-700 text-white text-sm shadow">
                Upload Gallery Images
            </button>
        </form>
    </div>

    
    <?php if (isset($component)) { $__componentOriginal0cddb52b7e1a0caa17bcc83c14110d3e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0cddb52b7e1a0caa17bcc83c14110d3e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.images.grid','data' => ['title' => 'Main Images','images' => $mainImages,'deleteRoute' => 'seller.images.delete']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('images.grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Main Images','images' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($mainImages),'delete-route' => 'seller.images.delete']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0cddb52b7e1a0caa17bcc83c14110d3e)): ?>
<?php $attributes = $__attributesOriginal0cddb52b7e1a0caa17bcc83c14110d3e; ?>
<?php unset($__attributesOriginal0cddb52b7e1a0caa17bcc83c14110d3e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0cddb52b7e1a0caa17bcc83c14110d3e)): ?>
<?php $component = $__componentOriginal0cddb52b7e1a0caa17bcc83c14110d3e; ?>
<?php unset($__componentOriginal0cddb52b7e1a0caa17bcc83c14110d3e); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal0cddb52b7e1a0caa17bcc83c14110d3e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0cddb52b7e1a0caa17bcc83c14110d3e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.images.grid','data' => ['title' => 'Gallery Images','images' => $galleryImages,'deleteRoute' => 'seller.images.delete']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('images.grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Gallery Images','images' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($galleryImages),'delete-route' => 'seller.images.delete']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0cddb52b7e1a0caa17bcc83c14110d3e)): ?>
<?php $attributes = $__attributesOriginal0cddb52b7e1a0caa17bcc83c14110d3e; ?>
<?php unset($__attributesOriginal0cddb52b7e1a0caa17bcc83c14110d3e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0cddb52b7e1a0caa17bcc83c14110d3e)): ?>
<?php $component = $__componentOriginal0cddb52b7e1a0caa17bcc83c14110d3e; ?>
<?php unset($__componentOriginal0cddb52b7e1a0caa17bcc83c14110d3e); ?>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.seller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/seller/images/index.blade.php ENDPATH**/ ?>