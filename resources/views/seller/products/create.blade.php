@extends('layouts.seller')

@section('content')
<div class="min-h-screen">
    @include('products.partials._form', [
        'title' => 'Create Product',
        'formAction' => route('seller.products.store'),
        'formMethod' => 'POST',
        'categories' => $categories,
        'product' => null,
        'submitText' => 'Create Product',
        'cancelUrl' => route('seller.products.index'),
    ])
</div>
@endsection
