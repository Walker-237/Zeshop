@php
    $img = $product->getFirstMediaUrl('thumbnail') ?: $product->getFirstMediaUrl('uploads');
    $price   = $product->prices->first()->amount ?? 0;
    $compare = $product->prices->first()->compare_amount ?? 0;
    $pct     = $compare > 0 ? round((1 - $price / $compare) * 100) : 0;
    $tall    = $tall ?? false;
@endphp

<a href="{{ route('products.show', $product->slug) }}" class="product-card">
    <div class="card-img {{ $tall ? 'tall' : '' }}">
        @if($img)
            <img src="{{ $img }}" alt="{{ $product->name }}" loading="lazy">
        @else
            <div class="card-img-placeholder">🛍️</div>
        @endif

        @if($pct > 0)
            <span class="card-badge badge-sale">-{{ $pct }}%</span>
        @endif

        <div class="card-wishlist">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
            </svg>
        </div>

        <div class="card-actions">
            <button type="button">Quick View</button>
            <button type="button" class="add-cart-btn">Add to Cart</button>
        </div>
    </div>

    <div class="card-body">
        <div class="card-brand">{{ $product->brand->name ?? '' }}</div>
        <div class="card-name">{{ $product->name }}</div>
        <div class="card-price">
            @if($price > 0)
                <span class="price-now">{{ number_format($price, 2) }} FCFA</span>
                @if($compare > 0)
                    <span class="price-old">{{ number_format($compare, 2) }} FCFA</span>
                @endif
            @else
                <span class="price-no-stock">No price set</span>
            @endif
        </div>
    </div>
</a>