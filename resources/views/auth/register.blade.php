<x-guest-layout>
    <div class="w-full max-w-md mx-auto py-2">
        <!-- Google Login Button -->
        <a href="{{ route('google.login', ['provider' => 'google']) }}"
            class="flex items-center justify-center gap-4 px-3 py-2 rounded-lg hover:bg-gray-100 text-gray-700 border border-rose-100 font-semibold text-base transition mb-6">
            <img src="{{ asset('img/google.png') }}"
                alt="Google Logo"
                class="h-6 w-6" />
            Continue with Google
        </a>
        <div class="relative flex items-center my-6">
            <div class="flex-grow border-t border-rose-100"></div>
            <span class="mx-3 text-gray-400 text-sm">or</span>
            <div class="flex-grow border-t border-rose-100"></div>
        </div>
        <!-- Email/Password Register Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name"
                    class="block mt-1 w-full bg-white border border-rose-100 text-gray-900 rounded-md transition focus:ring-2 focus:ring-pink-400"
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email"
                    class="block mt-1 w-full bg-white border border-rose-100 text-gray-900 rounded-md transition focus:ring-2 focus:ring-pink-400"
                    type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password"
                    class="block mt-1 w-full bg-white border border-rose-100 text-gray-900 rounded-md transition focus:ring-2 focus:ring-pink-400"
                    type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation"
                    class="block mt-1 w-full bg-white border border-rose-100 text-gray-900 rounded-md transition focus:ring-2 focus:ring-pink-400"
                    type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>
            <div class="flex items-center justify-between mt-6">
                <a class="underline text-sm text-gray-500 hover:text-pink-600 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-400"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>
                <x-primary-button class="bg-orange-500 hover:bg-orange-600">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
