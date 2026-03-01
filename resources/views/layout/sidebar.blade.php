<div class="sidebar p-3">
    {{-- <div class="text-center mb-4">
        <h4 class="fw-bold text-primary fs-6">Product Management System</h4>
    </div> --}}

    <a href="{{ route('dashboard.categories.index') }}">
        <i class="bi bi-folder"></i> Categories
    </a>
    <a href="{{ route('dashboard.products.index') }}">
        <i class="bi bi-box"></i> Products
    </a>

    <a href="{{ route('dashboard.variants.index') }}">
        <i class="bi bi-ui-checks"></i> variants
    </a>




    <a href="{{ route('dashboard.variant-options.index') }}">
        <i class="bi bi-filter"></i>variant-options
    </a>

    {{-- <a href="{{ route('dashboard.orders.index') }}">
        <i class="bi bi-cart"></i> Orders
    </a> --}}

</div>
