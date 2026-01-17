@php
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Str;

    // keep same platform list (max 8)
    $platforms = ['website','facebook','instagram','tiktok','twitter','linkedin','youtube','pinterest'];

    // normalize social urls (support both foo and foo_url)
    $socials = [
        'website'   => $seller->website ?? $seller->website_url ?? null,
        'facebook'  => $seller->facebook ?? $seller->facebook_url ?? null,
        'instagram' => $seller->instagram ?? $seller->instagram_url ?? null,
        'tiktok'    => $seller->tiktok ?? $seller->tiktok_url ?? null,
        'twitter'   => $seller->twitter ?? $seller->twitter_url ?? null,
        'linkedin'  => $seller->linkedin ?? $seller->linkedin_url ?? null,
        'youtube'   => $seller->youtube ?? $seller->youtube_url ?? null,
        'pinterest' => $seller->pinterest ?? $seller->pinterest_url ?? null,
    ];

    $badgeClasses = [
        'website'   => 'bg-gray-800 dark:bg-gray-700',
        'facebook'  => 'bg-blue-700 dark:bg-blue-600',
        'instagram' => 'bg-gradient-to-tr from-pink-400 via-purple-600 to-yellow-400 dark:from-pink-500 dark:via-purple-700 dark:to-yellow-500',
        'tiktok'    => 'bg-black dark:bg-gray-900',
        'twitter'   => 'bg-sky-500 dark:bg-sky-400',
        'linkedin'  => 'bg-blue-700 dark:bg-blue-600',
        'youtube'   => 'bg-red-600 dark:bg-red-500',
        'pinterest' => 'bg-red-500 dark:bg-red-400',
    ];

    $hasIcon = fn($name) => File::exists(public_path("icons/social/{$name}.svg"));
    $labelFor = fn($p) => ucfirst($p === 'website' ? 'Website' : $p);
    $shortDomain = fn($url) => Str::limit(parse_url($url, PHP_URL_HOST) ?? $url, 28);
@endphp

<div class="mt-6">
    {{-- Contact info --}}
    <section>
        <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Contact Information</h2>
        <ul class="space-y-3 text-sm">
            @if($seller->contact_email)
                <li class="flex items-start gap-3">
                    <x-heroicon-o-envelope class="w-5 h-5 text-blue-400 flex-shrink-0"/>
                    <a href="mailto:{{ $seller->contact_email }}" class="hover:underline break-words text-gray-700 dark:text-gray-100">{{ $seller->contact_email }}</a>
                </li>
            @endif

            @if($seller->address)
                <li class="flex items-start gap-3">
                    <x-heroicon-o-map-pin class="w-5 h-5 text-blue-400 flex-shrink-0"/>
                    <address class="not-italic break-words text-gray-700 dark:text-gray-100">{{ $seller->address }}</address>
                </li>
            @endif

            @if($seller->phone)
                <li class="flex items-start gap-3">
                    <x-heroicon-o-phone class="w-5 h-5 text-blue-400 flex-shrink-0"/>
                    <a href="tel:{{ $seller->phone }}" class="hover:underline text-gray-700 dark:text-gray-100">{{ $seller->phone }}</a>
                </li>
            @endif
        </ul>
    </section>

    {{-- Socials: improved design with label + domain --}}
    <section class="mt-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Socials</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($platforms as $p)
                @php $url = $socials[$p] ?? null; @endphp
                @if(!$url) @continue @endif

                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                   class="group flex items-center gap-3 p-3 rounded-lg bg-gray-300 dark:bg-gray-800 hover:bg-gray-400 dark:hover:bg-gray-700 transition-shadow shadow-sm hover:shadow-md"
                   aria-label="{{ $labelFor($p) }} profile"
                   title="{{ $url }}">
                    {{-- badge icon --}}
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full flex-shrink-0 shadow-inner ring-1 ring-white/5 group-hover:scale-105 transition-transform duration-150
                                 {{ $badgeClasses[$p] ?? 'bg-gray-800 dark:bg-gray-700' }}">
                        @if($hasIcon($p))
                            <img src="{{ asset('icons/social/' . $p . '.svg') }}" alt="{{ $p }} icon" class="w-5 h-5"/>
                        @else
                            {!! view('components.icon-socials', ['name' => $p, 'class' => 'text-white', 'bare' => true])->render() !!}
                        @endif
                    </span>

                    {{-- text block --}}
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $labelFor($p) }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">•</span>
                            <span class="text-xs text-gray-400 dark:text-gray-300">{{ $shortDomain($url) }}</span>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-full">
                            {{ Str::limit($url, 60) }}
                        </div>
                    </div>
                </a>
            @endforeach

            {{-- Add/edit affordance (only for owner) --}}
            @can('update', $seller)
                <a href="{{ route('seller.settings.edit') }}"
                   class="group flex items-center gap-3 p-3 rounded-lg border border-dashed border-white/6 dark:border-gray-600 bg-transparent hover:bg-gray-800/30 dark:hover:bg-gray-700/30 transition">
                    <span class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-gray-700 text-white">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 5v14M5 12h14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <div>
                        <div class="font-medium text-gray-900 dark:text-gray-100">Manage Social Links</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Add or edit up to 8 links</div>
                    </div>
                </a>
            @endcan
        </div>
    </section>
</div>