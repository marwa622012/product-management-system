@extends('layout.dashboard')

@section('content')

<div class="container mt-4">
    <h2>Product Variants</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('dashboard.productvariants.create') }}" class="btn btn-primary mb-3">Add Product Variant</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>SKU</th>
                <th>Name (EN)</th>
                <th>Name (AR)</th>
                <th>Product</th>
                <!-- <th>Options</th> -->
                <th>Price</th>
                <th>Stock</th>
                <th>Active</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($variants as $variant)
                <tr>

                    <td>{{ $variant->id }}</td>
                    <td>{{ $variant->sku }}</td>
                    <td>{{ $variant->getTranslation('name','en') }}</td>
                    <td>{{ $variant->getTranslation('name','ar') }}</td>
                    <td>{{ $variant->product->name ?? '-' }}</td>
                        <!-- <td>
                    @foreach($variant->variantOptions as $option)
                        <span class="badge bg-primary">
                            {{ $variant->getTranslation('name','en')}} <br>
                    </span>
                    @endforeach
                </td> -->
                    <td>{{ $variant->price }}</td>
                    <td>{{ $variant->stock }}</td>
                    <td>{{ $variant->is_active ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('dashboard.productvariants.edit',$variant->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('dashboard.productvariants.destroy',$variant->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
