<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-dark: #0f0f1a;
            --brand-accent: #4361ee;
            --brand-accent-glow: rgba(67,97,238,0.35);
        }
        body {
            min-height: 100vh;
            background: var(--brand-dark);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
            padding: 20px;
            position: relative; overflow: hidden;
        }
        body::before, body::after {
            content: ''; position: fixed; border-radius: 50%;
            filter: blur(80px); opacity: 0.15; pointer-events: none;
        }
        body::before { width: 400px; height: 400px; background: var(--brand-accent); top: -100px; left: -100px; }
        body::after { width: 350px; height: 350px; background: #7209b7; bottom: -100px; right: -100px; }

        .auth-card {
            width: 100%; max-width: 440px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px; padding: 36px 34px;
            backdrop-filter: blur(20px);
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
            position: relative; z-index: 1;
            animation: slideUp 0.5s ease both;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .brand-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, var(--brand-accent), #7209b7);
            border-radius: 16px; display: flex; align-items: center; justify-content: center;
            font-size: 24px; color: white; margin: 0 auto 20px;
            box-shadow: 0 8px 24px var(--brand-accent-glow);
        }
        .auth-card h1 { font-size: 22px; font-weight: 700; color: #fff; text-align: center; margin-bottom: 4px; }
        .auth-card .subtitle { font-size: 13px; color: rgba(255,255,255,0.4); text-align: center; margin-bottom: 26px; }
        .form-label { font-size: 13px; color: rgba(255,255,255,0.65); font-weight: 500; margin-bottom: 6px; }
        .form-control {
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12);
            color: #fff; border-radius: 10px; padding: 11px 14px; font-size: 14px; transition: all 0.2s;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.1); border-color: var(--brand-accent);
            box-shadow: 0 0 0 3px var(--brand-accent-glow); color: #fff;
        }
        .form-control::placeholder { color: rgba(255,255,255,0.25); }
        .input-group-text {
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.12);
            border-right: none; color: rgba(255,255,255,0.4); border-radius: 10px 0 0 10px;
        }
        .input-group .form-control { border-left: none; border-radius: 0 10px 10px 0; }
        .btn-primary {
            background: linear-gradient(135deg, var(--brand-accent), #3a0ca3);
            border: none; border-radius: 10px; padding: 13px;
            font-size: 15px; font-weight: 600; transition: all 0.25s;
            box-shadow: 0 4px 15px var(--brand-accent-glow);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 8px 25px var(--brand-accent-glow); }
        .auth-link { display: block; text-align: center; color: var(--brand-accent); font-size: 14px; text-decoration: none; margin-top: 16px; }
        .auth-link:hover { color: #7b91f8; text-decoration: underline; }
        .invalid-feedback { font-size: 12px; color: #f87171 !important; }
        .is-invalid { border-color: rgba(220,53,69,0.6) !important; }
        .alert-danger { background: rgba(220,53,69,0.15); border: 1px solid rgba(220,53,69,0.3); color: #f87171; border-radius: 10px; font-size: 13px; padding: 12px 16px; }
        .password-hint { font-size: 11px; color: rgba(255,255,255,0.3); margin-top: 4px; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="brand-icon">
            <i class="bi bi-person-plus-fill"></i>
        </div>
        <h1>Create Account</h1>
        <p class="subtitle">Join {{ config('app.name') }}</p>

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-triangle me-1"></i>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('auth.register.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="Your full name" autofocus required>
                </div>
                @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="you@example.com" required>
                </div>
                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="Min 8 chars, mixed case + number" required>
                </div>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @else
                    <p class="password-hint">Minimum 8 characters with uppercase, lowercase & a number.</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="form-label">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Re-enter password" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-send me-1"></i> Create Account & Send OTP
            </button>
        </form>

        <a href="{{ route('auth.login') }}" class="auth-link">
            Already have an account? <strong>Sign In</strong>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
