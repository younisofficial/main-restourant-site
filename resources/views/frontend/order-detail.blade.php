@extends('layouts.app')

@section('title', 'Order ' . $order->order_number)

@section('content')
@include('partials.page-head', ['title' => 'Order ' . $order->order_number, 'crumb' => 'My orders', 'subtitle' => 'Placed on ' . $order->created_at->format('d M Y, h:i A')])

<section class="section">
    <div class="container" style="max-width: 820px">
        <div class="panel">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Order status</h5>
                <span class="status status-{{ $order->status_color }}"><i class="bi bi-{{ $order->status_icon }}"></i>{{ $order->status_label }}</span>
            </div>
            @include('frontend._order-details')
        </div>
        <a href="{{ route('account') }}" class="btn btn-link text-decoration-none mt-3 px-0"><i class="bi bi-arrow-left me-1"></i>Back to my orders</a>
    </div>
</section>
@endsection
