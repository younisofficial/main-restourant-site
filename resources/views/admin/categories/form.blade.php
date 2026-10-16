@extends('layouts.admin')

@section('title', $category->exists ? 'Edit category' : 'Add category')

@section('content')
<form action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" class="card-x" style="max-width: 820px">
    @csrf
    @if ($category->exists) @method('PUT') @endif
    <div class="card-head"><h2>{{ $category->exists ? $category->name : 'New category' }}</h2></div>
    <div class="card-body">
        <div class="row g-4">
            <div class="col-md-7">
                <div class="mb-3">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" placeholder="e.g. BBQ" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">Short description</label>
                    <input type="text" id="description" name="description" class="form-control @error('description') is-invalid @enderror" value="{{ old('description', $category->description) }}" placeholder="Shown on the menu page">
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="sort_order">Position on menu</label>
                    <input type="number" id="sort_order" name="sort_order" min="0" class="form-control" style="max-width: 140px" value="{{ old('sort_order', $category->sort_order ?? 0) }}">
                    <div class="form-text">Lower numbers appear first.</div>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" @checked(old('is_active', $category->is_active))>
                    <label class="form-check-label" for="is_active">Show this category on the website</label>
                </div>
            </div>
            <div class="col-md-5">
                <label class="form-label" for="image">Image</label>
                <img id="catPreview" src="{{ $category->image ? $category->image_url : '' }}" alt="" class="img-preview mb-2 {{ $category->image ? '' : 'd-none' }}">
                <input type="file" id="image" name="image" accept="image/*" data-preview="catPreview" class="form-control @error('image') is-invalid @enderror">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">JPG, PNG or WEBP, up to 2 MB. A square photo looks best.</div>
            </div>
        </div>
    </div>
    <div class="card-body border-top d-flex gap-2">
        <button class="btn btn-primary">{{ $category->exists ? 'Save changes' : 'Add category' }}</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-light">Cancel</a>
    </div>
</form>
@endsection
