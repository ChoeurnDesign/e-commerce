@extends('layouts.admin')

@section('title', 'Import Products')

@section('content')
    @include('products.partials.import_form', [
        'title' => 'Import Products',
        'formAction' => route('admin.products.import'),
        'backRoute' => route('admin.products.index'),
        'buttonText' => 'Import Products'
    ])
@endsection
