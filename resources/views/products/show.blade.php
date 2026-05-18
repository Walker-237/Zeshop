<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $category->name }} — ZeShop</title>
    <link rel="icon" type="image/x-icon" href="/cpanel/images/favicons/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/cpanel/images/favicons/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/cpanel/images/favicons/favicon-32x32.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <meta name="theme-color" content="#0b2240">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        /* ==================== EXACT STYLES FROM YOUR HOME PAGE ==================== */
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --ink:       #1d1d1f;
            --navy:      #0b2240;
            --blue:      #0071e3;
            --mid:       #0077ed;
            --sky:       #2997ff;
            --pale:      #f5f5f7;
            --white:     #ffffff;
            --off:       #f5f5f7;
            --muted:     #6e6e73;
            --border:    #d2d2d7;
            --gold:      #d4a843;
            --red:       #ff3b30;
            --green:     #30d158;
            --sans:      -apple-system, 'Inter', 'Helvetica Neue', Helvetica, sans-serif;
            --display:   -apple-system, 'Inter', 'Helvetica Neue', Helvetica, sans-serif;
        }

        body { font-family: var(--sans); background: var(--off); color: var(--ink); font-size: 14px; -webkit-font-smoothing: antialiased; }
        a { text-decoration: none; color: inherit; }
        img { display: block; width: 100%; }
        button { cursor: pointer; font-family: var(--sans); border: none; outline: none; }

        .announce { background: var(--navy); color: #a8c8f0; text-align: center; font-size: 12px; padding: 8px 20px; }
        .announce span { color: var(--gold); font-weight: 500; }

        .topnav {
            background: rgba(255,255,255,0.85); backdrop-filter: saturate(180%) blur(20px);
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
        .search-wrap input { flex: 1; border: none; padding: 0 14px; }
        .search-wrap button { background: var(--blue); color: white; padding: 0 18px; font-weight: 500; }

        .topnav-actions { display: flex; align-items: center; gap: 8px; margin-left: auto; }
        .action-btn {
            display: flex; flex-direction: column; align-items: center; gap: 2px;
            font-size: 10px; color: var(--muted); padding: 6px 10px; border-radius: 8px;
        }
        .action-btn:hover { color: var(--blue); background: var(--pale); }
        .action-btn svg { width: 20px; height: 20px; }

        .catnav {
            background: rgba(255,255,255,0.9); backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 0.5px solid var(--border); padding: 0 24px;
            display: flex; align-items: center; overflow-x: auto;
        }
        .catnav a {
            color: var(--muted); font-size: 13px; padding: 12px 16px;
            white-space: nowrap; border-bottom: 2px solid transparent;
        }
        .catnav a.active { color: var(--blue); border-bottom-color: var(--blue); font-weight: 500; }

        /* Product Card - Exact from your home */
        .products-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; padding: 0 24px;
        }
        .product-card {
            background: var(--white); border: 0.5px solid var(--border);
            border-radius: 16px; overflow: hidden; position: relative;
            transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.25s;
            text-decoration: none; display: block;
        }
        .product-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,0.1); transform: translateY(-3px); }
        .product-card:hover .card-actions { opacity: 1; transform: translateY(0); }

        .card-img {
            height: 190px; background: var(--pale); position: relative; overflow: hidden;
        }
        .card-img img { width: 100%; height: 100%; object-fit: cover; }

        .card-badge {
            position: absolute; top: 10px; left: 10px;
            font-size: 10px; font-weight: 600; padding: 3px 9px; border-radius: 20px; z-index: 2;
        }
        .badge-sale { background: var(--blue); color: #fff; }
        .badge-new { background: var(--green); color: #fff; }

        .card-wishlist {
            position: absolute; top: 10px; right: 10px;
            width: 30px; height: 30px; border-radius: 50%;
            background: rgba(255,255,255,0.85); backdrop-filter: blur(10px);
            border: 0.5px solid rgba(0,0,0,0.08);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; z-index: 3;
        }
        .card-wishlist svg { width: 14px; height: 14px; stroke: var(--muted); fill: none; transition: all .2s; }
        .card-wishlist:hover svg, .card-wishlist.active svg { stroke: var(--red); fill: var(--red); }

        .card-actions {
            position: absolute; bottom: 0; left: 0; right: 0;
            background: rgba(0,0,0,0.65); backdrop-filter: blur(8px);
            display: flex; gap: 1px; opacity: 0; transform: translateY(4px);
            transition: all .2s; z-index: 2;
        }
        .card-actions button {
            flex: 1; padding: 9px 4px; font-size: 11px; font-weight: 500;
            color: rgba(255,255,255,0.9); background: none;
        }
        .card-actions button.add-cart-btn { background: var(--blue); color: white; }
        .card-actions button.add-cart-btn:hover { background: #0062c4; }

        .card-body { padding: 12px 14px 14px; }
        .card-brand { font-size: 11px; color: var(--muted); margin-bottom: 3px; }
        .card-name { font-size: 13px; line-height: 1.4; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .card-price { display: flex; align-items: baseline; gap: 6px; }
        .price-now { font-size: 15px; font-weight: 600; color: var(--ink); }
        .price-old { font-size: 12px; color: #aaa; text-decoration: line-through; }

        .empty-state { padding: 60px 20px; text-align: center; color: var(--muted); grid-column: 1/-1; }

        .page-header {
            background: linear-gradient(135deg, var(--navy) 0%, #123a6e 100%);
            padding: 40px 24px 36px; color: white;
        }
        .page-title { font-size: 36px; font-weight: 700; letter-spacing: -1px; }
    </style>
</head>
<body>

{{-- ANNOUNCEMENT BAR --}}
<div class="announce">
    Welcome to ZeShop — New users get <span>15% off</span> their first order!
    <a href="{{ route('products.index') }}">Shop now →</a>
</div>

{{-- TOP NAV --}}
<nav class="topnav">
    <a href="{{ route('home') }}" class="logo">Ze<span>Shop</span></a>

    <form action="{{ route('products.index') }}" method="GET" class="search-wrap">
        <select name="category">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
            @endforeach
        </select>
        <input type="text" name="q" placeholder="Search for products, brands and more…" value="{{ request('q') }}">
        <button type="submit">Search</button>
    </form>

    <div class="topnav-actions">
        @auth
            <a href="{{ route('account') }}" class="action-btn">Account</a>
        @else
            <a href="{{ route('login') }}" class="action-btn">Sign In</a>
        @endauth

        <a href="#" class="action-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            Wishlist
        </a>

        <a href="{{ route('cart') }}" class="action-btn">Cart</a>
    </div>
</nav>

{{-- CATEGORY NAV --}}
<nav class="catnav">
    <a href="{{ route('home') }}">Home</a>
    @foreach($categories as $cat)
        <a href="{{ route('categories.show', $cat->slug) }}" class="{{ $category->slug === $cat->slug ? 'active' : '' }}">
            {{ $cat->name }}
        </a>
    @endforeach
</nav>

{{-- PAGE HEADER --}}
<div class="page-header">
    <h1 class="page-title">{{ $category->name }}</h1>
    <p style="margin-top:8px; opacity:0.9;">{{ $category->description ?? 'Explore our handpicked collection' }}</p>
</div>

<div style="max-width:1200px; margin:24px auto; padding:0 24px;">
    <div class="products-grid">
        @forelse($products as $product)
            @php
                $img = $product->getFirstMediaUrl('thumbnail') ?: $product->getFirstMediaUrl('uploads');
                $price = $product->prices->first()->amount ?? 0;
                $compare = $product->prices->first()->compare_amount ?? 0;
                $pct = $compare > 0 ? round((1 - $price / $compare) * 100) : 0;
            @endphp

            <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                <div class="card-img">
                    @if($img)
                        <img src="{{ $img }}" alt="{{ $product->name }}" loading="lazy">
                    @else
                        <div class="card-img-placeholder" style="font-size:60px;">🛍️</div>
                    @endif

                    @if($pct > 0)
                        <span class="card-badge badge-sale">-{{ $pct }}%</span>
                    @endif

                    <div class="card-wishlist" onclick="event.stopImmediatePropagation(); this.classList.toggle('active')">
                        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                    </div>

                    <div class="card-actions">
                        <button type="button" onclick="event.preventDefault()">Quick View</button>
                        <button type="button" class="add-cart-btn" onclick="event.preventDefault(); addToCart(this, {{ $product->id }})">Add to Cart</button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="card-brand">{{ $product->brand->name ?? '' }}</div>
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
                <p>No products found in this category at the moment.</p>
            </div>
        @endforelse
    </div>

    <div style="margin: 40px 0; text-align:center;">
        {{ $products->links() }}
    </div>
</div>

<script>
    function addToCart(btn, id) {
        event.stopImmediatePropagation();
        const orig = btn.innerHTML;
        btn.innerHTML = '✓ Added!';
        btn.style.background = 'var(--green)';
        setTimeout(() => {
            btn.innerHTML = orig;
            btn.style.background = 'var(--blue)';
        }, 1500);
    }
</script>
</body>
</html>