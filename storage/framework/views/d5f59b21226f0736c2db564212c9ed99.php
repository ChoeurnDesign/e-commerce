<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
     <?php $__env->endSlot(); ?>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            
            <section
                class="relative bg-white dark:bg-gradient-to-b dark:from-slate-900 dark:via-slate-800 dark:to-slate-900 shadow-2xl overflow-hidden">
                
                <div class="">
                    <?php if (isset($component)) { $__componentOriginalc132df06a9593e4f03748b2046b1e9c4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc132df06a9593e4f03748b2046b1e9c4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.store.banner-header','data' => ['seller' => $seller,'logoClass' => 'w-44 h-44','bannerClass' => 'h-54','bannerFontClass' => 'text-2xl','logoOffset' => '-bottom-24']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('store.banner-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['seller' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seller),'logoClass' => 'w-44 h-44','bannerClass' => 'h-54','bannerFontClass' => 'text-2xl','logoOffset' => '-bottom-24']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc132df06a9593e4f03748b2046b1e9c4)): ?>
<?php $attributes = $__attributesOriginalc132df06a9593e4f03748b2046b1e9c4; ?>
<?php unset($__attributesOriginalc132df06a9593e4f03748b2046b1e9c4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc132df06a9593e4f03748b2046b1e9c4)): ?>
<?php $component = $__componentOriginalc132df06a9593e4f03748b2046b1e9c4; ?>
<?php unset($__componentOriginalc132df06a9593e4f03748b2046b1e9c4); ?>
<?php endif; ?>
                </div>

                
                <div class="px-8 pb-12 pt-6">
                    <div class="flex flex-col md:flex-row md:items-end md:gap-8">
                        
                        <div class="w-8"></div>

                        <div class="flex-1">
                            <?php $followersCount = $seller->followers_count ?? 0; ?>

                            <div class="w-full mt-4 flex justify-between">
                                <div class="flex ml-36 items-center">
                                    
                                    <span class="inline-flex items-center gap-2 mr-3 text-emerald-500 dark:text-emerald-300 text-lg font-semibold leading-none">
                                        <?php echo e($followersCount); ?> <?php echo e(\Illuminate\Support\Str::plural('follower', $followersCount)); ?>

                                    </span>

                                    
                                    <?php echo $__env->make('stores.partials.follow-button', [
                                        'seller' => $seller,
                                        'isFollowing' => $isFollowing ?? null,
                                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                </div>

                                <div class="flex">
                                    
                                    <?php echo $__env->make('stores.partials.chat-button', ['seller' => $seller], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                </div>
                            </div>

                            <h1
                                class="text-4xl mt-8 md:text-5xl font-extrabold text-cyan-700 dark:text-cyan-400 tracking-wide">
                                <?php echo e($seller->store_name ?? $seller->name); ?>

                            </h1>

                            
                            <div class="mt-6 flex flex-wrap items-center gap-4">
                                <span
                                    class="inline-flex items-center gap-3
                                            bg-indigo-500 dark:bg-indigo-800 text-gray-100
                                            px-4 py-2 rounded-full shadow-sm text-sm font-semibold">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-inbox'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 text-blue-300']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                    Products: <?php echo e($seller->products_count ?? $seller->products()->count()); ?>

                                </span>

                                <?php if(auth()->guard()->check()): ?>
                                    <?php
                                        $hasReviewed = auth()->check() && auth()->user()->hasReviewedStore($seller->id);
                                    ?>

                                    <?php if(!$hasReviewed): ?>
                                        <button
                                            @click.prevent="document.dispatchEvent(new CustomEvent('show-store-review'))"
                                            class="inline-flex items-center gap-2
                                                bg-sky-600 text-white
                                                dark:bg-blue-600 dark:text-white text-gray-100
                                                px-4 py-2 rounded-full shadow-sm hover:bg-sky-700 transition text-sm font-semibold">
                                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 text-blue-300']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                            Add Review
                                        </button>
                                    <?php else: ?>
                                        <span
                                            class="inline-flex items-center gap-2
                                                    bg-blue-600 dark:bg-blue-800 text-gray-100
                                                    px-4 py-2 rounded-full shadow-sm text-sm font-semibold">
                                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 text-blue-300']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                            Reviewed
                                        </span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <a href="<?php echo e(route('login')); ?>"
                                        class="inline-flex items-center gap-2 bg-sky-600 text-white dark:text-white px-4 py-2 rounded-full shadow-sm hover:bg-sky-700 dark:hover:bg-blue-600 transition text-sm font-semibold">
                                        Add Review
                                    </a>
                                <?php endif; ?>

                                <span
                                    class="inline-flex items-center gap-3
                                            bg-green-500 text-gray-100 dark:bg-green-700 
                                            px-4 py-2 rounded-full shadow-sm text-sm font-semibold">
                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-calendar-days'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 text-blue-300']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                    Opened: <?php echo e($seller->created_at->format('Y-m-d')); ?>

                                </span>
                            </div>

                            
                            <div class="mt-6 text-slate-700 dark:text-slate-300 prose prose-invert max-w-none">
                                <p class="mt-2 text-green-700 dark:text-green-300 text-sm md:text-base">
                                    <?php echo e($seller->description ?? 'No description provided.'); ?>

                                </p>
                            </div>
                        </div>
                    </div>

                    
                    <?php echo $__env->make('stores.partials.contact-info', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
            </section>

            
            <?php if(auth()->guard()->check()): ?>
                <?php if(!(auth()->user()->hasReviewedStore($seller->id) ?? false)): ?>
                    <div id="review-form-container" x-data="{ show: false, rating: 0 }" x-init="document.addEventListener('show-store-review', () => show = true)" x-show="show"
                        style="display: none;" role="dialog" aria-modal="true" aria-labelledby="review-modal-title"
                        class="fixed inset-0 z-50 flex items-center justify-center p-4">
                        <div class="absolute inset-0 bg-black bg-opacity-50" @click="show = false" aria-hidden="true"></div>

                        <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-xl relative"
                            @keydown.escape.window="show = false">
                            <!-- Header -->
                            <div class="bg-gray-700 px-6 py-4 rounded-t-lg flex items-center justify-between">
                                <div class="text-white">
                                    <h3 id="review-modal-title" class="text-lg">Add Review</h3>
                                    <p class="text-sm text-gray-300">To "<?php echo e($seller->store_name ?? $seller->name); ?>"</p>
                                </div>
                                <button type="button" @click="show = false" class="text-white text-xl hover:text-gray-300"
                                    aria-label="Close modal">✕</button>
                            </div>

                            <!-- Form -->
                            <div class="p-6">
                                <form action="<?php echo e(route('seller.store-reviews.store', $seller)); ?>" method="POST" novalidate>
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-4">
                                        <label for="rating" class="block text-gray-300 text-sm mb-3">How would you rate this store?</label>

                                        <div class="flex items-center gap-1 mb-2" role="radiogroup" aria-labelledby="rating">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <button type="button" @click="rating = <?php echo e($i); ?>"
                                                    :aria-checked="rating === <?php echo e($i); ?>" role="radio"
                                                    tabindex="<?php echo e($i === 1 ? '0' : '-1'); ?>"
                                                    class="text-2xl transition-colors"
                                                    :class="rating >= <?php echo e($i); ?> ? 'text-yellow-400' : 'text-gray-500'">
                                                    <template x-if="rating >= <?php echo e($i); ?>">
                                                        <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'star-empty','class' => 'h-8 w-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'star-empty','class' => 'h-8 w-8']); ?>
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
                                                    </template>
                                                    <template x-if="rating < <?php echo e($i); ?>">
                                                        <?php if (isset($component)) { $__componentOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9467a222f025bb28cc0dfbd8d0ecdd8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icon-nav','data' => ['name' => 'star-filled','class' => 'h-8 w-8']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icon-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'star-filled','class' => 'h-8 w-8']); ?>
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
                                                    </template>
                                                </button>
                                            <?php endfor; ?>
                                        </div>

                                        <input type="hidden" name="rating" :value="rating" required>

                                        <div x-show="rating === 0" class="text-red-400 text-sm mb-3" role="alert">
                                            Please select a rating
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <label for="comment" class="block text-gray-300 text-sm mb-2">Share your experience</label>
                                        <textarea id="comment" name="comment" rows="4" required
                                            placeholder="Tell others about your experience with this store..."
                                            class="w-full bg-gray-700 text-gray-300 px-4 py-3 rounded border-0 resize-none focus:bg-gray-600 transition-colors"></textarea>
                                    </div>

                                    <div class="flex gap-3">
                                        <button type="submit" :disabled="rating === 0"
                                            :class="rating === 0 ? 'bg-gray-600 cursor-not-allowed' : 'bg-gray-600 hover:bg-gray-500'"
                                            class="flex-1 text-white py-2 rounded-full transition-colors">
                                            Submit Review
                                        </button>
                                        <button type="button" @click="show = false"
                                            class="px-6 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-full transition-colors">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            
            <div class="mt-10">
                <div class="flex justify-between items-center mb-6 flex-wrap gap-4">
                    <p class="text-slate-700 dark:text-slate-300 font-medium">
                        <span class="text-emerald-600 dark:text-emerald-400">
                            <?php echo e($products->total()); ?>

                        </span>
                        products found in this store
                    </p>
                    <div
                        class="text-sm text-slate-600 dark:text-slate-400 bg-white/60 dark:bg-slate-800/40 px-4 py-2 rounded-full border border-slate-200/60 dark:border-slate-700/40">
                        Page <?php echo e($products->currentPage()); ?> of <?php echo e($products->lastPage()); ?>

                    </div>
                </div>

                <?php if($products->count()): ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if (isset($component)) { $__componentOriginal7f6ddac8eec65d4d0856184e2105c7fe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7f6ddac8eec65d4d0856184e2105c7fe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.products.product-card','data' => ['product' => $product]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('products.product-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['product' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7f6ddac8eec65d4d0856184e2105c7fe)): ?>
<?php $attributes = $__attributesOriginal7f6ddac8eec65d4d0856184e2105c7fe; ?>
<?php unset($__attributesOriginal7f6ddac8eec65d4d0856184e2105c7fe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7f6ddac8eec65d4d0856184e2105c7fe)): ?>
<?php $component = $__componentOriginal7f6ddac8eec65d4d0856184e2105c7fe; ?>
<?php unset($__componentOriginal7f6ddac8eec65d4d0856184e2105c7fe); ?>
<?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="flex justify-center">
                        <?php echo e($products->links()); ?>

                    </div>
                <?php else: ?>
                    <div
                        class="text-center py-16 bg-white/60 dark:bg-slate-800/40 rounded-2xl shadow-md border border-slate-200/60 dark:border-slate-700/40">
                        <div class="text-6xl mb-4 text-slate-500 dark:text-slate-400" aria-hidden="true">📦</div>
                        <h3 class="text-xl text-slate-700 dark:text-slate-300 mb-4">
                            No Available Products Found
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 mb-6">
                            Try adjusting your filters or check back later.
                        </p>
                        <a href="<?php echo e(route('stores.index')); ?>"
                            class="bg-sky-600 hover:bg-sky-700 text-white px-8 py-3 rounded-full font-medium transition-all shadow-md hover:shadow-lg">
                            View All Stores
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            
            <div class="mt-10">
                <?php if (isset($component)) { $__componentOriginal70d91d0bce643fce95370f48a1a12310 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal70d91d0bce643fce95370f48a1a12310 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.store.reviews-grid','data' => ['seller' => $seller,'reviews' => $reviews]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('store.reviews-grid'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['seller' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($seller),'reviews' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($reviews)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal70d91d0bce643fce95370f48a1a12310)): ?>
<?php $attributes = $__attributesOriginal70d91d0bce643fce95370f48a1a12310; ?>
<?php unset($__attributesOriginal70d91d0bce643fce95370f48a1a12310); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal70d91d0bce643fce95370f48a1a12310)): ?>
<?php $component = $__componentOriginal70d91d0bce643fce95370f48a1a12310; ?>
<?php unset($__componentOriginal70d91d0bce643fce95370f48a1a12310); ?>
<?php endif; ?>
            </div>

        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/stores/show.blade.php ENDPATH**/ ?>