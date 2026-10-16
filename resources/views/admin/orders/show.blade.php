@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)

@php $c = config('restaurant.currency'); @endphp

@section('content')
<a href="{{ route('admin.orders.index') }}" class="d-inline-block mb-3 text-decoration-none"><i class="bi bi-arrow-left me-1"></i>All orders</a>
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card-x">
            <div class="card-head">
                <h2>Items</h2>
                <span class="status status-{{ $order->status_color }}"><i class="bi bi-{{ $order->status_icon }}"></i>{{ $order->status_label }}</span>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead><tr><th>Dish</th><th class="text-center">Qty</th><th class="text-end">Price</th><th class="text-end">Total</th></tr></thead>
                    <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td class="fw-semibold">{{ $item->food_name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">{{ $c }} {{ number_format($item->price) }}</td>
                            <td class="text-end">{{ $c }} {{ number_format($item->total) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr><td colspan="3" class="text-end">Subtotal</td><td class="text-end">{{ $c }} {{ number_format($order->subtotal) }}</td></tr>
                        <tr><td colspan="3" class="text-end">Delivery</td><td class="text-end">{{ $order->delivery_fee > 0 ? $c . ' ' . number_format($order->delivery_fee) : 'Free' }}</td></tr>
                        <tr><td colspan="3" class="text-end fw-bold">Total to collect</td><td class="text-end fw-bold fs-5">{{ $c }} {{ number_format($order->total) }}</td></tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-x mb-3">
            <div class="card-head"><h2>Update status</h2></div>
            <div class="card-body">
                <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="d-flex gap-2">
                    @csrf @method('PATCH')
                    <select name="status" class="form-select" aria-label="Order status">
                        @foreach (\App\Models\Order::STATUSES as $key => $s)
                            <option value="{{ $key }}" @selected($order->status === $key)>{{ $s['label'] }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
        <div class="card-x mb-3">
            <div class="card-head"><h2>Customer</h2></div>
            <div class="card-body">
                <p class="mb-1 fw-semibold">{{ $order->customer_name }}
                    @if ($order->user)<span class="status status-primary ms-1">Registered</span>@else<span class="status status-secondary ms-1">Guest</span>@endif
                </p>
                <p class="mb-1"><i class="bi bi-telephone me-2 text-muted"></i><a href="tel:{{ $order->phone }}">{{ $order->phone }}</a></p>
                @if ($order->email)<p class="mb-1"><i class="bi bi-envelope me-2 text-muted"></i>{{ $order->email }}</p>@endif
                <p class="mb-1"><i class="bi bi-geo-alt me-2 text-muted"></i>{{ $order->address }}</p>
                @if ($order->notes)<div class="mt-3 p-2 rounded-3 small" style="background:#FFF4DF"><strong>Note:</strong> {{ $order->notes }}</div>@endif
                <hr>
                <p class="small text-muted mb-0">Placed {{ $order->created_at->format('d M Y, h:i A') }}. Payment: cash on delivery.</p>
            </div>
        </div>
        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" data-confirm="Delete order {{ $order->order_number }}? This cannot be undone.">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-trash3 me-1"></i>Delete order</button>
        </form>
    </div>
</div>
@endsection
