<div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6 mb-8">
    <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Customer Reviews</h2>

    <?php if($product->approvedReviews->count() > 0): ?>
        <div class="mb-4 flex items-center">
            <div class="flex text-yellow-400 mr-2">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <?php if($i <= round($product->average_rating)): ?>
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.385-2.46a1 1 0 00-1.175 0l-3.385 2.46c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118l-3.385-2.46c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.967z"/>
                        </svg>
                    <?php else: ?>
                        <svg class="w-5 h-5 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.385 2.46a1 1 0 00-.364 1.118l1.287 3.966c.3.922-.755 1.688-1.54 1.118l-3.385-2.46a1 1 0 00-1.175 0l-3.385 2.46c-.784.57-1.838-.196-1.54-1.118l1.287-3.966a1 1 0 00-.364-1.118l-3.385-2.46c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.967z"/>
                        </svg>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
            <span class="text-lg font-semibold text-gray-900 dark:text-gray-100"><?php echo e(number_format($product->average_rating, 1)); ?> out of 5</span>
            <span class="text-gray-500 dark:text-gray-400 ml-2">(<?php echo e($product->reviews_count); ?> reviews)</span>
        </div>

        <div class="space-y-6">
            <?php $__currentLoopData = $product->approvedReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-4 last:border-b-0">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <div class="font-semibold text-gray-900 dark:text-gray-100"><?php echo e($review->user->name ?? 'Anonymous'); ?></div>
                        <div class="text-yellow-400 mt-1">
                            <?php echo $review->rating_stars; ?>

                        </div>
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <?php echo e($review->created_at->format('M d, Y')); ?>

                        <?php if(auth()->guard()->check()): ?>
                            <?php if(isset($userReview) && $review->id === $userReview->id): ?>
                                <form action="<?php echo e(route('reviews.destroy', $review->id)); ?>" method="POST" class="inline-block mt-2 ml-2"
                                    onsubmit="return confirm('Are you sure you want to delete your review?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-medium transition">
                                        Delete Review
                                    </button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-300"><?php echo e($review->comment); ?></p>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(isset($userReview) && $review->id === $userReview->id): ?>
                        <div class="mt-4">
                            <a href="<?php echo e(route('reviews.edit', $review->id)); ?>"
                            class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-2 py-2 rounded text-sm font-medium transition">
                                Edit Your Review
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <p class="text-gray-500 dark:text-gray-400 mb-4">No reviews yet for this product.</p>
    <?php endif; ?>

    <?php if(auth()->guard()->check()): ?>
        <?php if(!$userReview): ?>
            <!-- Only show Add Review button/form if user hasn't reviewed yet -->
            <div class="mt-6 text-center">
                <a
                    href="#add-review-form"
                    class="inline-block border border-indigo-600 dark:border-purple-400 text-indigo-600 dark:text-purple-300 hover:bg-indigo-600 dark:hover:bg-purple-700 hover:text-white px-5 py-2 rounded-full font-medium transition">
                    Add Review </a>
            </div>
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700" id="add-review-form">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Write a Review</h3>
                <?php if($errors->any()): ?>
                    <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
                        <ul class="text-sm">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>- <?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <form action="<?php echo e(route('reviews.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                    <div class="mb-4">
                        <label for="rating" class="block font-semibold mb-2">Rating</label>
                        <select name="rating" id="rating" required class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100">
                            <option value="">Select rating</option>
                            <?php for($i=5; $i>=1; $i--): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e(old('rating') == $i ? 'selected' : ''); ?>><?php echo e($i); ?></option>
                            <?php endfor; ?>
                        </select>
                        <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-4">
                        <label for="comment" class="block font-semibold mb-2">Comment</label>
                        <textarea name="comment" id="comment" rows="4" class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100"><?php echo e(old('comment')); ?></textarea>
                        <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-600 dark:text-red-400"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">Submit Review</button>
                </form>
            </div>
        <?php else: ?>
            <!-- User has already reviewed -->
            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
                <p class="text-gray-600 dark:text-gray-300">
                    You have already reviewed this product.
                    <a href="<?php echo e(route('reviews.edit', $userReview->id)); ?>"
                       class="text-indigo-600 dark:text-purple-300 font-medium underline">Edit your review</a>
                </p>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(auth()->guard()->guest()): ?>
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
            <p class="text-gray-600 dark:text-gray-300">Please <a href="<?php echo e(route('login')); ?>" class="text-indigo-600 dark:text-purple-300 font-medium">sign in</a> to leave a review</p>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/products/_reviews.blade.php ENDPATH**/ ?>