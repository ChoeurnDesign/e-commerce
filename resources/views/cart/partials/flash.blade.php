@if(session('success'))
    <div class="fixed top-0 left-0 w-full z-50 py-3 px-4 text-center font-semibold shadow bg-green-500 text-white">
        <span class="text-lg mr-2">✅</span>
        <span>{{ session('success') }}</span>
        <button class="absolute right-8 top-2 text-xl font-bold leading-none focus:outline-none" onclick="this.parentElement.style.display='none'">&times;</button>
    </div>
@endif
@if(session('error'))
    <div class="fixed top-0 left-0 w-full z-50 py-3 px-4 text-center font-semibold shadow bg-red-500 text-white">
        <span class="text-lg mr-2">❌</span>
        <span>{{ session('error') }}</span>
        <button class="absolute right-8 top-2 text-xl font-bold leading-none focus:outline-none" onclick="this.parentElement.style.display='none'">&times;</button>
    </div>
@endif
@if(session('warning'))
    <div class="fixed top-0 left-0 w-full z-50 py-3 px-4 text-center font-semibold shadow bg-yellow-400 text-gray-900">
        <span class="text-lg mr-2">⚠️</span>
        <span>{{ session('warning') }}</span>
        <button class="absolute right-8 top-2 text-xl font-bold leading-none focus:outline-none" onclick="this.parentElement.style.display='none'">&times;</button>
    </div>
@endif
