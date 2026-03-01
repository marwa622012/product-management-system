@extends('layout.dashboard')

@section('content')
<div>
    <h1>Dashboard</h1>

    <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary mb-3">
        Create New product
    </a>

    <table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>SKU</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Type</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" width="60">
                    @else
                        —
                    @endif
                </td>

                <td>{{ $product->sku }}</td>

                <td>{{ $product->name}}</td>

                <td>{{ $product->category->name }}</td>

                 <td>
                    @if($product->type === 'variable')
                        {{ $product->product_variants->min('price') }}
                    @else
                        {{ $product->price }}
                    @endif
                 </td>


                <!-- <td>{{ $product->stock }}</td> -->
                  <td>
                    @if($product->type === 'variable')
                        {{ $product->product_variants->min('stock') }}
                    @else
                        {{ $product->stock }}
                    @endif
                 </td>

                <td>
                    <span class="badge bg-info">
                        {{ $product->type }}
                    </span>
                </td>

                <td>
                    @if($product->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>

                <td>
                    <a href="{{ route('dashboard.products.show',$product->id) }}" class="btn btn-sm btn-warning">Show</a>
                    <a href="{{ route('dashboard.products.edit',$product->id) }}" class="btn btn-sm btn-success">Edit</a>
                    <form  onsubmit="return confirm('Are you sure?')" action="{{ route('dashboard.products.destroy',$product->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</div>
@endsection

