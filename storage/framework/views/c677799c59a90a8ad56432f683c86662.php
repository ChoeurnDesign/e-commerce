<div
    x-data="{
        reportOpen: false,
        files: [],
        fileObjects: [],
        maxFiles: 5,
        addFiles(event) {
            let newFiles = Array.from(event.target.files);
            let total = this.files.length + newFiles.length;
            if(total > this.maxFiles) {
                newFiles = newFiles.slice(0, this.maxFiles - this.files.length);
            }
            newFiles.forEach((file) => {
                this.files.push(file);
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.fileObjects.push(e.target.result);
                };
                reader.readAsDataURL(file);
            });
            event.target.value = '';
        },
        removeFile(index) {
            this.files.splice(index, 1);
            this.fileObjects.splice(index, 1);
        }
    }"
>
    <!-- Open Modal Button -->
    <div class="w-full flex justify-end pt-6">
        <button
            @click="reportOpen = true"
            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-full shadow-lg font-semibold flex items-center gap-2 transition
                   dark:bg-red-500 dark:hover:bg-red-600"
        >
            Report a Problem
        </button>
    </div>

    <!-- Modal -->
    <div
        x-show="reportOpen"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 dark:bg-opacity-60"
    >
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-xl max-w-lg w-full p-6 relative"
            @click.away="reportOpen = false"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <button
                @click="reportOpen = false"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 text-2xl leading-none"
            >&times;</button>
            <h4 class="text-lg font-bold mb-3 text-gray-800 dark:text-white">Report a Problem</h4>

            <form
                action="<?php echo e(route('report.store')); ?>"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-4"
                @submit="if(files.length === 0) { return true; } else { $nextTick(() => $el.querySelector('input[type=file]').files = files); return true; }"
            >
                <?php echo csrf_field(); ?>
                <label class="block">
                    <span class="text-gray-700 dark:text-gray-200">Title <span class="text-red-500">*</span></span>
                    <input name="title" type="text" required maxlength="255"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400"
                        placeholder="Brief description of the issue">
                </label>
                <label class="block">
                    <span class="text-gray-700 dark:text-gray-200">Description</span>
                    <textarea name="description" rows="4" maxlength="2000"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-800 dark:text-white dark:placeholder-gray-400"
                        placeholder="Please describe the problem in detail"></textarea>
                </label>
                <div>
                    <span class="text-gray-700 dark:text-gray-200">Screenshots / Images (up to 5, optional)</span>
                    <div class="flex items-center gap-2 mt-2">
                        <template x-if="files.length === 0">
                            <button
                                type="button"
                                @click.prevent="$refs.fileInput.click()"
                                class="bg-gray-200 px-4 py-2 rounded text-sm font-medium text-gray-700 hover:bg-gray-300 focus:outline-none"
                            >
                                Choose Images
                            </button>
                        </template>
                        <template x-if="files.length > 0">
                            <div class="flex items-center gap-2">
                                <template x-for="(img, idx) in fileObjects" :key="idx">
                                    <div class="relative group">
                                        <img :src="img" class="w-16 h-16 object-cover rounded border border-gray-300 dark:border-gray-700"/>
                                        <button type="button" @click="removeFile(idx)" class="absolute top-0 right-0 bg-black bg-opacity-60 text-white rounded-full px-1 text-xs opacity-0 group-hover:opacity-100 transition">×</button>
                                    </div>
                                </template>
                                <button
                                    x-show="files.length < maxFiles"
                                    type="button"
                                    @click.prevent="$refs.fileInput.click()"
                                    class="ml-2 w-16 h-16 flex items-center justify-center border-2 border-dashed border-gray-400 rounded text-3xl text-gray-400 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-600"
                                    aria-label="Add more images"
                                >+</button>
                            </div>
                        </template>
                        <input
                            type="file"
                            x-ref="fileInput"
                            name="images[]"
                            accept="image/*"
                            multiple
                            class="hidden"
                            :disabled="files.length >= maxFiles"
                            @change="addFiles"
                        />
                    </div>
                    <span class="text-xs text-gray-400 dark:text-gray-500 block mt-1">You can upload up to 5 images.</span>
                </div>
                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-md transition dark:bg-red-500 dark:hover:bg-red-600"
                >Submit Report</button>
            </form>
        </div>
    </div>
</div>
<?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/layouts/report-problem.blade.php ENDPATH**/ ?>