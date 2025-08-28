<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    {{-- Cropper.js CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css"/>

    <div class="py-12 bg-gray-300 dark:bg-[#101624] min-h-screen flex justify-center items-start">
        <div class="w-full max-w-2xl border-2 border-gray-300 bg-white dark:bg-[#181f31] rounded-2xl shadow-xl p-8 space-y-10">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profile-update-form" class="space-y-10">
                @csrf
                @method('patch')
                <div class="flex items-center space-x-6">
                    <div class="relative group block">
                        <div id="profile-image-preview" class="h-24 w-24 rounded-full overflow-hidden border-gray-300 dark:border-gray-400 border-2 shadow-lg object-cover transition-shadow group-hover:shadow-xl bg-gray-300 dark:bg-[#181f31] flex items-center justify-center">
                            @if($user->profile_image && file_exists(public_path('storage/' . $user->profile_image)))
                                <img src="{{ asset('storage/' . $user->profile_image) }}"
                                     alt="Avatar"
                                     class="w-full h-full object-cover object-center"
                                     id="current-profile-img" />
                            @else
                                <span class="h-24 w-24 flex items-center justify-center rounded-full bg-gray-300 dark:bg-[#181f31] text-indigo-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <circle cx="12" cy="8" r="4" />
                                        <path d="M6 20c0-2.2 3.6-4 6-4s6 1.8 6 4" />
                                    </svg>
                                </span>
                            @endif
                        </div>
                        <!-- Camera button, light/dark adaptive -->
                        <button type="button" id="change-image-btn"
                                class="absolute bottom-0 right-0 bg-gray-300 dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 rounded-full p-1 shadow-lg flex items-center justify-center z-10"
                                style="width: 32px; height: 32px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff9500" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
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
                        </button>
                        <input type="file" id="profile_image" name="profile_image" accept="image/*" class="hidden">
                        <input type="hidden" name="cropped_profile_image" id="cropped_profile_image">
                    </div>
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

    <!-- Crop Modal -->
    <div id="cropper-modal" class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-70 hidden">
        <div class="bg-white dark:bg-[#23263a] p-6 rounded-xl shadow-xl w-full max-w-md">
            <div class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Crop Your Image</div>
            <div>
                <img id="cropper-image" src="" class="max-w-full max-h-96 mx-auto rounded-lg">
            </div>
            <div class="mt-4 flex justify-end space-x-2">
                <button class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-100" id="cancel-crop-btn">Cancel</button>
                <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded" id="apply-crop-btn">Crop & Use</button>
            </div>
        </div>
    </div>

    {{-- Cropper.js JS --}}
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.js"></script>
    <script>
        let cropper;
        const input = document.getElementById('profile_image');
        const changeBtn = document.getElementById('change-image-btn');
        const modal = document.getElementById('cropper-modal');
        const cropperImage = document.getElementById('cropper-image');
        const cancelBtn = document.getElementById('cancel-crop-btn');
        const applyBtn = document.getElementById('apply-crop-btn');
        const previewContainer = document.getElementById('profile-image-preview');
        const croppedInput = document.getElementById('cropped_profile_image');

        // Open file dialog
        changeBtn.addEventListener('click', function() {
            input.value = '';
            input.click();
        });

        // After choosing file, show crop modal
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    cropperImage.src = event.target.result;
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        if (cropper) cropper.destroy();
                        cropper = new Cropper(cropperImage, {
                            aspectRatio: 1,
                            viewMode: 1,
                            autoCropArea: 1,
                        });
                    }, 100);
                };
                reader.readAsDataURL(file);
            }
        });

        // Cancel cropping
        cancelBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
            if (cropper) cropper.destroy();
            cropper = null;
            input.value = '';
        });

        // Apply cropping
        applyBtn.addEventListener('click', function() {
            if (cropper) {
                const canvas = cropper.getCroppedCanvas({
                    width: 300,
                    height: 300,
                    imageSmoothingQuality: 'high'
                });
                const url = canvas.toDataURL('image/png');
                // Update preview
                let img = previewContainer.querySelector('img');
                if (!img) {
                    img = document.createElement('img');
                    img.className = 'w-full h-full object-cover object-center';
                    previewContainer.innerHTML = '';
                    previewContainer.appendChild(img);
                }
                img.src = url;
                // Store base64 in hidden input
                croppedInput.value = url;
                // Close modal
                modal.classList.add('hidden');
                cropper.destroy();
                cropper = null;
                input.value = '';
            }
        });
    </script>
</x-app-layout>
