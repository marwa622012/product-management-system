@extends('layout.dashboard')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Categories</h2>

        {{-- @can('categories.create')
            <a href="{{ route('dashboard.categoriess.create') }}"
                class="btn btn-success">
                + Add Category
            </a>
        @endcan --}}
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Is Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($category->image)
                            <img 
                                src="{{ asset('storage/' . $category->image) }}"
                                width="70" height="70"
                                style="object-fit:cover"
                                class="rounded"
                            >
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>

                    <td>{{ $category->name }}</td>

                    <td>
                        {{$category->is_active }}
                    </td>

                    <td class="d-flex justify-content-center gap-2">

                        <a href="{{ route('dashboard.categories.show', $category) }}"
                            class="btn btn-sm bg-warning">
                                Show
                            </a>
                        {{-- @can('categories.update') --}}
                            <a href="{{ route('dashboard.categories.edit', $category) }}"
                            class="btn btn-sm btn-info">
                                Edit
                            </a>
                        {{-- @endcan --}}

                        {{-- @can('categories.delete') --}}
                            <form method="POST"
                                action="{{ route('dashboard.categories.destroy', $category) }}"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    Delete
                                </button>
                            </form>
                        {{-- @endcan --}}

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        No categories found
                    </td>
                </tr>
            @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection
