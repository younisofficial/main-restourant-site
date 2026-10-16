<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | {{ config('restaurant.short_name') }} Admin</title>
    <link href="{{ asset('vendor/fonts/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    <aside class="sidebar" id="sidebar">
        <a class="brand" href="{{ route('admin.dashboard') }}">
            <span class="brand-mark" aria-hidden="true"><span>ذ</span></span>
            <span>{{ config('restaurant.short_name') }}<small>Admin panel</small></span>
        </a>
        <div class="ajrak-strip" aria-hidden="true"></div>
        <nav class="side-nav" aria-label="Admin navigation">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-grid-1x2"></i>Dashboard</a>

            <div class="group">Menu</div>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="bi bi-tags"></i>Categories</a>
            <a href="{{ route('admin.foods.index') }}" class="{{ request()->routeIs('admin.foods.*') ? 'active' : '' }}"><i class="bi bi-egg-fried"></i>Food items</a>

            <div class="group">Customers</div>
            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="bi bi-receipt"></i>Orders
                @if ($badges['orders'])<span class="count" title="Pending orders">{{ $badges['orders'] }}</span>@endif</a>
            <a href="{{ route('admin.reservations.index') }}" class="{{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}"><i class="bi bi-calendar2-week"></i>Reservations
                @if ($badges['reservations'])<span class="count" title="Pending reservations">{{ $badges['reservations'] }}</span>@endif</a>
            <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}"><i class="bi bi-chat-left-text"></i>Messages
                @if ($badges['messages'])<span class="count" title="Unread messages">{{ $badges['messages'] }}</span>@endif</a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="bi bi-people"></i>Users</a>
        </nav>
        <div class="sidebar-foot">
            <a href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right me-2"></i>View website</a>
            <form action="{{ route('logout') }}" method="POST" class="mt-2">@csrf
                <button class="btn btn-link p-0 text-decoration-none" style="color: rgba(255,255,255,.78)"><i class="bi bi-box-arrow-left me-2"></i>Log out</button>
            </form>
        </div>
    </aside>
    <div class="backdrop" onclick="document.body.classList.remove('nav-open')"></div>

    <div class="main">
        <header class="topbar">
            <button class="menu-btn" type="button" onclick="document.body.classList.toggle('nav-open')" aria-label="Open menu"><i class="bi bi-list fs-5"></i></button>
            <h1>@yield('title', 'Dashboard')</h1>
            <div class="user">
                <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                <span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            </div>
        </header>

        <div class="content">
            @if (session('success'))
                <div class="flash" role="status"><i class="bi bi-check-circle-fill"></i>{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="flash error" role="alert"><i class="bi bi-exclamation-circle-fill"></i>{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script>
        // confirm before deleting
        document.querySelectorAll('[data-confirm]').forEach(f => f.addEventListener('submit', e => { if (!confirm(f.dataset.confirm)) e.preventDefault(); }));
        // live image preview on upload
        document.querySelectorAll('input[type=file][data-preview]').forEach(inp => inp.addEventListener('change', () => {
            const img = document.getElementById(inp.dataset.preview);
            if (inp.files[0] && img) { img.src = URL.createObjectURL(inp.files[0]); img.classList.remove('d-none'); }
        }));
        // auto-submit status dropdowns
        document.querySelectorAll('select[data-autosubmit]').forEach(s => s.addEventListener('change', () => s.form.submit()));
    </script>
    @stack('scripts')
</body>
</html>
