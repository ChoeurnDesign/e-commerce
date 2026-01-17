@php
    $compact = $compact ?? false;
@endphp

{{-- VIEW --}}
<a href="{{ route('admin.sellers.show', $seller->id) }}"
   class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs rounded transition mr-2"
   title="View Seller">
    View
</a>

{{-- EDIT --}}
<a href="{{ route('admin.sellers.edit', $seller->id) }}"
   class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs rounded transition mr-2"
   title="Edit Seller">
    Edit
</a>

{{-- STATUS ACTIONS (status passed in URL) --}}
@if($seller->status === 'pending')
    <form action="{{ route('admin.sellers.updateStatus', [$seller->id, 'approved']) }}" method="POST" class="inline-block">
    @csrf
    @method('PATCH') <!-- Correctly specify the PATCH method -->
    <button type="submit"
        class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs rounded transition"
        title="Approve Seller">
        Approve
    </button>
</form>
    <form action="{{ route('admin.sellers.updateStatus', [$seller->id, 'rejected']) }}" method="POST" class="inline-block ml-2">
        @csrf
        <input type="hidden" name="_method" value="">
        <button type="submit"
            class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs rounded transition"
            title="Reject Seller">
            Reject
        </button>
    </form>
@elseif($seller->status === 'approved')
    <span class="inline-block px-3 py-1.5 bg-green-700 text-white text-xs rounded" title="Seller Approved">Approved</span>
    @if(!$compact)
        <form action="{{ route('admin.sellers.updateStatus', [$seller->id, 'rejected']) }}" method="POST" class="inline-block ml-2">
            @csrf
            <input type="hidden" name="_method" value="">
            <button type="submit"
                class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs rounded transition"
                title="Reject Seller">
                Reject
            </button>
        </form>
    @endif
@elseif($seller->status === 'rejected')
    <span class="inline-block px-3 py-1.5 bg-red-700 text-white text-xs rounded" title="Seller Rejected">Rejected</span>
    @if(!$compact)
        <form action="{{ route('admin.sellers.updateStatus', [$seller->id, 'approved']) }}" method="POST" class="inline-block ml-2">
            @csrf
            <input type="hidden" name="_method" value="">
            <button type="submit"
                class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs rounded transition"
                title="Approve Seller">
                Approve
            </button>
        </form>
    @endif
@endif

