<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Application Received</title>
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f3f4f6; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); padding: 40px 48px; text-align: center; }
        .header-icon { width: 64px; height: 64px; background: rgba(255,255,255,0.15); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
        .header h1 { color: #ffffff; font-size: 24px; font-weight: 700; margin: 0 0 8px; }
        .header p { color: rgba(255,255,255,0.85); font-size: 15px; margin: 0; }
        .body { padding: 40px 48px; }
        .greeting { font-size: 16px; color: #374151; margin-bottom: 20px; }
        .info-box { background: #f9fafb; border: 1px solid #e5e7eb; border-radius: 8px; padding: 20px 24px; margin: 24px 0; }
        .info-box h3 { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; margin: 0 0 12px; }
        .info-row { display: flex; align-items: center; margin-bottom: 8px; font-size: 14px; color: #374151; }
        .info-row span:first-child { color: #6b7280; width: 120px; flex-shrink: 0; }
        .info-row span:last-child { font-weight: 600; }
        .steps { margin: 28px 0; }
        .step { display: flex; align-items: flex-start; margin-bottom: 16px; }
        .step-num { width: 28px; height: 28px; background: #4f46e5; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; margin-right: 14px; margin-top: 2px; }
        .step-text h4 { margin: 0 0 2px; font-size: 14px; font-weight: 600; color: #111827; }
        .step-text p { margin: 0; font-size: 13px; color: #6b7280; }
        .btn { display: inline-block; padding: 12px 28px; background: #4f46e5; color: #ffffff !important; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 15px; margin: 8px 4px; }
        .btn-outline { background: transparent; color: #4f46e5 !important; border: 2px solid #4f46e5; }
        .note { background: #fffbeb; border-left: 4px solid #f59e0b; border-radius: 0 8px 8px 0; padding: 14px 18px; margin: 24px 0; font-size: 13px; color: #92400e; }
        .footer { background: #f9fafb; border-top: 1px solid #e5e7eb; padding: 24px 48px; text-align: center; }
        .footer p { margin: 0; font-size: 12px; color: #9ca3af; }
        .footer a { color: #4f46e5; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="header-icon">
            <svg width="32" height="32" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1>Application Received!</h1>
        <p>We've got your seller application and are reviewing it now.</p>
    </div>

    <div class="body">
        <p class="greeting">Hi <strong>{{ $seller->user->name }}</strong>,</p>

        <p style="color: #374151; font-size: 15px; line-height: 1.6;">
            Thank you for applying to sell on <strong>{{ config('app.name') }}</strong>.
            Your application has been successfully received and our team will review it shortly.
        </p>

        <div class="info-box">
            <h3>Application Summary</h3>
            <div class="info-row">
                <span>Store Name</span>
                <span>{{ $seller->store_name }}</span>
            </div>
            <div class="info-row">
                <span>Submitted</span>
                <span>{{ $seller->created_at->format('F j, Y \a\t g:i a') }}</span>
            </div>
            <div class="info-row">
                <span>Status</span>
                <span style="color: #d97706; background: #fffbeb; padding: 2px 10px; border-radius: 20px;">Under Review</span>
            </div>
        </div>

        <div class="steps">
            <h3 style="font-size: 15px; font-weight: 600; color: #111827; margin-bottom: 16px;">What happens next?</h3>
            <div class="step">
                <div class="step-num">1</div>
                <div class="step-text">
                    <h4>Review (1–3 business days)</h4>
                    <p>Our team will verify your store details and business document if provided.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <div class="step-text">
                    <h4>Decision email</h4>
                    <p>You'll receive an email with the approval result at <strong>{{ $seller->user->email }}</strong>.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <div class="step-text">
                    <h4>Start selling</h4>
                    <p>Once approved, your seller dashboard unlocks and you can list products immediately.</p>
                </div>
            </div>
        </div>

        <div class="note">
            <strong>Tip:</strong> Make sure your email inbox isn't full so you receive our decision.
            Add <strong>{{ config('mail.from.address') }}</strong> to your contacts.
        </div>

        <div style="text-align: center; margin: 32px 0;">
            <a href="{{ url('/sell') }}" class="btn">View Seller Info</a>
        </div>
    </div>

    <div class="footer">
        <p>You received this email because you applied to sell on {{ config('app.name') }}.</p>
        <p style="margin-top: 8px;">Questions? <a href="{{ url('/contact') }}">Contact support</a></p>
    </div>
</div>
</body>
</html>
