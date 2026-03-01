@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h3>🛒 My Cart</h3>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif


    @if($cartItems->count() == 0)
        <p>Your cart is empty.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    {{-- <th>Variant</th> --}}
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                            alt="{{ $item->product->name }}" style="height:50px; width:50px; object-fit:cover;">
                        {{ $item->product->name }}
                    </td>
                    {{-- <td>{{ $item->variant ? $item->variant->name : '-' }}</td> --}}
                    <!-- <td>{{ $item->product->price }}</td> -->
                    <td class="text-success fw-semibold">
    @if($item->variant)
        {{ $item->variant->price }} EGP
    @else
        {{ $item->product->price }} EGP
    @endif
</td>


                    <td>
                        <form action="{{ route('cart.update') }}" method="POST" class="d-flex">
                            @csrf
                            <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control" style="width:70px;">
                            {{-- <button class="btn btn-sm btn-primary ms-2">Update</button> --}}
                        </form>
                    </td>
                    <td>{{ $item->product->price * $item->quantity }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    @if($cartItems->count() > 0)
         <div class="text-end mt-3">
            <a href="{{ route('checkout.index') }}" class="btn btn-success">
              Checkout
             </a>
         </div>
     @endif

</div>
@endsection
