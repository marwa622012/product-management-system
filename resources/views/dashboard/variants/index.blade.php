@extends('layout.dashboard')

@section('content')
<div class="card mb-4 p-3 shadow">
    <h5>Add New Variant</h5>

    <form action="{{ route('dashboard.variants.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-6">
                <input type="text" name="name[en]" class="form-control" placeholder="Name (EN)" required>
            </div>

            <div class="col-6">
                <input type="text" name="name[ar]" class="form-control" placeholder="Name (AR)" required>
            </div>
        </div>
        <div id="optionsSection" style="display:none;">
            <h5>Options</h5>
        </div>

        <div class="mt-3">
            <button type="button" class="btn btn-info" id="addOption">
                Add Option
            </button>

            <button type="submit" class="btn btn-primary">
                Save Variant
            </button>
        </div>
    </form>
</div>






    <div class="card p-3 shadow">
        <h5>All Variants</h5>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name (EN)</th>
                    <th>Name (AR)</th>
                    <th>Options</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($variants as $variant)
                    <tr>
                        <td>{{ $variant->id }}</td>
                        <td>{{ $variant->getTranslation('name', 'en') }}</td>
                        <td>{{ $variant->getTranslation('name', 'ar') }}</td>
                        {{-- <td>{{ $variant->VariantOptions }}</td> --}}
                        <td>
                                @if($variant->variantOptions->count())
                                    @foreach($variant->variantOptions as $option)
                                        <span class="badge bg-info me-1">
                                            {{ $option->getTranslation('name','en') }}
                                        </span>
                                    @endforeach
                                @else
                                <span class="text-muted">—</span>
                                @endif
                        </td>

                        
                        <td>
                            <a href="{{ route('dashboard.variants.edit', $variant->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('dashboard.variants.destroy', $variant->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
