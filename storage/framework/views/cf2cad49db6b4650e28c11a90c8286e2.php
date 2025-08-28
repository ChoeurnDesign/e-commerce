

<?php $__env->startSection('content'); ?>
<?php
    $user   = auth()->user();
    $seller = $seller ?? $user->seller;
?>

<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">Store Profile</h1>

    
    <?php $__currentLoopData = ['status' => 'green', 'info' => 'amber']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flash => $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(session($flash)): ?>
            <div class="mb-4 bg-<?php echo e($color); ?>-100 text-<?php echo e($color); ?>-800 px-4 py-2 rounded text-sm">
                <?php echo e(session($flash)); ?>

            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if($seller->admin_comment && $seller->status === 'rejected'): ?>
        <div class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded text-sm">
            Admin Comment: <?php echo e($seller->admin_comment); ?>

        </div>
    <?php endif; ?>

    <form method="POST"
          action="<?php echo e(route('seller.settings.update')); ?>"
          enctype="multipart/form-data"
          class="space-y-10">
        <?php echo csrf_field(); ?>

        
        <section class="bg-white dark:bg-[#23263a] p-6 rounded border border-gray-200 dark:border-gray-700 space-y-5">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Store Information</h2>

            <div>
                <label class="block text-sm font-medium mb-1">Store Name</label>
                <input type="text" name="store_name"
                       value="<?php echo e(old('store_name', $seller->store_name)); ?>"
                       class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500"
                       required>
                <?php $__errorArgs = ['store_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Description</label>
                <textarea name="description" rows="4"
                          class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500"><?php echo e(old('description', $seller->description)); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="text-sm">
                <span class="font-medium">Status:</span>
                <span class="ml-2 px-2 py-0.5 rounded text-xs
                    class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                        'bg-green-500/20 text-green-600' => $seller->status==='approved',
                        'bg-amber-500/20 text-amber-600' => $seller->status==='pending',
                        'bg-red-500/20 text-red-600'     => $seller->status==='rejected',
                        'bg-gray-500/20 text-gray-400'   => !in_array($seller->status,['approved','pending','rejected']),
                    ]); ?>"">
                    <?php echo e(ucfirst($seller->status)); ?>

                </span>
            </div>
        </section>

        
        <section class="bg-white dark:bg-[#23263a] p-6 rounded border border-gray-200 dark:border-gray-700 space-y-5">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Store Logo</h2>

            <?php if($seller->store_logo_url): ?>
                <div class="flex items-start gap-6 flex-wrap">
                    <div class="flex flex-col items-center gap-2">
                        <img src="<?php echo e($seller->store_logo_url); ?>"
                             alt="Store Logo"
                             class="w-28 h-28 rounded object-cover border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700"
                             onerror="this.onerror=null;this.src='<?php echo e(asset('images/default-store.png')); ?>';">
                        <span class="text-[11px] text-gray-500">Current Logo</span>
                    </div>
                    <label class="inline-flex items-center gap-2 text-sm mt-2">
                        <input type="checkbox" name="remove_logo" value="1"
                               class="rounded border-gray-500 text-red-600 focus:ring-red-500">
                        <span>Remove current logo</span>
                    </label>
                </div>
            <?php else: ?>
                <p class="text-sm text-gray-500">No logo uploaded yet.</p>
            <?php endif; ?>

            <div>
                <input type="file" name="store_logo" accept=".jpg,.jpeg,.png,.webp"
                       class="block w-full text-sm text-gray-300 dark:text-gray-300
                       file:bg-gray-700 file:dark:bg-gray-600 file:text-gray-100 file:border-0 file:px-3 file:py-2 file:rounded
                       file:hover:bg-gray-600">
                <p class="text-xs text-gray-500 mt-1">Accepted: JPG / PNG / WEBP (max 3MB)</p>
                <?php $__errorArgs = ['store_logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </section>

        
        <section class="bg-white dark:bg-[#23263a] p-6 rounded border border-gray-200 dark:border-gray-700 space-y-5">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Business Document</h2>

            <?php if($seller->business_document_url): ?>
                <div class="flex items-center gap-4 flex-wrap">
                    <a href="<?php echo e($seller->business_document_url); ?>" target="_blank"
                       class="px-3 py-1 rounded bg-indigo-600 text-white text-xs hover:bg-indigo-500">
                        View / Download
                    </a>
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" name="remove_document" value="1"
                               class="rounded border-gray-500 text-red-600 focus:ring-red-500">
                        <span>Remove current document</span>
                    </label>
                </div>
            <?php else: ?>
                <p class="text-sm text-gray-500">No document uploaded.</p>
            <?php endif; ?>

            <div>
                <input type="file" name="business_document" accept=".pdf,.jpg,.jpeg,.png,.webp"
                       class="block w-full text-sm text-gray-300 dark:text-gray-300
                       file:bg-gray-700 file:dark:bg-gray-600 file:text-gray-100 file:border-0 file:px-3 file:py-2 file:rounded
                       file:hover:bg-gray-600">
                <p class="text-xs text-gray-500 mt-1">Accepted: PDF / JPG / PNG / WEBP (max 4MB)</p>
                <?php $__errorArgs = ['business_document'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </section>

        <div class="flex gap-4">
            <button type="submit"
                    class="px-6 py-2 rounded bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Save Changes
            </button>
            <a href="<?php echo e(route('seller.dashboard')); ?>"
               class="px-6 py-2 rounded border text-sm dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800">
               Back
            </a>
            <?php if(Route::has('store.show') && $seller->slug && $seller->status==='approved'): ?>
                <a href="<?php echo e(route('store.show', $seller)); ?>"
                   target="_blank"
                   class="px-6 py-2 rounded bg-gray-700 text-white text-sm hover:bg-gray-600">
                    View Storefront
                </a>
            <?php endif; ?>
        </div>

        
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.seller', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/seller/settings/edit.blade.php ENDPATH**/ ?>