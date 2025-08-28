<!-- resources/views/seller/products/index.blade.php -->
@extends('layouts.seller')
@section('title', 'Products Management')
@section('content')
    @include('products.partials.index', [
        'products' => $products,
        'imagePartial' => 'products.partials.image-seller', 
        'createRoute' => route('seller.products.create'),
        'importRoute' => route('seller.products.import.form'),
        'showRouteName' => 'seller.products.show',
        'editRouteName' => 'seller.products.edit',
        'deleteRouteName' => 'seller.products.destroy',
    ])
@endsection
