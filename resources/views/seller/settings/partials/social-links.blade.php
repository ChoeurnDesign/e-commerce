@php
    $initialSocials = [
        'website'   => old('website', $seller->website ?? ''),
        'facebook'  => old('facebook', $seller->facebook ?? ''),
        'instagram' => old('instagram', $seller->instagram ?? ''),
        'tiktok'    => old('tiktok', $seller->tiktok ?? ''),
        'twitter'   => old('twitter', $seller->twitter ?? ''),
        'linkedin'  => old('linkedin', $seller->linkedin ?? ''),
        'youtube'   => old('youtube', $seller->youtube ?? ''),
        'pinterest' => old('pinterest', $seller->pinterest ?? ''),
    ];
    $initialSocials = array_filter($initialSocials, fn($v) => !empty($v));

    // Platforms available in dropdown (must match your icon component cases)
    $platforms = ['website','facebook','instagram','tiktok','twitter','linkedin','youtube','pinterest'];

    // Background classes for badges per platform (used both in dropdown and JS-list)
    $bgClasses = [
        'website' => 'bg-gray-100 dark:bg-gray-1000',
        'facebook' => 'bg-blue-600 dark:bg-blue-500',
        'instagram' => 'bg-gradient-to-tr from-pink-500 via-pink-400 to-yellow-400 dark:from-pink-400 dark:via-pink-300 dark:to-yellow-300',
        'tiktok' => 'bg-black dark:bg-gray-900',
        'twitter' => 'bg-sky-500 dark:bg-sky-400',
        'linkedin' => 'bg-blue-700 dark:bg-blue-600',
        'youtube' => 'bg-red-600 dark:bg-red-500',
        'pinterest' => 'bg-red-500 dark:bg-red-400',
    ];

    // Render the server-side "bare" icon component HTML for each platform so JS can reuse exact markup.
    $iconHtml = [];
    foreach ($platforms as $p) {
        // pass 'bare' => true so the component returns only the <i> element (fa-fw included)
        $iconHtml[$p] = trim(view('components.icon-socials', ['name' => $p, 'class' => 'text-white', 'bare' => true])->render());
    }
@endphp

<div id="social-links-wrapper" class="space-y-4" data-initial='@json($initialSocials)'>
    <label class="block font-semibold text-gray-700 dark:text-gray-100 mb-2 text-base">Website & Social Links</label>

    <div class="flex flex-col md:items-center gap-2 md:gap-4">
        <button type="button" id="social-add-toggle"
            class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded transition shadow-sm font-medium
                bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-200 dark:border-transparent hover:bg-gray-100 dark:hover:bg-gray-600"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            <span>Social Link</span>
        </button>
        <p id="social-hint" class="text-sm text-gray-500 dark:text-gray-400">Add site or social links for your storefront (max 8 links).</p>
    </div>

    <div id="social-add-panel" class="mt-2 bg-gray-100 dark:bg-gray-800 p-5 rounded-lg shadow-md text-gray-900 dark:text-white w-full max-w-md transition hidden" aria-hidden="true">
        <!-- Platforms -->
        <div id="social-platforms" class="grid grid-cols-4 gap-3 mb-4">
            @foreach($platforms as $p)
                <button type="button"
                    class="platform-btn flex flex-col items-center gap-1 rounded bg-gray-100 dark:bg-gray-900 border border-transparent hover:border-primary-400 focus:outline-none p-3 shadow-sm transition"
                    data-key="{{ $p }}"
                    aria-pressed="false"
                    title="{{ ucfirst($p) }}"
                >
                    <span class="flex items-center justify-center w-9 h-9 rounded-full {{ $bgClasses[$p] ?? 'bg-gray-100 dark:bg-gray-600' }}">
                        {!! view('components.icon-socials', ['name' => $p, 'class' => 'text-white', 'bare' => true])->render() !!}
                    </span>
                    <span class="text-xs text-gray-600 dark:text-gray-300">{{ ucfirst($p) }}</span>
                </button> 
            @endforeach
        </div>
        <input type="hidden" id="social-platform" value="">
        <input id="social-url" type="url" placeholder="Enter profile or website URL"
            class="w-full p-2 rounded bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 mt-1 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-primary-400" />
        <div class="flex justify-end mt-4 gap-3">
            <button type="button" id="social-cancel" class="px-4 py-1.5 rounded font-medium bg-gray-300 dark:bg-gray-700 hover:bg-gray-400 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-100 transition">Cancel</button>
            <button type="button" id="social-add" class="px-4 py-1.5 rounded font-medium bg-primary-600 hover:bg-primary-700 text-white transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>Add</button>
        </div>
    </div>

    <p id="social-empty-message" class="text-sm text-gray-500 dark:text-gray-400" style="display:none;">No website or social links added yet.</p>

    <div id="social-list" class="space-y-3"></div>
</div>

<script>
(function () {
    const wrapper = document.getElementById('social-links-wrapper');
    if (!wrapper) return;

    // ICONS and BG_CLASSES come from server-side so dropdown icons and list icons match exactly
    const ICONS = @json($iconHtml);
    const BG_CLASSES = @json($bgClasses);
    const ALL_KEYS = @json($platforms);

    const toggleBtn = document.getElementById('social-add-toggle');
    const panel = document.getElementById('social-add-panel');
    const platformBtns = Array.from(document.querySelectorAll('#social-platforms .platform-btn'));
    const platformInput = document.getElementById('social-platform'); // hidden input
    const urlInput = document.getElementById('social-url');
    const addBtn = document.getElementById('social-add');
    const cancelBtn = document.getElementById('social-cancel');
    const listEl = document.getElementById('social-list');
    const emptyMessage = document.getElementById('social-empty-message');

    let socials = {};
    try { socials = JSON.parse(wrapper.dataset.initial || '{}'); } catch(e) { socials = {}; }

    function refreshPlatformButtons() {
        platformBtns.forEach(btn => {
            const key = btn.dataset.key;
            if (socials[key]) {
                btn.classList.add('opacity-40', 'cursor-not-allowed');
                btn.setAttribute('disabled', 'true');
                btn.setAttribute('aria-pressed', 'false');
            } else {
                btn.classList.remove('opacity-40', 'cursor-not-allowed');
                btn.removeAttribute('disabled');
            }

            if (platformInput.value === key) {
                btn.classList.add('ring-2','ring-blue-400');
                btn.setAttribute('aria-pressed', 'true');
            } else {
                btn.classList.remove('ring-2','ring-blue-400');
                if (!btn.hasAttribute('disabled')) btn.setAttribute('aria-pressed','false');
            }
        });
    }

    function renderList() {
        const keys = Object.keys(socials);
        if (!keys.length) {
            emptyMessage.style.display = '';
            listEl.innerHTML = '';
            return;
        }
        emptyMessage.style.display = 'none';

        listEl.innerHTML = keys.map(k => {
            const rawIconHtml = ICONS[k] || ICONS.website || '';
            // keep only the <i> if a wrapper exists (safe and short)
            let iHtml = rawIconHtml;
            try {
                const tmp = document.createElement('div');
                tmp.innerHTML = rawIconHtml.trim();
                const innerI = tmp.querySelector('i');
                if (innerI) iHtml = innerI.outerHTML;
            } catch (err) { /* ignore */ }

            const badgeClass = BG_CLASSES[k] || 'bg-gray-700';
            // badge won't shrink; we keep it circular in both light/dark
            const wrappedIcon = `<span class="flex-shrink-0 flex items-center justify-center w-8 h-8 rounded-full ${badgeClass}">${iHtml}</span>`;

            // Use light/dark-friendly card + truncated link so long URLs won't wrap and break layout
            return `
                <div class="flex items-center gap-3 rounded p-3 max-w-full social-item bg-gray-100 dark:bg-gray-800 border border-gray-100 dark:border-gray-700">
                    ${wrappedIcon}
                    <a class="flex-1 min-w-0 truncate text-blue-600 dark:text-blue-400 underline" href="${socials[k]}" target="_blank" rel="noopener" title="${socials[k]}">${socials[k]}</a>
                    <button type="button" data-remove="${k}" class="ml-2 text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">✕</button>
                    <input type="hidden" name="${k}" value="${socials[k]}">
                </div>
            `;
        }).join('');
        toggleBtn.style.display = Object.keys(socials).length >= ALL_KEYS.length ? 'none' : '';
        refreshPlatformButtons();
    }

    platformBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (btn.hasAttribute('disabled')) return;
            const key = btn.dataset.key;
            platformInput.value = key;
            addBtn.disabled = !(platformInput.value && urlInput.value.trim());
            refreshPlatformButtons();
        });
    });

    urlInput.addEventListener('input', () => {
        addBtn.disabled = !(platformInput.value && urlInput.value.trim());
    });

    toggleBtn.addEventListener('click', () => {
        const isHidden = panel.classList.contains('hidden');
        panel.classList.toggle('hidden', !isHidden);
        panel.setAttribute('aria-hidden', String(!isHidden));
        if (!isHidden) {
            platformInput.value = '';
            urlInput.value = '';
            addBtn.disabled = true;
        } else {
            refreshPlatformButtons();
            urlInput.focus();
        }
    });

    addBtn.addEventListener('click', () => {
        const key = platformInput.value;
        const url = (urlInput.value || '').trim();
        if (!key || !url) return;
        socials[key] = url;
        platformInput.value = '';
        urlInput.value = '';
        addBtn.disabled = true;
        panel.classList.add('hidden');
        panel.setAttribute('aria-hidden','true');
        renderList();
    });

    cancelBtn.addEventListener('click', () => {
        panel.classList.add('hidden');
        panel.setAttribute('aria-hidden','true');
        platformInput.value = '';
        urlInput.value = '';
        addBtn.disabled = true;
    });

    listEl.addEventListener('click', (e) => {
        const btn = e.target.closest('button[data-remove]');
        if (!btn) return;
        const k = btn.dataset.remove;
        delete socials[k];
        renderList();
    });

    document.addEventListener('click', (e) => {
        if (!panel.contains(e.target) && !toggleBtn.contains(e.target)) {
            panel.classList.add('hidden');
            panel.setAttribute('aria-hidden','true');
        }
    });

    refreshPlatformButtons();
    renderList();
})();
</script>