<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @if (!empty($enableDataTables))
        <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    @endif
    <style>
        /* ── Design System ───────────────────────────── */
        :root {
            --sidebar-w: 260px;
            --topbar-h: 60px;
            --brand-dark: #0f0f1a;
            --brand-mid: #1a1a2e;
            --brand-accent: #4361ee;
            --brand-accent-light: rgba(67, 97, 238, 0.12);
            --brand-hover: rgba(67, 97, 238, 0.18);
            --text-primary: #e2e8f0;
            --text-muted: rgba(226, 232, 240, 0.5);
            --border-color: rgba(255, 255, 255, 0.08);
            --card-bg: #ffffff;
            --body-bg: #f1f5f9;
        }

        * { box-sizing: border-box; }

        body {
            background: var(--body-bg);
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            margin: 0;
        }

        /* ── Top Navbar ─────────────────────────────── */
        .topbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1040;
            height: var(--topbar-h);
            background: linear-gradient(135deg, var(--brand-dark) 0%, #16213e 100%);
            border-bottom: 1px solid var(--border-color);
            display: flex; align-items: center;
            padding: 0 16px; gap: 12px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
        }

        .topbar-brand {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none; flex: 1;
        }

        .brand-logo {
            width: 36px; height: 36px; border-radius: 10px;
            background: linear-gradient(135deg, var(--brand-accent), #7209b7);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: white;
            box-shadow: 0 3px 10px rgba(67, 97, 238, 0.4);
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 16px; font-weight: 700; color: white;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        .topbar-hamburger {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 8px;
            color: white; font-size: 18px;
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; flex-shrink: 0;
            transition: background 0.2s;
        }
        .topbar-hamburger:hover { background: rgba(255,255,255,0.14); }

        .topbar-right {
            display: flex; align-items: center; gap: 10px; flex-shrink: 0;
        }

        .user-chip {
            display: flex; align-items: center; gap: 8px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 50px; padding: 5px 12px 5px 5px;
            cursor: pointer; transition: background 0.2s;
            text-decoration: none;
        }
        .user-chip:hover { background: rgba(255,255,255,0.14); }

        .user-avatar {
            width: 28px; height: 28px; border-radius: 50%;
            background: linear-gradient(135deg, var(--brand-accent), #7209b7);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: white; flex-shrink: 0;
        }

        .user-name {
            font-size: 13px; color: rgba(255,255,255,0.85); font-weight: 500;
            max-width: 120px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
        }

        @media (max-width: 480px) {
            .user-name { display: none; }
        }

        /* ── Off-Canvas Sidebar ─────────────────────── */
        .sidebar-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.5);
            z-index: 1045; opacity: 0; pointer-events: none;
            transition: opacity 0.3s;
        }
        .sidebar-overlay.show { opacity: 1; pointer-events: all; }

        .sidebar {
            position: fixed; top: 0; left: -var(--sidebar-w); left: calc(-1 * var(--sidebar-w));
            width: var(--sidebar-w); height: 100vh; z-index: 1050;
            background: linear-gradient(180deg, var(--brand-dark) 0%, #16213e 100%);
            display: flex; flex-direction: column;
            transition: transform 0.32s cubic-bezier(0.25, 0.8, 0.25, 1);
            transform: translateX(0);
            border-right: 1px solid var(--border-color);
            overflow-y: auto; overscroll-behavior: contain;
        }

        .sidebar.open { transform: translateX(var(--sidebar-w)); }

        /* Desktop: always visible sidebar */
        @media (min-width: 992px) {
            .sidebar {
                transform: translateX(var(--sidebar-w)) !important;
                box-shadow: none;
            }
            .sidebar-overlay { display: none !important; }
            .topbar-hamburger { display: none; }
            .main-content { margin-left: var(--sidebar-w); }
        }

        .sidebar-header {
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--border-color);
            display: flex; align-items: center; justify-content: space-between;
        }

        .sidebar-brand { display: flex; align-items: center; gap: 10px; }

        .sidebar-brand-logo {
            width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg, var(--brand-accent), #7209b7);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; color: white;
        }

        .sidebar-brand-text { font-size: 15px; font-weight: 700; color: white; line-height: 1.2; }
        .sidebar-brand-sub { font-size: 11px; color: var(--text-muted); }

        .sidebar-close {
            background: rgba(255,255,255,0.08); border: none;
            border-radius: 8px; color: var(--text-muted);
            width: 32px; height: 32px; display: flex; align-items: center;
            justify-content: center; cursor: pointer; font-size: 16px;
            transition: all 0.2s;
        }
        .sidebar-close:hover { background: rgba(255,255,255,0.14); color: white; }

        @media (min-width: 992px) { .sidebar-close { display: none; } }

        .sidebar-user {
            margin: 16px; padding: 12px;
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            display: flex; align-items: center; gap: 10px;
        }

        .sidebar-user-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg, var(--brand-accent), #7209b7);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700; color: white; flex-shrink: 0;
        }

        .sidebar-user-name { font-size: 13px; font-weight: 600; color: var(--text-primary); }
        .sidebar-user-role {
            font-size: 11px; color: var(--text-muted);
            text-transform: uppercase; letter-spacing: 0.5px;
        }

        /* ── Sidebar Navigation ─────────────────────── */
        .sidebar-nav { flex: 1; padding: 8px 12px; }

        .nav-section-label {
            font-size: 10px; font-weight: 700; letter-spacing: 1.2px;
            color: var(--text-muted); text-transform: uppercase;
            padding: 12px 8px 6px; margin-top: 4px;
        }

        .sidebar-link {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px; margin-bottom: 2px;
            color: var(--text-muted); text-decoration: none;
            font-size: 14px; font-weight: 500;
            transition: all 0.18s;
        }

        .sidebar-link i { font-size: 17px; flex-shrink: 0; width: 20px; text-align: center; }

        .sidebar-link:hover {
            background: var(--brand-hover); color: white;
        }

        .sidebar-link.active {
            background: var(--brand-accent-light);
            color: #818cf8;
            font-weight: 600;
            border-left: 3px solid var(--brand-accent);
        }

        .sidebar-link.active i { color: var(--brand-accent); }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border-color);
        }

        .logout-btn {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px; width: 100%;
            background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.15);
            color: #f87171; font-size: 14px; font-weight: 500;
            cursor: pointer; transition: all 0.2s; text-decoration: none;
        }
        .logout-btn:hover { background: rgba(239,68,68,0.15); color: #fca5a5; }
        .logout-btn i { font-size: 17px; }

        /* ── Main Content ────────────────────────────── */
        .main-content {
            margin-top: var(--topbar-h);
            min-height: calc(100vh - var(--topbar-h));
            padding: 20px 16px 100px;
            transition: margin-left 0.32s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        @media (min-width: 768px) { .main-content { padding: 24px 24px 40px; } }

        /* ── Page Components ─────────────────────────── */
        .page-header {
            margin-bottom: 20px;
        }
        .page-title {
            font-size: 20px; font-weight: 700; color: #1e293b; margin: 0 0 4px;
        }
        @media (min-width: 768px) { .page-title { font-size: 24px; } }

        .card {
            border: none; border-radius: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 4px 16px rgba(0,0,0,0.04);
        }

        .card-header {
            background: white; border-bottom: 1px solid rgba(0,0,0,0.06);
            font-weight: 600; border-radius: 14px 14px 0 0 !important;
            padding: 14px 20px;
        }

        /* ── Mobile List Cards ───────────────────────── */
        .mobile-list-card {
            background: white;
            border-radius: 12px;
            padding: 14px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.05);
        }

        /* ── Stat Cards ──────────────────────────────── */
        .stat-card {
            background: white; border-radius: 14px; padding: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            border: 1px solid rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.1); }

        /* ── Alerts ──────────────────────────────────── */
        .alert-success {
            background: rgba(16,185,129,0.1);
            border: 1px solid rgba(16,185,129,0.25);
            color: #065f46; border-radius: 10px;
        }

        .alert-danger {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.25);
            color: #7f1d1d; border-radius: 10px;
        }

        /* ── Tables ──────────────────────────────────── */
        .table { font-size: 14px; }
        .table th {
            font-size: 12px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.5px; color: #64748b; background: #f8fafc;
            border-bottom: 1px solid #e2e8f0; padding: 12px 16px;
        }
        .table td { padding: 12px 16px; vertical-align: middle; border-color: #f1f5f9; }
        .table-hover tbody tr:hover { background: #f8fafc; }

        /* ── Buttons ─────────────────────────────────── */
        .btn { border-radius: 8px; font-size: 14px; font-weight: 500; min-height: 40px; }
        .btn-sm { min-height: 34px; font-size: 13px; }
        .btn-primary { background: var(--brand-accent); border-color: var(--brand-accent); }
        .btn-primary:hover { background: #3451d1; border-color: #3451d1; }

        /* ── Form Controls ───────────────────────────── */
        .form-control, .form-select { border-radius: 8px; font-size: 14px; min-height: 40px; }
        .form-label { font-weight: 500; font-size: 13px; color: #374151; }

        /* ── Toast ───────────────────────────────────── */
        .toast-container { z-index: 9999; }
        .toast { border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); }

        /* ── Pagination ──────────────────────────────── */
        .pagination { flex-wrap: wrap; gap: 4px; }
        .page-link { border-radius: 6px !important; min-width: 36px; text-align: center; }
    </style>
    @stack('styles')
</head>
<body>

{{-- ─── Top Navbar ──────────────────────────────────────────────────────── --}}
<header class="topbar">
    <button class="topbar-hamburger" id="sidebar-toggle" aria-label="Toggle menu">
        <i class="bi bi-list"></i>
    </button>
    <a href="{{ route('dashboard') }}" class="topbar-brand">
        <div class="brand-logo"><i class="bi bi-briefcase-fill"></i></div>
        <span class="brand-name">{{ config('app.name') }}</span>
    </a>
    <div class="topbar-right">
        <div class="dropdown">
            <a class="user-chip" href="#" role="button" data-bs-toggle="dropdown">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <span class="user-name">{{ auth()->user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end mt-1">
                <li><span class="dropdown-item-text text-muted small">{{ auth()->user()->email }}</span></li>
                <li><span class="dropdown-item-text">
                    <span class="badge {{ auth()->user()->isAdmin() ? 'bg-primary' : 'bg-secondary' }}">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </span></li>
                <li><hr class="dropdown-divider"></li>
                @if(auth()->user()->isAdmin())
                <li><a class="dropdown-item" href="{{ route('auth.users.index') }}"><i class="bi bi-people me-2"></i>User Management</a></li>
                <li><hr class="dropdown-divider"></li>
                @endif
                <li>
                    <form method="POST" action="{{ route('auth.logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

{{-- ─── Sidebar Overlay ──────────────────────────────────────────────────── --}}
<div class="sidebar-overlay" id="sidebar-overlay"></div>

{{-- ─── Sidebar ──────────────────────────────────────────────────────────── --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <div class="sidebar-brand-logo"><i class="bi bi-briefcase-fill"></i></div>
            <div>
                <div class="sidebar-brand-text">{{ config('app.name') }}</div>
                <div class="sidebar-brand-sub">Business ERP</div>
            </div>
        </div>
        <button class="sidebar-close" id="sidebar-close"><i class="bi bi-x-lg"></i></button>
    </div>

    <div class="sidebar-user">
        <div class="sidebar-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div>
            <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
            <div class="sidebar-user-role">{{ auth()->user()->role }}</div>
        </div>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section-label">Finance</div>
        <a href="{{ route('incomes.index') }}" class="sidebar-link {{ request()->routeIs('incomes.*') ? 'active' : '' }}">
            <i class="bi bi-graph-up-arrow"></i> Income
        </a>
        <a href="{{ route('expenses.index') }}" class="sidebar-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
            <i class="bi bi-graph-down-arrow"></i> Expenses
        </a>
        <a href="{{ route('accounts.index') }}" class="sidebar-link {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
            <i class="bi bi-bank"></i> Accounts
        </a>

        <div class="nav-section-label">Operations</div>
        <a href="{{ route('customers.index') }}" class="sidebar-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Customers
        </a>
        <a href="{{ route('orders.index') }}" class="sidebar-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
            <i class="bi bi-bag-check"></i> Orders
        </a>
        <a href="{{ route('projects.index') }}" class="sidebar-link {{ request()->routeIs('projects.*') ? 'active' : '' }}">
            <i class="bi bi-kanban"></i> Projects
        </a>
        <a href="{{ route('tasks.index') }}" class="sidebar-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}">
            <i class="bi bi-check2-square"></i> Tasks
        </a>

        <div class="nav-section-label">Settings</div>
        <a href="{{ route('businesses.index') }}" class="sidebar-link {{ request()->routeIs('businesses.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i> Businesses
        </a>
        <a href="{{ route('reports.index') }}" class="sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-bar-graph"></i> Reports & Export
        </a>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('auth.users.index') }}" class="sidebar-link {{ request()->routeIs('auth.users.*') ? 'active' : '' }}">
            <i class="bi bi-shield-lock"></i> Users
        </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('auth.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-left"></i> Sign Out
            </button>
        </form>
    </div>
</aside>

{{-- ─── Main Content ─────────────────────────────────────────────────────── --}}
<main class="main-content">

    {{-- Success Toast --}}
    @if (session('success'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div class="toast align-items-center text-bg-success border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body"><i class="bi bi-check-circle me-1"></i> {{ session('success') }}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>
    @endif

    {{-- Error Alert --}}
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i>
        <ul class="mb-0 ps-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@if (!empty($enableDataTables))
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
@endif
<script>
    // ── Sidebar Toggle ────────────────────────────────────────────────────────
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const toggleBtn = document.getElementById('sidebar-toggle');
    const closeBtn = document.getElementById('sidebar-close');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
        document.body.style.overflow = '';
    }

    toggleBtn?.addEventListener('click', openSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);

    // Close sidebar on nav link click (mobile)
    document.querySelectorAll('.sidebar-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 992) closeSidebar();
        });
    });

    // ── Delete Confirm ────────────────────────────────────────────────────────
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!confirm(form.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });

    // ── Auto-dismiss Toast ────────────────────────────────────────────────────
    document.querySelectorAll('.toast').forEach(el => {
        setTimeout(() => {
            const toast = bootstrap.Toast.getOrCreateInstance(el);
            toast.hide();
        }, 4000);
    });

    @if (!empty($enableDataTables))
        $('table.table.table-striped').DataTable({
            paging: false,
            info: false,
        });
    @endif
</script>
@stack('scripts')
</body>
</html>
