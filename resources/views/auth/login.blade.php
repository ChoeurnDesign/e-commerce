<x-guest-layout>
    <div class="w-full max-w-md mx-auto py-8">

        <!-- Google Login Button -->
        <a href="{{ route('social.login', ['provider' => 'google']) }}"
            class="flex items-center justify-center gap-6 px-1 py-1.5 rounded-full hover:bg-gray-300 text-black border-2 border-gray-300 font-bold text-lg shadow transition mb-6">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/800px-Google_%22G%22_logo.svg.png"
                alt="Google Logo" class="h-8 w-8 rounded-full" />
            Continue with Google
        </a>
        <div class="relative flex items-center my-6">
            <div class="flex-grow border-t border-gray-200 dark:border-gray-800"></div>
            <span class="mx-4 text-gray-500 dark:text-gray-400">or</span>
            <div class="flex-grow border-t border-gray-200 dark:border-gray-800"></div>
        </div>
        <!-- Email/Password Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email"
                    class="block mt-1 w-full bg-gray-300 dark:bg-gray-800 text-gray-900 dark:text-gray-100" type="email"
                    name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password"
                    class="block mt-1 w-full bg-gray-300 dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                    type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <div class="block">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">{{ __('Remember me') }}</span>
                </label>
            </div>
            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
                <x-primary-button>
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
            <div class="mt-6 text-center">
                <span class="text-gray-500 dark:text-gray-400">Don't have an account?</span>
                <a href="{{ route('register') }}"
                    class="ml-2 text-indigo-600 dark:text-indigo-400  hover:underline">Register</a>
            </div>
        </form>
    </div>
</x-guest-layout>
