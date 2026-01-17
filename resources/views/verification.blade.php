<x-app-layout>
    <div class="flex justify-center items-center bg-gradient-to-br from-[#0f0f10] via-[#1a1c22] to-[#101215] py-10">
        <div class="w-full max-w-md bg-[#1f2127] border border-[#2c2f39] shadow-xl rounded-xl p-6 relative overflow-hidden">

            {{-- Decorative Gradient Circle --}}
            <div class="absolute -top-16 -right-16 w-40 h-40 bg-[#7b7afc]/20 rounded-full blur-2xl"></div>

            {{-- Step Indicator --}}
            <div class="flex justify-between items-center mb-6 relative z-10">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-[#7b7afc] rounded-full flex items-center justify-center text-white text-xs font-bold">1</div>
                    <span class="text-gray-300 text-xs font-medium">Check Email</span>
                </div>
                <div class="flex-1 h-[1px] bg-gray-700 mx-2"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center text-white text-xs font-bold">2</div>
                    <span class="text-gray-400 text-xs font-medium">Verify Code</span>
                </div>
            </div>

            {{-- Icon & Title --}}
            <div class="flex flex-col items-center mb-6 relative z-10">
                <div class="w-20 h-20 bg-[#8b5cf6] flex items-center justify-center mb-4">
                    <img
                        src="{{ !empty($settings['store_logo']) ? asset($settings['store_logo']) : asset('images/default-logo.png') }}"
                        alt="Logo"
                        class="w-full h-full object-contain"
                    />
                </div>
                <h2 class="text-xl font-bold text-white text-center">Verify Your Email</h2>
                <p class="text-gray-400 text-center mt-1 text-xs leading-relaxed">
                    We’ve sent a <span class="text-[#7b7afc] font-semibold">6-digit code</span> to your email.  
                    Enter it below to complete your verification.
                </p>
                @if(isset($email) || Auth::user())
                    <p class="text-gray-300 mt-1 text-xs text-center">
                        Sent to: <span class="text-[#7b7afc]">{{ $email ?? Auth::user()->email }}</span>
                    </p>
                @endif
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-3 text-green-400 font-medium text-center text-sm animate-pulse">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Resend Code Success/Error Messages --}}
            @if(session('resend_success'))
                <div class="text-green-400 mt-1 text-sm text-center">
                    {{ session('resend_success') }}
                </div>
            @endif
            @if(session('resend_error'))
                <div class="text-red-400 mt-1 text-sm text-center">
                    {{ session('resend_error') }}
                </div>
            @endif

            {{-- Verification Form --}}
            <form method="POST" action="{{ route('code.verify') }}" class="flex flex-col gap-4 relative z-10">
                @csrf
                <div>
                    <label for="code" class="block mb-1 font-medium text-gray-200 text-sm">Verification Code</label>
                    <input
                        type="text"
                        name="code"
                        id="code"
                        maxlength="6"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        required
                        autofocus
                        aria-label="Enter your 6-digit verification code"
                        aria-describedby="code-description"
                        class="w-full bg-[#2c2f39] text-white rounded-md px-3 py-2 text-base tracking-widest text-center border border-transparent focus:border-[#7b7afc] focus:ring-1 focus:ring-[#7b7afc] outline-none transition"
                        placeholder="# # # # # #"
                    />
                    <p id="code-description" class="sr-only">
                        Enter the 6-digit code sent to your email to verify your account.
                    </p>
                    @error('code')
                        <div class="text-red-400 mt-1 text-xs animate-bounce">{{ $message }}</div>
                    @enderror
                </div>
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-[#7b7afc] to-[#5b58d9] text-white py-2 rounded-md font-semibold text-sm tracking-wide shadow hover:opacity-90 transition"
                >
                    Verify & Continue
                </button>
            </form>

            {{-- Footer Options --}}
            <div class="flex justify-between items-center mt-8 relative z-10">
                <form method="GET" action="{{ route('code.send') }}">
                    <button type="submit" class="text-xs text-[#7b7afc] hover:underline font-medium">
                        Resend Code
                    </button>
                </form>
                <a href="{{ route('logout') }}" class="text-xs text-gray-400 hover:underline">
                    Wrong email?
                </a>
            </div>
        </div>
    </div>
</x-app-layout>