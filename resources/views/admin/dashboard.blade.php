@extends('layouts.admin')

@section('title', 'Dashboard')

@php $c = config('restaurant.currency'); $max = max(1, $week->max('total')); @endphp

@section('content')
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card-x stat"><span class="ic ic-red"><i class="bi bi-cash-stack"></i></span>
            <div><div class="val">{{ $c }} {{ number_format($stats['sales_today']) }}</div><div class="lbl">Sales today</div></div></div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="text-decoration-none text-reset">
            <div class="card-x stat"><span class="ic ic-saffron"><i class="bi bi-hourglass-split"></i></span>
                <div><div class="val">{{ $stats['orders_pending'] }}</div><div class="lbl">Orders waiting</div></div></div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <a href="{{ route('admin.reservations.index', ['status' => 'pending']) }}" class="text-decoration-none text-reset">
            <div class="card-x stat"><span class="ic ic-indigo"><i class="bi bi-calendar2-week"></i></span>
                <div><div class="val">{{ $stats['reservations_pending'] }}</div><div class="lbl">Bookings to confirm</div></div></div>
        </a>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card-x stat"><span class="ic ic-green"><i class="bi bi-graph-up-arrow"></i></span>
            <div><div class="val">{{ $c }} {{ number_format($stats['sales_total']) }}</div><div class="lbl">Total sales ({{ $stats['orders_total'] }} orders)</div></div></div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card-x h-100">
            <div class="card-head"><h2>Sales in the last 7 days</h2></div>
            <div class="card-body">
                <div class="bars" role="img" aria-label="Bar chart of daily sales for the last 7 days">
                    @foreach ($week as $i => $d)
                        <div class="bar {{ $loop->last ? 'today' : '' }}">
                            <span class="amt">{{ $d['total'] ? number_format($d['total']) : '' }}</span>
                            <div class="fill" style="height: {{ max(2, round($d['total'] / $max * 100)) }}%"></div>
                            <span class="day">{{ $loop->last ? 'Today' : $d['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-x h-100">
            <div class="card-head"><h2>At a glance</h2></div>
            <div class="card-body">
                <div class="d-flex justify-content-between py-2 border-bottom"><span>Dishes on menu</span><strong>{{ $stats['foods'] }}</strong></div>
                <div class="d-flex justify-content-between py-2 border-bottom"><span>Registered customers</span><strong>{{ $stats['customers'] }}</strong></div>
                <div class="d-flex justify-content-between py-2 border-bottom"><span>Unread messages</span><strong>{{ $stats['unread_messages'] }}</strong></div>
                <div class="d-grid gap-2 mt-3">
                    <a href="{{ route('admin.foods.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add a dish</a>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-secondary">Add a category</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-xl-8">
        <div class="card-x">
            <div class="card-head"><h2>Latest orders</h2><a href="{{ route('admin.orders.index') }}" class="small">All orders</a></div>
            @if ($recentOrders->isEmpty())
                <div class="empty"><i class="bi bi-receipt"></i>No orders yet. They will appear here as soon as customers check out.</div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Status</th><th>Time</th></tr></thead>
                        <tbody>
                        @foreach ($recentOrders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order) }}" class="fw-semibold">{{ $order->order_number }}</a></td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $c }} {{ number_format($order->total) }}</td>
                                <td><span class="status status-{{ $order->status_color }}">{{ $order->status_label }}</span></td>
                                <td class="text-muted small">{{ $order->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card-x">
            <div class="card-head"><h2>Upcoming bookings</h2><a href="{{ route('admin.reservations.index') }}" class="small">All bookings</a></div>
            <div class="card-body">
                @forelse ($upcomingReservations as $r)
                    <div class="d-flex justify-content-between align-items-center py-2 {{ ! $loop->last ? 'border-bottom' : '' }}">
                        <div>
                            <div class="fw-semibold">{{ $r->name }} <span class="text-muted fw-normal">({{ $r->guests }})</span></div>
                            <small class="text-muted">{{ $r->reservation_date->format('D d M') }}, {{ \Carbon\Carbon::createFromFormat('H:i', $r->reservation_time)->format('h:i A') }}</small>
                        </div>
                        <span class="status status-{{ $r->status_color }}">{{ $r->status_label }}</span>
                    </div>
                @empty
                    <p class="text-muted mb-0">No upcoming bookings.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
