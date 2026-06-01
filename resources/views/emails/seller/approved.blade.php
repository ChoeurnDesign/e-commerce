<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Store is Approved!</title>
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f3f4f6; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #059669 0%, #10b981 100%); padding: 40px 48px; text-align: center; }
        .header-icon { width: 72px; height: 72px; background: rgba(255,255,255,0.2); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
        .header h1 { color: #ffffff; font-size: 26px; font-weight: 700; margin: 0 0 8px; }
        .header p { color: rgba(255,255,255,0.9); font-size: 15px; margin: 0; }
        .body { padding: 40px 48px; }
        .greeting { font-size: 16px; color: #374151; margin-bottom: 20px; }
        .info-box { background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 20px 24px; margin: 24px 0; }
        .info-box h3 { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #065f46; margin: 0 0 12px; }
        .info-row { display: flex; align-items: center; margin-bottom: 8px; font-size: 14px; color: #374151; }
        .info-row span:first-child { color: #6b7280; width: 120px; flex-shrink: 0; }
        .info-row span:last-child { font-weight: 600; }
        .checklist { margin: 24px 0; }
        .check-item { display: flex; align-items: flex-start; margin-bottom: 14px; }
        .check-icon { width: 22px; height: 22px; background: #d1fae5; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-right: 12px; margin-top: 2px; }
        .check-text h4 { margin: 0 0 2px; font-size: 14px; font-weight: 600; color: #111827; }
        .check-text p { margin: 0; font-size: 13px; color: #6b7280; }
        .btn { display: inline-block; padding: 14px 32px; background: #059669; color: #ffffff !important; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 16px; margin: 8px 4px; }
        .btn-secondary { background: #4f46e5; }
        .features { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin: 24px 0; }
        .feature { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 14px 16px; }
        .feature h4 { margin: 0 0 4px; font-size: 13px; font-weight: 600; color: #111827; }
        .feature p { margin: 0; font-size: 12px; color: #6b7280; }
        .footer { background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 24px 48px; text-align: center; }
        .footer p { margin: 0; font-size: 12px; color: #9ca3af; }
        .footer a { color: #4f46e5; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="header-icon">
            <svg width="36" height="36" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
        </div>
        <h1>Congratulations!</h1>
        <p>Your store <strong>{{ $seller->store_name }}</strong> is now approved and live.</p>
    </div>

    <div class="body">
        <p class="greeting">Hi <strong>{{ $seller->user->name }}</strong>,</p>

        <p style="color: #374151; font-size: 15px; line-height: 1.6;">
            Great news! Your application to sell on <strong>{{ config('app.name') }}</strong> has been
            <strong style="color: #059669;">approved</strong>. You can now access your full seller dashboard,
            list products, and start earning.
        </p>

        <div class="info-box">
            <h3>Your Store Details</h3>
            <div class="info-row">
                <span>Store Name</span>
                <span>{{ $seller->store_name }}</span>
            </div>
            <div class="info-row">
                <span>Store URL</span>
                <span>
                    @if($seller->slug)
                        {{ url('/stores/' . $seller->slug) }}
                    @else
                        Available in your dashboard
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span>Status</span>
                <span style="color: #059669; background: #d1fae5; padding: 2px 10px; border-radius: 20px;">Approved</span>
            </div>
        </div>

        <div class="checklist">
            <h3 style="font-size: 15px; font-weight: 600; color: #111827; margin-bottom: 16px;">Get started in 3 steps</h3>
            <div class="check-item">
                <div class="check-icon">
                    <svg width="12" height="12" fill="none" stroke="#059669" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="check-text">
                    <h4>Set up your store profile</h4>
                    <p>Add a store logo, banner, and description to attract customers.</p>
                </div>
            </div>
            <div class="check-item">
                <div class="check-icon">
                    <svg width="12" height="12" fill="none" stroke="#059669" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="check-text">
                    <h4>List your first product</h4>
                    <p>Add high-quality photos, a clear description, and competitive pricing.</p>
                </div>
            </div>
            <div class="check-item">
                <div class="check-icon">
                    <svg width="12" height="12" fill="none" stroke="#059669" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="check-text">
                    <h4>Share your store</h4>
                    <p>Tell friends and customers about your new store on {{ config('app.name') }}.</p>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin: 32px 0;">
            <a href="{{ url('/seller/dashboard') }}" class="btn">Go to My Dashboard</a>
        </div>

        <div class="features">
            <div class="feature">
                <h4>Zero Listing Fees</h4>
                <p>List as many products as you want, for free.</p>
            </div>
            <div class="feature">
                <h4>Sales Analytics</h4>
                <p>Track performance with your built-in dashboard.</p>
            </div>
            <div class="feature">
                <h4>Secure Payments</h4>
                <p>Earnings are transferred to your wallet safely.</p>
            </div>
            <div class="feature">
                <h4>Seller Support</h4>
                <p>Contact us anytime through the chat feature.</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Congratulations again from the {{ config('app.name') }} team!</p>
        <p style="margin-top: 8px;">Need help? <a href="{{ url('/contact') }}">Contact support</a></p>
    </div>
</div>
</body>
</html>
