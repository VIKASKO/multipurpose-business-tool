@extends('layouts.app')
@php($enableDataTables = true)
@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title"><i class="bi bi-bag-check me-2"></i>Orders</h1>
        <p class="text-muted small mb-0">Manage all customer orders.</p>
    </div>
    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Add</a>
</div>

<div class="card">
    <div class="card-body p-0">
        {{-- Desktop table --}}
        <div class="d-none d-md-block table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead><tr><th>Order #</th><th>Business</th><th>Customer</th><th>Status</th><th>Total</th><th class="text-end">Actions</th></tr></thead>
                <tbody>@forelse($items as $item)<tr><td class="fw-semibold">{{ $item->order_number }}</td><td>{{ $item->business->business_name }}</td><td>{{ $item->customer->customer_name }}</td><td><span class="badge bg-light text-dark border">{{ $item->status }}</span></td><td class="fw-semibold">${{ number_format((float)$item->total_amount,2) }}</td><td class="text-end"><a href="{{ route('orders.edit',$item) }}" class="btn btn-sm btn-outline-secondary">Edit</a> <form method="POST" action="{{ route('orders.destroy',$item) }}" class="d-inline" data-confirm="Delete this order?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@empty <tr><td colspan="6" class="text-center py-4">No records found.</td></tr> @endforelse</tbody>
            </table>
        </div>
        
        {{-- Mobile cards --}}
        <div class="d-md-none p-3">
            @forelse($items as $item)
            <div class="mobile-list-card mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <div class="fw-semibold">#{{ $item->order_number }}</div>
                    <span class="badge bg-light text-dark border">{{ $item->status }}</span>
                </div>
                <div class="text-muted small mb-3">
                    <div><i class="bi bi-building me-1"></i> {{ $item->business->business_name }}</div>
                    <div><i class="bi bi-person me-1"></i> {{ $item->customer->customer_name }}</div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small text-muted">Total Amount</span>
                    <span class="fw-bold">${{ number_format((float)$item->total_amount,2) }}</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('orders.edit',$item) }}" class="btn btn-sm btn-outline-secondary flex-fill">Edit</a>
                    <form method="POST" action="{{ route('orders.destroy',$item) }}" class="flex-fill" data-confirm="Delete this order?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger w-100">Delete</button></form>
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
