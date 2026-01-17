@extends('layouts.seller')

@section('content')
<div class="max-w-full mx-auto space-y-8">
    @include('products.partials._form', [
        'title' => 'Edit Product',
        'formAction' => route('seller.products.update', $product),
        'formMethod' => 'PUT',
        'categories' => $categories,
        'product' => $product,
        'submitText' => 'Update Product',
        'cancelUrl' => route('seller.products.index'),
    ])
</div>
@endsection
