<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root {
            --brand-dark: #0f0f1a;
            --brand-mid: #1a1a2e;
            --brand-accent: #4361ee;
            --brand-accent-glow: rgba(67,97,238,0.35);
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            background: var(--brand-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', system-ui, sans-serif;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        /* Animated background orbs */
        body::before, body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 8s ease-in-out infinite;
            pointer-events: none;
        }
        body::before {
            width: 400px; height: 400px;
            background: var(--brand-accent);
            top: -100px; left: -100px;
        }
        body::after {
            width: 350px; height: 350px;
            background: #7209b7;
            bottom: -100px; right: -100px;
            animation-delay: -4s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 40px 36px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 25px 60px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.05);
            position: relative;
            z-index: 1;
            animation: slideUp 0.5s ease both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, var(--brand-accent), #7209b7);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            color: white;
            margin: 0 auto 20px;
            box-shadow: 0 8px 24px var(--brand-accent-glow);
        }

        .auth-card h1 {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
            text-align: center;
            margin-bottom: 4px;
        }

        .auth-card .subtitle {
            font-size: 14px;
            color: rgba(255,255,255,0.45);
            text-align: center;
            margin-bottom: 28px;
        }

        .form-label {
            font-size: 13px;
            color: rgba(255,255,255,0.65);
            font-weight: 500;
            margin-bottom: 6px;
        }

        .form-control {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            color: #fff;
            border-radius: 10px;
            padding: 12px 14px;
            font-size: 15px;
            transition: all 0.2s;
        }

        .form-control:focus {
            background: rgba(255,255,255,0.1);
            border-color: var(--brand-accent);
            box-shadow: 0 0 0 3px var(--brand-accent-glow);
            color: #fff;
        }

        .form-control::placeholder { color: rgba(255,255,255,0.25); }

        .input-group-text {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-right: none;
            color: rgba(255,255,255,0.4);
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--brand-accent), #3a0ca3);
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: all 0.25s;
            box-shadow: 0 4px 15px var(--brand-accent-glow);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px var(--brand-accent-glow);
        }

        .btn-primary:active { transform: translateY(0); }

        .divider {
            display: flex; align-items: center; gap: 12px;
            margin: 20px 0;
            color: rgba(255,255,255,0.2);
            font-size: 12px;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1;
            height: 1px; background: rgba(255,255,255,0.1);
        }

        .auth-link {
            display: block;
            text-align: center;
            color: var(--brand-accent);
            font-size: 14px;
            text-decoration: none;
            transition: color 0.2s;
        }

        .auth-link:hover { color: #7b91f8; text-decoration: underline; }

        .form-check-input {
            background-color: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.2);
        }
        .form-check-input:checked {
            background-color: var(--brand-accent);
            border-color: var(--brand-accent);
        }
        .form-check-label { color: rgba(255,255,255,0.55); font-size: 13px; }

        .invalid-feedback { font-size: 12px; }

        .alert-danger {
            background: rgba(220,53,69,0.15);
            border: 1px solid rgba(220,53,69,0.3);
            color: #f87171;
            border-radius: 10px;
            font-size: 14px;
            padding: 12px 16px;
        }

        .alert-success {
            background: rgba(25,135,84,0.15);
            border: 1px solid rgba(25,135,84,0.3);
            color: #6ee7b7;
            border-radius: 10px;
            font-size: 14px;
            padding: 12px 16px;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="brand-icon">
            <i class="bi bi-briefcase-fill"></i>
        </div>
        <h1>Welcome Back</h1>
        <p class="subtitle">Sign in to {{ config('app.name') }}</p>

        @if(session('success'))
            <div class="alert alert-success mb-3">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-success mb-3" style="background:rgba(67,97,238,0.15);border-color:rgba(67,97,238,0.3);color:#a5b4fc;">
                <i class="bi bi-info-circle me-1"></i> {{ session('info') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-3">
                <i class="bi bi-exclamation-triangle me-1"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('auth.login.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}"
                        placeholder="you@example.com"
                        autofocus
                        autocomplete="email"
                        required
                    >
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        required
                    >
                </div>
            </div>

            <div class="mb-4 d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
            </button>
        </form>

        <div class="divider">or</div>

        <a href="{{ route('auth.register') }}" class="auth-link">
            Don't have an account? <strong>Register</strong>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
