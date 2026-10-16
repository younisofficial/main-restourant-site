@extends('layouts.app')

@section('title', 'Menu')

@section('content')
@include('partials.page-head', [
    'title' => 'Our menu',
    'subtitle' => 'Everything is cooked fresh when you order. Prices include tax.',
])

<div class="menu-filters">
    <div class="container">
        <div class="row g-2 align-items-center">
            <div class="col-lg-8">
                <div class="chip-row">
                    <a href="{{ route('menu', array_filter(['q' => $search])) }}" class="chip {{ ! $active ? 'active' : '' }}">All dishes</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('menu', array_filter(['category' => $category->slug, 'q' => $search])) }}"
                           class="chip {{ $active === $category->slug ? 'active' : '' }}">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-4">
                <form action="{{ route('menu') }}" method="GET" class="search-box" role="search">
                    @if ($active)<input type="hidden" name="category" value="{{ $active }}">@endif
                    <i class="bi bi-search"></i>
                    <input type="search" name="q" value="{{ $search }}" class="form-control" placeholder="Search biryani, pizza…" aria-label="Search the menu">
                </form>
            </div>
        </div>
    </div>
</div>

<section class="pb-5">
    <div class="container">
        @if ($search !== '')
            <p class="mt-4 mb-0 text-muted-2">
                {{ $foods->count() }} {{ \Illuminate\Support\Str::plural('result', $foods->count()) }} for “{{ $search }}”.
                <a href="{{ route('menu', array_filter(['category' => $active])) }}">Clear search</a>
            </p>
        @endif

        @forelse ($foods->groupBy('category.name') as $categoryName => $items)
            <div class="menu-group-title">
                <h2>{{ $categoryName }}</h2>
                <span>{{ $items->first()->category->description }}</span>
            </div>
            <div class="row g-4">
                @foreach ($items as $food)
                    <div class="col-sm-6 col-lg-4 col-xl-3">
                        @include('partials.food-card', ['food' => $food, 'showCategory' => false])
                    </div>
                @endforeach
            </div>
        @empty
            <div class="empty">
                <i class="bi bi-search"></i>
                <h4>No dishes match your search</h4>
                <p>Try another word, or browse all dishes.</p>
                <a href="{{ route('menu') }}" class="btn btn-primary">Show all dishes</a>
            </div>
        @endforelse
    </div>
</section>
@endsection
