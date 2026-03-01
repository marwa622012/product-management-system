@extends('layout.dashboard')

@section('content')

<div class="container mt-4" style="max-width: 700px">

    <h2 class="mb-4">Create Category</h2>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
        action="{{ route('dashboard.categories.store') }}"
        enctype="multipart/form-data">

        @csrf

        {{-- Title --}}
        <div class="mb-3">
            <label class="form-label">name</label>
            <input type="text"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required>
        </div>

        {{-- Image --}}
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file"
                name="image"
                class="form-control">
        </div>


        <select name="is_active">
            <option value="1" {{ old('is_active') == 1 ? 'selected' : '' }}>Active</option>
            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
        </select>

        {{-- Buttons --}}
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">
                Create
            </button>

            {{-- <a href="{{ route('dashboard.categories.index') }}"
            class="btn btn-secondary">
                Cancel
            </a> --}}
        </div>

    </form>
</div>

@endsection
