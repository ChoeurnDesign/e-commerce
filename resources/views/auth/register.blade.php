<x-guest-layout>
    <div class="w-full max-w-md mx-auto py-2">
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8 space-y-8">
                <!-- Google Login Button -->
                <a href="{{ route('social.login', ['provider' => 'google']) }}"
                class="flex items-center justify-center gap-6 px-1 py-1.5 rounded-full hover:bg-gray-300 text-black border-2 border-gray-300 font-bold text-lg shadow transition mb-6">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c1/Google_%22G%22_logo.svg/800px-Google_%22G%22_logo.svg.png"
                    alt="Google Logo"
                    class="h-8 w-8 rounded-full" />
                    Continue with Google
                </a>
            <div class="relative flex items-center my-6">
                <div class="flex-grow border-t border-gray-200 dark:border-gray-800"></div>
                <span class="mx-4 text-gray-500 dark:text-gray-400">or</span>
                <div class="flex-grow border-t border-gray-200 dark:border-gray-800"></div>
            </div>
            <!-- Email/Password Register Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full bg-gray-300 dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full bg-gray-300 dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full bg-gray-300 dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-300 dark:bg-gray-800 text-gray-900 dark:text-gray-100"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div class="flex items-center justify-between mt-6">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                    <x-primary-button>
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
