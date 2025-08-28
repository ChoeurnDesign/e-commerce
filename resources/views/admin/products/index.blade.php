<!-- resources/views/admin/products/index.blade.php -->
@extends('layouts.admin')
@section('title', 'Products Management')
@section('content')
    @include('products.partials.index', [
        'products' => $products,
        'imagePartial' => 'products.partials.image-admin',
        'createRoute' => route('admin.products.create'),
        'importRoute' => route('admin.products.import.form'),
        'showRouteName' => 'admin.products.show',
        'editRouteName' => 'admin.products.edit',
        'deleteRouteName' => 'admin.products.destroy',
    ])
@endsection
