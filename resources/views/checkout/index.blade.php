@extends('layout.app')
@section('content')
<div class="container mt-4">
    <h3>📦 Checkout</h3>
    

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Shipping Address</label>
            <textarea name="address" class="form-control" rows="4" required></textarea>
        </div>

        <button class="btn btn-primary">
            🧾 Place Order
        </button>
    </form>
</div>
@endsection
