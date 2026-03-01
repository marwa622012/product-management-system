@extends('layout.dashboard')

@section('content')

<div class="container mt-5 d-flex justify-content-center">

    <div class="card shadow-lg border-0" style="max-width: 900px; width:100%;">
        <div class="row g-0 align-items-center">

            <!-- Image -->
            <div class="col-md-5 text-center p-3">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}"
                        class="img-fluid rounded"
                        style="max-height: 320px; object-fit: contain;"
                        alt="product image">
                @else
                    <img src="https://via.placeholder.com/400x400"
                        class="img-fluid rounded"
                        alt="product image">
                @endif
            </div>

            <!-- Content -->
            <div class="col-md-7">
                <div class="card-body">

                    <h3 class="card-title mb-1">
                        {{ $product->name['en'] ?? '' }}
                    </h3>

                    <p class="text-muted mb-2">
                        Category:
                        <strong>{{ $product->category->name ?? '-' }}</strong>
                    </p>

                    {{-- <h4 class="text-success mb-3">
                        {{ number_format($product->product_variants->min('price')) }} EGP
                    </h4> --}}
                    <p class="text-success fw-semibold mb-2">
                        @if($product->type == 'simple')
                            {{ number_format($product->price) }} EGP
                        @else
                            {{ number_format($product->product_variants->min('price')) }} EGP
                       @endif
                    </p>


                    <p class="card-text mb-3">
                        {{ $product->description ?? 'No description available' }}
                    </p>

                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item px-0">
                            <strong>SKU:</strong> {{ $product->sku }}
                        </li>
                        {{-- <li class="list-group-item px-0">
                            <strong>Stock:</strong> {{ $product->product_variants->sum('stock') }}

                        </li> --}}
                        <li class="list-group-item px-0">
                            <strong>Stock:</strong> {{ $product->total_stock }}
                        </li>

                        <li class="list-group-item px-0">
                            <strong>Type:</strong> {{ ucfirst($product->type) }}
                        </li>
                        <li class="list-group-item px-0">
                            <strong>Status:</strong>
                            @if($product->is_active)
                                <span class="badge bg-success ms-1">Active</span>
                            @else
                                <span class="badge bg-danger ms-1">Inactive</span>
                            @endif
                        </li>
                    </ul>

                    <a href="{{ route('dashboard.products.index') }}"
                    class="btn btn-secondary">
                        Back
                    </a>

                </div>
            </div>

        </div>
    </div>

</div>
@if($product->type === 'variable' && $product->product_variants->count())
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h5 class="mb-3">
                🔀 Product Variants
            </h5>

            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product->product_variants as $variant)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $variant->name }}
                            </td>

                            <td>{{ $variant->sku }}</td>

                            <td class="text-success fw-semibold">
                                {{ number_format($variant->price, 2) }} EGP
                            </td>

                            <td>
                                {{ $variant->stock }}
                            </td>

                            <td>
                                @if($variant->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endif


@endsection
