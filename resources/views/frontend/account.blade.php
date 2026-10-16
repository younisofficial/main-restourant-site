@extends('layouts.app')

@section('title', 'My orders & bookings')

@section('content')
@include('partials.page-head', ['title' => 'Assalam-o-Alaikum, ' . \Illuminate\Support\Str::of($user->name)->before(' '), 'crumb' => 'My account', 'subtitle' => 'Track your orders and table bookings here.'])

<section class="section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="panel">
                    <h5 class="mb-3">My orders</h5>
                    @if ($orders->isEmpty())
                        <div class="empty py-4">
                            <i class="bi bi-receipt"></i>
                            <h4>No orders yet</h4>
                            <p>Your first biryani is one click away.</p>
                            <a href="{{ route('menu') }}" class="btn btn-primary">Browse the menu</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead><tr><th>Order</th><th>Date</th><th>Items</th><th>Total</th><th>Status</th><th></th></tr></thead>
                                <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="fw-semibold">{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>{{ $order->items_count }}</td>
                                        <td>{{ config('restaurant.currency') }} {{ number_format($order->total) }}</td>
                                        <td><span class="status status-{{ $order->status_color }}">{{ $order->status_label }}</span></td>
                                        <td class="text-end"><a href="{{ route('account.order', $order) }}" class="btn btn-sm btn-outline-dark">Details</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel">
                    <h5 class="mb-3">My table bookings</h5>
                    @forelse ($reservations as $r)
                        <div class="d-flex justify-content-between align-items-start py-2 {{ ! $loop->last ? 'border-bottom' : '' }}">
                            <div>
                                <div class="fw-semibold">{{ $r->reservation_date->format('D, d M Y') }}</div>
                                <small class="text-muted-2">{{ \Carbon\Carbon::createFromFormat('H:i', $r->reservation_time)->format('h:i A') }} · {{ $r->guests }} {{ \Illuminate\Support\Str::plural('guest', $r->guests) }}</small>
                            </div>
                            <span class="status status-{{ $r->status_color }}">{{ $r->status_label }}</span>
                        </div>
                    @empty
                        <p class="text-muted-2 mb-3">You have not booked a table yet.</p>
                    @endforelse
                    <a href="{{ route('reservation') }}" class="btn btn-outline-dark btn-sm mt-3">Book a table</a>
                </div>
                <div class="panel mt-4">
                    <h5 class="mb-2">Account</h5>
                    <p class="mb-1"><i class="bi bi-envelope me-2 text-muted-2"></i>{{ $user->email }}</p>
                    @if ($user->phone)<p class="mb-0"><i class="bi bi-telephone me-2 text-muted-2"></i>{{ $user->phone }}</p>@endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
