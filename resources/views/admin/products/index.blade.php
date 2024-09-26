@extends('admin.dashboard.master')

@section('content')

        <h1>Product List</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add New Product</a>

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

        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Price</th>
                <th>Weight</th>
                <th>Quantity</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->category ? $product->category->name : 'No Category' }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->weight }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>
                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" width="100">
                    </td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-info">View</a>

                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $products->links() }}


@endsection
