@extends('admin.dashboard.master')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h1>Create Category</h1>
    <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Category Name:</label>
            <input type="text" name="name" id="name" class="form-control" required>
            @error('name')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="image">Upload Image:</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Create</button>
    </form>
@endsection
