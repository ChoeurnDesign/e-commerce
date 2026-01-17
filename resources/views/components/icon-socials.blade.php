@props([
    'name',
    'class' => '',
    'label' => null,
    'bare' => false, // when true return only the <i> element
])

@php
    // ensure we always include any sizing if not provided by caller
    $classes = trim($class);
@endphp

@if($bare)
    @switch($name)
        @case('facebook')   <i class="fa-brands fa-facebook {{ $classes ?: 'text-white text-xl' }}" aria-hidden="true"></i> @break
        @case('twitter')    <i class="fa-brands fa-twitter {{ $classes ?: 'text-white text-xl' }}" aria-hidden="true"></i> @break
        @case('instagram')  <i class="fa-brands fa-instagram {{ $classes ?: 'text-white text-xl' }}" aria-hidden="true"></i> @break
        @case('linkedin')   <i class="fa-brands fa-linkedin {{ $classes ?: 'text-white text-xl' }}" aria-hidden="true"></i> @break
        @case('tiktok')     <i class="fa-brands fa-tiktok {{ $classes ?: 'text-white text-xl' }}" aria-hidden="true"></i> @break
        @case('youtube')    <i class="fa-brands fa-youtube {{ $classes ?: 'text-white text-xl' }}" aria-hidden="true"></i> @break
        @case('pinterest')  <i class="fa-brands fa-pinterest {{ $classes ?: 'text-white text-xl' }}" aria-hidden="true"></i> @break
        @case('website')    <i class="fa-solid fa-globe {{ $classes ?: 'text-white text-xl' }}" aria-hidden="true"></i> @break
        @default            <i class="fa-solid fa-circle {{ $classes ?: 'text-white text-xl' }}" aria-hidden="true"></i>
    @endswitch
@else
    <span class="inline-flex items-center" role="img" aria-label="{{ $label ?? $name }}">
        @switch($name)
            @case('facebook')   <i class="fa-brands fa-facebook {{ $classes }}" aria-hidden="true"></i> @break
            @case('twitter')    <i class="fa-brands fa-twitter {{ $classes }}" aria-hidden="true"></i> @break
            @case('instagram')  <i class="fa-brands fa-instagram {{ $classes }}" aria-hidden="true"></i> @break
            @case('linkedin')   <i class="fa-brands fa-linkedin {{ $classes }}" aria-hidden="true"></i> @break
            @case('tiktok')     <i class="fa-brands fa-tiktok {{ $classes }}" aria-hidden="true"></i> @break
            @case('youtube')    <i class="fa-brands fa-youtube {{ $classes }}" aria-hidden="true"></i> @break
            @case('pinterest')  <i class="fa-brands fa-pinterest {{ $classes }}" aria-hidden="true"></i> @break
            @case('website')    <i class="fa-solid fa-globe {{ $classes }}" aria-hidden="true"></i> @break
            @default            <i class="fa-solid fa-circle {{ $classes }}" aria-hidden="true"></i>
        @endswitch

        @if($label)
            <span class="sr-only">{{ $label }}</span>
        @endif
    </span>
@endif