<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; padding: 0; background-color: #fdf2f8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; color: #18181b; }
        a { color: inherit; }

        /* ── Outer wrapper ── */
        .outer { width: 100%; background-color: #fdf2f8; padding: 32px 16px; }
        .card  { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(236,72,153,0.10); }

        /* ── Header ── */
        .header { background: linear-gradient(135deg, #db2777 0%, #ec4899 60%, #f472b6 100%); padding: 40px 32px 36px; text-align: center; }
        .logo-wrap { margin-bottom: 20px; }
        .logo-img  { max-height: 52px; max-width: 180px; object-fit: contain; border-radius: 8px; background: rgba(255,255,255,0.15); padding: 6px 14px; }
        .logo-text { display: inline-block; font-size: 22px; font-weight: 800; color: #ffffff; letter-spacing: -0.5px; background: rgba(255,255,255,0.15); padding: 6px 18px; border-radius: 8px; }
        .check-circle { display: inline-block; width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; margin-bottom: 16px; line-height: 60px; text-align: center; }
        .header h1 { margin: 0 0 8px; color: #ffffff; font-size: 26px; font-weight: 800; letter-spacing: -0.3px; }
        .header p  { margin: 0; color: #fce7f3; font-size: 15px; line-height: 1.5; }

        /* ── Body ── */
        .body { padding: 32px; }
        .greeting { font-size: 16px; color: #3f3f46; margin: 0 0 8px; }
        .intro    { font-size: 14px; color: #71717a; line-height: 1.6; margin: 0 0 28px; }

        /* ── Order info box ── */
        .order-box { background: #fdf2f8; border: 1px solid #fbcfe8; border-radius: 10px; padding: 20px 24px; margin-bottom: 28px; }
        .order-number-label { font-size: 12px; color: #9ca3af; margin-bottom: 4px; }
        .order-number-value { font-size: 16px; font-weight: 700; color: #db2777; margin-bottom: 16px; }

        /* ── Section title ── */
        .section-title { font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.08em; margin: 0 0 12px; padding-bottom: 8px; border-bottom: 1px solid #fce7f3; }

        /* ── Items table ── */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        .items-table th { font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.06em; padding: 0 0 10px; border-bottom: 2px solid #fce7f3; }
        .items-table th.center { text-align: center; }
        .items-table th.right  { text-align: right; }
        .items-table td { font-size: 14px; color: #374151; padding: 12px 0; border-bottom: 1px solid #fdf2f8; vertical-align: top; line-height: 1.5; }
        .items-table td.center { text-align: center; }
        .items-table td.right  { text-align: right; font-weight: 600; color: #18181b; }
        .items-table tr:last-child td { border-bottom: none; }

        /* ── Totals ── */
        .totals-table { width: 100%; border-collapse: collapse; background: #fdf2f8; border-radius: 10px; overflow: hidden; margin-top: 4px; }
        .totals-table td { padding: 8px 20px; font-size: 14px; color: #6b7280; }
        .totals-table td.label { text-align: left; }
        .totals-table td.value { text-align: right; }
        .totals-table tr.discount td { color: #16a34a; }
        .totals-table tr.grand td { font-size: 16px; font-weight: 700; color: #18181b; border-top: 2px solid #fbcfe8; padding-top: 12px; padding-bottom: 14px; }

        /* ── Address ── */
        .address-box { background: #f9fafb; border-radius: 8px; padding: 16px 20px; font-size: 14px; color: #374151; line-height: 1.7; margin-bottom: 28px; }

        /* ── Badge ── */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; }
        .badge-cod    { background: #fef3c7; color: #92400e; }
        .badge-card   { background: #fce7f3; color: #9d174d; }
        .badge-paypal { background: #dbeafe; color: #1e40af; }
        .badge-online { background: #d1fae5; color: #065f46; }

        /* ── CTA button ── */
        .cta { text-align: center; padding: 28px 0 8px; }
        .btn { display: inline-block; background: linear-gradient(135deg, #db2777, #ec4899); color: #ffffff !important; text-decoration: none; padding: 14px 36px; border-radius: 10px; font-weight: 700; font-size: 15px; letter-spacing: 0.2px; }

        /* ── Footer ── */
        .footer { background: #fdf2f8; padding: 24px 32px; text-align: center; border-top: 1px solid #fbcfe8; }
        .footer p   { margin: 4px 0; font-size: 12px; color: #9ca3af; }
        .footer a   { color: #db2777; text-decoration: none; }
    </style>
</head>
<body>
<div class="outer">
<div class="card">

    {{-- ══ HEADER ══ --}}
    <div class="header">

        {{-- Logo --}}
        <div class="logo-wrap">
            @php
                $storeName = setting('store_name', 'ShopExpress');
                $logoPath  = setting('store_logo');
                $logoUrl   = null;
                if ($logoPath) {
                    if (file_exists(public_path($logoPath))) {
                        $logoUrl = asset($logoPath);
                    } elseif (file_exists(public_path('storage/' . $logoPath))) {
                        $logoUrl = asset('storage/' . $logoPath);
                    }
                }
            @endphp
            @if($logoUrl)
                <img src="{{ $logoUrl }}" alt="{{ $storeName }}" class="logo-img">
            @else
                <span class="logo-text">{{ $storeName }}</span>
            @endif
        </div>

        {{-- Check icon --}}
        <div class="check-circle">
            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" style="display:inline-block;vertical-align:middle;">
                <path d="M5 13l4 4L19 7" stroke="#ffffff" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <h1>Order Confirmed!</h1>
        <p>Thank you for your purchase. Your order is being processed.</p>
    </div>

    {{-- ══ BODY ══ --}}
    <div class="body">

        <p class="greeting">Hi {{ $order->customer_name }},</p>
        <p class="intro">
            Great news — we've received your order and it's now being processed.
            You'll receive another update once your order has been shipped.
        </p>

        {{-- Order info box --}}
        <div class="order-box">
            <div class="order-number-label">Order Number</div>
            <div class="order-number-value">#{{ $order->order_number }}</div>

            {{-- Meta: use table for email compatibility --}}
            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td style="padding:0; width:33%; vertical-align:top;">
                        <div style="font-size:13px;font-weight:700;color:#18181b;">{{ $order->created_at->format('M d, Y') }}</div>
                        <div style="font-size:11px;color:#9ca3af;margin-top:2px;">Order Date</div>
                    </td>
                    <td style="padding:0; width:34%; vertical-align:top; text-align:center;">
                        @if($order->payment_method === 'cash_on_delivery')
                            <span class="badge badge-cod">Cash on Delivery</span>
                        @elseif($order->payment_method === 'credit_card')
                            <span class="badge badge-card">Credit Card</span>
                        @elseif($order->payment_method === 'paypal')
                            <span class="badge badge-paypal">PayPal</span>
                        @else
                            <span class="badge badge-online">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</span>
                        @endif
                        <div style="font-size:11px;color:#9ca3af;margin-top:4px;">Payment Method</div>
                    </td>
                    <td style="padding:0; width:33%; vertical-align:top; text-align:right;">
                        <div style="font-size:13px;font-weight:700;color:#18181b;">{{ $order->orderItems->count() }} item(s)</div>
                        <div style="font-size:11px;color:#9ca3af;margin-top:2px;">Total Items</div>
                    </td>
                </tr>
            </table>
        </div>

        {{-- Items ordered --}}
        <p class="section-title">Items Ordered</p>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="text-align:left;">Product</th>
                    <th class="center">Qty</th>
                    <th class="right">Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="center">{{ $item->quantity }}</td>
                    <td class="right">${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <table class="totals-table" style="margin-top:12px;">
            <tr>
                <td class="label">Subtotal</td>
                <td class="value">${{ number_format($order->subtotal, 2) }}</td>
            </tr>
            @if($order->discount_amount > 0)
            <tr class="discount">
                <td class="label">Discount ({{ $order->coupon_code }})</td>
                <td class="value">-${{ number_format($order->discount_amount, 2) }}</td>
            </tr>
            @endif
            @if($order->tax_amount > 0)
            <tr>
                <td class="label">Tax</td>
                <td class="value">${{ number_format($order->tax_amount, 2) }}</td>
            </tr>
            @endif
            <tr class="grand">
                <td class="label">Total</td>
                <td class="value">${{ number_format($order->total_price, 2) }}</td>
            </tr>
        </table>

        {{-- Shipping address --}}
        <p class="section-title" style="margin-top:28px;">Shipping Address</p>
        <div class="address-box">
            {{ $order->shipping_address }}<br>
            {{ $order->shipping_city }}@if($order->shipping_state), {{ $order->shipping_state }}@endif {{ $order->shipping_postal_code }}<br>
            {{ $order->shipping_country }}
        </div>

        @if($order->notes)
        <p class="section-title">Order Notes</p>
        <div class="address-box" style="margin-bottom:0;">{{ $order->notes }}</div>
        @endif

        {{-- CTA --}}
        <div class="cta">
            <a href="{{ route('orders.show', $order->order_number) }}" class="btn">View Order Details</a>
        </div>

    </div>{{-- /body --}}

    {{-- ══ FOOTER ══ --}}
    <div class="footer">
        <p>This email was sent to <strong>{{ $order->customer_email }}</strong></p>
        <p style="margin-top:8px;">
            Questions? <a href="{{ route('help') }}">Contact Support</a>
            &nbsp;&bull;&nbsp;
            <a href="{{ route('home') }}">{{ $storeName }}</a>
        </p>
        <p style="margin-top:12px;">&copy; {{ date('Y') }} {{ $storeName }}. All rights reserved.</p>
    </div>

</div>{{-- /card --}}
</div>{{-- /outer --}}
</body>
</html>
