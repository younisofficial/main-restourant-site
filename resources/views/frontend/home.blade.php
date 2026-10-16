@extends('layouts.app')

@section('title', 'Desi food, made with love')

@section('content')
{{-- ================= HERO ================= --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <div class="hero-urdu" lang="ur">ذائقہ</div>
                <h1 class="mb-3">Real desi flavour, delivered hot.</h1>
                <p class="lead mb-4">Dum biryani, handi and karahi cooked the slow way, plus burgers and pizza for the whole family. Order online or book your table in a minute.</p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('menu') }}" class="btn btn-saffron btn-lg"><i class="bi bi-bag me-2"></i>Order food</a>
                    <a href="{{ route('reservation') }}" class="btn btn-outline-light btn-lg">Book a table</a>
                </div>
                <div class="hero-facts">
                    <span><i class="bi bi-clock"></i>Delivery in 30–45 min</span>
                    <span><i class="bi bi-truck"></i>Free delivery over Rs. {{ number_format(\App\Support\Cart::FREE_DELIVERY_ABOVE) }}</span>
                    <span><i class="bi bi-cash-coin"></i>Cash on delivery</span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="arch-wrap">
                    <div class="arch">
                        <img src="{{ asset('images/hero-arch.jpg') }}" alt="A plate of chicken biryani with lime and fried onions">
                    </div>
                    @php $hero = $featured->firstWhere('slug', 'chicken-biryani') ?? $featured->first(); @endphp
                    @if ($hero)
                        <div class="arch-tag">
                            <img src="{{ $hero->image_url }}" alt="">
                            <div>
                                <small>Most ordered</small>
                                <strong>{{ $hero->name }}</strong>
                                <span class="price">{{ config('restaurant.currency') }} {{ number_format($hero->price) }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<div class="ajrak-strip" aria-hidden="true"></div>

{{-- ================= CATEGORIES ================= --}}
<section class="section-sm">
    <div class="container">
        <div class="section-head d-flex flex-wrap justify-content-between align-items-end gap-2">
            <div>
                <h2>What are you craving?</h2>
                <p>Pick a category to jump straight to it on the menu.</p>
            </div>
            <a href="{{ route('menu') }}" class="btn btn-outline-dark btn-sm">See full menu</a>
        </div>
        <div class="cat-rail">
            @foreach ($categories as $category)
                <a href="{{ route('menu', ['category' => $category->slug]) }}" class="cat-item">
                    <div class="cat-img"><img src="{{ $category->image_url }}" alt="" loading="lazy"></div>
                    <strong>{{ $category->name }}</strong>
                    <small>{{ $category->foods_count }} {{ \Illuminate\Support\Str::plural('dish', $category->foods_count) }}</small>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ================= FEATURED ================= --}}
<section class="section pt-2">
    <div class="container">
        <div class="section-head">
            <h2>Our guests' favourites</h2>
            <p>The dishes people come back for, week after week.</p>
        </div>
        @if ($featured->isEmpty())
            <div class="empty panel">
                <i class="bi bi-egg-fried"></i>
                <h4>No featured dishes yet</h4>
                <p>Mark dishes as popular from the admin panel and they will show up here.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach ($featured as $food)
                    <div class="col-sm-6 col-lg-3">
                        @include('partials.food-card', ['food' => $food])
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

{{-- ================= HOW IT WORKS ================= --}}
<section class="section bg-white border-top border-bottom">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-4">
                <h2 class="mb-3" style="font-size: clamp(1.9rem,3.4vw,2.6rem)">Ordering takes less than two minutes</h2>
                <p class="text-muted-2 mb-0">No app to install. Add dishes to your cart, tell us where to deliver, and pay when the food arrives.</p>
            </div>
            <div class="col-lg-8">
                <div class="row g-4 steps">
                    <div class="col-md-4">
                        <div class="step"><span class="step-num">1</span>
                            <div><h5>Choose your dishes</h5><p>Browse the menu and tap Add on anything you like.</p></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step"><span class="step-num">2</span>
                            <div><h5>Confirm your address</h5><p>Enter your name, phone and address at checkout.</p></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step"><span class="step-num">3</span>
                            <div><h5>Enjoy it hot</h5><p>We cook fresh and deliver in 30–45 minutes. Pay cash at the door.</p></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================= RESERVATION BAND ================= --}}
<section class="reserve-band">
    <div class="container">
        <h2 class="mb-3">Dinner with family? Save your table.</h2>
        <p class="mb-4">Birthdays, family dinners or a quiet meal for two. Tell us when you are coming and we will have your table ready.</p>
        <a href="{{ route('reservation') }}" class="btn btn-saffron btn-lg"><i class="bi bi-calendar2-check me-2"></i>Book a table</a>
    </div>
</section>

{{-- ================= INFO ================= --}}
<section class="section-sm">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="info-tile"><i class="bi bi-geo-alt"></i>
                    <div><h6>Find us</h6><p>{{ config('restaurant.address') }}</p></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-tile"><i class="bi bi-clock"></i>
                    <div><h6>Opening hours</h6><p>{{ config('restaurant.hours') }}</p></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-tile"><i class="bi bi-telephone"></i>
                    <div><h6>Call to order</h6><p><a href="tel:{{ config('restaurant.phone') }}">{{ config('restaurant.phone') }}</a></p></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
