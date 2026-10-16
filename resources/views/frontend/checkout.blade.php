@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
@include('partials.page-head', ['title' => 'Checkout', 'subtitle' => 'Tell us where to bring your food. You pay in cash when it arrives.'])

<section class="section">
    <div class="container">
        <form action="{{ route('checkout.store') }}" method="POST" novalidate>
            @csrf
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="panel">
                        <h5 class="mb-3">Delivery details</h5>
                        @guest
                            <p class="small text-muted-2">Have an account? <a href="{{ route('login') }}">Log in</a> to track this order later. You can also order as a guest.</p>
                        @endguest
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="customer_name">Full name</label>
                                <input type="text" id="customer_name" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name', $user?->name) }}" required autocomplete="name">
                                @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="phone">Phone number</label>
                                <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user?->phone) }}" placeholder="03XX-XXXXXXX" required autocomplete="tel">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="email">Email <span class="text-muted-2 fw-normal">(optional)</span></label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user?->email) }}" autocomplete="email">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="address">Delivery address</label>
                                <textarea id="address" name="address" rows="2" class="form-control @error('address') is-invalid @enderror" placeholder="House no, street, area" required autocomplete="street-address">{{ old('address', $user?->address) }}</textarea>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="notes">Note for the kitchen <span class="text-muted-2 fw-normal">(optional)</span></label>
                                <input type="text" id="notes" name="notes" class="form-control" value="{{ old('notes') }}" placeholder="e.g. less spicy, extra raita">
                            </div>
                        </div>

                        <h5 class="mt-4 mb-3">Payment</h5>
                        <div class="form-check p-3 border rounded-3 d-flex gap-3 align-items-center">
                            <input class="form-check-input m-0" type="radio" name="payment" id="cod" checked>
                            <label class="form-check-label" for="cod"><strong>Cash on delivery</strong><br><small class="text-muted-2">Pay the rider when your order arrives.</small></label>
                            <i class="bi bi-cash-stack fs-3 ms-auto text-success"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="panel mb-3">
                        <h5 class="mb-3">Your items</h5>
                        @foreach ($items as $item)
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <img src="{{ $item->food->image_url }}" alt="" width="52" height="52" class="rounded-3 object-fit-cover">
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $item->food->name }}</div>
                                    <small class="text-muted-2">Qty {{ $item->quantity }}</small>
                                </div>
                                <span class="fw-semibold">{{ config('restaurant.currency') }} {{ number_format($item->total) }}</span>
                            </div>
                        @endforeach
                        <a href="{{ route('cart.index') }}" class="small">Edit cart</a>
                    </div>
                    @include('frontend._summary')
                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-3"><i class="bi bi-check2-circle me-2"></i>Place order</button>
                </div>
            </div>
        </form>
    </div>
</section>
@endsection
