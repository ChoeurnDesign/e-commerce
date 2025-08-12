<?php $__env->startSection('content'); ?>
<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto p-8 min-h-screen font-sans">
    
<div
    x-data="{
        showEdit: false,
        editBanner: null,
        editForm: { id: '', title: '', subtitle: '', order: '', image: '' },
        openEdit(banner) {
            this.editForm = {
                id: banner.id,
                title: banner.title ?? '',
                subtitle: banner.subtitle ?? '',
                order: banner.order ?? 0,
                image: ''
            };
            this.showEdit = true;
        }
    }"
    class="mb-12 bg-gray-800 p-8 rounded-xl shadow-lg space-y-8"
>
    <h2 class="text-3xl text-white mb-6 border-b border-gray-700 pb-4">Homepage Banners</h2>
    
    <form action="<?php echo e(route('admin.settings.add_banner')); ?>" method="POST" enctype="multipart/form-data" class="mb-8">
        <?php echo csrf_field(); ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <div>
                <label class="block text-gray-300 mb-2">Image</label>
                <input type="file" name="image" required class="bg-gray-700 border-none text-gray-100 p-2 rounded">
            </div>
            <div>
                <label class="block text-gray-300 mb-2">Order</label>
                <input type="number" name="order" value="0" class="bg-gray-700 border-none text-gray-100 p-2 rounded">
            </div>
            <div>
                <label class="block text-gray-300 mb-2">Title (optional)</label>
                <input type="text" name="title" class="bg-gray-700 border-none text-gray-100 p-2 rounded">
            </div>
            <div>
                <label class="block text-gray-300 mb-2">Subtitle (optional)</label>
                <input type="text" name="subtitle" class="bg-gray-700 border-none text-gray-100 p-2 rounded">
            </div>
        </div>
        <button type="submit" class="bg-indigo-600 text-white rounded px-5 py-2 font-bold">Add Banner</button>
    </form>

    
    <div class="space-y-4">
        <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-gray-700 p-4 rounded flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img src="<?php echo e(asset('storage/'.$banner->image_path)); ?>" class="h-16 rounded shadow" />
                    <div>
                        <div class="text-white font-bold"><?php echo e($banner->title); ?></div>
                        <div class="text-gray-300"><?php echo e($banner->subtitle); ?></div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <button
                        class="text-blue-400 hover:text-blue-600 font-bold"
                        @click="openEdit({
                            id: <?php echo e($banner->id); ?>,
                            title: <?php echo \Illuminate\Support\Js::from($banner->title)->toHtml() ?>,
                            subtitle: <?php echo \Illuminate\Support\Js::from($banner->subtitle)->toHtml() ?>,
                            order: <?php echo e($banner->order); ?>

                        })"
                        type="button"
                    >
                        Edit
                    </button>
                    <form action="<?php echo e(route('admin.settings.delete_banner', $banner)); ?>" method="POST" onsubmit="return confirm('Delete this banner?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button class="text-red-400 hover:text-red-600 font-bold">Delete</button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div
        x-show="showEdit"
        style="display: none;"
        class="fixed inset-0 bg-black/40 flex items-center justify-center z-50"
    >
        <div class="bg-gray-800 p-8 rounded-xl shadow-lg w-full max-w-lg relative">
            <button class="absolute top-3 right-4 text-gray-400" @click="showEdit = false">&times;</button>
            <h3 class="text-2xl font-bold text-white mb-4">Edit Banner</h3>
            <form
                :action="'/admin/settings/banner/' + editForm.id + '/edit'"
                method="POST"
                enctype="multipart/form-data"
            >
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="mb-4">
                    <label class="block text-gray-300 mb-2">Image (leave blank to keep current)</label>
                    <input type="file" name="image" class="bg-gray-700 border-none text-gray-100 p-2 rounded w-full">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-300 mb-2">Order</label>
                    <input type="number" name="order" x-model="editForm.order" class="bg-gray-700 border-none text-gray-100 p-2 rounded w-full">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-300 mb-2">Title (optional)</label>
                    <input type="text" name="title" x-model="editForm.title" class="bg-gray-700 border-none text-gray-100 p-2 rounded w-full">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-300 mb-2">Subtitle (optional)</label>
                    <input type="text" name="subtitle" x-model="editForm.subtitle" class="bg-gray-700 border-none text-gray-100 p-2 rounded w-full">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-indigo-600 text-white rounded px-5 py-2 font-bold">Save Changes</button>
                    <button type="button" class="bg-gray-700 text-white rounded px-5 py-2 font-bold" @click="showEdit = false">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

    
    <form action="<?php echo e(route('admin.settings.save_general')); ?>" method="POST" enctype="multipart/form-data" class="mb-12 bg-gray-800 p-8 rounded-xl shadow-lg space-y-8">
        <?php echo csrf_field(); ?>
        <h2 class="text-3xl text-white mb-6 border-b border-gray-700 pb-4">General Settings</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label for="store_name" class="block text-sm font-medium text-gray-300 mb-2">Store Name</label>
                <input type="text" id="store_name" name="store_name" value="<?php echo e(old('store_name', $settings['store_name'] ?? '')); ?>" class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4" placeholder="e.g., My Awesome Shop">
            </div>
            <div>
                <label for="base_currency" class="block text-sm font-medium text-gray-300 mb-2">Base Currency</label>
                <input id="base_currency" name="base_currency" type="text" value="USD" class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4" disabled>
                <p class="text-xs text-gray-400 mt-1">All product prices are stored in USD. Display currency can be changed by users only.</p>
            </div>
            <div>
                <label for="store_email" class="block text-sm font-medium text-gray-300 mb-2">Store Email</label>
                <input type="email" id="store_email" name="store_email" value="<?php echo e(old('store_email', $settings['store_email'] ?? '')); ?>" class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4" placeholder="e.g., contact@myawesomeshop.com">
            </div>
            <div>
                <label for="store_phone" class="block text-sm font-medium text-gray-300 mb-2">Store Phone</label>
                <input type="text" id="store_phone" name="store_phone" value="<?php echo e(old('store_phone', $settings['store_phone'] ?? '')); ?>"
                    class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4"
                    placeholder="e.g., +855 12 345 678">
            </div>
            <div>
                <label for="support_email" class="block text-sm font-medium text-gray-300 mb-2">Support Email</label>
                <input type="email" id="support_email" name="support_email" value="<?php echo e(old('support_email', $settings['support_email'] ?? '')); ?>" class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4" placeholder="e.g., support@yourshop.com">
            </div>
            <div>
                <label for="support_phone" class="block text-sm font-medium text-gray-300 mb-2">Support Phone</label>
                <input type="text" id="support_phone" name="support_phone" value="<?php echo e(old('support_phone', $settings['support_phone'] ?? '')); ?>" class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4" placeholder="e.g., +855 99 888 777">
            </div>
            <div class="col-span-1 md:col-span-2">
                <label for="store_address" class="block text-sm font-medium text-gray-300 mb-2">Store Address</label>
                <textarea id="store_address" name="store_address" rows="3" class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4" placeholder="e.g., 123 E-Commerce St, Suite 456, Phnom Penh, Cambodia"><?php echo e(old('store_address', $settings['store_address'] ?? '')); ?></textarea>
            </div>
            <div>
                <label for="store_logo" class="block text-sm font-medium text-gray-300 mb-2">Store Logo</label>
                <?php if(!empty($settings['store_logo'])): ?>
                    <div class="mb-2">
                        <img src="<?php echo e(asset($settings['store_logo'])); ?>" alt="Current Logo" class="h-16" />
                    </div>
                    <label class="block mt-2">
                        <input type="checkbox" name="remove_logo" value="1" class="mr-2"> Remove current logo
                    </label>
                <?php endif; ?>
                <input type="file" id="store_logo" name="store_logo" class="block w-full text-sm mt-2 rounded-full text-gray-300">
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-full shadow-lg">Save General</button>
        </div>
    </form>

    
    <form action="<?php echo e(route('admin.settings.save_storefront')); ?>" method="POST" class="mb-12 bg-gray-800 p-8 rounded-xl shadow-lg space-y-8">
        <?php echo csrf_field(); ?>
        <h2 class="text-3xl text-white mb-6 border-b border-gray-700 pb-4">Storefront Settings</h2>
        <div class="space-y-6">
            <div>
                <label for="storefront_title" class="block text-sm font-medium text-gray-300 mb-2">Storefront Title</label>
                <input type="text" id="storefront_title" name="storefront_title" value="<?php echo e(old('storefront_title', $settings['storefront_title'] ?? '')); ?>" class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4" placeholder="e.g., Your Online Shopping Destination">
            </div>
            <div>
                <label for="welcome_message" class="block text-sm font-medium text-gray-300 mb-2">Welcome Message</label>
                <textarea id="welcome_message" name="welcome_message" rows="3" class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4" placeholder="e.g., Welcome to our store! We're glad you're here."><?php echo e(old('welcome_message', $settings['welcome_message'] ?? '')); ?></textarea>
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-full shadow-lg">Save Storefront</button>
        </div>
    </form>

    
    <form action="<?php echo e(route('admin.settings.save_payment')); ?>" method="POST" class="mb-12 bg-gray-800 p-8 rounded-xl shadow-lg space-y-8">
        <?php echo csrf_field(); ?>
        <h2 class="text-3xl text-white mb-6 border-b border-gray-700 pb-4">Payment Settings</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label for="payment_gateway" class="block text-sm font-medium text-gray-300 mb-2">Payment Gateway</label>
                <select id="payment_gateway" name="payment_gateway" class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4">
                    <option value="none" <?php echo e((old('payment_gateway', $settings['payment_gateway'] ?? '') == 'none') ? 'selected' : ''); ?>>Select a Gateway</option>
                    <option value="paypal" <?php echo e((old('payment_gateway', $settings['payment_gateway'] ?? '') == 'paypal') ? 'selected' : ''); ?>>PayPal</option>
                    <!-- Add your local gateways here -->
                    <option value="aba_payway" <?php echo e((old('payment_gateway', $settings['payment_gateway'] ?? '') == 'aba_payway') ? 'selected' : ''); ?>>ABA PayWay</option>
                    <option value="wing" <?php echo e((old('payment_gateway', $settings['payment_gateway'] ?? '') == 'wing') ? 'selected' : ''); ?>>Wing</option>
                    <option value="truemoney" <?php echo e((old('payment_gateway', $settings['payment_gateway'] ?? '') == 'truemoney') ? 'selected' : ''); ?>>TrueMoney</option>
                </select>
            </div>
            <div>
                <label for="api_key" class="block text-sm font-medium text-gray-300 mb-2">API Key</label>
                <input type="text" id="api_key" name="api_key" value="<?php echo e(old('api_key', $settings['api_key'] ?? '')); ?>" class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4" placeholder="Enter your API key">
            </div>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-full shadow-lg">Save Payment</button>
        </div>
    </form>

    
    <form action="<?php echo e(route('admin.settings.savePolicies')); ?>" method="POST" class="mb-12 bg-gray-800 p-8 rounded-xl shadow-lg space-y-8">
        <?php echo csrf_field(); ?>
        <h2 class="text-3xl text-white mb-6 border-b border-gray-700 pb-4">Policy Settings</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label for="return_policy" class="block text-sm font-medium text-gray-300 mb-2">Return Policy</label>
                <textarea id="return_policy" name="return_policy" rows="4"
                    class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4"
                    placeholder="Write your return policy here..."><?php echo e(old('return_policy', $settings['return_policy'] ?? '')); ?></textarea>
            </div>
            <div>
                <label for="privacy_policy" class="block text-sm font-medium text-gray-300 mb-2">Privacy Policy</label>
                <textarea id="privacy_policy" name="privacy_policy" rows="4"
                    class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4"
                    placeholder="Write your privacy policy here..."><?php echo e(old('privacy_policy', $settings['privacy_policy'] ?? '')); ?></textarea>
            </div>
            <div>
                <label for="terms_of_service" class="block text-sm font-medium text-gray-300 mb-2">Terms of Service</label>
                <textarea id="terms_of_service" name="terms_of_service" rows="4"
                    class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4"
                    placeholder="Write your terms of service here..."><?php echo e(old('terms_of_service', $settings['terms_of_service'] ?? '')); ?></textarea>
            </div>
            <div>
                <label for="support_info" class="block text-sm font-medium text-gray-300 mb-2">Support Info</label>
                <textarea id="support_info" name="support_info" rows="4"
                    class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4"
                    placeholder="Write your support info here..."><?php echo e(old('support_info', $settings['support_info'] ?? '')); ?></textarea>
            </div>
        </div>
        <div>
            <label for="shipping_policy" class="block text-sm font-medium text-gray-300 mb-2">Shipping Policy</label>
            <textarea id="shipping_policy" name="shipping_policy" rows="4"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4"
                placeholder="Write your shipping policy here..."><?php echo e(old('shipping_policy', $settings['shipping_policy'] ?? '')); ?></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-full shadow-lg">Save Policies</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>