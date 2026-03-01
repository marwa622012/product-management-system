@extends('layout.app')

@section('content')
<div class="container mt-4">
    <h3>❤️ My Wishlist</h3>

    @if($wishlist->count() == 0)
        <p>No items in wishlist</p>
    @else
        <div class="row">
            @foreach($wishlist as $item)
<div class="col-md-4">
    <div class="card mb-3">
        <div class="card-body text-center">
            <img src="{{ asset('storage/' . $item->product->image) }}" 
                alt="{{ $item->product->name }}" 
                class="img-fluid mb-2" style="height: 150px; object-fit: cover;">

            <h5>{{ $item->product->name }}</h5>
            <p>{{ $item->product->price }} EGP</p>

            <form action="{{ route('wishlist.toggle') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                <button class="wishlist-btn btn btn-sm active">❤️</button>
            </form>
        </div>
    </div>
</div>
@endforeach
        </div>
    @endif
</div>
@endsection

