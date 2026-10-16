@extends('layouts.app')

@section('title', 'Order placed')

@section('content')
<section class="section">
    <div class="container" style="max-width: 760px">
        <div class="panel">
            <div class="text-center mb-2">
                <div class="d-inline-grid rounded-circle text-white mb-3" style="width:72px;height:72px;place-items:center;background:var(--leaf)">
                    <i class="bi bi-check-lg fs-1"></i>
                </div>
                <h1 class="h2">Thank you, {{ \Illuminate\Support\Str::of($order->customer_name)->before(' ') }}! Your order is placed.</h1>
                <p class="text-muted-2 mb-1">Order number <strong class="text-body">{{ $order->order_number }}</strong></p>
                <p class="text-muted-2">We will call you on {{ $order->phone }} to confirm. Food usually arrives in 30–45 minutes.</p>
            </div>

            @include('frontend._order-details')

            <div class="d-flex flex-wrap gap-2 justify-content-center mt-4">
                <a href="{{ route('menu') }}" class="btn btn-primary">Order something else</a>
                @auth<a href="{{ route('account') }}" class="btn btn-outline-dark">View my orders</a>@endauth
            </div>
        </div>
    </div>
</section>
@endsection
