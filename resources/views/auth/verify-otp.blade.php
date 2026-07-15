<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --brand-dark: #0f0f1a; --brand-accent: #4361ee; --brand-accent-glow: rgba(67,97,238,0.35); }
        body {
            min-height: 100vh; background: var(--brand-dark);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif; padding: 20px;
            position: relative; overflow: hidden;
        }
        body::before, body::after {
            content: ''; position: fixed; border-radius: 50%;
            filter: blur(80px); opacity: 0.15; pointer-events: none;
        }
        body::before { width: 400px; height: 400px; background: var(--brand-accent); top: -100px; left: -100px; }
        body::after { width: 350px; height: 350px; background: #7209b7; bottom: -100px; right: -100px; }
        .auth-card {
            width: 100%; max-width: 420px;
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px; padding: 40px 36px;
            backdrop-filter: blur(20px);
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
            position: relative; z-index: 1;
            animation: slideUp 0.5s ease both;
        }
        @keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .brand-icon {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, #06d6a0, #118ab2);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 28px; color: white; margin: 0 auto 20px;
            box-shadow: 0 8px 24px rgba(6,214,160,0.3);
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse { 0%,100% { box-shadow: 0 8px 24px rgba(6,214,160,0.3); } 50% { box-shadow: 0 8px 36px rgba(6,214,160,0.6); } }
        h1 { font-size: 22px; font-weight: 700; color: #fff; text-align: center; margin-bottom: 6px; }
        .subtitle { font-size: 13px; color: rgba(255,255,255,0.45); text-align: center; margin-bottom: 6px; }
        .email-badge {
            background: rgba(67,97,238,0.15); border: 1px solid rgba(67,97,238,0.3);
            border-radius: 8px; padding: 8px 16px; text-align: center;
            color: #a5b4fc; font-size: 14px; font-weight: 600; margin: 12px 0 24px;
        }
        .otp-inputs { display: flex; gap: 10px; justify-content: center; margin-bottom: 24px; }
        .otp-digit {
            width: 48px; height: 56px; text-align: center;
            background: rgba(255,255,255,0.07); border: 2px solid rgba(255,255,255,0.12);
            border-radius: 12px; color: #fff; font-size: 22px; font-weight: 700;
            font-family: 'Courier New', monospace;
            transition: all 0.2s; -moz-appearance: textfield;
        }
        .otp-digit::-webkit-outer-spin-button, .otp-digit::-webkit-inner-spin-button { -webkit-appearance: none; }
        .otp-digit:focus { border-color: var(--brand-accent); box-shadow: 0 0 0 3px var(--brand-accent-glow); outline: none; background: rgba(255,255,255,0.1); }
        .otp-digit.filled { border-color: rgba(6,214,160,0.6); }
        .btn-primary {
            background: linear-gradient(135deg, var(--brand-accent), #3a0ca3);
            border: none; border-radius: 10px; padding: 13px;
            font-size: 15px; font-weight: 600; transition: all 0.25s;
            box-shadow: 0 4px 15px var(--brand-accent-glow);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 25px var(--brand-accent-glow); }
        .btn-link-custom { color: rgba(255,255,255,0.4); font-size: 13px; text-align: center; display: block; margin-top: 16px; text-decoration: none; }
        .btn-link-custom strong { color: var(--brand-accent); }
        .btn-link-custom:hover { color: rgba(255,255,255,0.7); }
        .alert-danger { background: rgba(220,53,69,0.15); border: 1px solid rgba(220,53,69,0.3); color: #f87171; border-radius: 10px; font-size: 13px; padding: 12px 16px; }
        .alert-success { background: rgba(25,135,84,0.15); border: 1px solid rgba(25,135,84,0.3); color: #6ee7b7; border-radius: 10px; font-size: 13px; padding: 12px 16px; }
        #hidden-otp { position: absolute; opacity: 0; pointer-events: none; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="brand-icon">
            <i class="bi bi-shield-check"></i>
        </div>
        <h1>Verify Your Email</h1>
        <p class="subtitle">We sent a 6-digit code to</p>
        <div class="email-badge">
            <i class="bi bi-envelope-fill me-1"></i>{{ $email }}
        </div>

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-triangle me-1"></i> {{ $errors->first('otp') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success mb-3">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('auth.otp.verify') }}" id="otp-form">
            @csrf
            <input type="hidden" name="otp" id="hidden-otp">

            <div class="otp-inputs" id="otp-inputs">
                @for($i = 0; $i < 6; $i++)
                    <input type="number" class="otp-digit" maxlength="1" min="0" max="9"
                        id="digit-{{ $i }}" data-index="{{ $i }}" inputmode="numeric">
                @endfor
            </div>

            <button type="submit" class="btn btn-primary w-100" id="verify-btn">
                <i class="bi bi-check2-circle me-1"></i> Verify & Continue
            </button>
        </form>

        <form method="POST" action="{{ route('auth.otp.resend') }}" style="margin-top: 0;">
            @csrf
            <button type="submit" class="btn-link-custom w-100 bg-transparent border-0 cursor-pointer mt-3">
                Didn't get the code? <strong>Resend OTP</strong>
            </button>
        </form>

        <a href="{{ route('auth.login') }}" class="btn-link-custom" style="margin-top:8px;">
            &larr; Back to Login
        </a>
    </div>

    <script>
        const digits = document.querySelectorAll('.otp-digit');
        const hiddenOtp = document.getElementById('hidden-otp');

        function updateHidden() {
            hiddenOtp.value = Array.from(digits).map(d => d.value).join('');
        }

        digits.forEach((digit, i) => {
            digit.addEventListener('input', function () {
                // Only allow single digit
                if (this.value.length > 1) this.value = this.value.slice(-1);
                if (this.value) {
                    this.classList.add('filled');
                    if (i < 5) digits[i + 1].focus();
                } else {
                    this.classList.remove('filled');
                }
                updateHidden();

                // Auto-submit when all 6 digits filled
                if (Array.from(digits).every(d => d.value)) {
                    setTimeout(() => document.getElementById('otp-form').submit(), 200);
                }
            });

            digit.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && !this.value && i > 0) {
                    digits[i - 1].focus();
                    digits[i - 1].value = '';
                    digits[i - 1].classList.remove('filled');
                    updateHidden();
                }
            });

            // Handle paste
            digit.addEventListener('paste', function (e) {
                e.preventDefault();
                const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
                pasted.split('').forEach((char, idx) => {
                    if (digits[idx]) {
                        digits[idx].value = char;
                        digits[idx].classList.add('filled');
                    }
                });
                updateHidden();
                if (pasted.length === 6) setTimeout(() => document.getElementById('otp-form').submit(), 200);
            });
        });

        // Focus first digit on load
        digits[0].focus();
    </script>
</body>
</html>
