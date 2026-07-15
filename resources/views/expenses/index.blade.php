@extends('layouts.app')
@php($enableDataTables = true)
@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title"><i class="bi bi-graph-down-arrow me-2"></i>Expenses</h1>
        <p class="text-muted small mb-0">Manage all expense records.</p>
    </div>
    <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Add</a>
</div>

<div class="card mb-4">
    <div class="card-body p-3">
        <form method="GET" class="row g-2">
            <div class="col-12 col-md-3"><label class="form-label d-md-none">From</label><input type="date" class="form-control" name="from" value="{{ request('from') }}"></div>
            <div class="col-12 col-md-3"><label class="form-label d-md-none">To</label><input type="date" class="form-control" name="to" value="{{ request('to') }}"></div>
            <div class="col-12 col-md-4"><label class="form-label d-md-none">Category</label><select class="form-select" name="category_id"><option value="">All Categories</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((int)request('category_id')===$category->id)>{{ $category->category_name }}</option>@endforeach</select></div>
            <div class="col-12 col-md-2 d-flex align-items-end"><button class="btn btn-outline-primary w-100">Filter</button></div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        {{-- Desktop table --}}
        <div class="d-none d-md-block table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead><tr><th>Date</th><th>Business</th><th>Category</th><th>Account</th><th>Amount</th><th class="text-end">Actions</th></tr></thead>
                <tbody>@forelse($items as $item)<tr><td>{{ $item->date?->format('d M Y') }}</td><td>{{ $item->business->business_name }}</td><td><span class="badge bg-light text-dark border">{{ $item->category->category_name }}</span></td><td>{{ $item->account->account_name }}</td><td class="fw-semibold text-danger">${{ number_format((float)$item->amount,2) }}</td><td class="text-end"><a href="{{ route('expenses.edit',$item) }}" class="btn btn-sm btn-outline-secondary">Edit</a> <form method="POST" action="{{ route('expenses.destroy',$item) }}" class="d-inline" data-confirm="Delete this expense?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@empty <tr><td colspan="6" class="text-center py-4">No records found.</td></tr> @endforelse</tbody>
            </table>
        </div>
        
        {{-- Mobile cards --}}
        <div class="d-md-none p-3">
            @forelse($items as $item)
            <div class="mobile-list-card mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <div class="fw-semibold">{{ $item->business->business_name }}</div>
                    <div class="fw-bold text-danger">${{ number_format((float)$item->amount,2) }}</div>
                </div>
                <div class="text-muted small mb-3">
                    <div><i class="bi bi-calendar3 me-1"></i> {{ $item->date?->format('d M Y') }}</div>
                    <div><i class="bi bi-tag me-1"></i> {{ $item->category->category_name }} &bull; <i class="bi bi-bank me-1"></i> {{ $item->account->account_name }}</div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('expenses.edit',$item) }}" class="btn btn-sm btn-outline-secondary flex-fill">Edit</a>
                    <form method="POST" action="{{ route('expenses.destroy',$item) }}" class="flex-fill" data-confirm="Delete this expense?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger w-100">Delete</button></form>
                </div>
            </div>
            @empty
            <div class="text-center py-4 text-muted">No records found.</div>
            @endforelse
        </div>
    </div>
</div>
<div class="mt-3">{{ $items->links() }}</div>
@endsection
