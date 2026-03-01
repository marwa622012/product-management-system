@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h3>📝 Order #{{ $order->id }}</h3>
    <p>Status: <strong>{{ $order->status }}</strong></p>
    <p>Ordered At: {{ $order->ordered_at->format('d-m-Y H:i') }}</p>
    <p>Total Amount: {{ $order->total_amount }} EGP</p>
    <p>Shipping Address: {{ $order->address }}</p>

    <h5 class="mt-4">Products</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <!-- <th>Variant</th> -->
                <th>Quantity</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->ordered_items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <!-- <td>{{ $item->productVariant ? $item->productVariant->name : '-' }}</td> -->
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->total_price }} EGP</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Back to Orders</a>
</div>
@endsection
