@extends('layouts.admin')

@section('title', 'Food items')

@section('content')
<div class="card-x">
    <div class="card-head">
        <form method="GET" class="d-flex flex-wrap gap-2" role="search">
            <input type="search" name="q" value="{{ $search }}" class="form-control form-control-sm" style="width: 200px" placeholder="Search dishes" aria-label="Search dishes">
            <select name="category" class="form-select form-select-sm" style="width: 190px" aria-label="Filter by category" data-autosubmit>
                <option value="">All categories</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected((string) $categoryId === (string) $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-indigo btn-sm">Search</button>
            @if ($search || $categoryId)<a href="{{ route('admin.foods.index') }}" class="btn btn-light btn-sm">Clear</a>@endif
        </form>
        <a href="{{ route('admin.foods.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Add dish</a>
    </div>

    @if ($foods->isEmpty())
        <div class="empty"><i class="bi bi-egg-fried"></i>No dishes found. Try another search or add a new dish.</div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Dish</th><th>Category</th><th>Price</th><th>Labels</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                @foreach ($foods as $food)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $food->image_url }}" alt="" class="thumb">
                                <div class="fw-semibold">{{ $food->name }}</div>
                            </div>
                        </td>
                        <td>{{ $food->category->name }}</td>
                        <td class="text-nowrap">{{ config('restaurant.currency') }} {{ number_format($food->price) }}</td>
                        <td>
                            @if ($food->is_featured)<span class="status status-warning"><i class="bi bi-star-fill"></i>Popular</span>@endif
                            @if ($food->is_spicy)<span class="status status-danger"><i class="bi bi-fire"></i>Spicy</span>@endif
                        </td>
                        <td><span class="status status-{{ $food->is_available ? 'success' : 'secondary' }}">{{ $food->is_available ? 'Available' : 'Sold out' }}</span></td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.foods.edit', $food) }}" class="btn btn-light btn-icon" title="Edit" aria-label="Edit {{ $food->name }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.foods.destroy', $food) }}" method="POST" class="d-inline" data-confirm="Delete “{{ $food->name }}” from the menu?">
                                @csrf @method('DELETE')
                                <button class="btn btn-light btn-icon text-danger" title="Delete" aria-label="Delete {{ $food->name }}"><i class="bi bi-trash3"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if ($foods->hasPages())<div class="card-body border-top">{{ $foods->links() }}</div>@endif
    @endif
</div>
@endsection
