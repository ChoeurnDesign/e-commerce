<?php
    $documents = $seller->documents ?? collect();
?>

<div class="mb-8">
    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">
        Business & Compliance Documents
    </h3>

    <form action="<?php echo e(route('admin.sellers.documents.store', $seller->id)); ?>"
          method="POST" enctype="multipart/form-data"
          class="mb-4 flex flex-wrap items-center gap-3">
        <?php echo csrf_field(); ?>
        <input type="file" name="file" required class="text-sm">
        <input type="text" name="type" placeholder="Type (optional)"
               class="border rounded px-2 py-1 text-sm">
        <button class="px-3 py-1.5 bg-indigo-600 text-white text-xs rounded hover:bg-indigo-700">
            Upload
        </button>
        <?php $__errorArgs = ['file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-red-600 text-xs"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </form>

    <?php if($documents->count()): ?>
        <ul class="space-y-3">
            <?php $__currentLoopData = $documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="flex items-center gap-4 bg-gray-100 dark:bg-gray-900 p-4 rounded">
                    <span class="flex-1">
                        <span class="font-medium text-gray-800 dark:text-gray-200">
                            <?php echo e($document->original_name ?? basename($document->path)); ?>

                        </span>
                        <span class="block text-xs text-gray-500 mt-1">
                            <?php echo e($document->type ?? '—'); ?> • <?php echo e($document->created_at->format('Y-m-d')); ?>

                        </span>
                    </span>
                    <a class="text-blue-500 hover:underline"
                       href="<?php echo e(Storage::url($document->path)); ?>" target="_blank">View</a>
                    <form action="<?php echo e(route('admin.sellers.documents.destroy', [$seller->id,$document->id])); ?>"
                          method="POST" onsubmit="return confirm('Delete?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="text-red-600 text-xs hover:underline">Delete</button>
                    </form>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php else: ?>
        <div class="text-gray-500 dark:text-gray-400">No documents.</div>
    <?php endif; ?>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/sellers/partials/documents.blade.php ENDPATH**/ ?>