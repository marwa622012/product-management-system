@extends('layout.dashboard')
@section('content')
{{-- {{ dd(old('name')) }} --}}

    <form method="POST"
    action="{{ route('dashboard.products.update',$product->id) }}"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- SKU --}}
    <div class="mb-3">
        <label class="form-label">SKU</label>
        <input type="text"
            name="sku"
            class="form-control"
            placeholder="Enter product SKU"
            value="{{ old('sku',$product->sku) }}">
    </div>
    @error('sku')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    {{-- Name Arabic --}}
    <div class="mb-3">
        <label class="form-label">Product Name (Arabic)</label>
        <input type="text"
            name="name[ar]"
            class="form-control"
            value="{{ old('name.ar', $product->name['ar'] ?? '') }}">

    </div>

    {{-- Name English --}}
    <div class="mb-3">
        <label class="form-label">Product Name (English)</label>
        <input type="text"
            name="name[en]"
            class="form-control"
            placeholder="Enter product name in English"
            value="{{ old('name.en', $product->name['en'] ?? '') }}">

    </div>
    @error('name.en')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    {{-- Category --}}
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" class="form-select">
            <option value="">Select category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    @error('category_id')
        <div class="text-danger">{{ $message }}</div>
    @enderror

    {{-- Description --}}
    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description"
    class="form-control"
    placeholder="Write product description"
    rows="3">{{ old('description',$product->description) }}</textarea>
    </div>
    @error('description')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    {{-- Price --}}
    <div class="mb-3">
        <label class="form-label">Price</label>
        <input type="number"
            step="0.01"
            name="price"
            class="form-control"
            placeholder="Enter product price"
            value="{{ old('price',$product->price) }}">
    </div>
    @error('price')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    {{-- Stock --}}
    <div class="mb-3">
        <label class="form-label">Stock</label>
        <input type="number"
            name="stock"
            class="form-control"
            placeholder="Available quantity"
            value="{{ old('stock', 0) }}">
    </div>
    @error('stock')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    {{-- Type --}}
    <div class="mb-3">
        <label class="form-label">Product Type</label>
        <select name="type" class="form-select">
            <option value="simple" {{ old('type')=='simple' ? 'selected' : '' }}>
                Simple
            </option>
            <option value="variant" {{ old('type')=='variant' ? 'selected' : '' }}>
                Variable
            </option>
        </select>
    </div>
    @error('type')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    {{-- Status --}}
    <div class="mb-3">
        <label class="form-label">Status</label>
        <select name="is_active" class="form-select">
            <option value="1" {{ old('is_active',1)==1 ? 'selected' : '' }}>
                Active
            </option>
            <option value="0" {{ old('is_active')==0 ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>
    @error('is_active')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    {{-- Image --}}
    <div class="mb-4">
        <label class="form-label">Product Image</label>
        <input type="file"
            name="image"
            class="form-control">
    </div>
    @error('image')
        <div class="text-danger">{{ $message }}</div>
    @enderror
    {{-- <button class="btn btn-success">Save Product</button> --}}
    <button type="submit" class="btn btn-info">
    Update
</button>
</form>


@endsection