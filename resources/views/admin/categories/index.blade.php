@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="card-x">
    <div class="card-head">
        <h2>{{ $categories->count() }} categories</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i>Add category</a>
    </div>
    @if ($categories->isEmpty())
        <div class="empty"><i class="bi bi-tags"></i>No categories yet. Add one to start building your menu.</div>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead><tr><th>Category</th><th>Dishes</th><th>Order</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $category->image_url }}" alt="" class="thumb rounded-circle">
                                <div>
                                    <div class="fw-semibold">{{ $category->name }}</div>
                                    <small class="text-muted">{{ $category->description }}</small>
                                </div>
                            </div>
                        </td>
                        <td><a href="{{ route('admin.foods.index', ['category' => $category->id]) }}">{{ $category->foods_count }}</a></td>
                        <td>{{ $category->sort_order }}</td>
                        <td>
                            <span class="status status-{{ $category->is_active ? 'success' : 'secondary' }}">{{ $category->is_active ? 'Visible' : 'Hidden' }}</span>
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-light btn-icon" title="Edit" aria-label="Edit {{ $category->name }}"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline" data-confirm="Delete the category “{{ $category->name }}”?">
                                @csrf @method('DELETE')
                                <button class="btn btn-light btn-icon text-danger" title="Delete" aria-label="Delete {{ $category->name }}"><i class="bi bi-trash3"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
