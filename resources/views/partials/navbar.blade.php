<nav class="navbar navbar-expand-lg site-nav" aria-label="Main navigation">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <span class="brand-mark" aria-hidden="true"><span>ذ</span></span>
            {{ config('restaurant.short_name') }}
        </a>

        <div class="d-flex align-items-center gap-1 order-lg-last">
            <a href="{{ route('cart.index') }}" class="nav-link cart-link text-white px-2 py-2" aria-label="Cart, {{ $cartCount }} items">
                <i class="bi bi-bag fs-5"></i>
                <span class="cart-badge {{ $cartCount ? '' : 'd-none' }}">{{ $cartCount }}</span>
            </a>
            <button class="navbar-toggler ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('menu') ? 'active' : '' }}" href="{{ route('menu') }}">Menu</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('reservation') ? 'active' : '' }}" href="{{ route('reservation') }}">Book a table</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2 me-lg-2">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>{{ \Illuminate\Support\Str::of(auth()->user()->name)->before(' ') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if (auth()->user()->is_admin)
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Admin panel</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('account') }}"><i class="bi bi-receipt me-2"></i>My orders & bookings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">@csrf
                                    <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Log out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light">Log in</a>
                    <a href="{{ route('menu') }}" class="btn btn-sm btn-saffron">Order now</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
