@extends('admin.dashboard.master')

@section('content')
    <h1>Category Details</h1>
    <p><strong>Name:</strong> {{ $category->name }}</p>
    <div class="col-md-6">
        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" width="100">
    </div>

    <a href="{{ route('admin.category.index') }}" class="btn btn-secondary">Back to Categories</a>
@endsection
