<x-app-layout>
    <div class="flex mt-8 justify-center items-center bg-[#15181c] p-2 sm:px-4 md:px-8">
        <div class="w-full max-w-md rounded-[32px] bg-[#15181c] shadow-2xl border border-[#23262f] flex flex-col p-8">
            <div class="flex flex-col items-center mb-6">
                <div class="w-12 h-12 bg-[#8b5cf6] rounded-lg flex items-center justify-center mb-3">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-[#7b7afc] text-center">Verify your email</h2>
                <span class="text-gray-400 text-base mt-1 text-center">
                    Enter the 6-digit code sent to your email.
                </span>
                @if(isset($email) || Auth::user())
                    <span class="text-[#7b7afc] text-base mt-1 text-center">
                        Please check your inbox for <b>{{ $email ?? Auth::user()->email }}</b>
                        and click the link to verify, or enter the code below.
                    </span>
                @endif
            </div>
            @if(session('success'))
                <div class="mb-4 text-green-400 font-semibold text-center">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('code.verify') }}" class="flex flex-col gap-4" aria-label="Verification code form">
                @csrf
                <div>
                    <label for="code" class="block mb-2 font-medium text-[#7b7afc]">Verification Code</label>
                    <input
                        type="text"
                        name="code"
                        id="code"
                        class="w-full border-1 bg-[#23262F] text-white rounded-full px-4 py-2 focus:ring-1 focus:ring-[#7b7afc] text-lg tracking-widest text-center transition"
                        maxlength="6"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        required
                        autofocus
                    >
                    @error('code')
                        <div class="text-red-400 mt-2 animate-shake">{{ $message }}</div>
                    @enderror
                </div>
                <button
                    type="submit"
                    class="w-full bg-[#7b7afc] text-white py-2 rounded-full font-bold text-lg tracking-wide hover:bg-[#6657c6] transition"
                    aria-busy="false"
                >
                    Verify Code
                </button>
            </form>
            <div class="flex justify-between items-center mt-6">
                <form method="GET" action="{{ route('code.send') }}">
                    <button type="submit" class="text-sm text-[#7b7afc] hover:underline font-medium">Resend Code</button>
                </form>
                <a href="{{ route('logout') }}" class="text-sm text-gray-400 hover:underline">Wrong email?</a>
            </div>
        </div>
    </div>
</x-app-layout>
