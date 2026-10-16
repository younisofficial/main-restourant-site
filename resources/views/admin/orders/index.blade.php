@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="card-x">
    <div class="card-head">
        <div class="filter-tabs">
            <a href="{{ route('admin.orders.index', array_filter(['q' => $search])) }}" class="{{ ! $status ? 'active' : '' }}">All<span>{{ $counts->sum() }}</span></a>
            @foreach (\App\Models\Order::STATUSES as $key => $s)
                <a href="{{ route('admin.orders.index', array_filter(['status' => $key, 'q' => $search])) }}" class="{{ $status === $key ? 'active' : '' }}">{{ $s['label'] }}<span>{{ $counts[$key] ?? 0 }}</span></a>
            @endforeach
        </div>
        <form method="GET" class="d-flex gap-2" role="search">
            @if ($status)<input type="hidden" name="status" value="{{ $status }}">@endif
            <input type="search" name="q" value="{{ $search }}" class="form-control form-control-sm" style="width: 220px" placeholder="Order no, name or phone" aria-label="Search orders">
            <button class="btn btn-indigo btn-sm">Search</button>
        </form>
    </div>

    @if ($orders->isEmpty())
        <div class="empty"><i class="bi bi-receipt"></i>No orders match this filter.</div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Order</th><th>Customer</th><th>Items</th><th>Total</th><th>Placed</th><th>Status</th><th></th></tr></thead>
                <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td class="fw-semibold">{{ $order->order_number }}</td>
                        <td>{{ $order->customer_name }}<br><small class="text-muted">{{ $order->phone }}</small></td>
                        <td>{{ $order->items_count }}</td>
                        <td class="text-nowrap">{{ config('restaurant.currency') }} {{ number_format($order->total) }}</td>
                        <td class="small text-muted text-nowrap">{{ $order->created_at->format('d M, h:i A') }}</td>
                        <td>
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                @csrf @method('PATCH')
                                <select name="status" class="form-select form-select-sm" style="min-width: 150px" data-autosubmit aria-label="Status of {{ $order->order_number }}">
                                    @foreach (\App\Models\Order::STATUSES as $key => $s)
                                        <option value="{{ $key }}" @selected($order->status === $key)>{{ $s['label'] }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="text-end"><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-light btn-sm">View</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($orders->hasPages())<div class="card-body border-top">{{ $orders->links() }}</div>@endif
    @endif
</div>
@endsection
