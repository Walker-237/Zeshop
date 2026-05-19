<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account — ZeShop</title>
    <link rel="icon" type="image/x-icon" href="/cpanel/images/favicons/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --ink: #1d1d1f; --navy: #0b2240; --blue: #0071e3;
            --pale: #f5f5f7; --white: #ffffff; --off: #f5f5f7;
            --muted: #6e6e73; --border: #d2d2d7; --red: #ff3b30; --green: #30d158;
            --sans: -apple-system, 'Inter', sans-serif;
        }
        body { font-family: var(--sans); background: var(--off); color: var(--ink); }
        a { text-decoration: none; color: inherit; }

        .account-wrap {
            max-width: 900px;
            margin: 40px auto;
            padding: 0 24px 80px;
        }

        .account-header {
            background: var(--navy);
            border-radius: 20px;
            padding: 32px;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 28px;
            color: #fff;
        }
        .account-avatar {
            width: 64px; height: 64px;
            background: var(--blue);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 22px; font-weight: 700;
            flex-shrink: 0;
        }
        .account-name { font-size: 22px; font-weight: 700; }
        .account-email { font-size: 13px; color: rgba(255,255,255,0.6); margin-top: 4px; }
        .account-role {
            display: inline-block;
            background: rgba(255,255,255,0.15);
            border-radius: 20px;
            padding: 3px 12px;
            font-size: 11px;
            margin-top: 8px;
        }

        .section-title {
            font-size: 18px; font-weight: 700;
            margin-bottom: 16px; color: var(--navy);
        }

        .orders-card {
            background: var(--white);
            border: 0.5px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .orders-card-header {
            padding: 16px 20px;
            border-bottom: 0.5px solid var(--border);
            font-weight: 600; font-size: 15px;
            background: var(--pale);
        }

        .order-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 0.5px solid var(--border);
            gap: 12px;
        }
        .order-row:last-child { border-bottom: none; }
        .order-number { font-weight: 600; font-size: 13px; }
        .order-date { font-size: 12px; color: var(--muted); margin-top: 3px; }
        .order-total { font-weight: 700; font-size: 14px; }
        .order-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .status-pending  { background: #fff3e0; color: #e65100; }
        .status-paid     { background: #e8f5e9; color: #2e7d32; }
        .status-cancelled{ background: #fce4ec; color: #c62828; }
        .status-default  { background: var(--pale); color: var(--muted); }

        .empty-orders {
            text-align: center; padding: 48px 20px;
            color: var(--muted); font-size: 14px;
        }
        .empty-orders a {
            display: inline-block; margin-top: 16px;
            background: var(--blue); color: #fff;
            padding: 12px 28px; border-radius: 30px;
            font-weight: 600; font-size: 14px;
        }

        @media (max-width: 600px) {
            .account-header { flex-direction: column; text-align: center; }
            .order-row { flex-wrap: wrap; }
        }
    </style>
</head>
<body>

@include('components.header')

<div class="account-wrap">

    {{-- Success message --}}
    @if(session('success'))
        <div style="background:#e8f5e9;border:1px solid #a5d6a7;border-radius:12px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#2e7d32;display:flex;align-items:center;gap:8px;">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Profile Card --}}
    <div class="account-header">
        <div class="account-avatar">
            {{ strtoupper(substr(auth()->user()->first_name ?? 'U', 0, 1)) }}{{ strtoupper(substr(auth()->user()->last_name ?? '', 0, 1)) }}
        </div>
        <div>
            <div class="account-name">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</div>
            <div class="account-email">{{ auth()->user()->email }}</div>
            <div class="account-role">{{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'customer') }}</div>
        </div>
    </div>

    {{-- Orders --}}
    <div class="section-title">My Orders</div>
    <div class="orders-card">
        <div class="orders-card-header">Order History</div>

        @forelse(auth()->user()->orders()->latest()->get() as $order)
            <div class="order-row">
                <div>
                    <div class="order-number">{{ $order->number }}</div>
                    <div class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</div>
                </div>
                <div class="order-total">
                    {{ number_format($order->price_amount) }} XAF
                </div>
                <span class="order-status status-{{ $order->status->value }}">
                    {{ ucfirst($order->status->value) }}
                </span>
            </div>
        @empty
            <div class="empty-orders">
                <div>You haven't placed any orders yet.</div>
                <a href="{{ route('products.index') }}">Start Shopping</a>
            </div>
        @endforelse
    </div>

</div>

</body>
</html>