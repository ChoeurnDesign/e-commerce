@if(session('success'))
    <div id="alert-success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-center" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif
@if(session('error'))
    <div id="alert-error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif
@if(session('warning'))
    <div id="alert-warning" class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4 text-center" role="alert">
        <span class="block sm:inline">{{ session('warning') }}</span>
    </div>
@endif
@if ($errors->any())
    <div id="alert-validation" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-center" role="alert">
        <ul class="list-disc list-inside text-center">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    // IDs of alert elements to auto-hide
    const ids = ['alert-success', 'alert-error', 'alert-warning', 'alert-validation'];

    // Delay before starting hide (ms)
    const HIDE_DELAY = 5000; // 5000 ms = 5 seconds

    // Fade duration (ms)
    const FADE_MS = 400;

    ids.forEach(function(id) {
        const el = document.getElementById(id);
        if (!el) return;

        // ensure element has starting styles for transition
        el.style.transition = `opacity ${FADE_MS}ms ease, transform ${FADE_MS}ms ease`;
        el.style.opacity = '1';
        el.style.transform = 'translateY(0)';

        // schedule hide
        setTimeout(function() {
            // fade out and slide up a bit
            el.style.opacity = '0';
            el.style.transform = 'translateY(-8px)';

            // remove from DOM after transition completes
            setTimeout(function() {
                if (el && el.parentNode) el.parentNode.removeChild(el);
            }, FADE_MS);
        }, HIDE_DELAY);
    });
});
</script>