<?php if(session('success')): ?>
    <div id="alert-success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center" role="alert">
        <span class="block sm:inline"><?php echo e(session('success')); ?></span>
    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div id="alert-error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center" role="alert">
        <span class="block sm:inline"><?php echo e(session('error')); ?></span>
    </div>
<?php endif; ?>
<?php if(session('warning')): ?>
    <div id="alert-warning" class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4 text-center" role="alert">
        <span class="block sm:inline"><?php echo e(session('warning')); ?></span>
    </div>
<?php endif; ?>
<?php if($errors->any()): ?>
    <div id="alert-validation" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center" role="alert">
        <ul class="list-disc list-inside text-center">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<script>
    // Hide all alerts after 3 seconds
    setTimeout(function() {
        ['alert-success', 'alert-error', 'alert-warning', 'alert-validation'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.style.display = 'none';
        });
    }, 3000);
</script>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/flash-messages.blade.php ENDPATH**/ ?>