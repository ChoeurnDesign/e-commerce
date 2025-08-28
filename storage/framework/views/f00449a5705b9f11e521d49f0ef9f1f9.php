<?php $__currentLoopData = ['success'=>'green','status'=>'green','warning'=>'amber','error'=>'red','info'=>'blue']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(session($key)): ?>
        <div x-data="{ show:true }"
             x-show="show"
             x-transition
             class="mb-6 border border-<?php echo e($color); ?>-400 dark:border-<?php echo e($color); ?>-700 bg-<?php echo e($color); ?>-100 dark:bg-<?php echo e($color); ?>-900/40 text-<?php echo e($color); ?>-800 dark:text-<?php echo e($color); ?>-200 px-4 py-3 rounded relative text-sm">
            <span class="block"><?php echo e(session($key)); ?></span>
            <button type="button" @click="show=false" class="absolute top-1 right-2 text-<?php echo e($color); ?>-600 dark:text-<?php echo e($color); ?>-300">
                &times;
            </button>
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/seller/partials/flash.blade.php ENDPATH**/ ?>