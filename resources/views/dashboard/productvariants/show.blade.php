@extends('layout.dashboard')

@section('content')
<div class="container">
    <h3>Variant Details</h3>

    <ul class="list-group">
        <li class="list-group-item"><strong>SKU:</strong> {{ $variant->sku }}</li>
        <li class="list-group-item"><strong>Name:</strong> {{ $variant->name }}</li>
        <li class="list-group-item"><strong>Price:</strong> {{ $variant->price }}</li>
        <li class="list-group-item"><strong>Stock:</strong> {{ $variant->stock }}</li>
        <li class="list-group-item"><strong>Status:</strong> {{ $variant->is_active ? 'Active' : 'Inactive' }}</li>
    </ul>

    <a href="{{ route('products.variants.index', $product) }}" class="btn btn-secondary mt-3">
        Back
    </a>
</div>
@endsection
