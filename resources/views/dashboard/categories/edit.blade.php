@extends('layout.dashboard')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Edit Category</h2>

    <form method="POST"
            action="{{ route('dashboard.categories.update', $category->id) }}"
            enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Name --}}
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text"
                name="name"
                class="form-control"
                value="{{ old('name', $category->name) }}">

            {{-- @error('name')
                <div class="text_danger">{{ $message }}</div>
            @enderror --}}
        </div>

        {{-- Image --}}
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file"
                    name="image"
                    class="form-control @error('image') is-invalid @enderror">

            {{-- @error('image')
                <div>{{ $message }}</div>
            @enderror --}}

            @if($category->image)
                <img src="{{ asset('storage/'.$category->image) }}"
                    width="120"
                    class="mt-2 img-thumbnail">
            @endif
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="is_active"
                    class="form-select @error('is_active') is-invalid @enderror">
                <option value="1" {{ old('is_active', $category->is_active) == 1 ? 'selected' : '' }}>
                    Active
                </option>
                <option value="0" {{ old('is_active', $category->is_active) == 0 ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>

            {{-- @error('is_active')
                <div class="text_danger">{{ $message }}</div>
            @enderror
        </div> --}}

        <button class="btn btn-success">Update</button>
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">
            Cancel
        </a>

    </form>
</div>
@endsection
