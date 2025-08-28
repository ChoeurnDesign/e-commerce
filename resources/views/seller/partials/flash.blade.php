@foreach (['success'=>'green','status'=>'green','warning'=>'amber','error'=>'red','info'=>'blue'] as $key => $color)
    @if(session($key))
        <div x-data="{ show:true }"
             x-show="show"
             x-transition
             class="mb-6 border border-{{ $color }}-400 dark:border-{{ $color }}-700 bg-{{ $color }}-100 dark:bg-{{ $color }}-900/40 text-{{ $color }}-800 dark:text-{{ $color }}-200 px-4 py-3 rounded relative text-sm">
            <span class="block">{{ session($key) }}</span>
            <button type="button" @click="show=false" class="absolute top-1 right-2 text-{{ $color }}-600 dark:text-{{ $color }}-300">
                &times;
            </button>
        </div>
    @endif
@endforeach