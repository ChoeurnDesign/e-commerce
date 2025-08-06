<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-300 dark:bg-[#101624] min-h-screen flex justify-center items-start">
        <div class="w-full max-w-2xl border-2 border-gray-300 bg-white dark:bg-[#181f31] rounded-2xl shadow-xl p-8 space-y-10">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profile-update-form" class="space-y-10">
                @csrf
                @method('patch')
                <div class="flex items-center space-x-6">
                    <label for="profile_image" class="relative cursor-pointer group block">
                        @if($user->profile_image && file_exists(public_path('storage/' . $user->profile_image)))
                            <img src="{{ asset('storage/' . $user->profile_image) }}"
                                 alt="Avatar"
                                 class="h-24 w-24 rounded-full border-gray-300 dark:border-gray-400 border-2 shadow-lg object-cover transition-shadow group-hover:shadow-xl bg-gray-300 dark:bg-[#181f31]" />
                        @else
                            <span class="h-24 w-24 flex items-center justify-center rounded-full border-gray-300 dark:border-gray-400 border-2 bg-gray-300 dark:bg-[#181f31] text-indigo-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="12" cy="8" r="4" />
                                    <path d="M6 20c0-2.2 3.6-4 6-4s6 1.8 6 4" />
                                </svg>
                            </span>
                        @endif
                        <!-- Camera button, light/dark adaptive -->
                        <span class="absolute bottom-0 right-0 bg-gray-300 dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 rounded-full p-1 shadow-lg flex items-center justify-center z-10" style="width: 32px; height: 32px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ff9500" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 20h-7a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v3" />
                            <path d="M14.973 13.406a3 3 0 1 0 -2.973 2.594" />
                            <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M19.001 15.5v1.5" />
                            <path d="M19.001 21v1.5" />
                            <path d="M22.032 17.25l-1.299 .75" />
                            <path d="M17.27 20l-1.3 .75" />
                            <path d="M15.97 17.25l1.3 .75" />
                            <path d="M20.733 20l1.3 .75" />
                            </svg>
                        </span>
                        <input
                            type="file"
                            id="profile_image"
                            name="profile_image"
                            accept="image/*"
                            class="hidden"
                            onchange="document.getElementById('profile-update-form').submit();"
                        >
                    </label>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</h2>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $user->email }}</p>
                        <button type="button" class="mt-2 inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full text-xs font-semibold transition"
                            onclick="document.getElementById('profile-info').scrollIntoView({ behavior: 'smooth' })">
                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M15.232 5.232l3.536 3.536M9 11l6.232-6.232a2 2 0 1 1 2.828 2.828L11 13.828V17h3.172l7.071-7.071a4 4 0 1 0-5.656-5.657L6 12.343V17h4.657l7.071-7.071a4 4 0 1 0-5.656-5.657L6 12.343V17"></path>
                            </svg>
                            Edit Profile
                        </button>
                    </div>
                </div>
                <div class="pt-8" id="profile-info">
                    <div class="p-0 bg-transparent shadow-none rounded-none">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Profile Information') }}
                                </h2>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                                    {{ __("Update your account's profile information and email address.") }}
                                </p>
                            </header>
                            <div class="mt-6 space-y-6">
                                <div>
                                    <x-input-label for="name" :value="__('Name')" class="text-gray-700 dark:text-gray-200"/>
                                    <x-text-input
                                        id="name"
                                        name="name"
                                        type="text"
                                        class="mt-1 block w-full bg-gray-300 dark:bg-[#181f31] text-gray-900 dark:text-gray-100"
                                        :value="old('name', $user->name)"
                                        required autofocus autocomplete="name"
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                </div>
                                <div>
                                    <x-input-label for="email" :value="__('Email')" class="text-gray-700 dark:text-gray-200"/>
                                    <x-text-input
                                        id="email"
                                        name="email"
                                        type="email"
                                        class="mt-1 block w-full bg-gray-300 dark:bg-[#181f31] text-gray-900 dark:text-gray-100"
                                        :value="old('email', $user->email)"
                                        required autocomplete="username"
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                        <div>
                                            <p class="text-sm mt-2 text-gray-700 dark:text-gray-200">
                                                {{ __('Your email address is unverified.') }}
                                                <button form="send-verification" class="underline text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    {{ __('Click here to re-send the verification email.') }}
                                                </button>
                                            </p>
                                            @if (session('status') === 'verification-link-sent')
                                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                                    {{ __('A new verification link has been sent to your email address.') }}
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="flex items-center gap-4">
                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                                    @if (session('status') === 'profile-updated')
                                        <p
                                            x-data="{ show: true }"
                                            x-show="show"
                                            x-transition
                                            x-init="setTimeout(() => show = false, 2000)"
                                            class="text-sm text-green-600 dark:text-green-400"
                                        >{{ __('Saved.') }}</p>
                                    @endif
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </form>
            <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                <div class="p-0 bg-transparent shadow-none rounded-none">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
                <div class="p-0 bg-transparent shadow-none rounded-none">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
