@php
    $currency = config('restaurant.currency');
    $freeAbove = \App\Support\Cart::FREE_DELIVERY_ABOVE;
@endphp
<div class="panel">
    <h5 class="mb-3">Order summary</h5>
    <div class="summary-row"><span>Subtotal</span><span>{{ $currency }} {{ number_format($subtotal) }}</span></div>
    <div class="summary-row">
        <span>Delivery</span>
        <span>{!! $deliveryFee > 0 ? e($currency . ' ' . number_format($deliveryFee)) : '<span class="text-success fw-bold">Free</span>' !!}</span>
    </div>
    <div class="summary-row summary-total"><span>Total</span><span>{{ $currency }} {{ number_format($total) }}</span></div>

    @if ($subtotal < $freeAbove)
        <div class="free-note mt-3">
            Add {{ $currency }} {{ number_format($freeAbove - $subtotal) }} more for free delivery.
            <div class="progress mt-2" role="progressbar" aria-label="Progress to free delivery" aria-valuenow="{{ round($subtotal / $freeAbove * 100) }}" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: {{ min(100, round($subtotal / $freeAbove * 100)) }}%"></div>
            </div>
        </div>
    @else
        <div class="free-note mt-3"><i class="bi bi-check-circle-fill me-1"></i>You get free delivery on this order.</div>
    @endif
</div>
