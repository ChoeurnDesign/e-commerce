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
        <?php if (isset($component)) { $__componentOriginal55a39280dca36f6c98ca5e68ef99e12c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal55a39280dca36f6c98ca5e68ef99e12c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.chat.chat-layout','data' => ['chats' => $chats,'currentChat' => $currentChat ?? null]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chat.chat-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['chats' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($chats),'currentChat' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($currentChat ?? null)]); ?>
            <?php echo $__env->make('chat._conversation', [
                'currentChat' => $currentChat,
                'lastSentId' => $lastSentId ?? null,
                'lastSentMessageTs' => $lastSentMessageTs ?? null,
                'messages' => $messages ?? [],
                'isSellerDashboard' => false,
            ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal55a39280dca36f6c98ca5e68ef99e12c)): ?>
<?php $attributes = $__attributesOriginal55a39280dca36f6c98ca5e68ef99e12c; ?>
<?php unset($__attributesOriginal55a39280dca36f6c98ca5e68ef99e12c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal55a39280dca36f6c98ca5e68ef99e12c)): ?>
<?php $component = $__componentOriginal55a39280dca36f6c98ca5e68ef99e12c; ?>
<?php unset($__componentOriginal55a39280dca36f6c98ca5e68ef99e12c); ?>
<?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/chat/index.blade.php ENDPATH**/ ?>