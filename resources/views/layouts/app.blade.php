<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Desi food, made with love') | {{ config('restaurant.name') }}</title>
    <meta name="description" content="@yield('meta', 'Order biryani, karahi, burgers and pizza online or book a table at Zaiqa Restaurant.')">

    <link href="{{ asset('vendor/fonts/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    @include('partials.navbar')

    <div class="toast-stack" id="toastStack" aria-live="polite">
        @if (session('success'))
            <div class="flash" role="status"><i class="bi bi-check-circle-fill"></i><span>{{ session('success') }}</span><button type="button" class="btn-close" aria-label="Close"></button></div>
        @endif
        @if (session('error'))
            <div class="flash error" role="alert"><i class="bi bi-exclamation-circle"></i><span>{{ session('error') }}</span><button type="button" class="btn-close" aria-label="Close"></button></div>
        @endif
    </div>

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
