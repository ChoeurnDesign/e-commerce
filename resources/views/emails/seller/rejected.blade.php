<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update on Your Seller Application</title>
    <style>
        body { margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f3f4f6; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #374151 0%, #4b5563 100%); padding: 40px 48px; text-align: center; }
        .header-icon { width: 64px; height: 64px; background: rgba(255,255,255,0.1); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px; }
        .header h1 { color: #ffffff; font-size: 24px; font-weight: 700; margin: 0 0 8px; }
        .header p { color: rgba(255,255,255,0.8); font-size: 15px; margin: 0; }
        .body { padding: 40px 48px; }
        .greeting { font-size: 16px; color: #374151; margin-bottom: 20px; }
        .reason-box { background: #fff7ed; border: 1px solid #fed7aa; border-radius: 8px; padding: 20px 24px; margin: 24px 0; }
        .reason-box h3 { font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #92400e; margin: 0 0 10px; }
        .reason-box p { margin: 0; font-size: 14px; color: #78350f; line-height: 1.6; }
        .steps { margin: 24px 0; }
        .step { display: flex; align-items: flex-start; margin-bottom: 14px; }
        .step-icon { width: 28px; height: 28px; background: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-right: 12px; margin-top: 2px; }
        .step-text h4 { margin: 0 0 2px; font-size: 14px; font-weight: 600; color: #111827; }
        .step-text p { margin: 0; font-size: 13px; color: #6b7280; }
        .btn { display: inline-block; padding: 12px 28px; background: #4f46e5; color: #ffffff !important; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 15px; margin: 8px 4px; }
        .btn-outline { background: transparent; color: #4f46e5 !important; border: 2px solid #4f46e5; padding: 10px 28px; }
        .note { background: #eff6ff; border-left: 4px solid #3b82f6; border-radius: 0 8px 8px 0; padding: 14px 18px; margin: 24px 0; font-size: 13px; color: #1e40af; line-height: 1.6; }
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
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <h1>Application Update</h1>
        <p>We reviewed your seller application for <strong>{{ $seller->store_name }}</strong>.</p>
    </div>

    <div class="body">
        <p class="greeting">Hi <strong>{{ $seller->user->name }}</strong>,</p>

        <p style="color: #374151; font-size: 15px; line-height: 1.6;">
            Thank you for your interest in selling on <strong>{{ config('app.name') }}</strong>.
            After reviewing your application, we are unable to approve it at this time.
        </p>

        @if($reason)
        <div class="reason-box">
            <h3>Reason for Decision</h3>
            <p>{{ $reason }}</p>
        </div>
        @endif

        <div class="note">
            <strong>This is not permanent.</strong> Many sellers are approved after addressing the
            feedback above. You are welcome to reapply once you have made the necessary adjustments.
        </div>

        <div class="steps">
            <h3 style="font-size: 15px; font-weight: 600; color: #111827; margin-bottom: 16px;">What you can do</h3>
            <div class="step">
                <div class="step-icon">
                    <svg width="14" height="14" fill="none" stroke="#6b7280" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <div class="step-text">
                    <h4>Review the feedback above</h4>
                    <p>Address any specific issues mentioned in the reason for decision.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-icon">
                    <svg width="14" height="14" fill="none" stroke="#6b7280" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                </div>
                <div class="step-text">
                    <h4>Contact our support team</h4>
                    <p>If you have questions about this decision, we're here to help.</p>
                </div>
            </div>
            <div class="step">
                <div class="step-icon">
                    <svg width="14" height="14" fill="none" stroke="#6b7280" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <div class="step-text">
                    <h4>Reapply when ready</h4>
                    <p>Visit your dashboard to submit a new application after making improvements.</p>
                </div>
            </div>
        </div>

        <div style="text-align: center; margin: 32px 0;">
            <a href="{{ url('/sell') }}" class="btn">Learn About Selling</a>
            <a href="{{ url('/contact') }}" class="btn btn-outline">Contact Support</a>
        </div>

        <p style="color: #6b7280; font-size: 13px; text-align: center;">
            You can continue shopping on {{ config('app.name') }} as a customer.
        </p>
    </div>

    <div class="footer">
        <p>You received this email regarding your seller application on {{ config('app.name') }}.</p>
        <p style="margin-top: 8px;">Questions? <a href="{{ url('/contact') }}">Contact support</a></p>
    </div>
</div>
</body>
</html>
