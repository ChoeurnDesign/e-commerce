<?php
    $compact = $compact ?? false;
?>


<a href="<?php echo e(route('admin.sellers.show', $seller->id)); ?>"
   class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded transition mr-2"
   title="View Seller">
    View
</a>


<a href="<?php echo e(route('admin.sellers.edit', $seller->id)); ?>"
   class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs rounded transition mr-2"
   title="Edit Seller">
    Edit
</a>


<?php if($seller->status === 'pending'): ?>
    <form action="<?php echo e(route('admin.sellers.updateStatus', [$seller->id, 'approved'])); ?>" method="POST" class="inline-block">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PATCH'); ?> <!-- Correctly specify the PATCH method -->
    <button type="submit"
        class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs rounded transition"
        title="Approve Seller">
        Approve
    </button>
</form>
    <form action="<?php echo e(route('admin.sellers.updateStatus', [$seller->id, 'rejected'])); ?>" method="POST" class="inline-block ml-2">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="_method" value="">
        <button type="submit"
            class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs rounded transition"
            title="Reject Seller">
            Reject
        </button>
    </form>
<?php elseif($seller->status === 'approved'): ?>
    <span class="inline-block px-3 py-1.5 bg-green-700 text-white text-xs rounded" title="Seller Approved">Approved</span>
    <?php if(!$compact): ?>
        <form action="<?php echo e(route('admin.sellers.updateStatus', [$seller->id, 'rejected'])); ?>" method="POST" class="inline-block ml-2">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" value="">
            <button type="submit"
                class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs rounded transition"
                title="Reject Seller">
                Reject
            </button>
        </form>
    <?php endif; ?>
<?php elseif($seller->status === 'rejected'): ?>
    <span class="inline-block px-3 py-1.5 bg-red-700 text-white text-xs rounded" title="Seller Rejected">Rejected</span>
    <?php if(!$compact): ?>
        <form action="<?php echo e(route('admin.sellers.updateStatus', [$seller->id, 'approved'])); ?>" method="POST" class="inline-block ml-2">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" value="">
            <button type="submit"
                class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs rounded transition"
                title="Approve Seller">
                Approve
            </button>
        </form>
    <?php endif; ?>
<?php endif; ?>

<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/admin/sellers/partials/actions.blade.php ENDPATH**/ ?>