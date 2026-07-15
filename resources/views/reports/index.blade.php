@extends('layouts.app')
@php($enableDataTables = false)

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title"><i class="bi bi-file-earmark-bar-graph me-2"></i>Reports & Export</h1>
        <p class="text-muted small mb-0">Analytics and data exports.</p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body p-3">
        <form method="GET" class="row g-2">
            <div class="col-6 col-md-2"><label class="form-label d-md-none">From</label><input type="date" name="from" value="{{ $from->format('Y-m-d') }}" class="form-control"></div>
            <div class="col-6 col-md-2"><label class="form-label d-md-none">To</label><input type="date" name="to" value="{{ $to->format('Y-m-d') }}" class="form-control"></div>
            <div class="col-12 col-md-3"><select name="source_id" class="form-select"><option value="">All Income Sources</option>@foreach($sources as $source)<option value="{{ $source->id }}" @selected((int)request('source_id') === $source->id)>{{ $source->source_name }}</option>@endforeach</select></div>
            <div class="col-12 col-md-3"><select name="category_id" class="form-select"><option value="">All Expense Categories</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((int)request('category_id') === $category->id)>{{ $category->category_name }}</option>@endforeach</select></div>
            <div class="col-12 col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100">Apply Filter</button></div>
        </form>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="stat-card border-success-subtle h-100">
            <div class="text-muted small mb-1"><i class="bi bi-graph-up-arrow text-success me-1"></i> Filtered Income</div>
            <h2 class="h5 mb-0 fw-bold text-success">${{ number_format($incomeTotal, 2) }}</h2>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-card border-danger-subtle h-100">
            <div class="text-muted small mb-1"><i class="bi bi-graph-down-arrow text-danger me-1"></i> Filtered Expenses</div>
            <h2 class="h5 mb-0 fw-bold text-danger">${{ number_format($expenseTotal, 2) }}</h2>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-card bg-primary text-white h-100 border-0 shadow-sm" style="background: linear-gradient(135deg, var(--brand-accent), #7209b7) !important;">
            <div class="text-white-50 small mb-1"><i class="bi bi-piggy-bank text-white me-1"></i> Filtered Profit</div>
            <h2 class="h4 mb-0 fw-bold">${{ number_format($profitTotal, 2) }}</h2>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-bag-check me-2"></i>Orders by Status</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light"><tr><th class="ps-3">Status</th><th class="text-end pe-3">Total Orders</th></tr></thead>
                    <tbody>
                    @forelse($ordersByStatus as $status => $total)
                        <tr><td class="ps-3"><span class="badge bg-light text-dark border">{{ $status }}</span></td><td class="text-end pe-3 fw-medium">{{ $total }}</td></tr>
                    @empty
                        <tr><td colspan="2" class="text-center py-4 text-muted">No orders found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-graph-up me-2"></i>Revenue by Month</span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light"><tr><th class="ps-3">Month</th><th class="text-end pe-3">Revenue</th></tr></thead>
                    <tbody>
                    @forelse($monthlyRevenue as $month => $total)
                        <tr><td class="ps-3 fw-medium">{{ $month }}</td><td class="text-end pe-3 text-success fw-bold">${{ number_format((float)$total, 2) }}</td></tr>
                    @empty
                        <tr><td colspan="2" class="text-center py-4 text-muted">No revenue data.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<h6 class="text-uppercase text-muted fw-bold small mb-3 letter-spacing-1">Export Data (CSV)</h6>
<div class="card mb-4">
    <div class="card-body p-3">
        <div class="row g-2">
            <div class="col-6 col-md-2"><a href="{{ route('export.incomes') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-filetype-csv me-1"></i> Incomes</a></div>
            <div class="col-6 col-md-2"><a href="{{ route('export.expenses') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-filetype-csv me-1"></i> Expenses</a></div>
            <div class="col-6 col-md-2"><a href="{{ route('export.orders') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-filetype-csv me-1"></i> Orders</a></div>
            <div class="col-6 col-md-2"><a href="{{ route('export.customers') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-filetype-csv me-1"></i> Customers</a></div>
            <div class="col-6 col-md-2"><a href="{{ route('export.projects') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-filetype-csv me-1"></i> Projects</a></div>
            <div class="col-6 col-md-2"><a href="{{ route('export.tasks') }}" class="btn btn-outline-secondary w-100"><i class="bi bi-filetype-csv me-1"></i> Tasks</a></div>
        </div>
    </div>
</div>
@endsection
