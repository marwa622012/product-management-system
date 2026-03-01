<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
    <a class="navbar-brand" href="#">Product System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            
            <a class="nav-link active" aria-current="page" href="{{route('products.index')}}">{{ __('messages.home') }}</a>
        </li>
        @auth
        <li class="nav-item">
            <a class="nav-link " href="{{ route('logout') }}">{{ __('messages.logout') }}</a>
        </li>
        @endauth
        @guest
        <li class="nav-item">
            <a class="nav-link " href="{{ route('login') }}">{{ __('messages.login') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " href="{{ route('register') }}">{{ __('messages.register') }}</a>
        </li>
        @endguest
        @auth
        {{-- <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ __('messages.My Account') }}
            </a>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('profile')}}">Profile</a></li>
            <li><a class="dropdown-item" href="{{route('orders.index')}}">My order</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{route('wishlist.index')}}">My wishlist</a></li>
        </ul>
        </li> --}}

        @endauth 
            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ __('messages.language') }}
            </a>
            <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ url('lang/en') }}">English</a></li>
            <li><a class="dropdown-item" href="{{ url('lang/ar') }}">Arabic</a></li>
            </ul>
        </li>
        
        </ul>
        <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit">{{ __('messages.search') }}</button>
        </form>
    </div>
    </div>
</nav>