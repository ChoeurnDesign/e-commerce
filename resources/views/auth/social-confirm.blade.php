<x-app-layout>
    <div class="flex justify-center items-center bg-white dark:bg-[#13161a] p-4 py-10 sm:px-4 md:px-8 lg:px-16 xl:px-32">
        <div class="w-full max-w-5xl rounded-[32px] bg-white dark:bg-[#15181c] shadow-2xl border border-gray-400 dark:border-[#23262f] flex flex-col">
            <!-- Top: Google logo and "Sign in with Google" -->
            <div class="flex items-center px-4 md:px-8 lg:px-12 pt-6 pb-2">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/800px-Google_%22G%22_logo.svg.png" alt="Google" class="h-6 w-6 mr-2">
                <span class="text-gray-700 dark:text-gray-200 font-medium text-[1rem]">Sign in with Google</span>
            </div>
            <!-- Divider line -->
            <div class="border-b border-gray-200 dark:border-[#23262f] mx-4 md:mx-8 lg:mx-12"></div>
            <!-- Main Content: Left & Right -->
            <div class="flex flex-col md:flex-row justify-between px-4 md:px-8 lg:px-12 pt-6 pb-6 flex-1">
                <!-- Left: Main info -->
                <div class="flex-1 min-w-[260px]">
                    <!-- (Optional) Your app logo -->
                    <div class="w-20 h-20 bg-[#8b5cf6] flex items-center justify-center mb-4">
                        @if(!empty($settings['store_logo']))
                            <img
                                src="{{ asset($settings['store_logo']) }}"
                                alt="Logo"
                                class="w-full h-full object-contain border border-violet-400"
                            />
                        @endif
                    </div>

                    <div class="text-2xl font-bold text-gray-900 dark:text-white mb-3 leading-tight">
                        You're signing back in to<br>
                        <span class="text-[#7b7afc]">{{ config('app.domain') ?? config('app.name') }}</span>
                    </div>
                    <!-- Account pill styled to match Google style exactly -->
                    <a href="{{ route('social.login', 'google') }}"
                       class="inline-flex items-center px-1 py-1 rounded-full border border-[#444] bg-[#181f31] text-white font-medium text-base mt-6"
                       style="min-width: 0;">
                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode($info['name'] ?? 'U') }}&background=181f31&color=fff"
                            alt="Avatar"
                            class="w-6 h-6 rounded-full mr-2 border border-white object-cover"
                            onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=U&background=181f31&color=fff';"
                        />
                        <span class="truncate">{{ $info['email'] }}</span>
                        <svg class="w-4 h-4 ml-2 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 10l5 5 5-5"/>
                        </svg>
                    </a>
                </div>
                <!-- Right: Policy/info -->
                <div class="flex-1 md:ml-14 mt-6 mb-20 md:mt-6 flex items-center">
                    <div class="text-gray-600 dark:text-gray-300 text-[.97rem] leading-relaxed">
                        Review shopexpress.com's
                        <a href="#" class="underline text-[#7b7afc]">Privacy Policy</a> and
                        <a href="#" class="underline text-[#7b7afc]">Terms of Service</a> to understand how {{ config('app.domain') ?? config('app.name') }} will process and protect your data.<br><br>
                        To make changes at any time, go to your <span class="text-[#7b7afc]">Google Account</span>.<br><br>
                        Learn more about <a href="#" class="underline text-[#7b7afc]">Sign in with Google</a>.
                    </div>
                </div>
            </div>
            <!-- Bottom: Buttons, always at the bottom -->
            <div class="flex justify-end px-4 md:px-8 lg:px-12 pb-6 space-x-4">
                <form method="POST" action="{{ route('social.confirm.cancel') }}">
                    @csrf
                    <button type="submit" class="px-20 py-2 rounded-full border border-[#444] bg-transparent text-gray-900 dark:text-white font-semibold hover:bg-[#f3f4f6] dark:hover:bg-[#232952] transition text-base">Cancel</button>
                </form>
                <form method="POST" action="{{ route('social.confirm.proceed') }}">
                    @csrf
                    <button type="submit" class="px-20 py-2 rounded-full border border-[#444] bg-transparent text-gray-900 dark:text-white font-semibold hover:bg-[#f3f4f6] dark:hover:bg-[#232952] transition text-base">Continue</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
