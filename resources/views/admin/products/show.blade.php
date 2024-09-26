@extends('admin.dashboard.master')


@section('content')
    <h1>Product Details</h1>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            {{ $product->name }}
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-6">
                    <h4>Description</h4>
                    <p>{{ $product->description }}</p>
                    <h4>Price</h4>
                    <p>${{ $product->price }}</p>
                    <h4>Weight</h4>
                    <p>{{ $product->weight }} kg</p>
                    <h4>Quantity</h4>
                    <p>{{ $product->quantity }}</p>
                    <h4>Category</h4>
                    <p>{{ $product->category->name }}</p>
                    <div class="col-md-6">
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" width="100">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Back to Product List</a>
        </div>
    </div>
@endsection

