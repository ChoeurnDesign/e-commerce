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
    // Hide all alerts after 3 seconds
    setTimeout(function() {
        ['alert-success', 'alert-error', 'alert-warning', 'alert-validation'].forEach(function(id) {
            var el = document.getElementById(id);
            if (el) el.style.display = 'none';
        });
    }, 3000);
</script>
