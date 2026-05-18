<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Products — ZeShop</title>
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
  ul { list-style: none; }
  img { display: block; }
  button { cursor: pointer; font-family: var(--sans); border: none; outline: none; }

  /* ANNOUNCE */
  .announce { background: var(--navy); color: #a8c8f0; text-align: center; font-size: 12px; padding: 8px 20px; }
  .announce span { color: var(--gold); font-weight: 500; }
  .announce a { color: #6aaee0; text-decoration: underline; margin-left: 8px; }

  /* NAV */
  .topnav {
    background: rgba(255,255,255,0.9); backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 0.5px solid var(--border); padding: 0 24px;
    display: flex; align-items: center; gap: 16px; height: 60px;
    position: sticky; top: 0; z-index: 100;
  }
  .logo { font-size: 24px; font-weight: 700; color: var(--ink); letter-spacing: -0.5px; }
  .logo span { color: var(--blue); }
  .search-wrap {
    flex: 1; display: flex; max-width: 560px; background: var(--pale);
    border-radius: 10px; overflow: hidden; border: 1px solid transparent;
    transition: border-color .2s, background .2s;
  }
  .search-wrap:focus-within { border-color: var(--blue); background: var(--white); }
  .search-wrap select {
    border: none; border-right: 0.5px solid var(--border); background: transparent;
    color: var(--ink); font-family: var(--sans); font-size: 13px;
    padding: 0 10px; width: 130px; cursor: pointer; outline: none;
  }
  .search-wrap input {
    flex: 1; border: none; padding: 0 14px; font-family: var(--sans);
    font-size: 14px; outline: none; color: var(--ink); background: transparent;
  }
  .search-wrap input::placeholder { color: var(--muted); }
  .search-wrap button {
    background: var(--blue); color: var(--white); padding: 0 18px;
    font-size: 13px; font-weight: 500; border-radius: 0 9px 9px 0; transition: background .2s;
  }
  .search-wrap button:hover { background: #0062c4; }
  .topnav-actions { display: flex; align-items: center; gap: 8px; margin-left: auto; }
  .action-btn {
    display: flex; flex-direction: column; align-items: center; gap: 2px;
    font-size: 10px; color: var(--muted); background: none; padding: 6px 10px;
    border-radius: 8px; text-decoration: none; transition: color .2s;
  }
  .action-btn:hover { color: var(--blue); background: var(--pale); }
  .action-btn svg { width: 20px; height: 20px; }
  .cart-badge {
    position: absolute; top: -4px; right: -4px;
    background: var(--red); color: #fff; font-size: 9px; font-weight: 600;
    width: 15px; height: 15px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    border: 1.5px solid var(--white);
  }

  /* CATNAV */
  .catnav {
    background: rgba(255,255,255,0.9); backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 0.5px solid var(--border); padding: 0 24px;
    display: flex; align-items: center; overflow-x: auto; scrollbar-width: none;
  }
  .catnav::-webkit-scrollbar { display: none; }
  .catnav a {
    color: var(--muted); font-size: 13px; padding: 12px 16px;
    white-space: nowrap; border-bottom: 2px solid transparent; transition: all .2s;
  }
  .catnav a:hover { color: var(--ink); }
  .catnav a.active { color: var(--blue); border-bottom-color: var(--blue); font-weight: 500; }

  /* PAGE HEADER */
  .page-header {
    background: linear-gradient(135deg, var(--navy) 0%, #123a6e 100%);
    padding: 40px 24px 36px; position: relative; overflow: hidden;
  }
  .page-header::before {
    content: ''; position: absolute; right: -100px; top: -100px;
    width: 500px; height: 500px; border-radius: 50%;
    background: radial-gradient(circle, rgba(41,151,255,0.12) 0%, transparent 70%);
    pointer-events: none;
  }
  .page-header-inner { max-width: 1200px; margin: 0 auto; }
  .breadcrumb { display: flex; align-items: center; gap: 6px; font-size: 12px; color: rgba(168,200,240,0.65); margin-bottom: 12px; }
  .breadcrumb a { color: rgba(168,200,240,0.65); transition: color .2s; }
  .breadcrumb a:hover { color: rgba(255,255,255,0.9); }
  .breadcrumb svg { width: 12px; height: 12px; }
  .page-title { font-size: 36px; font-weight: 700; color: #fff; letter-spacing: -1px; margin-bottom: 6px; }
  .page-sub { font-size: 14px; color: rgba(168,200,240,0.7); font-weight: 300; }
  .page-header-meta { display: flex; align-items: center; gap: 20px; margin-top: 20px; }
  .meta-tag {
    background: rgba(255,255,255,0.1); border: 0.5px solid rgba(255,255,255,0.15);
    color: rgba(255,255,255,0.8); font-size: 12px; font-weight: 500;
    padding: 5px 14px; border-radius: 20px; display: flex; align-items: center; gap: 6px;
  }
  .meta-tag svg { width: 13px; height: 13px; }

  /* LAYOUT */
  .shop-layout {
    max-width: 1200px; margin: 24px auto; padding: 0 24px 48px;
    display: grid; grid-template-columns: 240px 1fr; gap: 24px; align-items: start;
  }

  /* SIDEBAR */
  .sidebar { position: sticky; top: 84px; display: flex; flex-direction: column; gap: 6px; }
  .filter-card {
    background: var(--white); border: 0.5px solid var(--border);
    border-radius: 16px; overflow: hidden;
  }
  .filter-header {
    padding: 14px 18px; display: flex; align-items: center;
    justify-content: space-between; cursor: pointer;
    border-bottom: 0.5px solid var(--border);
  }
  .filter-header h3 { font-size: 13px; font-weight: 600; color: var(--ink); }
  .filter-header svg { width: 16px; height: 16px; color: var(--muted); transition: transform .2s; }
  .filter-header.open svg { transform: rotate(180deg); }
  .filter-body { padding: 14px 18px; }
  .filter-search {
    display: flex; align-items: center; gap: 8px;
    background: var(--pale); border-radius: 8px; padding: 7px 12px;
    margin-bottom: 12px; border: 1px solid transparent; transition: border-color .2s;
  }
  .filter-search:focus-within { border-color: var(--blue); }
  .filter-search svg { width: 13px; height: 13px; color: var(--muted); flex-shrink: 0; }
  .filter-search input { border: none; background: none; font-size: 12px; color: var(--ink); outline: none; width: 100%; }
  .filter-option {
    display: flex; align-items: center; gap: 10px;
    padding: 6px 0; cursor: pointer; transition: color .2s;
  }
  .filter-option input[type="checkbox"] { display: none; }
  .check-box {
    width: 16px; height: 16px; border-radius: 4px; border: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    transition: all .2s;
  }
  .filter-option.checked .check-box { background: var(--blue); border-color: var(--blue); }
  .filter-option.checked .check-box::after { content: ''; width: 8px; height: 5px; border-left: 1.5px solid #fff; border-bottom: 1.5px solid #fff; transform: rotate(-45deg) translate(1px, -1px); display: block; }
  .filter-option label { font-size: 13px; color: var(--muted); cursor: pointer; flex: 1; }
  .filter-option.checked label { color: var(--ink); font-weight: 500; }
  .filter-count { font-size: 11px; color: var(--muted); background: var(--pale); padding: 2px 7px; border-radius: 10px; }

  /* PRICE RANGE */
  .price-range-wrap { padding: 4px 0 8px; }
  .price-inputs { display: flex; gap: 8px; margin-bottom: 12px; }
  .price-input {
    flex: 1; background: var(--pale); border: 1px solid var(--border);
    border-radius: 8px; padding: 7px 10px; font-size: 12px; color: var(--ink);
    outline: none; font-family: var(--sans); transition: border-color .2s;
  }
  .price-input:focus { border-color: var(--blue); }
  .range-slider { width: 100%; accent-color: var(--blue); }

  /* ACTIVE FILTERS */
  .active-filters { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 6px; }
  .active-filter {
    background: #e8f0fe; color: var(--blue); font-size: 12px; font-weight: 500;
    padding: 4px 10px; border-radius: 20px; display: flex; align-items: center; gap: 5px;
    cursor: pointer; transition: background .2s;
  }
  .active-filter:hover { background: #d0e3fb; }
  .active-filter svg { width: 11px; height: 11px; }
  .clear-all { font-size: 12px; color: var(--blue); cursor: pointer; padding: 4px 0; }
  .clear-all:hover { text-decoration: underline; }

  /* PRODUCTS AREA */
  .toolbar {
    background: var(--white); border: 0.5px solid var(--border); border-radius: 14px;
    padding: 12px 16px; display: flex; align-items: center; gap: 12px; margin-bottom: 16px;
  }
  .results-count { font-size: 13px; color: var(--muted); flex: 1; }
  .results-count strong { color: var(--ink); }
  .sort-select {
    background: var(--pale); border: 1px solid var(--border); border-radius: 8px;
    padding: 7px 32px 7px 12px; font-size: 13px; color: var(--ink);
    outline: none; font-family: var(--sans); cursor: pointer; appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236e6e73' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
    background-repeat: no-repeat; background-position: right 10px center;
  }
  .view-toggle { display: flex; gap: 4px; }
  .view-btn {
    width: 32px; height: 32px; border-radius: 8px; background: var(--pale);
    border: 1px solid var(--border); display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .2s; color: var(--muted);
  }
  .view-btn.active { background: var(--blue); border-color: var(--blue); color: #fff; }
  .view-btn svg { width: 15px; height: 15px; }

  /* PRODUCT GRID */
  .products-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; }
  .products-grid.list-view { grid-template-columns: 1fr; }

  /* PRODUCT CARD */
  .product-card {
    background: var(--white); border: 0.5px solid var(--border); border-radius: 16px;
    overflow: hidden; cursor: pointer; transition: transform .25s, box-shadow .25s;
    text-decoration: none; display: block; position: relative;
  }
  .product-card:hover { box-shadow: 0 12px 40px rgba(0,0,0,0.1); transform: translateY(-3px); }
  .product-card:hover .card-actions { opacity: 1; transform: translateY(0); }

  /* LIST VIEW */
  .products-grid.list-view .product-card { display: flex; }
  .products-grid.list-view .card-img { width: 180px; height: 180px; flex-shrink: 0; }
  .products-grid.list-view .card-body { flex: 1; padding: 20px; display: flex; flex-direction: column; justify-content: space-between; }
  .products-grid.list-view .card-name { font-size: 15px; -webkit-line-clamp: 3; }
  .products-grid.list-view .card-actions { position: static; opacity: 1; transform: none; background: none; display: flex; gap: 8px; margin-top: 12px; }
  .products-grid.list-view .card-actions button { flex: unset; padding: 9px 18px; border-radius: 10px; font-size: 12px; color: var(--ink); background: var(--pale); border: 0.5px solid var(--border); }
  .products-grid.list-view .card-actions button.add-cart-btn { background: var(--blue); color: #fff; border-color: var(--blue); }

  .card-img {
    height: 180px; background: var(--pale);
    display: flex; align-items: center; justify-content: center;
    position: relative; overflow: hidden;
  }
  .card-img img { width: 100%; height: 100%; object-fit: cover; }
  .card-img-placeholder { font-size: 52px; }
  .card-badge {
    position: absolute; top: 10px; left: 10px;
    font-size: 10px; font-weight: 600; padding: 3px 9px; border-radius: 20px; z-index: 2;
  }
  .badge-new { background: var(--green); color: #fff; }
  .badge-sale { background: var(--blue); color: #fff; }
  .badge-hot { background: var(--red); color: #fff; }
  .card-wishlist {
    position: absolute; top: 10px; right: 10px;
    width: 30px; height: 30px; border-radius: 50%;
    background: rgba(255,255,255,0.85); backdrop-filter: blur(10px);
    border: 0.5px solid rgba(0,0,0,0.08);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer; transition: all .2s; z-index: 2;
  }
  .card-wishlist svg { width: 14px; height: 14px; stroke: var(--muted); fill: none; transition: all .2s; }
  .card-wishlist:hover svg { stroke: var(--red); }
  .card-actions {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: rgba(0,0,0,0.65); backdrop-filter: blur(8px);
    display: flex; gap: 1px;
    opacity: 0; transform: translateY(4px);
    transition: opacity .2s, transform .2s; z-index: 2;
  }
  .card-actions button {
    flex: 1; padding: 9px 4px; font-size: 11px; font-weight: 500;
    color: rgba(255,255,255,0.9); background: none; border: none; transition: background .2s;
  }
  .card-actions button:hover { background: rgba(255,255,255,0.12); }
  .card-actions button.add-cart-btn { background: var(--blue); color: #fff; }
  .card-actions button.add-cart-btn:hover { background: #0062c4; }
  .card-body { padding: 12px 14px 14px; }
  .card-brand { font-size: 11px; color: var(--muted); margin-bottom: 3px; }
  .card-name { font-size: 13px; color: var(--ink); line-height: 1.4; margin-bottom: 8px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
  .card-price { display: flex; align-items: baseline; gap: 6px; }
  .price-now { font-size: 15px; font-weight: 600; color: var(--ink); }
  .price-old { font-size: 12px; color: #aaa; text-decoration: line-through; font-weight: 300; }
  .price-save { font-size: 11px; color: var(--blue); font-weight: 500; }
  .price-no-stock { font-size: 12px; color: var(--red); }

  /* EMPTY STATE */
  .empty-state {
    background: var(--white); border: 0.5px solid var(--border); border-radius: 16px;
    padding: 60px 20px; text-align: center; grid-column: 1/-1;
  }
  .empty-state-icon { font-size: 48px; margin-bottom: 12px; }
  .empty-state h3 { font-size: 18px; font-weight: 600; color: var(--ink); margin-bottom: 6px; }
  .empty-state p { font-size: 13px; color: var(--muted); }

  /* PROMO STRIP */
  .promo-strip {
    background: var(--white); border: 0.5px solid var(--border); border-radius: 14px;
    padding: 14px 18px; margin-bottom: 16px;
    display: flex; align-items: center; justify-content: space-between; gap: 12px;
    overflow: hidden; position: relative;
  }
  .promo-strip::before {
    content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
    background: linear-gradient(to bottom, var(--blue), var(--sky));
  }
  .promo-strip-text strong { font-size: 13px; color: var(--ink); display: block; margin-bottom: 2px; }
  .promo-strip-text span { font-size: 12px; color: var(--muted); }
  .promo-strip-btn {
    background: var(--blue); color: #fff; font-size: 12px; font-weight: 500;
    padding: 7px 16px; border-radius: 8px; white-space: nowrap; transition: background .2s;
    text-decoration: none;
  }
  .promo-strip-btn:hover { background: #0062c4; }

  /* PAGINATION */
  .pagination { display: flex; align-items: center; justify-content: center; gap: 6px; margin-top: 32px; }
  .page-btn {
    width: 36px; height: 36px; border-radius: 10px; border: 0.5px solid var(--border);
    background: var(--white); color: var(--ink); font-size: 13px; font-weight: 500;
    display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all .2s;
    text-decoration: none;
  }
  .page-btn:hover { border-color: var(--blue); color: var(--blue); }
  .page-btn.active { background: var(--blue); border-color: var(--blue); color: #fff; }
  .page-btn svg { width: 14px; height: 14px; }

  /* MOBILE FILTER BTN */
  .mobile-filter-btn {
    display: none; position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
    background: var(--navy); color: #fff; font-size: 13px; font-weight: 600;
    padding: 13px 28px; border-radius: 30px; z-index: 200; gap: 8px; align-items: center;
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
  }
  .mobile-filter-btn svg { width: 16px; height: 16px; }

  /* FOOTER */
  footer { background: #1d1d1f; padding: 40px 24px 0; margin-top: 8px; }
  .footer-bottom { padding: 20px 0; display: flex; justify-content: space-between; align-items: center; border-top: 0.5px solid rgba(255,255,255,0.1); }
  .footer-bottom span { font-size: 12px; color: #515154; }
  .footer-legal { display: flex; gap: 20px; }
  .footer-legal a { font-size: 12px; color: #515154; }
  .footer-legal a:hover { color: #86868b; }

  @media (max-width: 900px) {
    .shop-layout { grid-template-columns: 1fr; }
    .sidebar { display: none; position: fixed; bottom: 0; left: 0; right: 0; z-index: 300; top: 0; background: rgba(0,0,0,0.5); }
    .sidebar.open { display: flex; flex-direction: column; justify-content: flex-end; }
    .sidebar-inner { background: var(--white); border-radius: 24px 24px 0 0; padding: 24px; max-height: 80vh; overflow-y: auto; }
    .mobile-filter-btn { display: flex; }
    .products-grid { grid-template-columns: repeat(2, 1fr); }
  }
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
        <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
          {{ $cat->name }}
        </option>
      @endforeach
    </select>
    <input type="text" name="q" placeholder="Search for products, brands and more…" value="{{ request('q') }}">
    <button type="submit">Search</button>
  </form>

  <div class="topnav-actions">
    @auth
      <a href="{{ route('account') }}" class="action-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Account
      </a>
    @else
      <a href="{{ route('login') }}" class="action-btn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Sign In
      </a>
    @endauth

    <a href="#" class="action-btn">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
      Wishlist
    </a>

    <a href="{{ route('cart') }}" class="action-btn" style="position:relative">
      <div style="position:relative">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        <span class="cart-badge">0</span>
      </div>
      Cart
    </a>
  </div>
</nav>

{{-- CATEGORY NAV --}}
<nav class="catnav">
  <a href="{{ route('home') }}">Home</a>
  @foreach($categories as $cat)
    <a href="{{ route('categories.show', $cat->slug) }}"
       class="{{ request('category') === $cat->slug ? 'active' : '' }}">
      {{ $cat->name }}
    </a>
  @endforeach
  <a href="{{ route('products.index') }}"
     class="{{ !request()->anyFilled(['category','brand','q']) ? 'active' : '' }}"
     style="color:#ff6b00; font-weight:500;">⚡ Flash Deals</a>
</nav>

{{-- PAGE HEADER --}}
<div class="page-header">
  <div class="page-header-inner">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
      <span style="color:rgba(255,255,255,0.85)">
        @if(request('q'))
          Search: "{{ request('q') }}"
        @elseif(isset($currentCategory))
          {{ $currentCategory->name }}
        @elseif(isset($currentBrand))
          {{ $currentBrand->name }}
        @else
          All Products
        @endif
      </span>
    </div>
    <h1 class="page-title">
      @if(request('q'))
        Results for "{{ request('q') }}"
      @elseif(isset($currentCategory))
        {{ $currentCategory->name }}
      @elseif(isset($currentBrand))
        {{ $currentBrand->name }}
      @else
        All Products
      @endif
    </h1>
    <p class="page-sub">Discover millions of products from trusted sellers worldwide</p>
    <div class="page-header-meta">
      <div class="meta-tag">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
        <span>{{ $products->total() }} products</span>
      </div>
      <div class="meta-tag">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
        Free shipping on orders over 5,000 FCFA
      </div>
    </div>
  </div>
</div>

{{-- MAIN LAYOUT --}}
<div class="shop-layout">

  {{-- SIDEBAR --}}
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-inner" id="sidebarInner">

      {{-- Active filters display --}}
      @if(request()->anyFilled(['category', 'brand', 'min_price', 'max_price', 'q']))
        <div style="margin-bottom:12px;">
          <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:8px;">
            <span style="font-size:12px; font-weight:600; color:var(--ink);">Active Filters</span>
            <a href="{{ route('products.index') }}" style="font-size:12px; color:var(--blue);">Clear all</a>
          </div>
          <div class="active-filters">
            @if(request('q'))
              <a href="{{ route('products.index', array_except(request()->all(), ['q'])) }}" class="active-filter">
                "{{ request('q') }}"
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              </a>
            @endif
            @if(request('category'))
              <a href="{{ route('products.index', array_except(request()->all(), ['category'])) }}" class="active-filter">
                {{ request('category') }}
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              </a>
            @endif
            @if(request('brand'))
              <a href="{{ route('products.index', array_except(request()->all(), ['brand'])) }}" class="active-filter">
                {{ request('brand') }}
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              </a>
            @endif
          </div>
        </div>
      @endif

      {{-- Categories filter --}}
      <div class="filter-card">
        <div class="filter-header open" onclick="toggleFilter(this)">
          <h3>Categories</h3>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="18 15 12 9 6 15"/></svg>
        </div>
        <div class="filter-body">
          <div class="filter-search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" placeholder="Search categories…" oninput="filterList(this, 'categoryFilters')">
          </div>
          <div id="categoryFilters">
            @foreach($categories as $cat)
              <a href="{{ route('products.index', array_merge(request()->except('category', 'page'), ['category' => $cat->slug])) }}"
                 class="filter-option {{ request('category') === $cat->slug ? 'checked' : '' }}"
                 style="text-decoration:none;">
                <div class="check-box"></div>
                <label style="cursor:pointer;">{{ $cat->name }}</label>
                <span class="filter-count">{{ $cat->products_count ?? 0 }}</span>
              </a>
            @endforeach
          </div>
        </div>
      </div>

      {{-- Price Range --}}
      <form action="{{ route('products.index') }}" method="GET" id="priceForm">
        @foreach(request()->except(['min_price','max_price','page']) as $key => $val)
          <input type="hidden" name="{{ $key }}" value="{{ $val }}">
        @endforeach
        <div class="filter-card">
          <div class="filter-header open" onclick="toggleFilter(this)">
            <h3>Price Range</h3>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="18 15 12 9 6 15"/></svg>
          </div>
          <div class="filter-body">
            <div class="price-range-wrap">
              <div class="price-inputs">
                <input class="price-input" type="number" name="min_price" placeholder="Min" value="{{ request('min_price', 0) }}">
                <input class="price-input" type="number" name="max_price" placeholder="Max" id="priceMax" value="{{ request('max_price', 500000) }}">
              </div>
              <input type="range" class="range-slider" min="0" max="500000"
                     value="{{ request('max_price', 500000) }}"
                     oninput="document.getElementById('priceMax').value=this.value">
              <button type="submit" style="width:100%; margin-top:10px; background:var(--blue); color:#fff; border-radius:8px; padding:8px; font-size:13px; font-weight:500; border:none; cursor:pointer;">Apply</button>
            </div>
          </div>
        </div>
      </form>

      {{-- Brands filter --}}
      <div class="filter-card">
        <div class="filter-header open" onclick="toggleFilter(this)">
          <h3>Brands</h3>
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="18 15 12 9 6 15"/></svg>
        </div>
        <div class="filter-body">
          <div class="filter-search">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" placeholder="Search brands…" oninput="filterList(this, 'brandFilters')">
          </div>
          <div id="brandFilters">
            @foreach($brands as $brand)
              <a href="{{ route('products.index', array_merge(request()->except('brand', 'page'), ['brand' => $brand->slug])) }}"
                 class="filter-option {{ request('brand') === $brand->slug ? 'checked' : '' }}"
                 style="text-decoration:none;">
                <div class="check-box"></div>
                <label style="cursor:pointer;">{{ $brand->name }}</label>
                <span class="filter-count">{{ $brand->products_count ?? 0 }}</span>
              </a>
            @endforeach
          </div>
        </div>
      </div>

    </div>
  </aside>

  {{-- PRODUCTS AREA --}}
  <main class="products-area">

    {{-- Promo Strip --}}
    <div class="promo-strip">
      <div class="promo-strip-text">
        <strong>⚡ Flash Sale — Up to 70% Off!</strong>
        <span>Limited time deals. Don't miss out.</span>
      </div>
      <a href="{{ route('products.index') }}" class="promo-strip-btn">Shop Deals</a>
    </div>

    {{-- Toolbar --}}
    <form action="{{ route('products.index') }}" method="GET" id="sortForm">
      @foreach(request()->except(['sort', 'page']) as $key => $val)
        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
      @endforeach
      <div class="toolbar">
        <span class="results-count">
          Showing <strong>{{ $products->firstItem() }}–{{ $products->lastItem() }}</strong>
          of <strong>{{ $products->total() }}</strong> products
        </span>
        <select class="sort-select" name="sort" onchange="document.getElementById('sortForm').submit()">
          <option value="popular"     {{ request('sort','popular') === 'popular'     ? 'selected' : '' }}>Most Popular</option>
          <option value="newest"      {{ request('sort') === 'newest'      ? 'selected' : '' }}>Newest First</option>
          <option value="price-asc"   {{ request('sort') === 'price-asc'   ? 'selected' : '' }}>Price: Low to High</option>
          <option value="price-desc"  {{ request('sort') === 'price-desc'  ? 'selected' : '' }}>Price: High to Low</option>
          <option value="rating"      {{ request('sort') === 'rating'      ? 'selected' : '' }}>Top Rated</option>
          <option value="discount"    {{ request('sort') === 'discount'    ? 'selected' : '' }}>Biggest Discount</option>
        </select>
        <div class="view-toggle">
          <button type="button" class="view-btn active" id="gridViewBtn" onclick="setView('grid')" title="Grid view">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
          </button>
          <button type="button" class="view-btn" id="listViewBtn" onclick="setView('list')" title="List view">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
          </button>
        </div>
      </div>
    </form>

    {{-- Products grid --}}
    <div class="grid grid-cols-3 gap-4">
      @forelse($products as $product)
        @php
          $img      = $product->getFirstMediaUrl('thumbnail') ?: $product->getFirstMediaUrl('uploads');
          $price    = $product->prices->first()->amount ?? 0;
          $compare  = $product->prices->first()->compare_amount ?? 0;
          $pct      = $compare > 0 ? round((1 - $price / $compare) * 100) : 0;
          $isNew    = $product->created_at->diffInDays(now()) <= 14;
        @endphp

        <a href="{{ route('products.show', $product->slug) }}" class="product-card">
          <div class="card-img">
            @if($img)
              <img src="{{ $img }}" alt="{{ $product->name }}" loading="lazy">
            @else
              <div class="card-img-placeholder">🛍️</div>
            @endif

            @if($pct > 0)
              <span class="card-badge badge-sale">-{{ $pct }}%</span>
            @elseif($isNew)
              <span class="card-badge badge-new">New</span>
            @endif

            <div class="card-wishlist">
              <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
            </div>

            <div class="card-actions">
              <button type="button" onclick="event.preventDefault()">Quick View</button>
              <button type="button" class="add-cart-btn" onclick="addToCart(event, {{ $product->id }})">Add to Cart</button>
            </div>
          </div>

          <div class="card-body">
            <div class="card-brand">{{ $product->brand->name ?? '' }}</div>
            <div class="card-name">{{ $product->name }}</div>
            <div class="card-price">
              @if($price > 0)
                <span class="price-now">{{ number_format($price) }} FCFA</span>
                @if($compare > 0)
                  <span class="price-old">{{ number_format($compare) }} FCFA</span>
                  <span class="price-save">-{{ $pct }}%</span>
                @endif
              @else
                <span class="price-no-stock">Price not set</span>
              @endif
            </div>
          </div>
        </a>

      @empty
        <div class="empty-state">
          <div class="empty-state-icon">🔍</div>
          <h3>No products found</h3>
          <p>Try adjusting your filters or search term.</p>
        </div>
      @endforelse
    </div>

    {{-- Pagination links go here, outside the loop --}}
    {{ $products->links() }}

  </main>
</div>

{{-- MOBILE FILTER BUTTON --}}
<button class="mobile-filter-btn" id="mobileFilterBtn" onclick="toggleMobileFilters()">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="6" x2="20" y2="6"/><line x1="8" y1="12" x2="16" y2="12"/><line x1="11" y1="18" x2="13" y2="18"/></svg>
  Filters & Sort
</button>

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
  // View toggle
  function setView(v) {
    const grid = document.getElementById('productsGrid');
    const gBtn = document.getElementById('gridViewBtn');
    const lBtn = document.getElementById('listViewBtn');
    if (v === 'list') {
      grid.classList.add('list-view');
      lBtn.classList.add('active'); gBtn.classList.remove('active');
    } else {
      grid.classList.remove('list-view');
      gBtn.classList.add('active'); lBtn.classList.remove('active');
    }
  }

  // Filter accordion toggle
  function toggleFilter(header) {
    const body = header.nextElementSibling;
    const isOpen = header.classList.contains('open');
    header.classList.toggle('open');
    body.style.display = isOpen ? 'none' : '';
  }

  // Live search within filter lists
  function filterList(input, listId) {
    const q = input.value.toLowerCase();
    document.querySelectorAll(`#${listId} .filter-option`).forEach(opt => {
      const label = opt.querySelector('label').textContent.toLowerCase();
      opt.style.display = label.includes(q) ? '' : 'none';
    });
  }

  // Add to cart (hook up to your real cart logic)
  function addToCart(e, productId) {
    e.preventDefault();
    e.stopPropagation();
    const btn = e.target;
    const orig = btn.textContent;
    btn.textContent = '✓ Added!';
    btn.style.background = 'var(--green)';
    // TODO: POST to your cart route, e.g.:
    // fetch('/cart/add', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}, body: JSON.stringify({product_id: productId, quantity: 1}) })
    setTimeout(() => { btn.textContent = orig; btn.style.background = ''; }, 1400);
  }

  // Wishlist toggle
  document.querySelectorAll('.card-wishlist').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault(); e.stopPropagation();
      this.classList.toggle('active');
      this.querySelector('svg').style.stroke = this.classList.contains('active') ? 'var(--red)' : 'var(--muted)';
      this.querySelector('svg').style.fill   = this.classList.contains('active') ? 'var(--red)' : 'none';
    });
  });

  // Mobile filter drawer
  function toggleMobileFilters() {
    document.getElementById('sidebar').classList.toggle('open');
  }
  document.getElementById('sidebar').addEventListener('click', function(e) {
    if (e.target === this) this.classList.remove('open');
  });
</script>
</body>
</html>