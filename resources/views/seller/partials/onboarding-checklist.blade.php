@php
    $hasLogo        = !empty($seller->store_logo);
    $hasDescription = !empty(trim($seller->description ?? ''));
    $hasContact     = !empty($seller->contact_email);
    $hasProduct     = isset($productsCount) ? $productsCount > 0 : $seller->products()->exists();
    $total          = 4;
    $done           = (int)$hasLogo + (int)$hasDescription + (int)$hasContact + (int)$hasProduct;
    $allDone        = $done === $total;
@endphp

@if(!$allDone)
<div class="mt-5 bg-pink-50 border border-pink-200 rounded-xl p-4">
    <div class="flex items-center justify-between mb-3">
        <h4 class="text-sm font-semibold text-pink-800">
            Store Setup Checklist
        </h4>
        <span class="text-xs font-medium text-pink-600 bg-pink-100 px-2 py-0.5 rounded-full">
            {{ $done }}/{{ $total }} done
        </span>
    </div>

    {{-- Progress bar --}}
    <div class="w-full bg-pink-100 rounded-full h-1.5 mb-3">
        <div class="bg-pink-500 h-1.5 rounded-full transition-all duration-500"
             style="width: {{ ($done / $total) * 100 }}%"></div>
    </div>

    <ul class="space-y-2">
        @php
            $items = [
                ['done' => $hasDescription, 'label' => 'Write a store description', 'href' => route('seller.settings.edit')],
                ['done' => $hasLogo,        'label' => 'Upload a store logo',        'href' => route('seller.settings.edit')],
                ['done' => $hasContact,     'label' => 'Set a contact email',        'href' => route('seller.settings.edit')],
                ['done' => $hasProduct,     'label' => 'List your first product',    'href' => route('seller.products.create')],
            ];
        @endphp

        @foreach($items as $item)
            <li class="flex items-center gap-2.5">
                @if($item['done'])
                    <span class="w-4 h-4 flex-shrink-0 rounded-full bg-pink-500 flex items-center justify-center">
                        <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <span class="text-xs text-pink-400 line-through">{{ $item['label'] }}</span>
                @else
                    <span class="w-4 h-4 flex-shrink-0 rounded-full border-2 border-pink-300"></span>
                    <a href="{{ $item['href'] }}" class="text-xs text-pink-700 hover:underline font-medium">
                        {{ $item['label'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</div>
@else
<div class="mt-4 flex items-center gap-2 text-sm text-green-700">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span class="font-medium">Your store setup is complete!</span>
</div>
@endif
