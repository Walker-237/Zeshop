<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout — ZeShop</title>
    <link rel="icon" type="image/x-icon" href="/cpanel/images/favicons/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <meta name="theme-color" content="#0b2240">

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --ink: #1d1d1f; --navy: #0b2240; --blue: #0071e3;
            --pale: #f5f5f7; --white: #ffffff; --off: #f7f4f0;
            --muted: #6e6e73; --border: #d2d2d7;
            --gold: #d4a843; --red: #ff3b30; --green: #30d158;
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
        button { border: none; cursor: pointer; font-family: var(--sans); }
        img { display: block; }

        /* ── PAGE LAYOUT ── */
        .checkout-wrap {
            max-width: 1100px;
            margin: 0 auto;
            padding: 48px 24px 80px;
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 36px;
            align-items: start;
        }

        /* ── PAGE TITLE ── */
        .checkout-title {
            font-family: var(--serif);
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 28px;
            color: var(--navy);
        }
        .checkout-title span { color: var(--blue); font-style: italic; }

        /* ── SECTION CARD ── */
        .section-card {
            background: var(--white);
            border: 0.5px solid var(--border);
            border-radius: 20px;
            padding: 24px 28px;
            margin-bottom: 20px;
        }
        .section-card h3 {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--navy);
        }
        .section-card h3 .step-num {
            width: 24px; height: 24px;
            background: var(--navy);
            color: #fff;
            border-radius: 50%;
            font-size: 11px;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        /* ── FORM FIELDS ── */
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 14px; }
        .form-group:last-child { margin-bottom: 0; }
        .form-group label { font-size: 12px; font-weight: 500; color: var(--muted); }
        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 11px 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            font-family: var(--sans);
            color: var(--ink);
            background: var(--white);
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(0,113,227,0.08);
        }
        .form-group textarea { resize: vertical; min-height: 80px; }

        /* ── USER INFO PREFILLED BANNER ── */
        .prefilled-banner {
            background: linear-gradient(135deg, #e8f4ff, #f0f7ff);
            border: 1px solid #c0d8f8;
            border-radius: 12px;
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            font-size: 13px;
            color: var(--navy);
        }
        .prefilled-banner svg { flex-shrink: 0; color: var(--blue); }

        /* ── ORDER SUMMARY (RIGHT COLUMN) ── */
        .summary-sticky { position: sticky; top: 80px; }

        .order-card {
            background: var(--white);
            border: 0.5px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
        }
        .order-card-header {
            background: var(--navy);
            color: #fff;
            padding: 18px 24px;
            font-family: var(--serif);
            font-size: 18px;
            font-weight: 600;
        }
        .order-card-body { padding: 20px 24px; }

        .order-items { margin-bottom: 16px; }
        .order-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 0.5px solid var(--border);
        }
        .order-item:last-child { border-bottom: none; }
        .order-item img {
            width: 52px; height: 52px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
            background: var(--pale);
        }
        .order-item-info { flex: 1; min-width: 0; }
        .order-item-name {
            font-size: 13px; font-weight: 500;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .order-item-qty { font-size: 12px; color: var(--muted); margin-top: 2px; }
        .order-item-price { font-size: 13px; font-weight: 600; flex-shrink: 0; }

        .summary-rows { border-top: 1px solid var(--border); padding-top: 14px; }
        .summary-row {
            display: flex; justify-content: space-between;
            font-size: 13px; color: var(--muted); margin-bottom: 10px;
        }
        .summary-row.total {
            font-size: 17px; font-weight: 700; color: var(--ink);
            border-top: 1px solid var(--border);
            padding-top: 14px; margin-top: 4px;
        }
        .summary-row.total span:last-child { color: var(--blue); }

        .pay-now-btn {
            display: block; width: 100%;
            background: var(--blue);
            color: #fff;
            padding: 15px;
            border-radius: 14px;
            font-size: 15px; font-weight: 600;
            text-align: center;
            border: none; cursor: pointer;
            margin-top: 20px;
            transition: opacity 0.2s, transform 0.15s;
            letter-spacing: 0.2px;
        }
        .pay-now-btn:hover { opacity: 0.88; transform: translateY(-1px); }
        .pay-now-btn:active { transform: scale(0.98); }

        .secure-note {
            display: flex; align-items: center; justify-content: center;
            gap: 5px; margin-top: 12px;
            font-size: 11px; color: var(--muted);
        }

        /* ── PAYMENT MODAL ── */
        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(6px);
            z-index: 999;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.open { display: flex; }

        .modal {
            background: var(--white);
            border-radius: 24px;
            width: 100%;
            max-width: 460px;
            margin: 16px;
            overflow: hidden;
            animation: modalUp 0.3s cubic-bezier(0.34,1.56,0.64,1);
            position: relative;
        }
        @keyframes modalUp {
            from { transform: translateY(40px) scale(0.97); opacity: 0; }
            to   { transform: translateY(0) scale(1); opacity: 1; }
        }

        .modal-header {
            background: linear-gradient(135deg, #0b2240, #1a3a5c);
            padding: 24px 28px 20px;
            color: #fff;
            position: relative;
        }
        .modal-header h2 {
            font-family: var(--serif);
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 4px;
        }
        .modal-header p { font-size: 13px; color: rgba(255,255,255,0.6); }
        .modal-total-pill {
            display: inline-block;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            color: #f5c842;
            font-size: 16px; font-weight: 700;
            padding: 6px 16px;
            border-radius: 20px;
            margin-top: 14px;
        }
        .modal-close {
            position: absolute; top: 16px; right: 16px;
            width: 32px; height: 32px;
            background: rgba(255,255,255,0.12);
            border: none; border-radius: 50%;
            color: #fff; font-size: 16px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: background 0.2s;
        }
        .modal-close:hover { background: rgba(255,255,255,0.25); }

        .modal-body { padding: 24px 28px 28px; }

        /* ── PAYMENT METHODS ── */
        .methods-label { font-size: 12px; font-weight: 500; color: var(--muted); margin-bottom: 12px; letter-spacing: 0.5px; text-transform: uppercase; }
        .methods-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 20px; }

        .method-card {
            border: 1.5px solid var(--border);
            border-radius: 14px;
            padding: 14px 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s;
            background: var(--white);
            position: relative;
        }
        .method-card:hover { border-color: var(--blue); background: #f0f7ff; }
        .method-card.active { border-color: var(--blue); background: #e8f2fd; box-shadow: 0 0 0 3px rgba(0,113,227,0.1); }
        .method-card .check {
            position: absolute; top: 8px; right: 8px;
            width: 18px; height: 18px;
            background: var(--blue); border-radius: 50%;
            color: #fff; font-size: 10px;
            display: none; align-items: center; justify-content: center;
        }
        .method-card.active .check { display: flex; }

        .method-logo {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 26px;
        }
        .method-logo.om   { background: #fff3e0; }
        .method-logo.momo { background: #fffde7; }
        .method-logo.mc   { background: #fce4e4; }
        .method-logo.pp   { background: #e3f2fd; }

        .method-name { font-size: 12px; font-weight: 600; color: var(--ink); text-align: center; }
        .method-sub  { font-size: 10px; color: var(--muted); text-align: center; }

        /* ── PAYMENT FORMS ── */
        .pay-form { display: none; margin-bottom: 20px; }
        .pay-form.visible { display: block; animation: fadeIn 0.2s ease; }
        @keyframes fadeIn { from { opacity:0; transform:translateY(6px); } to { opacity:1; transform:translateY(0); } }

        .pay-form label { display: block; font-size: 12px; font-weight: 500; color: var(--muted); margin-bottom: 6px; }
        .pay-form input {
            width: 100%; padding: 11px 14px;
            border: 1px solid var(--border); border-radius: 10px;
            font-size: 14px; font-family: var(--sans);
            outline: none; margin-bottom: 12px;
            transition: border-color 0.2s, box-shadow 0.2s;
            color: var(--ink);
        }
        .pay-form input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(0,113,227,0.08); }
        .pay-form input:last-child { margin-bottom: 0; }
        .card-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .card-row .pay-form-group { display: flex; flex-direction: column; }
        .card-row label { display: block; font-size: 12px; font-weight: 500; color: var(--muted); margin-bottom: 6px; }
        .card-row input { margin-bottom: 0; }

        /* ── CONFIRM BUTTON ── */
        .confirm-btn {
            width: 100%; padding: 14px;
            background: var(--blue); color: #fff;
            border: none; border-radius: 14px;
            font-size: 15px; font-weight: 600;
            cursor: pointer; transition: opacity 0.2s, transform 0.15s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .confirm-btn:hover { opacity: 0.88; }
        .confirm-btn:disabled { opacity: 0.4; cursor: not-allowed; }
        .confirm-btn.loading { pointer-events: none; }

        /* Spinner */
        .spinner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }
        .confirm-btn.loading .spinner { display: block; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── SUCCESS STATE ── */
        .success-state {
            display: none;
            text-align: center;
            padding: 20px 0 8px;
            animation: fadeIn 0.3s ease;
        }
        .success-icon {
            width: 72px; height: 72px;
            background: linear-gradient(135deg, #30d158, #25a244);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 32px;
            margin: 0 auto 20px;
            box-shadow: 0 8px 24px rgba(48,209,88,0.3);
        }
        .success-state h3 {
            font-family: var(--serif);
            font-size: 22px; font-weight: 700;
            margin-bottom: 8px;
        }
        .success-state p { color: var(--muted); font-size: 14px; line-height: 1.6; margin-bottom: 24px; }
        .success-actions { display: flex; flex-direction: column; gap: 10px; }
        .btn-orders {
            display: block; background: var(--navy); color: #fff;
            padding: 13px; border-radius: 12px; font-weight: 600; font-size: 14px;
        }
        .btn-home {
            display: block; background: var(--pale); color: var(--ink);
            padding: 13px; border-radius: 12px; font-weight: 500; font-size: 14px;
            border: 1px solid var(--border);
        }

        /* ── EMPTY CART STATE ── */
        .empty-checkout {
            text-align: center; padding: 60px 20px;
            background: var(--white); border-radius: 20px;
            border: 0.5px solid var(--border);
        }
        .empty-checkout h2 { font-family: var(--serif); font-size: 24px; margin-bottom: 10px; }
        .empty-checkout p { color: var(--muted); margin-bottom: 24px; }
        .btn-shop {
            display: inline-block; background: var(--navy); color: #fff;
            padding: 13px 28px; border-radius: 30px; font-weight: 600;
        }

        @media (max-width: 768px) {
            .checkout-wrap { grid-template-columns: 1fr; }
            .summary-sticky { position: static; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

@include('components.header')

<div class="checkout-wrap">

    {{-- ── LEFT: DELIVERY INFO ── --}}
    <div>
        <h1 class="checkout-title">Check<span>out</span></h1>

        {{-- Prefilled info banner --}}
        <div class="prefilled-banner">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 8v4l2 2"/>
            </svg>
            Logged in as <strong style="margin-left:4px;">{{ auth()->user()->first_name ?? auth()->user()->name }} {{ auth()->user()->last_name ?? '' }}</strong>
            &nbsp;·&nbsp;
            <span style="color:var(--muted);">{{ auth()->user()->email }}</span>
        </div>

        {{-- 1. Delivery Info --}}
        <div class="section-card">
            <h3><span class="step-num">1</span> Delivery Information</h3>

            <div class="form-row">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" value="{{ auth()->user()->first_name ?? auth()->user()->name }}" placeholder="First name">
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" value="{{ auth()->user()->last_name ?? '' }}" placeholder="Last name">
                </div>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" placeholder="e.g. +237 699 000 000">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" value="{{ auth()->user()->email }}" placeholder="your@email.com">
            </div>

            <div class="form-group">
                <label>City</label>
                <input type="text" placeholder="e.g. Yaoundé, Douala…">
            </div>

            <div class="form-group">
                <label>Delivery Address</label>
                <input type="text" placeholder="Street, neighbourhood, landmark…">
            </div>

            <div class="form-group">
                <label>Order Notes (optional)</label>
                <textarea placeholder="Any special instructions for delivery?"></textarea>
            </div>
        </div>

        {{-- 2. Order Items Preview --}}
        <div class="section-card">
            <h3><span class="step-num">2</span> Your Items</h3>
            <div id="checkoutItems">
                <p style="color:var(--muted);font-size:13px;">Loading your cart…</p>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: ORDER SUMMARY ── --}}
    <div class="summary-sticky">
        <div class="order-card">
            <div class="order-card-header">Order Summary</div>
            <div class="order-card-body">

                <div class="order-items" id="summaryItems">
                    {{-- filled by JS --}}
                </div>

                <div class="summary-rows">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="summarySubtotal">0 FCFA</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span style="color:var(--green); font-weight:500;">Free</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span id="summaryTotal">0 FCFA</span>
                    </div>
                </div>

                <button class="pay-now-btn" onclick="openPaymentModal()">
                    🔒 &nbsp;Pay Now
                </button>

                <div class="secure-note">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                    </svg>
                    Secure & encrypted payment
                </div>
            </div>
        </div>

        <a href="{{ route('cart') }}" style="display:block;text-align:center;margin-top:16px;font-size:13px;color:var(--muted);">
            ← Back to Cart
        </a>
    </div>
</div>

{{-- ── PAYMENT MODAL ── --}}
<div class="modal-overlay" id="payModal">
    <div class="modal">

        {{-- Modal Header --}}
        <div class="modal-header">
            <button class="modal-close" onclick="closePayModal()">✕</button>
            <h2>Choose Payment</h2>
            <p>Select your preferred payment method</p>
            <div class="modal-total-pill" id="modalTotal">0 FCFA</div>
        </div>

        {{-- Modal Body --}}
        <div class="modal-body" id="modalBody">

            <div class="methods-label">Payment Methods</div>

            <div class="methods-grid">

                {{-- Orange Money --}}
                <div class="method-card" id="method-om" onclick="selectMethod('om')">
                    <div class="check">✓</div>
                    <div class="method-logo om">🟠</div>
                    <div class="method-name">Orange Money</div>
                    <div class="method-sub">OM · Cameroon</div>
                </div>

                {{-- MTN MoMo --}}
                <div class="method-card" id="method-momo" onclick="selectMethod('momo')">
                    <div class="check">✓</div>
                    <div class="method-logo momo">🟡</div>
                    <div class="method-name">MTN MoMo</div>
                    <div class="method-sub">Mobile Money</div>
                </div>

                {{-- Mastercard --}}
                <div class="method-card" id="method-mc" onclick="selectMethod('mc')">
                    <div class="check">✓</div>
                    <div class="method-logo mc">💳</div>
                    <div class="method-name">Mastercard</div>
                    <div class="method-sub">Credit / Debit</div>
                </div>

                {{-- PayPal --}}
                <div class="method-card" id="method-pp" onclick="selectMethod('pp')">
                    <div class="check">✓</div>
                    <div class="method-logo pp">🅿️</div>
                    <div class="method-name">PayPal</div>
                    <div class="method-sub">International</div>
                </div>
            </div>

            {{-- Orange Money Form --}}
            <div class="pay-form" id="form-om">
                <label>Orange Money Phone Number</label>
                <input type="tel" placeholder="e.g. 699 000 000" maxlength="15">
            </div>

            {{-- MTN MoMo Form --}}
            <div class="pay-form" id="form-momo">
                <label>MTN MoMo Phone Number</label>
                <input type="tel" placeholder="e.g. 670 000 000" maxlength="15">
            </div>

            {{-- Mastercard Form --}}
            <div class="pay-form" id="form-mc">
                <label>Card Number</label>
                <input type="text" placeholder="1234 5678 9012 3456" maxlength="19" id="cardNumber">
                <label>Cardholder Name</label>
                <input type="text" placeholder="John Doe">
                <div class="card-row">
                    <div class="pay-form-group">
                        <label>Expiry Date</label>
                        <input type="text" placeholder="MM/YY" maxlength="5">
                    </div>
                    <div class="pay-form-group">
                        <label>CVV</label>
                        <input type="text" placeholder="123" maxlength="4">
                    </div>
                </div>
            </div>

            {{-- PayPal Form --}}
            <div class="pay-form" id="form-pp">
                <label>PayPal Email Address</label>
                <input type="email" placeholder="you@example.com">
            </div>

            {{-- Confirm Button --}}
            <button class="confirm-btn" id="confirmBtn" onclick="confirmPayment()" disabled>
                <div class="spinner"></div>
                <span id="confirmText">Select a payment method</span>
            </button>

        </div>

        {{-- Success State --}}
        <div class="modal-body" id="successState" style="display:none;">
            <div class="success-state" style="display:block;">
                <div class="success-icon">✓</div>
                <h3>Payment Successful!</h3>
                <p>
                    Thank you, <strong>{{ auth()->user()->first_name ?? auth()->user()->name }}</strong>!<br>
                    Your order has been placed and is being processed.
                </p>
                <div class="success-actions">
                    <a href="{{ route('account') }}" class="btn-orders">View My Orders</a>
                    <a href="{{ route('home') }}" class="btn-home">Back to Home</a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const cart = @json($cart);
    const total = {{ $total }};

    if (cart.length === 0) {
        window.location.href = '{{ route('cart') }}';
        return;
    }

    const itemsHtml = cart.map(item => `
        <div style="display:flex;align-items:center;gap:10px;padding:8px 0;border-bottom:0.5px solid var(--border);">
            <img src="${item.image ?? 'https://via.placeholder.com/52'}"
                 style="width:52px;height:52px;border-radius:10px;object-fit:cover;flex-shrink:0;background:var(--pale);">
            <div style="flex:1;min-width:0;">
                <div style="font-size:13px;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${item.name}</div>
                <div style="font-size:12px;color:var(--muted);margin-top:2px;">Qty: ${item.quantity}</div>
            </div>
            <div style="font-size:13px;font-weight:600;flex-shrink:0;">${(item.price * item.quantity).toLocaleString()} FCFA</div>
        </div>`
    ).join('');

    document.getElementById('checkoutItems').innerHTML  = itemsHtml;
    document.getElementById('summaryItems').innerHTML   = itemsHtml;
    document.getElementById('summarySubtotal').textContent = total.toLocaleString() + ' FCFA';
    document.getElementById('summaryTotal').textContent    = total.toLocaleString() + ' FCFA';
    document.getElementById('modalTotal').textContent      = total.toLocaleString() + ' FCFA';
});

// ── Payment modal
function openPaymentModal() {
    document.getElementById('payModal').classList.add('open');
}
function closePayModal() {
    document.getElementById('payModal').classList.remove('open');
}
document.getElementById('payModal').addEventListener('click', function (e) {
    if (e.target === this) closePayModal();
});

// ── Method selection
let selectedMethod = null;
function selectMethod(method) {
    selectedMethod = method;

    // Reset all
    document.querySelectorAll('.method-card').forEach(c => c.classList.remove('active'));
    document.querySelectorAll('.pay-form').forEach(f => f.classList.remove('visible'));

    // Activate
    document.getElementById('method-' + method).classList.add('active');
    document.getElementById('form-' + method).classList.add('visible');

    const labels = { om: 'Pay with Orange Money', momo: 'Pay with MTN MoMo', mc: 'Pay with Mastercard', pp: 'Pay with PayPal' };
    document.getElementById('confirmText').textContent = labels[method];
    document.getElementById('confirmBtn').disabled = false;
}

// ── Card number formatting
document.getElementById('cardNumber')?.addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').substring(0, 16);
    this.value = v.replace(/(.{4})/g, '$1 ').trim();
});

// ── Confirm payment
function confirmPayment() {
    if (!selectedMethod) return;

    const btn = document.getElementById('confirmBtn');
    btn.classList.add('loading');
    btn.disabled = true;
    document.getElementById('confirmText').textContent = 'Processing…';

    document.getElementById('f_first_name').value    = document.querySelector('input[placeholder="First name"]').value;
    document.getElementById('f_last_name').value     = document.querySelector('input[placeholder="Last name"]').value;
    document.getElementById('f_email').value         = document.querySelector('input[placeholder="your@email.com"]').value;
    document.getElementById('f_phone').value         = document.querySelector('input[placeholder="e.g. +237 699 000 000"]').value;
    document.getElementById('f_city').value          = document.querySelector('input[placeholder="e.g. Yaoundé, Douala…"]').value;
    document.getElementById('f_street_address').value = document.querySelector('input[placeholder="Street, neighbourhood, landmark…"]').value;
    document.getElementById('f_notes').value         = document.querySelector('textarea[placeholder="Any special instructions for delivery?"]').value;
    document.getElementById('f_payment').value       = selectedMethod;

    setTimeout(() => {
        document.getElementById('realOrderForm').submit();
    }, 1500);
}
</script>

<form id="realOrderForm" method="POST" action="{{ route('orders.store') }}" style="display:none;">
    @csrf
    <input type="hidden" name="first_name" id="f_first_name">
    <input type="hidden" name="last_name" id="f_last_name">
    <input type="hidden" name="email" id="f_email">
    <input type="hidden" name="phone" id="f_phone">
    <input type="hidden" name="city" id="f_city">
    <input type="hidden" name="street_address" id="f_street_address">
    <input type="hidden" name="notes" id="f_notes">
    <input type="hidden" name="payment" id="f_payment">
</form>
</body>
</html>