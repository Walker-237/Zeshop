<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} — ZeShop</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
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
        img { display: block; width: 100%; height: 100%; object-fit: cover; }
        button { cursor: pointer; font-family: var(--sans); border: none; outline: none; }

        /* Announcement */
        .announce { background: var(--navy); color: #a8c8f0; text-align: center; font-size: 12px; padding: 8px 20px; }
        .announce span { color: var(--gold); font-weight: 500; }

        /* Top Nav */
        .topnav {
            background: rgba(255,255,255,0.9); backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 0.5px solid var(--border); padding: 0 24px;
            display: flex; align-items: center; gap: 16px; height: 60px;
            position: sticky; top: 0; z-index: 100;
        }
        .logo { font-size: 24px; font-weight: 700; letter-spacing: -0.5px; }
        .logo span { color: var(--blue); }

        .search-wrap {
            flex: 1; max-width: 560px; background: var(--pale); border-radius: 10px;
            overflow: hidden; border: 1px solid transparent; transition: all .2s;
        }
        .search-wrap:focus-within { border-color: var(--blue); background: var(--white); }
        .search-wrap select { border: none; border-right: 0.5px solid var(--border); padding: 0 10px; width: 130px; background: transparent; }
        .search-wrap input { flex: 1; border: none; padding: 0 14px; font-size: 14px; }
        .search-wrap button { background: var(--blue); color: white; padding: 0 20px; font-weight: 500; }

        /* Cat Nav */
        .catnav {
            background: rgba(255,255,255,0.9); backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 0.5px solid var(--border); padding: 0 24px; display: flex; overflow-x: auto;
        }
        .catnav a {
            color: var(--muted); font-size: 13px; padding: 12px 16px; white-space: nowrap;
            border-bottom: 2px solid transparent; transition: all .2s;
        }
        .catnav a.active { color: var(--blue); border-bottom-color: var(--blue); font-weight: 500; }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--navy) 0%, #123a6e 100%);
            padding: 40px 24px 36px; position: relative;
        }
        .page-title { font-size: 36px; font-weight: 700; color: #fff; letter-spacing: -1px; }
        .page-sub { color: rgba(168,200,240,0.8); font-size: 14.5px; }

        /* Main Layout */
        .shop-layout {
            max-width: 1200px; margin: 24px auto; padding: 0 24px 48px;
            display: grid; grid-template-columns: 240px 1fr; gap: 24px;
        }

        /* Sidebar */
        .filter-card {
            background: var(--white); border: 0.5px solid var(--border);
            border-radius: 16px; overflow: hidden; margin-bottom: 16px;
        }
        .filter-header {
            padding: 14px 18px; font-weight: 600; border-bottom: 0.5px solid var(--border);
        }
        .filter-body { padding: 14px 18px; }

        /* Products */
        .products-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;
        }
        .product-card {
            background: var(--white); border: 0.5px solid var(--border);
            border-radius: 16px; overflow: hidden; position: relative;
            transition: all .25s; text-decoration: none; display: block;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.1);
        }

        .card-img {
            height: 190px; background: var(--pale); position: relative;
        }
        .card-badge {
            position: absolute; top: 10px; left: 10px;
            font-size: 10px; font-weight: 600; padding: 3px 9px;
            border-radius: 20px; z-index: 2;
        }
        .badge-sale { background: var(--blue); color: #fff; }
        .badge-new { background: var(--green); color: #fff; }

        .card-wishlist {
            position: absolute; top: 10px; right: 10px;
            width: 32px; height: 32px; border-radius: 50%;
            background: rgba(255,255,255,0.9); backdrop-filter: blur(10px);
            border: 0.5px solid rgba(0,0,0,0.1);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; z-index: 3; transition: all .2s;
        }
        .card-wishlist svg {
            width: 15px; height: 15px; stroke: var(--muted); fill: none;
        }
        .card-wishlist.active svg {
            stroke: var(--red); fill: var(--red);
        }

        .card-actions {
            position: absolute; bottom: 0; left: 0; right: 0;
            background: rgba(0, 0, 0, 0.59);
            backdrop-filter: blur(8px);
            display: flex; gap: 1px;
            opacity: 0; transform: translateY(4px);
            transition: opacity 0.2s, transform 0.2s; z-index: 2;
        }
        .product-card:hover .card-actions { opacity: 1; }
        .card-actions button {
            flex: 1; padding: 10px; color: white; font-size: 12px; font-weight: 500;
        }
        .card-actions .add-cart-btn { background: var(--blue); }
        .card-actions .add-cart-btn:hover { background: #0062c4; }

        .card-body { padding: 12px 14px; }
        .card-brand { font-size: 11px; color: var(--muted); }
        .card-name { font-size: 13.5px; line-height: 1.4; margin: 6px 0 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .price-now { font-size: 15.5px; font-weight: 600; }
        .price-old { font-size: 12px; color: #aaa; text-decoration: line-through; }

        .empty-state {
            grid-column: 1 / -1; text-align: center; padding: 80px 20px; color: var(--muted);
        }

        /* Pagination */
        .pagination { margin-top: 40px; text-align: center; }
    </style>
</head>
<body>

{{-- ANNOUNCEMENT --}}
@include('components.header')

{{-- PAGE HEADER --}}
<div class="page-header">
    <h1 class="page-title">{{ $category->name }}</h1>
    <p class="page-sub">{{ $category->description ?? 'Discover premium products in this category' }}</p>
</div>

<div class="shop-layout">

    {{-- SIDEBAR --}}
    <aside>
        <div class="filter-card">
            <div class="filter-header">Categories</div>
            <div class="filter-body">
                @foreach($categories as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}" style="display: block; padding: 8px 0; color: {{ $cat->slug === $category->slug ? 'var(--blue)' : 'inherit' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </aside>

    {{-- PRODUCTS SECTION --}}
    <main>
        <div class="products-grid">
            @forelse($products as $product)
                @php
                    $img = $product->getFirstMediaUrl('thumbnail') ?: $product->getFirstMediaUrl('uploads');
                    $price = $product->prices->first()->amount ?? 0;
                    $compare = $product->prices->first()->compare_amount ?? 0;
                    $discount = $compare > 0 ? round((1 - $price / $compare) * 100) : 0;
                @endphp

                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="card-img">
                        @if($img)
                            <img src="{{ $img }}" alt="{{ $product->name }}">
                        @else
                            <div style="font-size: 60px; color: #ddd;">🛍️</div>
                        @endif

                        @if($discount > 0)
                            <span class="card-badge badge-sale">-{{ $discount }}%</span>
                        @endif

                        <!-- Wishlist -->
                        <div class="card-wishlist" onclick="event.preventDefault(); toggleWishlist(this)">
                            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                        </div>

                        <!-- Actions -->
                        <div class="card-actions">
                            <button onclick="event.preventDefault()">Quick View</button>
                            <button class="add-cart-btn" onclick="event.preventDefault(); addToCart(this, {{ $product->id }})">Add to Cart</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="card-brand">{{ $product->brand->name ?? 'ZeShop' }}</div>
                        <div class="card-name">{{ $product->name }}</div>
                        <div class="card-price">
                            <span class="price-now">{{ number_format($price) }} FCFA</span>
                            @if($compare > 0)
                                <span class="price-old">{{ number_format($compare) }} FCFA</span>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="empty-state">
                    <h3>No products available</h3>
                    <p>We couldn't find any products in this category at the moment.</p>
                </div>
            @endforelse
        </div>

        <div class="pagination">
            {{ $products->links() }}
        </div>
    </main>
</div>

<script>
    // Wishlist Toggle
    function toggleWishlist(el) {
        event.stopImmediatePropagation();
        el.classList.toggle('active');
    }

    // Add to Cart
    function addToCart(btn, productId) {
        event.stopImmediatePropagation();
        const originalText = btn.textContent;
        const originalBg = btn.style.background;
        btn.textContent = "✓ Added!";
        btn.style.background = "var(--green)";
        btn.disabled = true;

        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: 1
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cart badge in header
                const badges = document.querySelectorAll('.cart-badge');
                badges.forEach(badge => {
                    badge.textContent = data.cartCount;
                });
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.background = originalBg;
                    btn.disabled = false;
                }, 1500);
            }
        })
        .catch(err => {
            console.error('Error:', err);
            btn.textContent = originalText;
            btn.style.background = originalBg;
            btn.disabled = false;
        });
    }
</script>
</body>
</html>