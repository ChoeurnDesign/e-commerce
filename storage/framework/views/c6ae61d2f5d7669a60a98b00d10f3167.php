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
    <div class="py-12 min-h-screen flex flex-col items-center bg-gray-300 dark:bg-[#101624]">
        <div class="w-full max-w-4xl bg-white dark:bg-[#181f31] rounded-2xl shadow-xl p-10 border border-gray-300 dark:border-gray-700">
            <h1 class="text-3xl font-bold text-indigo-700 dark:text-indigo-300 mb-4">Contact Us</h1>
            <p class="text-gray-700 dark:text-gray-200 mb-6">
                Have a question, suggestion, or need help? Our team is here for you! Please reach out using the form below or email us directly.
            </p>
            <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <form action="<?php echo e(route('contact.submit')); ?>" method="POST" class="space-y-4 bg-indigo-50 dark:bg-[#23263a] rounded-lg p-6 border border-indigo-100 dark:border-indigo-900">
                <?php echo csrf_field(); ?>
                <div>
                    <label for="name" class="block text-gray-800 dark:text-gray-200 font-semibold">Your Name</label>
                    <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-white" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-sm"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label for="email" class="block text-gray-800 dark:text-gray-200 font-semibold">Email Address</label>
                    <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-white" required>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-sm"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label for="message" class="block text-gray-800 dark:text-gray-200 font-semibold">Message</label>
                    <textarea name="message" id="message" rows="5" class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-white" required><?php echo e(old('message')); ?></textarea>
                    <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-sm"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">Send Message</button>
            </form>
            <div class="mt-8 text-gray-700 dark:text-gray-200">
                <p><span class="font-semibold">Email:</span> support@shopexpress.com</p>
                <p><span class="font-semibold">Phone:</span> +855 70 229 710</p>
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
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/contact.blade.php ENDPATH**/ ?>