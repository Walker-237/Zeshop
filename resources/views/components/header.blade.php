{{--
    ZeShop Header Partial
    Usage: @include('components.header')
    Requires: $categories (Collection) to be available in the view
--}}

<style>
/* hide elements until Alpine boots */
[x-cloak] { display: none !important; }

.ze-announce {
    background: var(--navy);
    color: #a8c8f0;
    text-align: center;
    font-size: 12px;
    padding: 8px 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.ze-announce span { color: var(--gold); font-weight: 500; }
.ze-announce a { color: #6aaee0; text-decoration: underline; margin-left: 4px; }

.ze-topnav {
    background: rgba(255,255,255,0.88);
    backdrop-filter: saturate(180%) blur(20px);
    -webkit-backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 0.5px solid var(--border);
    padding: 0 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    height: 60px;
    position: sticky;
    top: 0;
    z-index: 200;
}

.ze-logo {
    font-size: 24px;
    font-weight: 700;
    color: var(--ink);
    white-space: nowrap;
    letter-spacing: -0.5px;
    text-decoration: none;
    flex-shrink: 0;
}
.ze-logo span { color: var(--blue); }

.ze-search {
    flex: 1;
    display: flex;
    max-width: 560px;
    background: var(--pale);
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid transparent;
    transition: border-color 0.2s, background 0.2s;
}
.ze-search:focus-within { border-color: var(--blue); background: var(--white); }
.ze-search select {
    border: none;
    border-right: 0.5px solid var(--border);
    background: transparent;
    color: var(--ink);
    font-family: var(--sans);
    font-size: 13px;
    padding: 0 10px;
    width: 130px;
    cursor: pointer;
    outline: none;
}
.ze-search input {
    flex: 1;
    border: none;
    padding: 0 14px;
    font-family: var(--sans);
    font-size: 14px;
    outline: none;
    color: var(--ink);
    background: transparent;
    min-width: 0;
}
.ze-search input::placeholder { color: var(--muted); }
.ze-search button {
    background: var(--blue);
    color: #fff;
    padding: 0 18px;
    font-size: 13px;
    font-weight: 500;
    border: none;
    border-radius: 0 9px 9px 0;
    cursor: pointer;
    transition: background 0.2s;
    white-space: nowrap;
}
.ze-search button:hover { background: #0062c4; }

.ze-actions {
    display: flex;
    align-items: center;
    gap: 4px;
    margin-left: auto;
    flex-shrink: 0;
}

.ze-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
    font-size: 10px;
    font-weight: 400;
    color: var(--muted);
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px 10px;
    border-radius: 8px;
    text-decoration: none;
    transition: color 0.2s, background 0.2s;
    white-space: nowrap;
}
.ze-btn:hover { color: var(--blue); background: var(--pale); }
.ze-btn svg { width: 20px; height: 20px; flex-shrink: 0; }

/* Cart button */
.ze-cart-btn { position: relative; }
.ze-cart-icon-wrap { position: relative; display: inline-flex; }
.ze-cart-badge {
    position: absolute;
    top: -4px;
    right: -6px;
    background: var(--red);
    color: #fff;
    font-size: 9px;
    font-weight: 700;
    min-width: 16px;
    height: 16px;
    border-radius: 8px;
    padding: 0 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1.5px solid var(--white);
    line-height: 1;
    transition: transform 0.2s ease, background 0.2s ease;
}

/* Badge pop animation */
@keyframes badgePop {
    0%   { transform: scale(1); }
    40%  { transform: scale(1.5); }
    100% { transform: scale(1); }
}
.ze-cart-badge.pop { animation: badgePop 0.3s ease forwards; }

/* Divider */
.ze-nav-divider {
    width: 0.5px;
    height: 28px;
    background: var(--border);
    margin: 0 4px;
    flex-shrink: 0;
}

/* User avatar pill */
.ze-user-pill {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 5px 12px 5px 6px;
    border-radius: 22px;
    border: 0.5px solid var(--border);
    background: var(--pale);
    color: var(--ink);
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
    font-family: var(--sans);
}
.ze-user-pill:hover { border-color: var(--blue); color: var(--blue); background: #e8f2fd; }

.ze-avatar {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: var(--blue);
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    letter-spacing: 0;
}

/* Category nav */
.ze-catnav {
    background: rgba(255,255,255,0.92);
    backdrop-filter: saturate(180%) blur(20px);
    border-bottom: 0.5px solid var(--border);
    padding: 0 24px;
    display: flex;
    align-items: center;
    overflow-x: auto;
    scrollbar-width: none;
    position: sticky;
    top: 60px;
    z-index: 190;
}
.ze-catnav::-webkit-scrollbar { display: none; }
.ze-catnav a {
    color: var(--muted);
    font-size: 13px;
    font-weight: 400;
    padding: 12px 16px;
    white-space: nowrap;
    border-bottom: 2px solid transparent;
    transition: all 0.2s;
    text-decoration: none;
    flex-shrink: 0;
}
.ze-catnav a:hover { color: var(--ink); }
.ze-catnav a.active { color: var(--blue); border-bottom-color: var(--blue); font-weight: 500; }
.ze-catnav a.flash { color: #d4620a; font-weight: 500; }
.ze-catnav a.flash:hover { color: #b05208; }
</style>

{{-- ANNOUNCEMENT BAR --}}
<div class="ze-announce">
    🎉 Welcome to ZeShop — New users get <span>15% off</span> their first order!
    <a href="{{ route('products.index') }}">Shop now →</a>
</div>

{{-- TOP NAV --}}
<nav class="ze-topnav">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="ze-logo">Ze<span>Shop</span></a>

    {{-- Search --}}
    <form action="{{ route('products.index') }}" method="GET" class="ze-search">
        <select name="category" aria-label="Category">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
        <input
            type="text"
            name="q"
            placeholder="Search products, brands…"
            value="{{ request('q') }}"
            aria-label="Search"
        >
        <button type="submit" aria-label="Search">Search</button>
    </form>

    {{-- Action buttons --}}
    <div class="ze-actions">

        @auth
            {{-- ── LOGGED IN STATE ── --}}

            {{-- Wishlist --}}
            <a href="{{ route('wishlist') }}" class="ze-btn" title="Wishlist">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                </svg>
                Wishlist
            </a>

            {{-- Orders --}}
            <a href="{{ route('account') }}" class="ze-btn" title="My Orders">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="1"/>
                    <path d="M9 12h6M9 16h4"/>
                </svg>
                Orders
            </a>

            {{-- Cart --}}
            <a href="{{ route('cart') }}" class="ze-btn ze-cart-btn" title="Cart">
                <div class="ze-cart-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 01-8 0"/>
                    </svg>
                    <span class="ze-cart-badge" id="cartBadge">0</span>
                </div>
                Cart
            </a>

            <div class="ze-nav-divider" aria-hidden="true"></div>

            {{-- ── USER PILL WITH DROPDOWN ── --}}
            <div style="position:relative;" x-data="{ open: false }">

                <button @click="open = !open" class="ze-user-pill" title="My Account">
                    <div class="ze-avatar" aria-hidden="true">
                        {{ strtoupper(substr(auth()->user()->first_name ?? auth()->user()->name ?? 'U', 0, 1)) }}{{ strtoupper(substr(auth()->user()->last_name ?? '', 0, 1)) }}
                    </div>
                    {{ auth()->user()->first_name ?? auth()->user()->name ?? 'Account' }}
                    <svg style="width:12px;height:12px;margin-left:2px;transition:transform 0.2s;" :style="open ? 'transform:rotate(180deg)' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </button>

                {{-- Dropdown --}}
                <div
                    x-cloak
                    x-show="open"
                    @click.outside="open = false"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    style="
                        position: absolute;
                        top: calc(100% + 10px);
                        right: 0;
                        background: #fff;
                        border: 0.5px solid var(--border);
                        border-radius: 14px;
                        box-shadow: 0 12px 40px rgba(0,0,0,0.12);
                        min-width: 200px;
                        overflow: hidden;
                        z-index: 999;
                    "
                >
                    {{-- User info header --}}
                    <div style="padding:14px 16px; border-bottom:0.5px solid var(--border); background:var(--pale);">
                        <div style="font-size:13px; font-weight:600; color:var(--ink);">
                            {{ auth()->user()->first_name ?? auth()->user()->name }} {{ auth()->user()->last_name ?? '' }}
                        </div>
                        <div style="font-size:11px; color:var(--muted); margin-top:2px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                            {{ auth()->user()->email }}
                        </div>
                    </div>

                    {{-- My Account --}}
                    <a href="{{ route('account') }}" style="
                        display:flex; align-items:center; gap:10px;
                        padding:11px 16px; font-size:13px; color:var(--ink);
                        text-decoration:none; transition:background 0.15s;
                    "
                    onmouseover="this.style.background='var(--pale)'"
                    onmouseout="this.style.background=''"
                    >
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        My Account
                    </a>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="
                            display:flex; align-items:center; gap:10px;
                            padding:11px 16px; font-size:13px; color:var(--red);
                            background:none; border:none; width:100%; cursor:pointer;
                            text-align:left; transition:background 0.15s;
                            border-top:0.5px solid var(--border);
                            font-family:var(--sans);
                        "
                        onmouseover="this.style.background='#fff0ef'"
                        onmouseout="this.style.background=''"
                        >
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>

        @else
            {{-- ── GUEST STATE ── --}}

            {{-- Wishlist --}}
            <a href="{{ route('wishlist') }}" class="ze-btn" title="Wishlist">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                </svg>
                Wishlist
            </a>

            {{-- Cart --}}
            <a href="{{ route('cart') }}" class="ze-btn ze-cart-btn" title="Cart">
                <div class="ze-cart-icon-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                        <line x1="3" y1="6" x2="21" y2="6"/>
                        <path d="M16 10a4 4 0 01-8 0"/>
                    </svg>
                    <span class="ze-cart-badge" id="cartBadge">0</span>
                </div>
                Cart
            </a>

            <div class="ze-nav-divider" aria-hidden="true"></div>

            {{-- Sign In --}}
            <a href="{{ route('login') }}" class="ze-btn" title="Sign In">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Sign In
            </a>

            {{-- Register --}}
            <a href="{{ route('register') }}" class="ze-btn" title="Register">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                    <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                    <line x1="19" y1="8" x2="19" y2="14"/>
                    <line x1="22" y1="11" x2="16" y2="11"/>
                </svg>
                Register
            </a>

        @endauth
    </div>
</nav>

{{-- CATEGORY NAV --}}
<nav class="ze-catnav" aria-label="Product categories">
    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
    @foreach($categories as $cat)
        <a
            href="{{ route('categories.show', $cat->slug) }}"
            class="{{ request()->routeIs('categories.show') && request()->route('slug') === $cat->slug ? 'active' : '' }}"
        >
            {{ $cat->name }}
        </a>
    @endforeach
    <a href="{{ route('products.index') }}" class="flash">⚡ Flash Deals</a>
</nav>

<script defer src="https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js"></script>

{{-- ── CART BADGE SCRIPT ── --}}
<script>
(function () {
    function getCartCount() {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        return cart.reduce((sum, item) => sum + (parseInt(item.quantity) || 0), 0);
    }

    function updateBadge(animate) {
        const badge = document.getElementById('cartBadge');
        if (!badge) return;
        const count = getCartCount();
        badge.textContent = count;
        badge.style.display = count === 0 ? 'none' : 'flex';
        if (animate) {
            badge.classList.remove('pop');
            void badge.offsetWidth;
            badge.classList.add('pop');
        }
    }

    document.addEventListener('DOMContentLoaded', () => updateBadge(false));
    window.addEventListener('storage', (e) => { if (e.key === 'cart') updateBadge(true); });
    window.updateCartBadge = () => updateBadge(true);
})();
</script>