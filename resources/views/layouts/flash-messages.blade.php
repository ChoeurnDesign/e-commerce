{{-- ════════════════════════════════════════════════════════════════
     Flash messages → SweetAlert2 toast notifications
     Fires automatically on page load via session flash.
══════════════════════════════════════════════════════════════════ --}}
@php
    $flashIcons = ['success' => 'success', 'error' => 'error', 'warning' => 'warning', 'info' => 'info'];
    $flashMessages = [];
    foreach ($flashIcons as $type => $icon) {
        if (session($type)) {
            $flashMessages[] = ['icon' => $icon, 'text' => session($type)];
        }
    }
    if ($errors->any()) {
        $flashMessages[] = ['icon' => 'error', 'text' => $errors->first()];
    }
@endphp

@if(count($flashMessages) > 0)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (typeof Swal === 'undefined') return;

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            customClass: { popup: 'shop-toast' },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        const messages = @json($flashMessages);
        messages.forEach((msg, i) => {
            setTimeout(() => Toast.fire({ icon: msg.icon, title: msg.text }), i * 300);
        });
    });
</script>
<style>
    .shop-toast { border-radius: 12px !important; border-left: 4px solid #EC4899 !important; }
    .swal2-icon.swal2-success { border-color: #10B981 !important; color: #10B981 !important; }
    .swal2-icon.swal2-error   { border-color: #EF4444 !important; color: #EF4444 !important; }
</style>
@endif
