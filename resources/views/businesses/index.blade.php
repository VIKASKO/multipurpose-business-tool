5@extends('layouts.app')
@php($enableDataTables = true)
@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title"><i class="bi bi-building me-2"></i>Businesses</h1>
        <p class="text-muted small mb-0">Manage your business profiles.</p>
    </div>
    <a href="{{ route('businesses.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Add</a>
</div>

<div class="card">
    <div class="card-body p-0">
        {{-- Desktop table --}}
        <div class="d-none d-md-block table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead><tr><th>Name</th><th>Type</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
                <tbody>@forelse($items as $item)<tr><td class="fw-semibold">{{ $item->business_name }}</td><td>{{ $item->business_type }}</td><td><span class="badge bg-light text-dark border">{{ $item->status }}</span></td><td class="text-end"><a href="{{ route('businesses.edit',$item) }}" class="btn btn-sm btn-outline-secondary">Edit</a> <form method="POST" action="{{ route('businesses.destroy',$item) }}" class="d-inline" data-confirm="Delete this business?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@empty <tr><td colspan="4" class="text-center py-4">No records found.</td></tr> @endforelse</tbody>
            </table>
        </div>
        
        {{-- Mobile cards --}}
        <div class="d-md-none p-3">
            @forelse($items as $item)
            <div class="mobile-list-card mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <div class="fw-semibold">{{ $item->business_name }}</div>
                    <span class="badge bg-light text-dark border">{{ $item->status }}</span>
                </div>
                <div class="text-muted small mb-3">
                    <div><i class="bi bi-tag me-1"></i> {{ $item->business_type }}</div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('businesses.edit',$item) }}" class="btn btn-sm btn-outline-secondary flex-fill">Edit</a>
                    <form method="POST" action="{{ route('businesses.destroy',$item) }}" class="flex-fill" data-confirm="Delete this business?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger w-100">Delete</button></form>
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
