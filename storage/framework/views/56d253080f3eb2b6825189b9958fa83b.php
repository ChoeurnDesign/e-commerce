<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['seller', 'reviews']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['seller', 'reviews']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="flex flex-col items-center my-10">
    <div class="flex items-center">
        <?php
            $avg = round($seller->storeReviews()->avg('rating'), 1);
            $count = $seller->storeReviews()->count();
        ?>
        
        <?php if($count > 0): ?>
            <?php for($i = 1; $i <= 5; $i++): ?>
                <?php if($avg >= $i): ?>
                    <span class="text-yellow-400 text-2xl">&#9733;</span>
                <?php elseif($avg > $i - 1): ?>
                    <span class="text-yellow-400 text-2xl">&#9733;</span>
                <?php else: ?>
                    <span class="text-gray-300 dark:text-gray-700 text-2xl">&#9733;</span>
                <?php endif; ?>
            <?php endfor; ?>
            <span class="ml-2 text-md text-gray-500 dark:text-gray-400">
                (<?php echo e($avg); ?>) / <?php echo e($count); ?> review<?php echo e($count > 1 ? 's' : ''); ?>

            </span>
        <?php else: ?>
            <span class="text-gray-400 dark:text-gray-600">No ratings yet</span>
        <?php endif; ?>
    </div>
    
    
    <div class="w-full mt-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 flex flex-col items-start text-left hover:shadow-lg transition-all">
                    <div class="flex items-center justify-between w-full mb-3">
                        <div class="flex items-center">
                            <?php
                                $reviewUser = $review->user;
                                $reviewUserName = $reviewUser && $reviewUser->name ? $reviewUser->name : 'Anonymous';
                            ?>

                            <?php if($reviewUser && $reviewUser->profile_image && file_exists(public_path('storage/' . $reviewUser->profile_image))): ?>
                                <img src="<?php echo e(asset('storage/' . $reviewUser->profile_image)); ?>" alt="Avatar"
                                    class="w-14 h-14 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700" />
                            <?php else: ?>
                                <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($reviewUserName)); ?>" alt="Avatar"
                                    class="w-14 h-14 rounded-full object-cover border-2 border-gray-200 dark:border-gray-700" />
                            <?php endif; ?>
                        </div>

                        
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->id() === $review->user_id): ?>
                                <div class="flex space-x-2">
                                    <button onclick="editReview(<?php echo e($review->id); ?>)" 
                                        class="text-blue-600 hover:text-blue-800 text-sm">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <button onclick="deleteReview(<?php echo e($review->id); ?>)" 
                                        class="text-red-600 hover:text-red-800 text-sm">
                                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    
                    <div id="review-content-<?php echo e($review->id); ?>" class="text-gray-700 dark:text-gray-300 mb-4 min-h-[48px] w-full">
                        <?php echo e($review->comment); ?>

                    </div>

                    
                    <div id="edit-form-<?php echo e($review->id); ?>" class="hidden w-full mb-4">
                        <form onsubmit="updateReview(event, <?php echo e($review->id); ?>)">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rating</label>
                                <select name="rating" class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <option value="<?php echo e($i); ?>" <?php echo e($review->rating == $i ? 'selected' : ''); ?>><?php echo e($i); ?> Star<?php echo e($i > 1 ? 's' : ''); ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Comment</label>
                                <textarea name="comment" rows="3" class="w-full border border-gray-300 dark:border-gray-600 rounded-md px-3 py-2 dark:bg-gray-700 dark:text-white" required><?php echo e($review->comment); ?></textarea>
                            </div>
                            <div class="flex space-x-2">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm">
                                    Update
                                </button>
                                <button type="button" onclick="cancelEdit(<?php echo e($review->id); ?>)" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 text-sm">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="flex-col items-center">
                        <div class="">
                            <div class="font-semibold text-gray-900 dark:text-gray-100">
                                <?php echo e($review->user->name ?? 'Anonymous'); ?>

                            </div>
                        </div>
                        <span class="font-semibold text-lg text-yellow-500"><?php echo e(number_format($review->rating, 1)); ?></span>
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <span class="<?php echo e($i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-700'); ?> text-xl">&#9733;</span>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>


<script>
    function editReview(reviewId) {
        document.getElementById('review-content-' + reviewId).classList.add('hidden');
        document.getElementById('edit-form-' + reviewId).classList.remove('hidden');
    }

    function cancelEdit(reviewId) {
        document.getElementById('review-content-' + reviewId).classList.remove('hidden');
        document.getElementById('edit-form-' + reviewId).classList.add('hidden');
    }

    function updateReview(event, reviewId) {
        event.preventDefault();
        
        const form = event.target;
        const formData = new FormData(form);

        // Build the correct seller-prefixed route URL for updating store reviews
        const updateUrlTemplate = "<?php echo e(route('seller.reviews.update', ['review' => ':id'])); ?>";
        const url = updateUrlTemplate.replace(':id', reviewId);

        fetch(url, {
            method: 'POST', // formData contains _method=PUT (from <?php echo method_field('PUT'); ?>), so POST is fine
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // show alert for success (controller returns 'message' in JSON)
                alert(data.message || 'Review updated successfully');
                location.reload(); // Reload page to show updated review
            } else {
                alert('Error updating review: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating review');
        });
    }

    function deleteReview(reviewId) {
        if (confirm('Are you sure you want to delete this review?')) {
            const deleteUrlTemplate = "<?php echo e(route('seller.reviews.destroy', ['review' => ':id'])); ?>";
            const url = deleteUrlTemplate.replace(':id', reviewId);

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // show alert for success (controller returns 'message' in JSON)
                    alert(data.message || 'Review deleted successfully');
                    location.reload(); // Reload page to remove deleted review
                } else {
                    alert('Error deleting review: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting review');
            });
        }
    }
</script><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/store/reviews-grid.blade.php ENDPATH**/ ?>