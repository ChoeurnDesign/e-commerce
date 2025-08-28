<form action="<?php echo e($action); ?>" method="POST" class="inline" onsubmit="return confirm('<?php echo e($confirm ?? 'Are you sure?'); ?>');">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
    <button type="submit"
            class="inline-flex items-center text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-[#23263a] px-2 py-1 rounded transition-colors duration-200"
            title="<?php echo e($title ?? 'Delete'); ?>">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
        </svg>
        <span>Delete</span>
    </button>
</form>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/admin/table-delete-button.blade.php ENDPATH**/ ?>