@extends('layouts.app')
@php($enableDataTables = false)

@section('content')
<div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
    <div>
        <h1 class="page-title"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h1>
        <p class="text-muted small mb-0">Overview of your business performance.</p>
    </div>
    <form method="GET" class="d-flex gap-2 w-100" style="max-width: 300px;">
        <select name="business_id" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">All Businesses</option>
            @foreach($businesses as $business)
                <option value="{{ $business->id }}" @selected($selectedBusinessId === $business->id)>{{ $business->business_name }}</option>
            @endforeach
        </select>
    </form>
</div>

{{-- Financial Overview --}}
<h6 class="text-uppercase text-muted fw-bold small mb-3 mt-4 letter-spacing-1">Financial Overview</h6>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="stat-card border-success-subtle h-100">
            <div class="text-muted small mb-1"><i class="bi bi-graph-up-arrow text-success me-1"></i> Total Income</div>
            <h2 class="h5 mb-0 fw-bold text-success">${{ number_format((float)$overall['total_income'], 2) }}</h2>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="stat-card border-danger-subtle h-100">
            <div class="text-muted small mb-1"><i class="bi bi-graph-down-arrow text-danger me-1"></i> Total Expenses</div>
            <h2 class="h5 mb-0 fw-bold text-danger">${{ number_format((float)$overall['total_expenses'], 2) }}</h2>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-card bg-primary text-white h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, var(--brand-accent), #7209b7) !important;">
            <div class="text-white-50 small mb-1"><i class="bi bi-piggy-bank text-white me-1"></i> Net Profit</div>
            <h2 class="h4 mb-0 fw-bold">${{ number_format((float)$overall['net_profit'], 2) }}</h2>
        </div>
    </div>
</div>

{{-- Operations Overview --}}
<h6 class="text-uppercase text-muted fw-bold small mb-3 mt-4 letter-spacing-1">Operations Overview</h6>
<div class="row g-3 mb-4">
    @foreach([
        ['label' => 'Total Customers', 'value' => $overall['total_customers'], 'icon' => 'bi-people', 'color' => 'text-primary'],
        ['label' => 'New Customers', 'value' => $overall['new_customers_this_month'], 'icon' => 'bi-person-plus', 'color' => 'text-success'],
        ['label' => 'Active Projects', 'value' => $overall['active_projects'], 'icon' => 'bi-kanban', 'color' => 'text-warning'],
        ['label' => 'Pending Tasks', 'value' => $overall['pending_tasks'], 'icon' => 'bi-list-task', 'color' => 'text-info'],
        ['label' => 'Overdue Tasks', 'value' => $overall['overdue_tasks'], 'icon' => 'bi-exclamation-circle', 'color' => 'text-danger'],
        ['label' => 'New Orders', 'value' => $overall['new_orders'], 'icon' => 'bi-bag-plus', 'color' => 'text-primary'],
        ['label' => 'Pending Orders', 'value' => $overall['pending_orders'], 'icon' => 'bi-clock-history', 'color' => 'text-warning'],
        ['label' => 'Delivered Orders', 'value' => $overall['delivered_orders'], 'icon' => 'bi-box-seam', 'color' => 'text-success'],
    ] as $stat)
        <div class="col-6 col-lg-3">
            <div class="stat-card h-100 d-flex flex-column justify-content-center">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <p class="text-muted small mb-0 lh-sm">{{ $stat['label'] }}</p>
                    <i class="bi {{ $stat['icon'] }} {{ $stat['color'] }} fs-5 opacity-75"></i>
                </div>
                <h2 class="h4 mb-0 fw-bold">{{ $stat['value'] }}</h2>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-bank me-2"></i>Account Balances</span>
            </div>
            <ul class="list-group list-group-flush rounded-bottom">
                @forelse($overall['account_balances'] as $name => $balance)
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                        <span class="fw-medium">{{ $name }}</span>
                        <span class="fw-bold {{ $balance < 0 ? 'text-danger' : 'text-success' }}">${{ number_format((float)$balance, 2) }}</span>
                    </li>
                @empty
                    <li class="list-group-item text-muted p-4 text-center">No accounts found.</li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-bar-chart me-2"></i>Profit by Business</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light"><tr><th class="ps-3">Business</th><th>Income</th><th>Expense</th><th class="pe-3">Profit</th></tr></thead>
                    <tbody>
                    @forelse($profitByBusiness as $row)
                        <tr>
                            <td class="ps-3 fw-medium">{{ $row['business'] }}</td>
                            <td class="text-success">${{ number_format($row['income'], 2) }}</td>
                            <td class="text-danger">${{ number_format($row['expense'], 2) }}</td>
                            <td class="pe-3 fw-bold {{ $row['profit'] < 0 ? 'text-danger' : 'text-success' }}">${{ number_format($row['profit'], 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">No business records found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
