@extends('layouts.app')

@section('title', 'Your cart')

@section('content')
@include('partials.page-head', ['title' => 'Your cart', 'crumb' => 'Cart'])

<section class="section">
    <div class="container">
        @if ($items->isEmpty())
            <div class="panel empty">
                <i class="bi bi-bag"></i>
                <h4>Your cart is empty</h4>
                <p>Add a few dishes from the menu and they will appear here.</p>
                <a href="{{ route('menu') }}" class="btn btn-primary">Browse the menu</a>
            </div>
        @else
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="panel">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="mb-0">{{ $items->sum('quantity') }} {{ \Illuminate\Support\Str::plural('item', $items->sum('quantity')) }}</h5>
                            <form action="{{ route('cart.clear') }}" method="POST" data-confirm="Remove everything from your cart?">
                                @csrf @method('DELETE')
                                <button class="btn btn-link text-danger p-0 text-decoration-none"><i class="bi bi-trash3 me-1"></i>Empty cart</button>
                            </form>
                        </div>

                        @foreach ($items as $item)
                            <div class="cart-line">
                                <img src="{{ $item->food->image_url }}" alt="{{ $item->food->name }}">
                                <div class="info">
                                    <h6>{{ $item->food->name }}</h6>
                                    <small class="text-muted-2">{{ config('restaurant.currency') }} {{ number_format($item->food->price) }} each</small>
                                    <div class="d-flex align-items-center gap-3 mt-2">
                                        <form action="{{ route('cart.update', $item->food) }}" method="POST" data-qty-form>
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="quantity" value="{{ $item->quantity }}">
                                            <div class="qty">
                                                <button type="button" data-step="-1" aria-label="Decrease quantity">−</button>
                                                <span>{{ $item->quantity }}</span>
                                                <button type="button" data-step="1" aria-label="Increase quantity">+</button>
                                            </div>
                                        </form>
                                        <form action="{{ route('cart.remove', $item->food) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-link btn-sm text-muted-2 p-0 text-decoration-none">Remove</button>
                                        </form>
                                    </div>
                                </div>
                                <strong class="text-nowrap">{{ config('restaurant.currency') }} {{ number_format($item->total) }}</strong>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('menu') }}" class="btn btn-link text-decoration-none mt-2 px-0"><i class="bi bi-arrow-left me-1"></i>Add more dishes</a>
                </div>

                <div class="col-lg-4">
                    @include('frontend._summary')
                    <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg w-100 mt-3">Go to checkout</a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
