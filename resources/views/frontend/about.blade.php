@extends('layouts.app')

@section('title', 'About us')

@section('content')
@include('partials.page-head', ['title' => 'About Zaiqa', 'crumb' => 'About'])

<section class="section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <div class="about-photo"><img src="{{ asset('images/about.jpg') }}" alt="Chicken tikka masala in a white bowl"></div>
            </div>
            <div class="col-lg-7">
                <h2 class="mb-3" style="font-size: clamp(2rem,3.6vw,2.8rem)">A family kitchen that grew into a restaurant</h2>
                <p class="text-muted-2">Zaiqa started in 2012 as a small takeaway with one handi, one tandoor and our mother's biryani recipe. Word spread through the neighbourhood, and today we serve hundreds of families every week.</p>
                <p class="text-muted-2">We still cook the way we did on day one: whole spices roasted in the morning, fresh meat from trusted butchers, and no shortcuts on dum. Alongside our desi dishes, our younger chefs added burgers, pizza and pasta so everyone at the table finds something they love.</p>
                <div class="stat-line">
                    <div><strong>12+</strong><span>years of cooking</span></div>
                    <div><strong>25</strong><span>dishes on the menu</span></div>
                    <div><strong>40k</strong><span>orders delivered</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section bg-white border-top">
    <div class="container">
        <div class="section-head"><h2>What we promise</h2></div>
        <div class="row g-4">
            <div class="col-md-4"><div class="info-tile"><i class="bi bi-patch-check"></i><div><h6>100% halal</h6><p>All our meat comes from certified halal suppliers.</p></div></div></div>
            <div class="col-md-4"><div class="info-tile"><i class="bi bi-droplet"></i><div><h6>Clean kitchen</h6><p>Filtered water, fresh oil and a kitchen you are welcome to see.</p></div></div></div>
            <div class="col-md-4"><div class="info-tile"><i class="bi bi-lightning-charge"></i><div><h6>Hot on arrival</h6><p>Insulated bags and riders who know the shortest routes.</p></div></div></div>
        </div>
        <a href="{{ route('menu') }}" class="btn btn-primary mt-5">See what we cook</a>
    </div>
</section>
@endsection
