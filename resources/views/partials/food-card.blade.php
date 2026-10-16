<article class="food-card">
    <div class="food-img">
        <img src="{{ $food->image_url }}" alt="{{ $food->name }}" loading="lazy">
        <div class="badges">
            @if ($food->is_featured)<span class="tag"><i class="bi bi-star-fill text-warning"></i> Popular</span>@endif
            @if ($food->is_spicy)<span class="tag tag-spicy"><i class="bi bi-fire"></i> Spicy</span>@endif
        </div>
    </div>
    <div class="body">
        @if ($showCategory ?? true)
            <span class="cat-name">{{ $food->category->name }}</span>
        @endif
        <h3>{{ $food->name }}</h3>
        <p>{{ $food->description }}</p>
        <div class="foot">
            <span class="price"><small>{{ config('restaurant.currency') }}</small> {{ number_format($food->price) }}</span>
            <form class="add-to-cart" action="{{ route('cart.add', $food) }}" method="POST">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-add"><i class="bi bi-plus-lg"></i> Add</button>
            </form>
        </div>
    </div>
</article>
