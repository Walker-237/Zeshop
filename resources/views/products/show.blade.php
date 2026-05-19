<!DOCTYPE html>
<html lang="en">
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $product->name }} — ZeShop</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="icon" type="image/x-icon" href="/cpanel/images/favicons/favicon.ico">
<meta name="theme-color" content="#0b2240">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
  :root {
    --ink: #1d1d1f; --navy: #0b2240; --blue: #0071e3; --sky: #2997ff;
    --pale: #f5f5f7; --white: #ffffff; --off: #f5f5f7; --muted: #6e6e73;
    --border: #d2d2d7; --gold: #d4a843; --red: #ff3b30; --green: #30d158;
    --sans: -apple-system, 'Inter', 'Helvetica Neue', Helvetica, sans-serif;
  }
  body { font-family: var(--sans); background: var(--off); color: var(--ink); font-size: 14px; -webkit-font-smoothing: antialiased; }
  a { text-decoration: none; color: inherit; }
  ul { list-style: none; }
  img { display: block; }
  button { cursor: pointer; font-family: var(--sans); border: none; outline: none; }

  /* NAV */
  .announce { background: var(--navy); color: #a8c8f0; text-align: center; font-size: 12px; padding: 8px 20px; }
  .announce span { color: var(--gold); font-weight: 500; }
  .topnav {
    background: rgba(255,255,255,0.85); backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 0.5px solid var(--border); padding: 0 24px;
    display: flex; align-items: center; gap: 16px; height: 60px;
    position: sticky; top: 0; z-index: 100;
  }
  .logo { font-size: 24px; font-weight: 700; color: var(--ink); letter-spacing: -0.5px; }
  .logo span { color: var(--blue); }
  .search-wrap {
    flex: 1; display: flex; max-width: 560px; background: var(--pale);
    border-radius: 10px; overflow: hidden; border: 1px solid transparent;
    transition: border-color 0.2s, background 0.2s;
  }
  .search-wrap:focus-within { border-color: var(--blue); background: var(--white); }
  .search-wrap input {
    flex: 1; border: none; padding: 0 14px; font-family: var(--sans);
    font-size: 14px; outline: none; color: var(--ink); background: transparent;
  }
  .search-wrap input::placeholder { color: var(--muted); }
  .search-wrap button {
    background: var(--blue); color: var(--white); padding: 0 18px;
    font-size: 13px; font-weight: 500; border-radius: 0 9px 9px 0;
  }
  .topnav-actions { display: flex; align-items: center; gap: 8px; margin-left: auto; }
  .action-btn {
    display: flex; flex-direction: column; align-items: center; gap: 2px;
    font-size: 10px; color: var(--muted); background: none; padding: 6px 10px;
    border-radius: 8px; text-decoration: none; transition: color 0.2s;
  }
  .action-btn:hover { color: var(--blue); background: var(--pale); }
  .action-btn svg { width: 20px; height: 20px; }

  /* BREADCRUMB */
  .breadcrumb { padding: 16px 24px; display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--muted); }
  .breadcrumb a { color: var(--muted); transition: color 0.2s; }
  .breadcrumb a:hover { color: var(--blue); }
  .breadcrumb span { color: var(--ink); font-weight: 500; }

  /* PRODUCT LAYOUT */
  .product-page { max-width: 1200px; margin: 0 auto; padding: 0 24px 48px; display: grid; grid-template-columns: 1fr 1fr; gap: 48px; }

  /* GALLERY */
  .gallery { position: sticky; top: 76px; }
  .gallery-main {
    background: var(--white); border: 0.5px solid var(--border);
    border-radius: 20px; overflow: hidden; aspect-ratio: 1;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 12px; position: relative;
  }
  .gallery-main img { width: 100%; height: 100%; object-fit: cover; }
  .gallery-placeholder { font-size: 80px; }
  .gallery-thumbs { display: flex; gap: 8px; }
  .gallery-thumb {
    width: 72px; height: 72px; border-radius: 12px; overflow: hidden;
    border: 1.5px solid var(--border); cursor: pointer; transition: border-color 0.2s;
    background: var(--white); display: flex; align-items: center; justify-content: center;
  }
  .gallery-thumb.active { border-color: var(--blue); }
  .gallery-thumb img { width: 100%; height: 100%; object-fit: cover; }

  /* PRODUCT INFO */
  .product-info { padding-top: 8px; }
  .product-badges { display: flex; gap: 6px; margin-bottom: 12px; }
  .badge {
    font-size: 11px; font-weight: 600; padding: 4px 10px;
    border-radius: 20px; display: inline-block;
  }
  .badge-new { background: var(--green); color: #fff; }
  .badge-featured { background: var(--gold); color: #fff; }
  .brand-link { font-size: 13px; color: var(--blue); margin-bottom: 8px; display: block; }
  .brand-link:hover { text-decoration: underline; }
  .product-name { font-size: 32px; font-weight: 700; color: var(--ink); line-height: 1.15; margin-bottom: 16px; letter-spacing: -0.8px; }
  .product-summary { font-size: 15px; color: var(--muted); line-height: 1.7; margin-bottom: 24px; font-weight: 300; }

  /* PRICE */
  .price-block { background: var(--white); border: 0.5px solid var(--border); border-radius: 16px; padding: 20px; margin-bottom: 24px; }
  .price-row { display: flex; align-items: baseline; gap: 10px; margin-bottom: 6px; }
  .price-current { font-size: 32px; font-weight: 700; color: var(--ink); letter-spacing: -0.8px; }
  .price-original { font-size: 18px; color: #aaa; text-decoration: line-through; font-weight: 300; }
  .price-save { font-size: 13px; font-weight: 600; color: var(--blue); background: #e8f0fe; padding: 3px 10px; border-radius: 20px; }
  .price-note { font-size: 12px; color: var(--muted); font-weight: 300; }
  .price-no-stock { font-size: 20px; color: var(--red); font-weight: 500; }

  /* STOCK */
  .stock-status { display: flex; align-items: center; gap: 6px; font-size: 13px; margin-bottom: 24px; }
  .stock-dot { width: 8px; height: 8px; border-radius: 50%; }
  .stock-in { background: var(--green); }
  .stock-low { background: var(--gold); }
  .stock-out { background: var(--red); }

  /* ACTIONS */
  .product-actions { display: flex; gap: 10px; margin-bottom: 24px; }
  .btn-add-cart {
    flex: 1; background: var(--blue); color: var(--white);
    font-size: 15px; font-weight: 600; padding: 16px 24px;
    border-radius: 14px; transition: background 0.2s, transform 0.2s;
  }
  .btn-add-cart:hover { background: #0062c4; transform: scale(0.99); }
  .btn-buy-now {
    flex: 1; background: var(--ink); color: var(--white);
    font-size: 15px; font-weight: 600; padding: 16px 24px;
    border-radius: 14px; transition: opacity 0.2s, transform 0.2s;
  }
  .btn-buy-now:hover { opacity: 0.85; transform: scale(0.99); }
  .btn-wishlist {
    width: 52px; height: 52px; border-radius: 14px;
    background: var(--white); border: 0.5px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    transition: all 0.2s; flex-shrink: 0;
  }
  .btn-wishlist:hover { border-color: var(--red); }
  .btn-wishlist svg { width: 20px; height: 20px; stroke: var(--muted); fill: none; }
  .btn-wishlist:hover svg { stroke: var(--red); }

  /* TRUST MINI */
  .trust-mini { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-bottom: 24px; }
  .trust-mini-item {
    background: var(--white); border: 0.5px solid var(--border);
    border-radius: 12px; padding: 12px 14px;
    display: flex; align-items: center; gap: 10px;
  }
  .trust-mini-item svg { width: 18px; height: 18px; color: var(--blue); flex-shrink: 0; }
  .trust-mini-item span { font-size: 12px; color: var(--muted); line-height: 1.4; }
  .trust-mini-item strong { display: block; font-size: 12px; color: var(--ink); }

  /* DETAILS */
  .details-block { border-top: 0.5px solid var(--border); padding-top: 24px; }
  .details-title { font-size: 16px; font-weight: 600; color: var(--ink); margin-bottom: 12px; }
  .details-block p { font-size: 14px; color: var(--muted); line-height: 1.8; font-weight: 300; }
  .specs-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 16px; }
  .spec-item {
    background: var(--white); border: 0.5px solid var(--border);
    border-radius: 10px; padding: 10px 14px;
  }
  .spec-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 2px; }
  .spec-value { font-size: 13px; font-weight: 500; color: var(--ink); }

  /* RELATED */
  .related { max-width: 1200px; margin: 0 auto; padding: 0 24px 48px; }
  .sec-header { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 16px; }
  .sec-title { font-size: 24px; font-weight: 700; color: var(--ink); letter-spacing: -0.7px; }
  .sec-title span { color: var(--blue); }
  .sec-link { font-size: 13px; color: var(--blue); }
  .products-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; }
  .product-card {
    background: var(--white); border: 0.5px solid var(--border); border-radius: 16px;
    overflow: hidden; cursor: pointer; transition: transform 0.25s, box-shadow 0.25s;
    text-decoration: none; display: block;
  }
  .product-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,0.1); transform: translateY(-3px); }
  .card-img { height: 160px; background: var(--pale); display: flex; align-items: center; justify-content: center; overflow: hidden; }
  .card-img img { width: 100%; height: 100%; object-fit: cover; }
  .card-img-placeholder { font-size: 48px; }
  .card-body { padding: 12px 14px 14px; }
  .card-brand { font-size: 11px; color: var(--muted); margin-bottom: 3px; }
  .card-name { font-size: 13px; color: var(--ink); line-height: 1.4; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
  .card-price { font-size: 15px; font-weight: 600; color: var(--ink); }

  /* FOOTER */
  footer { background: #1d1d1f; padding: 48px 24px 0; }
  .footer-bottom { padding: 20px 0; display: flex; justify-content: space-between; align-items: center; border-top: 0.5px solid rgba(255,255,255,0.1); }
  .footer-bottom span { font-size: 12px; color: #515154; }
  .footer-legal { display: flex; gap: 20px; }
  .footer-legal a { font-size: 12px; color: #515154; }
  .footer-legal a:hover { color: #86868b; }
</style>
</head>
<body>

{{-- ANNOUNCEMENT BAR --}}
@include('components.header')

{{-- BREADCRUMB --}}
<div class="breadcrumb">
  <a href="{{ route('home') }}">Home</a>
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
  <a href="{{ route('products.index') }}">Products</a>
  @if($product->brand)
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
    <a href="{{ route('products.index', ['brand' => $product->brand->slug]) }}">{{ $product->brand->name }}</a>
  @endif
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
  <span>{{ $product->name }}</span>
</div>

{{-- PRODUCT --}}
@php
  $allMedia = $product->getMedia('thumbnail');
  $price    = $product->prices->first()->amount ?? 0;
  $compare  = $product->prices->first()->compare_amount ?? 0;
  $pct      = $compare > 0 ? round((1 - $price / $compare) * 100) : 0;
@endphp

<div class="product-page">

  {{-- GALLERY --}}
  <div class="gallery">
    <div class="gallery-main" id="mainImg">
      @if($allMedia->count())
        <img src="{{ $allMedia->first()->getUrl() }}" alt="{{ $product->name }}" id="mainImgEl">
      @else
        <div class="gallery-placeholder">🛍️</div>
      @endif
    </div>
    @if($allMedia->count() > 1)
    <div class="gallery-thumbs">
      @foreach($allMedia as $i => $media)
        <div class="gallery-thumb {{ $i === 0 ? 'active' : '' }}" onclick="switchImg('{{ $media->getUrl() }}', this)">
          <img src="{{ $media->getUrl() }}" alt="">
        </div>
      @endforeach
    </div>
    @endif
  </div>

  {{-- INFO --}}
  <div class="product-info">

    <div class="product-badges">
      @if($product->featured) <span class="badge badge-featured">Featured</span> @endif
      @if($product->created_at->gte(now()->subDays(7))) <span class="badge badge-new">New</span> @endif
    </div>

    @if($product->brand)
      <a href="{{ route('products.index', ['brand' => $product->brand->slug]) }}" class="brand-link">{{ $product->brand->name }}</a>
    @endif

    <h1 class="product-name">{{ $product->name }}</h1>

    @if($product->summary)
      <p class="product-summary">{{ $product->summary }}</p>
    @endif

    {{-- PRICE --}}
    <div class="price-block">
      @if($price > 0)
        <div class="price-row">
          <span class="price-current">{{ number_format($price, 2) }} FCFA</span>
          @if($compare > 0)
            <span class="price-original">{{ number_format($compare, 2) }} FCFA</span>
            <span class="price-save">Save {{ $pct }}%</span>
          @endif
        </div>
        <div class="price-note">Tax included. Shipping calculated at checkout.</div>
      @else
        <div class="price-no-stock">Price not available</div>
      @endif
    </div>

    {{-- STOCK --}}
    @php $stock = $product->security_stock ?? 0; @endphp
    <div class="stock-status">
      @if($stock > 10)
        <div class="stock-dot stock-in"></div>
        <span style="color:#30d158; font-weight:500;">In Stock</span>
        <span style="color:var(--muted);">· {{ $stock }} units available</span>
      @elseif($stock > 0)
        <div class="stock-dot stock-low"></div>
        <span style="color:#d4a843; font-weight:500;">Low Stock</span>
        <span style="color:var(--muted);">· Only {{ $stock }} left</span>
      @else
        <div class="stock-dot stock-out"></div>
        <span style="color:var(--red); font-weight:500;">Out of Stock</span>
      @endif
    </div>

    {{-- ACTIONS --}}
    <div class="product-actions">
        <button class="btn-add-cart"
            id="btn-add-cart"
            data-id="{{ $product->id }}"
            data-name="{{ $product->name }}"
            data-price="{{ $price }}"
            data-slug="{{ $product->slug }}"
            data-image="{{ $product->getFirstMediaUrl('thumbnail') ?: $product->getFirstMediaUrl('uploads') }}">
            Add to Cart
        </button>
        <button class="btn-buy-now">Buy Now</button>
      <button class="btn-wishlist">
        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
      </button>
    </div>

    {{-- TRUST --}}
    <div class="trust-mini">
      <div class="trust-mini-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="3" width="15" height="13" rx="1"/><path d="M16 8h4l3 5v3h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
        <div><strong>Free Shipping</strong><span>On orders over 5,000 FCFA</span></div>
      </div>
      <div class="trust-mini-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
        <div><strong>Buyer Protection</strong><span>Money back guarantee</span></div>
      </div>
      <div class="trust-mini-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 102.13-9.36L1 10"/></svg>
        <div><strong>Easy Returns</strong><span>30-day hassle free</span></div>
      </div>
      <div class="trust-mini-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
        <div><strong>24/7 Support</strong><span>Always here to help</span></div>
      </div>
    </div>

    {{-- DESCRIPTION --}}
    @if($product->description)
    <div class="details-block">
      <div class="details-title">Product Description</div>
      <div style="font-size:14px;color:var(--muted);line-height:1.8;font-weight:300;">{!! $product->description !!}</div>
    </div>
    @endif

    {{-- SPECS --}}
    @if($product->weight_value > 0 || $product->height_value > 0)
    <div class="details-block" style="margin-top:24px;">
      <div class="details-title">Specifications</div>
      <div class="specs-grid">
        @if($product->sku)
        <div class="spec-item">
          <div class="spec-label">SKU</div>
          <div class="spec-value">{{ $product->sku }}</div>
        </div>
        @endif
        @if($product->barcode)
        <div class="spec-item">
          <div class="spec-label">Barcode</div>
          <div class="spec-value">{{ $product->barcode }}</div>
        </div>
        @endif
        @if($product->weight_value > 0)
        <div class="spec-item">
          <div class="spec-label">Weight</div>
          <div class="spec-value">{{ $product->weight_value }} {{ $product->weight_unit }}</div>
        </div>
        @endif
        @if($product->height_value > 0)
        <div class="spec-item">
          <div class="spec-label">Dimensions</div>
          <div class="spec-value">{{ $product->height_value }} × {{ $product->width_value }} × {{ $product->depth_value }} {{ $product->height_unit }}</div>
        </div>
        @endif
      </div>
    </div>
    @endif

  </div>
</div>

{{-- RELATED PRODUCTS --}}
@php
  $related = \Shopper\Core\Models\Product::where('is_visible', true)
    ->where('id', '!=', $product->id)
    ->with('prices', 'brand')
    ->inRandomOrder()
    ->take(4)
    ->get();
@endphp

@if($related->isNotEmpty())
<div class="related">
  <div class="sec-header">
    <h2 class="sec-title">You Might Also <span>Like</span></h2>
    <a href="{{ route('products.index') }}" class="sec-link">View all →</a>
  </div>
  <div class="products-grid">
    @foreach($related as $rel)
      @php
        $relImg   = $rel->getFirstMediaUrl('thumbnail') ?: $rel->getFirstMediaUrl('uploads');
        $relPrice = $rel->prices->first()->amount ?? 0;
      @endphp
      <a href="{{ route('products.show', $rel->slug) }}" class="product-card">
        <div class="card-img">
          @if($relImg)
            <img src="{{ $relImg }}" alt="{{ $rel->name }}" loading="lazy">
          @else
            <div class="card-img-placeholder">🛍️</div>
          @endif
        </div>
        <div class="card-body">
          <div class="card-brand">{{ $rel->brand->name ?? '' }}</div>
          <div class="card-name">{{ $rel->name }}</div>
          @if($relPrice > 0)
            <div class="card-price">{{ number_format($relPrice, 2) }} FCFA</div>
          @endif
        </div>
      </a>
    @endforeach
  </div>
</div>
@endif

{{-- FOOTER --}}
<footer>
  <div class="footer-bottom">
    <span>© {{ date('Y') }} ZeShop. All rights reserved.</span>
    <div class="footer-legal">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Use</a>
    </div>
  </div>
</footer>

<script>
function switchImg(url, el) {
  document.getElementById('mainImgEl').src = url;
  document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
}

// ── Cart helpers ──────────────────────────────────────────
function getCart() {
  return JSON.parse(localStorage.getItem('cart') || '[]');
}

function saveCart(cart) {
  localStorage.setItem('cart', JSON.stringify(cart));
  updateCartCount();
  syncToServer(cart);
}

function updateCartCount() {
  const cart = getCart();
  const count = cart.reduce((sum, i) => sum + i.quantity, 0);
  document.querySelectorAll('.cart-count').forEach(el => {
    el.textContent = count;
    el.style.display = count > 0 ? 'inline-flex' : 'none';
  });
}

function syncToServer(cart) {
  fetch('/cart/sync', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
        || '{{ csrf_token() }}'
    },
    body: JSON.stringify({ cart })
  }).catch(() => {}); // silent fail — localStorage is the source of truth
}

// ── Add to Cart button ────────────────────────────────────
document.getElementById('btn-add-cart')?.addEventListener('click', function () {
  const btn = this;
  const item = {
    product_id: btn.dataset.id,
    name:       btn.dataset.name,
    price:      parseFloat(btn.dataset.price),
    slug:       btn.dataset.slug,
    image:      btn.dataset.image,
    quantity:   1,
  };

  const cart = getCart();
  const existing = cart.find(i => i.product_id == item.product_id);

  if (existing) {
    existing.quantity += 1;
  } else {
    cart.push(item);
  }

  saveCart(cart);

  // Button feedback
  btn.textContent = '✓ Added!';
  btn.style.background = '#30d158';
  setTimeout(() => {
    btn.textContent = 'Add to Cart';
    btn.style.background = '';
  }, 1500);
});

// Init count on page load
updateCartCount();
</script>
</body>
</html>