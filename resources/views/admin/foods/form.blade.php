@extends('layouts.admin')

@section('title', $food->exists ? 'Edit dish' : 'Add dish')

@section('content')
<form action="{{ $food->exists ? route('admin.foods.update', $food) : route('admin.foods.store') }}" method="POST" enctype="multipart/form-data" class="card-x" style="max-width: 940px">
    @csrf
    @if ($food->exists) @method('PUT') @endif
    <div class="card-head"><h2>{{ $food->exists ? $food->name : 'New dish' }}</h2></div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-7">
                <div class="mb-3">
                    <label class="form-label" for="name">Dish name</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $food->name) }}" placeholder="e.g. Chicken Karahi" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-sm-7">
                        <label class="form-label" for="category_id">Category</label>
                        <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Choose a category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" @selected((string) old('category_id', $food->category_id) === (string) $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-5">
                        <label class="form-label" for="price">Price ({{ config('restaurant.currency') }})</label>
                        <input type="number" id="price" name="price" min="1" step="1" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $food->price ? (int) $food->price : '') }}" required>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="What makes this dish special?">{{ old('description', $food->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="d-grid gap-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_available" name="is_available" value="1" @checked(old('is_available', $food->is_available))>
                        <label class="form-check-label" for="is_available">Available to order</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $food->is_featured))>
                        <label class="form-check-label" for="is_featured">Mark as popular (shown on the home page)</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_spicy" name="is_spicy" value="1" @checked(old('is_spicy', $food->is_spicy))>
                        <label class="form-check-label" for="is_spicy">Spicy</label>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <label class="form-label" for="image">Photo</label>
                <img id="foodPreview" src="{{ $food->image ? $food->image_url : '' }}" alt="" class="img-preview mb-2 {{ $food->image ? '' : 'd-none' }}">
                <input type="file" id="image" name="image" accept="image/*" data-preview="foodPreview" class="form-control @error('image') is-invalid @enderror" {{ $food->exists ? '' : 'required' }}>
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">{{ $food->exists ? 'Leave empty to keep the current photo. ' : '' }}JPG, PNG or WEBP, up to 2 MB.</div>
            </div>
        </div>
    </div>
    <div class="card-body border-top d-flex gap-2">
        <button class="btn btn-primary">{{ $food->exists ? 'Save changes' : 'Add dish' }}</button>
        <a href="{{ route('admin.foods.index') }}" class="btn btn-light">Cancel</a>
    </div>
</form>
@endsection
