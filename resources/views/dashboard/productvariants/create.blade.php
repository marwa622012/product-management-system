
@extends('layout.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Add Product Variant</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dashboard.productvariants.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>SKU</label>
            <input type="text" name="sku" class="form-control" required>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Name (EN)</label>
                <input type="text" name="name[en]" class="form-control" required>
            </div>
            <div class="col">
                <label>Name (AR)</label>
                <input type="text" name="name[ar]" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Description (EN)</label>
                <textarea name="description[en]" class="form-control"></textarea>
            </div>
            <div class="col">
                <label>Description (AR)</label>
                <textarea name="description[ar]" class="form-control"></textarea>
            </div>
        </div>

        <div class="mb-3">
            <label>Product</label>
            <select name="product_id" class="form-control" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>
         <div class="mb-3">
    <label class="fw-bold">Variant Options</label>

    @foreach($variants as $variant)
        <div class="mb-2 border rounded p-2">
            <strong>{{ $variant->getTranslation('name','en') }}</strong>

            <div class="mt-2">
                @forelse($variant->variantOptions as $option)
                    <label class="me-3">
                        <input type="checkbox"
                               name="variant_options[]"
                               value="{{ $option->id }}">
                        {{ $option->getTranslation('name','en') }}
                    </label>
                @empty
                    <span class="text-muted">No options</span>
                @endforelse
            </div>
        </div>
    @endforeach
</div>

        

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Active</label>
            <select name="is_active" class="form-control">
                <option value="1">Active</option>
                <option value="0">INactive</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Add Product Variant</button>
        <a href="{{ route('dashboard.productvariants.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
