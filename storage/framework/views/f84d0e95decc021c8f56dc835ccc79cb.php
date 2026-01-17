<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'title' => 'Images',
    'images' => null,               // Accept Collection or LengthAwarePaginator
    'deleteRoute' => null,          // kebab-case: delete-route when using component
    'deleteRouteName' => null,      // compatibility if someone still passes deleteRouteName
    'cols' => 4,
    'infinite' => false,            // if true, JS will attempt to auto-load more pages (requires controller.load route)
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'title' => 'Images',
    'images' => null,               // Accept Collection or LengthAwarePaginator
    'deleteRoute' => null,          // kebab-case: delete-route when using component
    'deleteRouteName' => null,      // compatibility if someone still passes deleteRouteName
    'cols' => 4,
    'infinite' => false,            // if true, JS will attempt to auto-load more pages (requires controller.load route)
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    use Illuminate\Support\Str;

    $images = $images ?? collect();
    $deleteRoute = $deleteRoute ?? $deleteRouteName;
    $gridLgCols = [1=>'lg:grid-cols-1',2=>'lg:grid-cols-2',3=>'lg:grid-cols-3',4=>'lg:grid-cols-4'][$cols] ?? 'lg:grid-cols-4';

    // determine if images is paginated
    $isPaginated = method_exists($images, 'links');
?>

<?php if($images->count()): ?>
    <h2 class="text-xl mt-10 mb-4 text-gray-900 dark:text-gray-100"><?php echo e($title); ?></h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 <?php echo e($gridLgCols); ?> gap-8 images-items" data-infinite="<?php echo e($infinite ? '1' : '0'); ?>" data-type="<?php echo e($images->first()->type ?? ''); ?>">
        <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $url = asset($img->path);
                $filename = Str::afterLast($img->path, '/');
                $isMain = ($img->type ?? '') === 'main';
                $badgeText = $isMain ? 'Main' : 'Gallery';
                $badgeColor = $isMain ? 'bg-blue-600 text-white' : 'bg-indigo-600 text-white';
            ?>

            <div class="group relative border rounded-md overflow-hidden shadow-md bg-white dark:bg-[#23263a] dark:border-[#2b3150]">
                <div class="w-full bg-gray-100 dark:bg-[#1e2335]">
                    <div class="aspect-[4/3] overflow-hidden">
                        <img src="<?php echo e($url); ?>" alt="<?php echo e($filename); ?>"
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
                    </div>
                </div>

                <div class="p-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="inline-flex px-2.5 py-0.5 text-[11px] rounded-full <?php echo e($badgeColor); ?>"><?php echo e($badgeText); ?></span>
                        <div class="flex items-center gap-2 opacity-80 group-hover:opacity-100 transition">
                            <button type="button" class="text-xs px-2.5 py-1 rounded bg-gray-100 hover:bg-gray-200 dark:bg-[#2a3146] dark:hover:bg-[#313a5a]" data-copy="<?php echo e($filename); ?>" title="Copy filename">Copy name</button>
                            <button type="button" class="text-xs px-2.5 py-1 rounded bg-gray-100 hover:bg-gray-200 dark:bg-[#2a3146] dark:hover:bg-[#313a5a]" data-copy="<?php echo e($url); ?>" title="Copy full URL">Copy URL</button>
                        </div>
                    </div>

                    <div class="text-sm font-mono text-gray-800 dark:text-gray-200 truncate" title="<?php echo e($filename); ?>"><?php echo e($filename); ?></div>

                    <?php if(!empty($img->created_at)): ?>
                        <div class="text-[11px] text-gray-500 dark:text-gray-400"><?php echo e($img->created_at->format('Y-m-d H:i')); ?></div>
                    <?php endif; ?>

                    <div class="pt-1 flex items-center justify-between">
                        <a href="<?php echo e($url); ?>" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-300 dark:hover:text-indigo-200">Open</a>

                        <?php if($deleteRoute): ?>
                            <form action="<?php echo e(route($deleteRoute)); ?>" method="POST" onsubmit="return confirm('Delete this image?')">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="image_id" value="<?php echo e($img->id); ?>">
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="pointer-events-none absolute inset-0 ring-0 group-hover:ring-2 group-hover:ring-indigo-500/40 rounded-md transition"></div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <?php if($isPaginated && !$infinite): ?>
        <div class="mt-6">
            <?php echo e($images->withQueryString()->links()); ?>

        </div>
    <?php endif; ?>

    <?php if (! $__env->hasRenderedOnce('26ddf7f7-72f1-4824-8fc5-aca64d66102b')): $__env->markAsRenderedOnce('26ddf7f7-72f1-4824-8fc5-aca64d66102b'); ?>
    <?php $__env->startPush('scripts'); ?>
    <script>
    (function () {
        // Copy button handler (works for component instances)
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('button[data-copy]');
            if (!btn) return;
            const text = btn.getAttribute('data-copy') || '';
            const fallback = () => {
                const ta = document.createElement('textarea'); ta.value = text;
                document.body.appendChild(ta); ta.select(); try { document.execCommand('copy'); } catch(e) {}
                document.body.removeChild(ta);
            };
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).catch(fallback);
            } else { fallback(); }
            const o = btn.textContent; btn.textContent = 'Copied!'; setTimeout(()=>btn.textContent=o, 900);
        });

        // Simple infinite loader: if data-infinite=1, detect last child and fetch next page
        async function fetchNextPage(container, page) {
            const type = container.dataset.type || ''; // main|gallery
            const url = new URL("<?php echo e(url('admin/images/load')); ?>", window.location.origin); // controller load route
            url.searchParams.set('type', type);
            url.searchParams.set('page', page);
            try {
                const res = await fetch(url.toString(), { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
                if (!res.ok) return null;
                const html = await res.text();
                return html;
            } catch (e) {
                return null;
            }
        }

        function setupInfiniteFor(container) {
            if (!container || container.dataset.infinite !== '1') return;
            // The paginated links will be used to discover current page. We'll read from data attribute if provided,
            // otherwise default to page 1 and attempt next pages.
            let nextPage = 2;
            const observer = new IntersectionObserver(async (entries) => {
                for (const entry of entries) {
                    if (!entry.isIntersecting) continue;
                    // load next page
                    const html = await fetchNextPage(container, nextPage);
                    if (!html) { observer.disconnect(); return; }
                    // insert nodes
                    const tmp = document.createElement('div');
                    tmp.innerHTML = html;
                    const items = tmp.querySelectorAll('.group');
                    if (items.length === 0) {
                        observer.disconnect();
                        return;
                    }
                    items.forEach(i => container.appendChild(i));
                    nextPage++;
                    // if a page returns fewer than perPage items you can stop, but we just continue until server returns empty
                }
            }, { rootMargin: '300px' });

            // observe last child
            const watch = () => {
                const last = container.lastElementChild;
                if (last) observer.observe(last);
            };

            // kick off
            watch();
            // also re-run watch after new items appended
            new MutationObserver(watch).observe(container, { childList: true, subtree: false });
        }

        // Find all image components containers and set infinite if requested
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.images-items').forEach(setupInfiniteFor);
        });
    })();
    </script>
    <?php $__env->stopPush(); ?>
    <?php endif; ?>

<?php else: ?>
    <h2 class="text-xl mt-10 mb-4 text-gray-900 dark:text-gray-100"><?php echo e($title); ?></h2>
    <div class="text-sm text-gray-500 dark:text-gray-300">No images uploaded yet.</div>
<?php endif; ?><?php /**PATH D:\Year III\SemesterII\WCT\ShopExpress\resources\views/components/images/grid.blade.php ENDPATH**/ ?>