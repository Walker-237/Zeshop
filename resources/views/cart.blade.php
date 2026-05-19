<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart — ZeShop</title>
    <link rel="icon" type="image/x-icon" href="/cpanel/images/favicons/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="/cpanel/images/favicons/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/cpanel/images/favicons/favicon-32x32.png">
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
        body { font-family: var(--sans); background: var(--off); color: var(--ink); font-size: 14px; }
        a { text-decoration: none; color: inherit; }
        img { display: block; width: 100%; }
        button { border: none; cursor: pointer; font-family: var(--sans); }

        .cart-item {
            background: var(--white); border: 0.5px solid var(--border);
            border-radius: 16px; padding: 16px; display: flex; gap: 16px;
            margin-bottom: 16px;
        }
        .cart-item img { width: 110px; height: 110px; object-fit: cover; border-radius: 12px; flex-shrink: 0; }

        .empty-state { text-align: center; padding: 80px 20px; }
        .empty-state h2 { font-size: 28px; margin-bottom: 12px; }
        .empty-state p { color: var(--muted); margin-bottom: 30px; }

        .btn-primary {
            background: var(--blue); color: white; padding: 14px 32px;
            border-radius: 30px; font-weight: 600; text-align: center;
            display: inline-block;
        }
        .btn-primary:hover { opacity: 0.9; }

        .cart-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 40px; }
        .order-summary {
            background: var(--white); border: 0.5px solid var(--border);
            border-radius: 16px; padding: 24px; height: fit-content;
        }
        .order-summary h2 { font-size: 20px; font-weight: 600; margin-bottom: 16px; }
        .summary-row { display: flex; justify-content: space-between; margin: 12px 0; }
        .summary-total { font-size: 18px; font-weight: 700; margin-top: 20px; }

        @media (max-width: 768px) {
            .cart-grid { grid-template-columns: 1fr; }
        }

        /* ── LOGIN PROMPT MODAL ── */
        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.45);
            backdrop-filter: blur(4px);
            z-index: 999;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.open { display: flex; }
        .modal {
            background: var(--white);
            border-radius: 24px;
            padding: 40px 32px;
            width: 100%;
            max-width: 380px;
            margin: 16px;
            text-align: center;
            position: relative;
            animation: slideUp 0.25s ease;
        }
        @keyframes slideUp {
            from { transform: translateY(30px); opacity: 0; }
            to   { transform: translateY(0);    opacity: 1; }
        }
        .modal-close {
            position: absolute; top: 14px; right: 16px;
            background: var(--pale); border: none; border-radius: 50%;
            width: 30px; height: 30px; font-size: 16px; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--muted);
        }
        .modal-close:hover { background: var(--border); }
        .modal .lock { font-size: 44px; margin-bottom: 14px; }
        .modal h2 { font-size: 20px; font-weight: 700; margin-bottom: 8px; }
        .modal p  { color: var(--muted); font-size: 13px; margin-bottom: 28px; line-height: 1.6; }
        .modal-actions { display: flex; flex-direction: column; gap: 10px; }
        .modal-actions a.btn-login {
            display: block; background: var(--blue); color: white;
            padding: 13px; border-radius: 12px; font-weight: 600; font-size: 14px;
        }
        .modal-actions a.btn-login:hover { opacity: 0.88; }
        .modal-actions a.btn-register {
            display: block; background: var(--pale); color: var(--ink);
            padding: 13px; border-radius: 12px; font-weight: 500; font-size: 14px;
            border: 1px solid var(--border);
        }
        .modal-actions a.btn-register:hover { background: var(--border); }
        .modal-actions .btn-cancel {
            background: none; color: var(--muted); font-size: 13px;
            padding: 8px; cursor: pointer;
        }
        .modal-actions .btn-cancel:hover { color: var(--ink); }
    </style>
</head>
<body>

@include('components.header')

<div style="max-width:1200px; margin:40px auto; padding:0 24px;">
    <h1 style="font-size:32px; font-weight:700; margin-bottom:24px;">Your Cart</h1>

    {{-- Empty state --}}
    <div id="empty-state" class="empty-state" style="display:none;">
        <h2>Your cart is empty</h2>
        <p>Looks like you haven't added anything yet.</p>
        <a href="{{ route('products.index') }}" class="btn-primary">Start Shopping</a>
    </div>

    {{-- Cart grid --}}
    <div id="cart-grid" class="cart-grid" style="display:none;">
        <div>
            <div id="cart-items-container"></div>
        </div>

        <div class="order-summary">
            <h2>Order Summary</h2>

            <div class="summary-row">
                <span style="color:var(--muted);">Subtotal</span>
                <span id="subtotal" style="font-weight:600;">0 FCFA</span>
            </div>
            <div class="summary-row">
                <span style="color:var(--muted);">Shipping</span>
                <span style="color:var(--green); font-weight:500;">Free</span>
            </div>

            <hr style="margin:20px 0; border:none; border-top:1px solid var(--border);">

            <div class="summary-total">
                <div style="display:flex; justify-content:space-between;">
                    <span>Total</span>
                    <span id="total">0 FCFA</span>
                </div>
            </div>

            <button onclick="handleCheckout()"
                style="display:block; width:100%; background:var(--blue); color:white;
                       text-align:center; padding:14px; border-radius:12px; margin-top:30px;
                       font-weight:600; font-size:15px; border:none; cursor:pointer;">
                Proceed to Checkout
            </button>

            <a href="{{ route('products.index') }}"
               style="display:block; text-align:center; padding:12px; margin-top:12px;
                      color:var(--blue); font-weight:500;">
                Continue Shopping
            </a>
        </div>
    </div>
</div>

{{-- ── LOGIN PROMPT MODAL (rendered for guests only) ── --}}
@guest
<div class="modal-overlay" id="loginModal">
    <div class="modal">
        <button class="modal-close" onclick="closeModal()">✕</button>
        <div class="lock">🔒</div>
        <h2>Sign in to Checkout</h2>
        <p>You need an account to complete your purchase.<br>Your cart will be saved.</p>
        <div class="modal-actions">
            <a href="{{ route('login') }}" class="btn-login">Sign In</a>
            <a href="{{ route('register') }}" class="btn-register">Create an Account</a>
            <button class="btn-cancel" onclick="closeModal()">Continue Shopping</button>
        </div>
    </div>
</div>
@endguest

<script>
    // Auth status passed from Laravel
    const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};

    document.addEventListener('DOMContentLoaded', function () {
        const cart       = JSON.parse(localStorage.getItem('cart') || '[]');
        const container  = document.getElementById('cart-items-container');
        const emptyState = document.getElementById('empty-state');
        const cartGrid   = document.getElementById('cart-grid');

        if (cart.length === 0) {
            emptyState.style.display = 'block';
            return;
        }

        cartGrid.style.display = 'grid';

        let total = 0;
        cart.forEach((item, index) => {
            total += item.price * item.quantity;
            container.innerHTML += `
                <div class="cart-item">
                    <img src="${item.image ?? 'https://via.placeholder.com/110'}" alt="${item.name}"
                         style="width:110px;height:110px;object-fit:cover;border-radius:12px;flex-shrink:0;">
                    <div style="flex:1;">
                        <a href="/products/${item.slug}"
                           style="font-weight:600;font-size:15px;display:block;margin-bottom:4px;">
                           ${item.name}
                        </a>
                        <p style="color:var(--muted);margin:4px 0;">${item.price.toLocaleString()} FCFA</p>
                        <input type="number" value="${item.quantity}" min="1"
                            style="width:70px;padding:6px;border:1px solid var(--border);border-radius:8px;
                                   text-align:center;margin-top:12px;"
                            onchange="updateQty(${index}, this.value)">
                    </div>
                    <div style="text-align:right;">
                        <p style="font-weight:700;font-size:16px;">
                            ${(item.price * item.quantity).toLocaleString()} FCFA
                        </p>
                        <button onclick="removeItem(${index})"
                            style="color:var(--red);background:none;font-size:14px;
                                   font-weight:500;margin-top:20px;cursor:pointer;">
                            Remove
                        </button>
                    </div>
                </div>`;
        });

        document.getElementById('subtotal').textContent = total.toLocaleString() + ' FCFA';
        document.getElementById('total').textContent    = total.toLocaleString() + ' FCFA';
    });

    // ── Checkout button: sync cart to session and redirect if logged in, show modal if guest
    async function handleCheckout() {
        if (isAuthenticated) {
            const cart = JSON.parse(localStorage.getItem('cart') || '[]');

            await fetch('{{ route('cart.sync') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ items: cart }),
            });

            window.location.href = '{{ route('checkout') }}';
        } else {
            document.getElementById('loginModal').classList.add('open');
        }
    }

    // ── Close modal
    function closeModal() {
        document.getElementById('loginModal').classList.remove('open');
    }

    // Close on overlay click
    document.getElementById('loginModal')?.addEventListener('click', function (e) {
        if (e.target === this) closeModal();
    });

    // ── Cart actions
    function updateQty(index, qty) {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        cart[index].quantity = Math.max(1, parseInt(qty));
        localStorage.setItem('cart', JSON.stringify(cart));
        location.reload();
    }

    function removeItem(index) {
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        location.reload();
    }
</script>

</body>
</html>