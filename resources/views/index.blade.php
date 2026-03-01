@extends('layout.app');
@section('content')
    <div class="container text-center mt-5">
        <h1 class="display-4 mb-3">Welcome to Products Management System</h1>
        <p class="lead mb-4">
            Discover the latest products and keep up with everything new in the world of products.
        </p>
        <a href="{{ route('dashboard.products.index') }}" class="btn btn-primary btn-lg">
            🚀 Go to products
        </a>
        
    </div>
@endsection