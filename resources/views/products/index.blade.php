@extends('layout.app')

@section('content')
<div class="container my-4">

    <div class="row g-4">
        @foreach($products as $product)
            <div class="col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm">

                    {{-- Product Image --}}
                    <img 
                        src="{{ asset('storage/' . $product->image) }}" 
                        class="card-img-top"
                        style="height: 200px; object-fit: cover;"
                        alt="{{ $product->name }}"
                    >

                    <div class="card-body d-flex flex-column">

                        {{-- Product Name --}}
                        <h6 class="card-title fw-bold">
                            {{ $product->name }}
                        </h6>

                        {{-- Product Price --}}
                        
                        <p class="text-success fw-semibold mb-2">
                                  @if($product->type === 'simple')
                                    {{ $product->price }} EGP
                                  @else
                                      {{ $product->product_variants->min('price') }}
                                  @endif
                        </p>
                         
                        <div class="mt-auto d-flex justify-content-between align-items-center">

                            {{-- Wishlist --}}
                            {{-- <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-outline-danger bg-white btn-sm">
                                    ❤️
                                </button>
                            </form> --}}
                            <form action="{{ route('wishlist.toggle') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <button type="submit"
                                                class="wishlist-btn btn btn-outline-danger bg-white btn-sm">
                                            ❤️
                                        </button>
                            </form>


                            {{-- Add to Cart --}}
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="product_variant_id" value="{{ $variant->id ?? '' }}">
                                <button class="btn btn-primary btn-sm">
                                    🛒 Add
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
