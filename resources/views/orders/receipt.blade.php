<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt {{ $order->number }} — ZeShop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --ink: #1d1d1f; --navy: #0b2240; --blue: #0071e3;
            --pale: #f5f5f7; --white: #ffffff; --muted: #6e6e73;
            --border: #d2d2d7; --green: #30d158;
            --sans: 'Inter', sans-serif;
        }
        body {
            font-family: var(--sans);
            background: var(--pale);
            color: var(--ink);
            font-size: 14px;
            padding: 40px 20px;
        }

        .receipt {
            max-width: 640px;
            margin: 0 auto;
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 40px rgba(0,0,0,0.08);
        }

        /* Header */
        .receipt-header {
            background: var(--navy);
            padding: 32px 36px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .receipt-logo { font-size: 24px; font-weight: 700; letter-spacing: -0.5px; }
        .receipt-logo span { color: var(--blue); }
        .receipt-label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.5);
            margin-bottom: 4px;
        }
        .receipt-number { font-size: 15px; font-weight: 600; }

        /* Status banner */
        .receipt-status {
            background: #e8f5e9;
            border-bottom: 1px solid #c8e6c9;
            padding: 12px 36px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #2e7d32;
        }

        /* Body */
        .receipt-body { padding: 32px 36px; }

        /* Info grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 28px;
        }
        .info-block-label {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
            margin-bottom: 8px;
        }
        .info-block-value {
            font-size: 13px;
            line-height: 1.6;
            color: var(--ink);
        }
        .info-block-value strong { font-weight: 600; }

        /* Items table */
        .items-title {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--muted);
            margin-bottom: 12px;
        }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items-table th {
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
        }
        .items-table th:last-child { text-align: right; }
        .items-table td {
            padding: 12px 0;
            font-size: 13px;
            border-bottom: 0.5px solid var(--border);
            vertical-align: top;
        }
        .items-table td:last-child { text-align: right; font-weight: 600; }
        .items-table tr:last-child td { border-bottom: none; }
        .item-name { font-weight: 500; }
        .item-qty { font-size: 12px; color: var(--muted); margin-top: 2px; }

        /* Totals */
        .totals { border-top: 1px solid var(--border); padding-top: 16px; }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 8px;
        }
        .total-row.grand {
            font-size: 16px;
            font-weight: 700;
            color: var(--ink);
            border-top: 1px solid var(--border);
            padding-top: 12px;
            margin-top: 4px;
        }
        .total-row.grand span:last-child { color: var(--blue); }

        /* Footer */
        .receipt-footer {
            background: var(--pale);
            border-top: 1px solid var(--border);
            padding: 20px 36px;
            text-align: center;
            font-size: 12px;
            color: var(--muted);
            line-height: 1.6;
        }

        /* Print button */
        .print-actions {
            max-width: 640px;
            margin: 20px auto 0;
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .btn-print {
            background: var(--navy);
            color: #fff;
            padding: 12px 28px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .btn-back {
            background: var(--white);
            color: var(--ink);
            padding: 12px 28px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid var(--border);
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        @media print {
            body { background: #fff; padding: 0; }
            .receipt { box-shadow: none; border-radius: 0; }
            .print-actions { display: none; }
        }
    </style>
</head>
<body>

{{-- Print / Back buttons --}}
<div class="print-actions">
    <a href="{{ route('account') }}" class="btn-back">← My Orders</a>
    <button class="btn-print" onclick="window.print()">
        🖨️ Print / Save PDF
    </button>
</div>

<div class="receipt">

    {{-- Header --}}
    <div class="receipt-header">
        <div class="receipt-logo">Ze<span>Shop</span></div>
        <div style="text-align:right;">
            <div class="receipt-label">Receipt</div>
            <div class="receipt-number">{{ $order->number }}</div>
            <div style="font-size:12px;color:rgba(255,255,255,0.5);margin-top:4px;">
                {{ $order->created_at->format('d M Y, H:i') }}
            </div>
        </div>
    </div>

    {{-- Status --}}
    <div class="receipt-status">
        ✅ Payment {{ ucfirst($order->status->value) }}
    </div>

    {{-- Body --}}
    <div class="receipt-body">

        {{-- Info Grid --}}
        <div class="info-grid">
            <div>
                <div class="info-block-label">Billed To</div>
                <div class="info-block-value">
                    <strong>{{ $address->first_name ?? '' }} {{ $address->last_name ?? '' }}</strong><br>
                    {{ $address->phone ?? '' }}<br>
                    {{ $address->city ?? '' }}<br>
                    {{ $address->street_address ?? '' }}<br>
                    {{ $address->country_name ?? '' }}
                </div>
            </div>
            <div>
                <div class="info-block-label">Payment Info</div>
                <div class="info-block-value">
                    <strong>Method:</strong>
                    @php
                        $method = $metadata['payment_method'] ?? 'N/A';
                        $labels = ['om' => 'Orange Money', 'momo' => 'MTN MoMo', 'mc' => 'Mastercard', 'pp' => 'PayPal'];
                    @endphp
                    {{ $labels[$method] ?? ucfirst($method) }}<br>
                    <strong>Email:</strong> {{ $metadata['email'] ?? auth()->user()->email }}<br>
                    <strong>Currency:</strong> {{ $order->currency_code }}
                </div>
            </div>
        </div>

        {{-- Items --}}
        <div class="items-title">Items Ordered</div>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th style="text-align:center;">Qty</th>
                    <th>Unit Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <div class="item-name">{{ $item->name }}</div>
                    </td>
                    <td style="text-align:center;">{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price_amount) }} {{ $order->currency_code }}</td>
                    <td>{{ number_format($item->unit_price_amount * $item->quantity) }} {{ $order->currency_code }}</td>
                </tr>
                @endforeach
            </tbody>
            <tbody>
                <a href="{{ route('orders.receipt', $order->id) }}"
                    style="font-size:12px;color:var(--blue);font-weight:500;white-space:nowrap;">
                        🧾 Receipt
                </a>
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="totals">
            <div class="total-row">
                <span>Subtotal</span>
                <span>{{ number_format($order->price_amount) }} {{ $order->currency_code }}</span>
            </div>
            <div class="total-row">
                <span>Shipping</span>
                <span style="color:var(--green);font-weight:500;">Free</span>
            </div>
            <div class="total-row grand">
                <span>Total</span>
                <span>{{ number_format($order->price_amount) }} {{ $order->currency_code }}</span>
            </div>
        </div>

    </div>

    {{-- Footer --}}
    <div class="receipt-footer">
        Thank you for shopping with <strong>ZeShop</strong>! 🛍️<br>
        For support, contact us at support@zeshop.cm
    </div>

</div>

</body>
</html>