@extends('layout.dashboard')

@section('content')
<div class="container mt-4 card px-5 w-50 py-5">

    <h2 class="mb-4">Category Details</h2>

    {{-- Name --}}
    <div class="mb-3">
        <strong>Name:</strong>
        <p>{{ $category->name }}</p>
    </div>

    {{-- Image --}}
    <div class="mb-3">
        <strong>Image:</strong><br>
        @if($category->image)
            <img src="{{ asset('storage/'.$category->image) }}"
                width="200"
                class="img-thumbnail">
        @else
            <p>No image</p>
        @endif
    </div>

    {{-- Status --}}
    <div class="mb-3">
        <strong>Status:</strong>
        @if($category->is_active)
            <span class="badge bg-success">Active</span>
        @else
            <span class="badge bg-danger">Inactive</span>
        @endif
    </div>

    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-info text-light">
        Back
    </a>

    <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-primary">
        Edit
    </a>

</div>
@endsection
