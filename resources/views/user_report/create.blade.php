@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white dark:bg-gray-800 rounded shadow mt-8">
    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Report a Problem</h2>
    <form action="{{ route('user_report.store') }}" method="POST" enctype="multipart/form-data">
        @include('user_report._form')
    </form>
</div>
@endsection
