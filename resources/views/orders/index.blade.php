@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h3>📦 My Orders</h3>

    @if($orders->count() == 0)
        <p>You have no orders yet.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Ordered At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->total_amount }} EGP</td>
                        <td>{{ $order->status }}</td>
                         <td>{{ \Carbon\Carbon::parse($order->ordered_at)->format('d-m-Y H:i') }}</td>

                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                View Details
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
