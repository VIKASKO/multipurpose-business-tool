<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Verification Code</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; background: #f4f6f9; }
        .wrapper { max-width: 520px; margin: 40px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); padding: 32px 40px; text-align: center; }
        .header h1 { margin: 0; color: #fff; font-size: 22px; font-weight: 700; letter-spacing: 0.5px; }
        .header p { margin: 4px 0 0; color: rgba(255,255,255,0.6); font-size: 13px; }
        .body { padding: 40px; }
        .body p { color: #444; font-size: 15px; line-height: 1.6; margin: 0 0 20px; }
        .otp-box { background: #f0f4ff; border: 2px dashed #4361ee; border-radius: 10px; padding: 24px; text-align: center; margin: 28px 0; }
        .otp-code { font-size: 42px; font-weight: 800; letter-spacing: 12px; color: #1a1a2e; font-family: 'Courier New', monospace; }
        .otp-note { font-size: 13px; color: #888; margin-top: 10px; }
        .warning { background: #fff8e1; border-left: 4px solid #ffc107; padding: 14px 18px; border-radius: 6px; font-size: 13px; color: #856404; margin-top: 20px; }
        .footer { background: #f9fafb; padding: 20px 40px; text-align: center; border-top: 1px solid #eee; }
        .footer p { margin: 0; font-size: 12px; color: #aaa; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            <p>Email Verification</p>
        </div>
        <div class="body">
            <p>Hello,</p>
            <p>Use the verification code below to confirm your email address and access your account.</p>

            <div class="otp-box">
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-note">This code expires in <strong>10 minutes</strong></div>
            </div>

            <p>If you did not request this, you can safely ignore this email. Someone may have entered your email address by mistake.</p>

            <div class="warning">
                🔒 Never share this code with anyone. Our team will never ask for it.
            </div>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
