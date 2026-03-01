@extends('layout.dashboard')

@section('content')
<div class="container mt-4">
    <h2>Edit Product Variant</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dashboard.product_variants.update', $variant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>SKU</label>
            <input type="text" name="sku" class="form-control" value="{{ $variant->sku }}" required>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Name (EN)</label>
                <input type="text" name="name[en]" class="form-control" value="{{ $variant->getTranslation('name','en') }}" required>
            </div>
            <div class="col">
                <label>Name (AR)</label>
                <input type="text" name="name[ar]" class="form-control" value="{{ $variant->getTranslation('name','ar') }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Description (EN)</label>
                <textarea name="description[en]" class="form-control">{{ $variant->getTranslation('description','en') }}</textarea>
            </div>
            <div class="col">
                <label>Description (AR)</label>
                <textarea name="description[ar]" class="form-control">{{ $variant->getTranslation('description','ar') }}</textarea>
            </div>
        </div>

        <div class="mb-3">
            <label>Product</label>
            <select name="product_id" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" @if($variant->product_id == $product->id) selected @endif>{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Variant Options</label>
            <div>
                @foreach($options as $option)
                    <label class="me-2">
                        <input type="checkbox" name="variant_options[]" value="{{ $option->id }}"
                        @if($variant->variantOptions->contains($option->id)) checked @endif> {{ $option->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" value="{{ $variant->price }}" step="0.01" required>
        </div>

        <div class="mb-3">
            <label>Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ $variant->stock }}" required>
        </div>

        <div class="mb-3">
            <label>Active</label>
            <select name="is_active" class="form-control">
                <option value="1" @if($variant->is_active) selected @endif>Yes</option>
                <option value="0" @if(!$variant->is_active) selected @endif>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
            @if($variant->image)
                <img src="{{ asset('storage/'.$variant->image) }}" alt="Image" class="img-thumbnail mt-2" style="width:100px;">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update Product Variant</button>
        <a href="{{ route('dashboard.productvariants.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
