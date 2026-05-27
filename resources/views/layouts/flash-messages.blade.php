@php
    $alerts = [
        'success' => ['icon' => 'ti-circle-check', 'title' => 'Success'],
        'error'   => ['icon' => 'ti-circle-x',     'title' => 'Error'],
        'warning' => ['icon' => 'ti-alert-triangle','title' => 'Warning'],
        'info'    => ['icon' => 'ti-info-circle',   'title' => 'Info'],
    ];
@endphp

@foreach($alerts as $type => $config)
    @if(session($type))
    <div id="flash-{{ $type }}" role="alert" aria-live="polite"
        class="flash-alert flash-{{ $type }}"
        style="position:fixed; top:64px; left:50%; transform:translateX(-50%); width:50%; border-radius:0.5rem; min-width:320px; z-index:9999; display:flex; align-items:center; justify-content:center; padding:16px 48px; overflow:hidden; transition:opacity 0.4s ease, transform 0.4s ease;">

        <i class="ti {{ $config['icon'] }}" style="font-size:20px; margin-right:10px; flex-shrink:0;" aria-hidden="true"></i>
        <strong style="font-size:15px;">{{ $config['title'] }}</strong>
        <span style="font-size:14px; margin-left:8px;">{{ session($type) }}</span>

        <button onclick="dismissAlert('{{ $type }}')" aria-label="Dismiss"
            style="position:absolute; right:20px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; opacity:0.6; font-size:20px; line-height:1;">
            <i class="ti ti-x"></i>
        </button>

        <div id="flash-bar-{{ $type }}" class="flash-bar-{{ $type }}"
            style="position:absolute; bottom:0; left:0; height:3px; width:100%;"></div>
    </div>
    @endif
@endforeach

@if($errors->any())
<div id="flash-validation" role="alert" aria-live="polite"
    class="flash-alert flash-error"
    style="position:fixed; top:64px; left:50%; transform:translateX(-50%); width:50%; border-radius:0.5rem; min-width:320px; z-index:9999; display:flex; align-items:center; justify-content:center; padding:16px 48px; overflow:hidden; transition:opacity 0.4s ease, transform 0.4s ease;">

    <i class="ti ti-circle-x" style="font-size:20px; margin-right:10px; flex-shrink:0;" aria-hidden="true"></i>
    <div style="text-align:left;">
        <strong style="font-size:15px;">Please fix the following</strong>
        <ul style="font-size:13px; margin:4px 0 0 16px; opacity:0.85; list-style:disc;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    <button onclick="dismissAlert('validation')" aria-label="Dismiss"
        style="position:absolute; right:20px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; opacity:0.6; font-size:20px; line-height:1;">
        <i class="ti ti-x"></i>
    </button>

    <div id="flash-bar-validation" class="flash-bar-error"
        style="position:absolute; bottom:0; left:0; height:3px; width:100%;"></div>
</div>
@endif


<style>
/* ── Light mode ───────────────────────────────────────────── */
.flash-success { background:#f0fdf4; border-bottom:1px solid #86efac; color:#166534; }
.flash-success .flash-bar-success { background:#16a34a; }

.flash-error   { background:#fef2f2; border-bottom:1px solid #fca5a5; color:#991b1b; }
.flash-error   .flash-bar-error   { background:#dc2626; }

.flash-warning { background:#fffbeb; border-bottom:1px solid #fcd34d; color:#92400e; }
.flash-warning .flash-bar-warning { background:#d97706; }

.flash-info    { background:#eff6ff; border-bottom:1px solid #93c5fd; color:#1e40af; }
.flash-info    .flash-bar-info    { background:#2563eb; }

/* ── Dark mode (Tailwind .dark class on <html>) ───────────── */
.dark .flash-success { background:#052e16; border-color:#166534; color:#86efac; }
.dark .flash-success .flash-bar-success { background:#16a34a; }

.dark .flash-error   { background:#450a0a; border-color:#991b1b; color:#fca5a5; }
.dark .flash-error   .flash-bar-error   { background:#dc2626; }

.dark .flash-warning { background:#451a03; border-color:#92400e; color:#fcd34d; }
.dark .flash-warning .flash-bar-warning { background:#d97706; }

.dark .flash-info    { background:#0c1a3a; border-color:#1e40af; color:#93c5fd; }
.dark .flash-info    .flash-bar-info    { background:#2563eb; }

/* ── Spin animation for loading icons ────────────────────── */
@keyframes spin {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const DURATION = 5000;

    function dismissAlert(type) {
        const el = document.getElementById('flash-' + type);
        if (!el) return;
        clearTimeout(el._timer);
        el.style.opacity = '0';
        el.style.transform = 'translateY(-100%)';
        setTimeout(() => el.remove(), 400);
    }

    function startAlert(type) {
        const el  = document.getElementById('flash-' + type);
        const bar = document.getElementById('flash-bar-' + type);
        if (!el || !bar) return;

        bar.style.transition = 'none';
        bar.style.width = '100%';

        requestAnimationFrame(() => requestAnimationFrame(() => {
            bar.style.transition = `width ${DURATION}ms linear`;
            bar.style.width = '0%';
        }));

        el._timer = setTimeout(() => dismissAlert(type), DURATION);

        el.addEventListener('mouseenter', () => {
            clearTimeout(el._timer);
            bar.style.transition = 'none';
        });

        el.addEventListener('mouseleave', () => {
            const remaining = (parseFloat(bar.style.width) / 100) * DURATION;
            bar.style.transition = `width ${remaining}ms linear`;
            bar.style.width = '0%';
            el._timer = setTimeout(() => dismissAlert(type), remaining);
        });
    }

    window.dismissAlert = dismissAlert;

    ['success', 'error', 'warning', 'info', 'validation'].forEach(startAlert);
});
</script>