<!-- resources/views/admin/products/index.blade.php -->
@extends('layouts.admin')
@section('title', 'Products Management')
@section('content')
    @include('products.partials.index', [
        'products' => $products,
        'imagePartial' => 'products.partials.image-seller',
        'showRouteName' => 'admin.products.show',
        'editRouteName' => 'admin.products.edit',
        'deleteRouteName' => 'admin.products.destroy',
    ])
@endsection
