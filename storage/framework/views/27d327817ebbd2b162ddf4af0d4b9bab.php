<div
    x-data="{
        open: false,
        title: '',
        content: '',
        show(modalTitle, modalContent) {
            if (
                (modalTitle && modalTitle.trim() !== '') ||
                (modalContent && modalContent.trim() !== '')
            ) {
                this.title = modalTitle;
                this.content = modalContent;
                this.open = true;
            } else {
                this.open = false;
                this.title = '';
                this.content = '';
            }
        }
    }"
    x-ref="modal"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-80"
    @keydown.escape.window="open = false"
>
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 relative">
        <button @click="open = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
        <template x-if="title || content">
            <div>
                <h4 class="text-lg font-bold mb-3 text-gray-800" x-text="title" x-show="title"></h4>
                <div class="text-gray-700" x-text="content" x-show="content"></div>
            </div>
        </template>
    </div>
</div>
<?php /**PATH D:\Year_IV\pp\ShopExpress\resources\views/components/info-modal.blade.php ENDPATH**/ ?>