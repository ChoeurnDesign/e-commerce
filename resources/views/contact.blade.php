<x-app-layout>
    <div class="py-12 min-h-screen flex flex-col items-center bg-gray-300 dark:bg-[#101624]">
        <div class="w-full max-w-4xl bg-white dark:bg-[#181f31] rounded-2xl shadow-xl p-10 border border-gray-300 dark:border-gray-700">
            <h1 class="text-3xl font-bold text-indigo-700 dark:text-indigo-300 mb-4">Contact Us</h1>
            <p class="text-gray-700 dark:text-gray-200 mb-6">
                Have a question, suggestion, or need help? Our team is here for you! Please reach out using the form below or email us directly.
            </p>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4 bg-indigo-50 dark:bg-[#23263a] rounded-lg p-6 border border-indigo-100 dark:border-indigo-900">
                @csrf
                <div>
                    <label for="name" class="block text-gray-800 dark:text-gray-200 font-semibold">Your Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-white" required>
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-gray-800 dark:text-gray-200 font-semibold">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-white" required>
                    @error('email')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="message" class="block text-gray-800 dark:text-gray-200 font-semibold">Message</label>
                    <textarea name="message" id="message" rows="5" class="mt-1 w-full rounded border-gray-300 dark:border-gray-600 bg-white dark:bg-[#23263a] text-gray-900 dark:text-white" required>{{ old('message') }}</textarea>
                    @error('message')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">Send Message</button>
            </form>
            <div class="mt-8 text-gray-700 dark:text-gray-200">
                <p><span class="font-semibold">Email:</span> support@shopexpress.com</p>
                <p><span class="font-semibold">Phone:</span> +855 70 229 710</p>
            </div>
        </div>
    </div>
</x-app-layout>
