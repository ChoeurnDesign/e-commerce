
<form action="<?php echo e(route('admin.settings.save_payment')); ?>" method="POST"
    class="mb-12 bg-gray-800 p-8 rounded-xl shadow-lg space-y-8">
    <?php echo csrf_field(); ?>
    <h2 class="text-3xl text-white mb-6 border-b border-gray-700 pb-4">Payment Settings</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div>
            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'payment_gateway','value' => 'Payment Gateway']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'payment_gateway','value' => 'Payment Gateway']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
            <select id="payment_gateway" name="payment_gateway"
                class="w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4">
                <option value="none"
                    <?php echo e((old('payment_gateway', $settings['payment_gateway'] ?? '') == 'none') ? 'selected' : ''); ?>>
                    Select a Gateway</option>
                <option value="paypal"
                    <?php echo e((old('payment_gateway', $settings['payment_gateway'] ?? '') == 'paypal') ? 'selected' : ''); ?>>
                    PayPal</option>
                <option value="aba_payway"
                    <?php echo e((old('payment_gateway', $settings['payment_gateway'] ?? '') == 'aba_payway') ? 'selected' : ''); ?>>
                    ABA PayWay</option>
                <option value="wing"
                    <?php echo e((old('payment_gateway', $settings['payment_gateway'] ?? '') == 'wing') ? 'selected' : ''); ?>>Wing
                </option>
                <option value="truemoney"
                    <?php echo e((old('payment_gateway', $settings['payment_gateway'] ?? '') == 'truemoney') ? 'selected' : ''); ?>>
                    TrueMoney</option>
            </select>
        </div>
        <div>
            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'api_key','value' => 'API Key']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'api_key','value' => 'API Key']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'api_key','name' => 'api_key','type' => 'text','value' => old('api_key', $settings['api_key'] ?? ''),'placeholder' => 'Enter your API key','class' => 'w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'api_key','name' => 'api_key','type' => 'text','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('api_key', $settings['api_key'] ?? '')),'placeholder' => 'Enter your API key','class' => 'w-full bg-gray-700 text-gray-100 border-gray-600 rounded-lg py-2 px-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
        </div>
    </div>
    <div class="flex justify-end">
        <?php if (isset($component)) { $__componentOriginald5e063f2aa851d5b0b7d5b4ed2e33474 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald5e063f2aa851d5b0b7d5b4ed2e33474 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.btn-submit','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.btn-submit'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>Save Payment <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald5e063f2aa851d5b0b7d5b4ed2e33474)): ?>
<?php $attributes = $__attributesOriginald5e063f2aa851d5b0b7d5b4ed2e33474; ?>
<?php unset($__attributesOriginald5e063f2aa851d5b0b7d5b4ed2e33474); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald5e063f2aa851d5b0b7d5b4ed2e33474)): ?>
<?php $component = $__componentOriginald5e063f2aa851d5b0b7d5b4ed2e33474; ?>
<?php unset($__componentOriginald5e063f2aa851d5b0b7d5b4ed2e33474); ?>
<?php endif; ?>
    </div>
</form>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/settings/partials/payment-section.blade.php ENDPATH**/ ?>