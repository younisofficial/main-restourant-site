@php
    $currency = config('restaurant.currency');
    $flow = ['pending', 'confirmed', 'preparing', 'out_for_delivery', 'delivered'];
    $reached = array_search($order->status, $flow, true);
@endphp

@if ($order->status === 'cancelled')
    <div class="alert alert-danger d-flex gap-2 align-items-center"><i class="bi bi-x-circle"></i>This order was cancelled. Call us at {{ config('restaurant.phone') }} if you have questions.</div>
@else
    <div class="tracker" aria-label="Order progress">
        @foreach ($flow as $i => $step)
            <div class="t-step {{ $reached !== false && $i <= $reached ? 'done' : '' }}">
                <div class="dot"><i class="bi bi-{{ \App\Models\Order::STATUSES[$step]['icon'] }}"></i></div>
                {{ \App\Models\Order::STATUSES[$step]['label'] }}
            </div>
        @endforeach
    </div>
@endif

<div class="table-responsive mt-3">
    <table class="table align-middle mb-0">
        <thead><tr><th>Dish</th><th class="text-center">Qty</th><th class="text-end">Price</th></tr></thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->food_name }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">{{ $currency }} {{ number_format($item->total) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr><td colspan="2">Subtotal</td><td class="text-end">{{ $currency }} {{ number_format($order->subtotal) }}</td></tr>
            <tr><td colspan="2">Delivery</td><td class="text-end">{{ $order->delivery_fee > 0 ? $currency . ' ' . number_format($order->delivery_fee) : 'Free' }}</td></tr>
            <tr class="fw-bold fs-5"><td colspan="2">Total (cash on delivery)</td><td class="text-end">{{ $currency }} {{ number_format($order->total) }}</td></tr>
        </tfoot>
    </table>
</div>

<div class="row g-3 mt-2 small">
    <div class="col-sm-6"><span class="text-muted-2 d-block">Deliver to</span><strong>{{ $order->customer_name }}</strong><br>{{ $order->address }}</div>
    <div class="col-sm-6"><span class="text-muted-2 d-block">Phone</span><strong>{{ $order->phone }}</strong>
        @if ($order->notes)<br><span class="text-muted-2">Note:</span> {{ $order->notes }}@endif
    </div>
</div>
