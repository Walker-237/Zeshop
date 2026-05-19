<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist — ZeShop</title>
    <link rel="icon" type="image/x-icon" href="/cpanel/images/favicons/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <meta name="theme-color" content="#0b2240">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --ink: #1d1d1f; --navy: #0b2240; --blue: #0071e3;
            --pale: #f5f5f7; --white: #ffffff; --off: #f7f4f0;
            --muted: #6e6e73; --border: #d2d2d7;
            --gold: #d4a843; --red: #ff3b30; --green: #30d158;
            --rose: #ff6b8a; --rose-pale: #fff0f3;
            --sans: 'DM Sans', sans-serif;
            --serif: 'Playfair Display', Georgia, serif;
        }

        body {
            font-family: var(--sans);
            background: var(--off);
            color: var(--ink);
            font-size: 14px;
            min-height: 100vh;
        }

        a { text-decoration: none; color: inherit; }
        img { display: block; }
        button { border: none; cursor: pointer; font-family: var(--sans); }

        /* ── HERO BANNER ── */
        .wishlist-hero {
            background: linear-gradient(135deg, #0b2240 0%, #1a3a5c 50%, #0b2240 100%);
            padding: 56px 24px 48px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .wishlist-hero::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(212,168,67,0.12) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 50%, rgba(255,107,138,0.10) 0%, transparent 60%);
        }
        .wishlist-hero::after {
            content: '♥';
            position: absolute;
            font-size: 320px;
            color: rgba(255,255,255,0.025);
            top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            line-height: 1;
        }
        .hero-inner { position: relative; z-index: 1; }
        .hero-tag {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(255,107,138,0.18);
            border: 1px solid rgba(255,107,138,0.35);
            color: #ffb3c4;
            font-size: 11px; font-weight: 500; letter-spacing: 1.5px; text-transform: uppercase;
            padding: 5px 14px; border-radius: 20px; margin-bottom: 20px;
        }
        .wishlist-hero h1 {
            font-family: var(--serif);
            font-size: clamp(36px, 5vw, 56px);
            font-weight: 700;
            color: #fff;
            line-height: 1.1;
            margin-bottom: 12px;
        }
        .wishlist-hero h1 em {
            font-style: italic;
            color: #f5c842;
        }
        .wishlist-hero p {
            color: rgba(255,255,255,0.55);
            font-size: 15px;
            font-weight: 300;
        }
        .hero-count {
            display: inline-block;
            margin-top: 20px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.15);
            color: rgba(255,255,255,0.8);
            font-size: 13px; font-weight: 500;
            padding: 7px 18px; border-radius: 20px;
        }
        .hero-count span { color: #f5c842; font-weight: 700; }

        /* ── MAIN CONTENT ── */
        .wishlist-main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 48px 24px 80px;
        }

        /* ── TOOLBAR ── */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
            gap: 12px;
            flex-wrap: wrap;
        }
        .toolbar-left {
            font-family: var(--serif);
            font-size: 22px;
            color: var(--ink);
        }
        .toolbar-left span {
            font-family: var(--sans);
            font-size: 13px;
            color: var(--muted);
            font-weight: 400;
            margin-left: 8px;
        }
        .clear-btn {
            display: flex; align-items: center; gap: 6px;
            background: none; color: var(--muted);
            font-size: 13px; font-weight: 400;
            padding: 8px 14px; border-radius: 8px;
            border: 1px solid var(--border);
            transition: all 0.2s;
        }
        .clear-btn:hover { color: var(--red); border-color: var(--red); background: #fff5f5; }

        /* ── GRID ── */
        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(270px, 1fr));
            gap: 24px;
        }

        /* ── CARD ── */
        .wish-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            border: 0.5px solid var(--border);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            animation: cardIn 0.4s ease both;
            position: relative;
        }
        .wish-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 48px rgba(0,0,0,0.10);
        }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* staggered delay */
        .wish-card:nth-child(1)  { animation-delay: 0.05s; }
        .wish-card:nth-child(2)  { animation-delay: 0.10s; }
        .wish-card:nth-child(3)  { animation-delay: 0.15s; }
        .wish-card:nth-child(4)  { animation-delay: 0.20s; }
        .wish-card:nth-child(5)  { animation-delay: 0.25s; }
        .wish-card:nth-child(6)  { animation-delay: 0.30s; }
        .wish-card:nth-child(7)  { animation-delay: 0.35s; }
        .wish-card:nth-child(8)  { animation-delay: 0.40s; }

        .card-img-wrap {
            position: relative;
            height: 220px;
            background: var(--pale);
            overflow: hidden;
        }
        .card-img-wrap img {
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .wish-card:hover .card-img-wrap img { transform: scale(1.06); }

        /* Remove (heart) button */
        .remove-wish {
            position: absolute; top: 12px; right: 12px;
            width: 36px; height: 36px; border-radius: 50%;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(8px);
            border: none;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }
        .remove-wish:hover { background: var(--rose-pale); transform: scale(1.1); }

        /* Price badge */
        .price-badge {
            position: absolute; bottom: 12px; left: 12px;
            background: rgba(11,34,64,0.88);
            backdrop-filter: blur(8px);
            color: #fff;
            font-size: 13px; font-weight: 600;
            padding: 5px 12px; border-radius: 10px;
        }

        .card-body { padding: 16px 18px 18px; }
        .card-name {
            font-family: var(--serif);
            font-size: 16px;
            font-weight: 700;
            color: var(--ink);
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .card-meta {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 14px;
        }

        .card-actions { display: flex; gap: 8px; }

        .btn-add-cart {
            flex: 1;
            background: var(--navy);
            color: #fff;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px; font-weight: 500;
            border: none; cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .btn-add-cart:hover { background: var(--blue); }
        .btn-add-cart:active { transform: scale(0.97); }
        .btn-add-cart.added { background: var(--green); }

        .btn-view {
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 13px; font-weight: 500;
            border: 1px solid var(--border);
            background: var(--pale);
            color: var(--ink);
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }
        .btn-view:hover { border-color: var(--blue); color: var(--blue); }

        /* ── EMPTY STATE ── */
        .empty-wish {
            display: none;
            text-align: center;
            padding: 80px 20px;
        }
        .empty-wish .heart-anim {
            font-size: 72px;
            margin-bottom: 24px;
            display: block;
            animation: heartbeat 1.6s ease-in-out infinite;
        }
        @keyframes heartbeat {
            0%, 100% { transform: scale(1); }
            14%       { transform: scale(1.15); }
            28%       { transform: scale(1); }
            42%       { transform: scale(1.08); }
            70%       { transform: scale(1); }
        }
        .empty-wish h2 {
            font-family: var(--serif);
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .empty-wish p {
            color: var(--muted);
            font-size: 15px;
            margin-bottom: 32px;
            max-width: 360px;
            margin-left: auto; margin-right: auto;
            line-height: 1.6;
        }
        .btn-shop {
            display: inline-flex; align-items: center; gap: 8px;
            background: var(--navy); color: #fff;
            padding: 14px 32px; border-radius: 30px;
            font-weight: 600; font-size: 15px;
            transition: background 0.2s, transform 0.2s;
        }
        .btn-shop:hover { background: var(--blue); transform: translateY(-2px); }

        /* ── TOAST ── */
        .toast {
            position: fixed; bottom: 28px; left: 50%;
            transform: translateX(-50%) translateY(80px);
            background: #1d1d1f;
            color: #fff;
            padding: 12px 22px;
            border-radius: 30px;
            font-size: 13px; font-weight: 500;
            display: flex; align-items: center; gap: 8px;
            z-index: 9999;
            transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1);
            white-space: nowrap;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
        }
        .toast.show { transform: translateX(-50%) translateY(0); }

        @media (max-width: 640px) {
            .wishlist-grid { grid-template-columns: repeat(auto-fill, minmax(160px, 1fr)); gap: 14px; }
            .card-img-wrap { height: 160px; }
            .wishlist-hero { padding: 40px 16px 36px; }
        }
    </style>
</head>
<body>

@include('components.header')

{{-- ── HERO ── --}}
<div class="wishlist-hero">
    <div class="hero-inner">
        <div class="hero-tag">♥ &nbsp;Saved Items</div>
        <h1>Your <em>Wishlist</em></h1>
        <p>Everything you love, all in one place.</p>
        <div class="hero-count">
            <span id="heroCount">0</span> item<span id="heroPlural">s</span> saved
        </div>
    </div>
</div>

{{-- ── MAIN ── --}}
<div class="wishlist-main">

    {{-- Toolbar --}}
    <div class="toolbar" id="toolbar" style="display:none;">
        <div class="toolbar-left">
            My Favourites
            <span id="toolbarCount"></span>
        </div>
        <button class="clear-btn" onclick="clearAll()">
            🗑 Clear all
        </button>
    </div>

    {{-- Grid --}}
    <div class="wishlist-grid" id="wishGrid"></div>

    {{-- Empty state --}}
    <div class="empty-wish" id="emptyWish">
        <span class="heart-anim">🤍</span>
        <h2>Nothing here yet</h2>
        <p>Browse our collection and tap the heart icon on products you love to save them here.</p>
        <a href="{{ route('products.index') }}" class="btn-shop">
            ✦ &nbsp;Start Exploring
        </a>
    </div>
</div>

{{-- Toast --}}
<div class="toast" id="toast"></div>

<script>
document.addEventListener('DOMContentLoaded', renderWishlist);

function getFavourites() {
    return JSON.parse(localStorage.getItem('favourite') || '[]');
}
function saveFavourites(list) {
    localStorage.setItem('favourite', JSON.stringify(list));
}

function renderWishlist() {
    const list     = getFavourites();
    const grid     = document.getElementById('wishGrid');
    const empty    = document.getElementById('emptyWish');
    const toolbar  = document.getElementById('toolbar');
    const heroCount = document.getElementById('heroCount');
    const heroPlural = document.getElementById('heroPlural');
    const toolbarCount = document.getElementById('toolbarCount');

    heroCount.textContent  = list.length;
    heroPlural.textContent = list.length === 1 ? '' : 's';
    toolbarCount.textContent = `— ${list.length} item${list.length === 1 ? '' : 's'}`;

    grid.innerHTML = '';

    if (list.length === 0) {
        empty.style.display   = 'block';
        toolbar.style.display = 'none';
        return;
    }

    empty.style.display   = 'none';
    toolbar.style.display = 'flex';

    list.forEach((item, index) => {
        const price   = item.price ? item.price.toLocaleString() + ' FCFA' : '';
        const imgSrc  = item.image || 'https://via.placeholder.com/400x300?text=No+Image';
        const slug    = item.slug || '#';

        const card = document.createElement('div');
        card.className = 'wish-card';
        card.style.animationDelay = (index * 0.06) + 's';
        card.innerHTML = `
            <div class="card-img-wrap">
                <img src="${imgSrc}" alt="${item.name ?? ''}">
                <button class="remove-wish" onclick="removeItem(${index})" title="Remove from wishlist">
                    🩷
                </button>
                ${price ? `<div class="price-badge">${price}</div>` : ''}
            </div>
            <div class="card-body">
                <div class="card-name">${item.name ?? 'Product'}</div>
                <div class="card-meta">${item.category ?? 'ZeShop'}</div>
                <div class="card-actions">
                    <button class="btn-add-cart" id="addBtn-${index}" onclick="addToCart(${index})">
                        🛒 Add to Cart
                    </button>
                    <a href="/products/${slug}" class="btn-view">View</a>
                </div>
            </div>`;
        grid.appendChild(card);
    });
}

function removeItem(index) {
    const list = getFavourites();
    const name = list[index]?.name ?? 'Item';
    list.splice(index, 1);
    saveFavourites(list);
    showToast('🩶 ' + name + ' removed from wishlist');
    renderWishlist();
}

function clearAll() {
    if (!confirm('Remove all items from your wishlist?')) return;
    saveFavourites([]);
    showToast('🗑 Wishlist cleared');
    renderWishlist();
}

function addToCart(index) {
    const list = getFavourites();
    const item = list[index];
    if (!item) return;

    // Add to cart in localStorage
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const existing = cart.find(c => c.product_id == item.product_id || c.slug == item.slug);
    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({
            product_id: item.product_id,
            name:       item.name,
            price:      item.price,
            slug:       item.slug,
            image:      item.image,
            quantity:   1,
        });
    }
    localStorage.setItem('cart', JSON.stringify(cart));

    // Update header badge if available
    if (typeof window.updateCartBadge === 'function') {
        window.updateCartBadge();
    }

    // Button feedback
    const btn = document.getElementById('addBtn-' + index);
    if (btn) {
        btn.classList.add('added');
        btn.textContent = '✓ Added!';
        setTimeout(() => {
            btn.classList.remove('added');
            btn.innerHTML = '🛒 Add to Cart';
        }, 1800);
    }

    showToast('🛒 ' + item.name + ' added to cart!');
}

function showToast(msg) {
    const toast = document.getElementById('toast');
    toast.textContent = msg;
    toast.classList.add('show');
    clearTimeout(window._toastTimer);
    window._toastTimer = setTimeout(() => toast.classList.remove('show'), 2800);
}
</script>

</body>
</html>