@extends('layouts.app')
@php($enableDataTables = true)
@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title"><i class="bi bi-people me-2"></i>Customers</h1>
        <p class="text-muted small mb-0">Manage your customer database.</p>
    </div>
    <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Add</a>
</div>

<div class="card mb-4">
    <div class="card-body p-3">
        <form method="GET">
            <div class="input-group">
                <span class="input-group-text bg-transparent"><i class="bi bi-search"></i></span>
                <input class="form-control border-start-0 ps-0" placeholder="Search name, mobile, or email" name="search" value="{{ request('search') }}">
                <button class="btn btn-outline-primary">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        {{-- Desktop table --}}
        <div class="d-none d-md-block table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead><tr><th>Business</th><th>Name</th><th>Mobile</th><th>Email</th><th class="text-end">Actions</th></tr></thead>
                <tbody>@forelse($items as $item)<tr><td>{{ $item->business->business_name }}</td><td class="fw-semibold">{{ $item->customer_name }}</td><td>{{ $item->mobile }}</td><td>{{ $item->email }}</td><td class="text-end"><a href="{{ route('customers.edit',$item) }}" class="btn btn-sm btn-outline-secondary">Edit</a> <form method="POST" action="{{ route('customers.destroy',$item) }}" class="d-inline" data-confirm="Delete this customer?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@empty <tr><td colspan="5" class="text-center py-4">No records found.</td></tr> @endforelse</tbody>
            </table>
        </div>
        
        {{-- Mobile cards --}}
        <div class="d-md-none p-3">
            @forelse($items as $item)
            <div class="mobile-list-card mb-3">
                <div class="fw-semibold mb-1">{{ $item->customer_name }}</div>
                <div class="text-muted small mb-3">
                    <div><i class="bi bi-building me-1"></i> {{ $item->business->business_name }}</div>
                    @if($item->mobile)<div><i class="bi bi-telephone me-1"></i> {{ $item->mobile }}</div>@endif
                    @if($item->email)<div><i class="bi bi-envelope me-1"></i> {{ $item->email }}</div>@endif
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('customers.edit',$item) }}" class="btn btn-sm btn-outline-secondary flex-fill">Edit</a>
                    <form method="POST" action="{{ route('customers.destroy',$item) }}" class="flex-fill" data-confirm="Delete this customer?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger w-100">Delete</button></form>
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
