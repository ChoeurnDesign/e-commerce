<x-guest-layout>
    <div class="w-full max-w-md mx-auto py-4">
        <a href="{{ route('google.login', ['provider' => 'google']) }}"
           class="flex items-center justify-center gap-4 px-4 py-2.5 rounded-lg bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 font-semibold text-base transition duration-200 shadow-sm mb-6">
            @php
                // Using the consistent 'public/images' path we discussed for static assets
                $googleIcon = asset('images/google.png');
            @endphp
            <img src="{{ $googleIcon }}"
                alt="Google Logo"
                class="h-6 w-6" 
                onerror="this.src='https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png'"/>
            <span>{{ __('Continue with Google') }}</span>
        </a>

        <div class="relative flex items-center my-8">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="mx-4 text-gray-400 text-xs uppercase tracking-widest font-bold">or</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <x-input-label for="email" :value="__('Email')" class="text-gray-700" />
                <x-text-input id="email"
                              class="block mt-1.5 w-full bg-white border border-rose-100 text-gray-900 rounded-md shadow-sm transition focus:ring-2 focus:ring-pink-400 focus:border-pink-400"
                              type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <x-input-label for="password" :value="__('Password')" class="text-gray-700" />
                </div>
                <x-text-input id="password"
                              class="block mt-1.5 w-full bg-white border border-rose-100 text-gray-900 rounded-md shadow-sm transition focus:ring-2 focus:ring-pink-400 focus:border-pink-400"
                              type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox"
                           class="w-4 h-4 rounded border-rose-200 text-pink-500 shadow-sm focus:ring focus:ring-pink-400"
                           name="remember">
                    <label for="remember_me" class="ml-2 text-sm text-gray-600 select-none">
                        {{ __('Remember me') }}
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a class="text-sm text-pink-600 hover:text-pink-500 transition"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-primary-button class="w-full justify-center py-2.5 bg-orange-500 hover:bg-orange-600 transition duration-200 text-base">
                {{ __('Log in') }}
            </x-primary-button>

            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                <p class="text-gray-500 text-sm">
                    {{ __("Don't have an account?") }}
                    <a href="{{ route('register') }}"
                       class="ml-1 text-pink-600 hover:underline font-semibold">
                       {{ __('Register') }}
                    </a>
                </p>
            </div>
        </form>
    </div>
</x-guest-layout>