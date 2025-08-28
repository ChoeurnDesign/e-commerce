@extends('layouts.seller')

@section('title', 'Import Products')

@section('content')
    @include('products.partials.import_form', [
        'title' => 'Import Products',
        'formAction' => route('seller.products.import'),
        'backRoute' => route('seller.products.index'),
        'buttonText' => 'Import Products'
    ])
@endsection
