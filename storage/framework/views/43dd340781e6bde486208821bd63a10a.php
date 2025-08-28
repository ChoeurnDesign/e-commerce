<?php
    $docPath = $seller->business_document;
?>

<div class="mb-6 bg-white dark:bg-[#23263a] p-6 rounded shadow">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-2">Business Document</h3>

    <?php if($docPath && Storage::disk('public')->exists($docPath)): ?>
        <a href="<?php echo e(Storage::disk('public')->url($docPath)); ?>"
           target="_blank"
           class="text-indigo-600 hover:underline text-sm">
            View / Download
        </a>
    <?php else: ?>
        <div class="text-gray-500 text-sm">No document uploaded.</div>
    <?php endif; ?>
</div><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/sellers/partials/business_document.blade.php ENDPATH**/ ?>