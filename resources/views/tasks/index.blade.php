@extends('layouts.app')
@php($enableDataTables = true)
@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title"><i class="bi bi-check2-square me-2"></i>Tasks</h1>
        <p class="text-muted small mb-0">Manage project tasks and deadlines.</p>
    </div>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg me-1"></i> Add</a>
</div>

<div class="card mb-4">
    <div class="card-body p-3">
        <form method="GET">
            <div class="input-group">
                <span class="input-group-text bg-transparent"><i class="bi bi-funnel"></i></span>
                <select class="form-select border-start-0 ps-0" name="status"><option value="">All Statuses</option>@foreach(['Pending','In Progress','Completed'] as $status)<option value="{{ $status }}" @selected(request('status')===$status)>{{ $status }}</option>@endforeach</select>
                <button class="btn btn-outline-primary">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        {{-- Desktop table --}}
        <div class="d-none d-md-block table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead><tr><th>Task</th><th>Project</th><th>Priority</th><th>Status</th><th>Due</th><th class="text-end">Actions</th></tr></thead>
                <tbody>@forelse($items as $item)<tr><td class="fw-semibold">{{ $item->task_name }}</td><td>{{ $item->project->project_name }}</td><td><span class="badge {{ $item->priority === 'High' ? 'bg-danger' : ($item->priority === 'Medium' ? 'bg-warning text-dark' : 'bg-info text-dark') }}">{{ $item->priority }}</span></td><td><span class="badge bg-light text-dark border">{{ $item->status }}</span></td><td>{{ optional($item->due_date)->format('d M Y') ?: '-' }}</td><td class="text-end"><a href="{{ route('tasks.edit',$item) }}" class="btn btn-sm btn-outline-secondary">Edit</a> <form method="POST" action="{{ route('tasks.destroy',$item) }}" class="d-inline" data-confirm="Delete this task?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@empty <tr><td colspan="6" class="text-center py-4">No records found.</td></tr> @endforelse</tbody>
            </table>
        </div>
        
        {{-- Mobile cards --}}
        <div class="d-md-none p-3">
            @forelse($items as $item)
            <div class="mobile-list-card mb-3">
                <div class="d-flex justify-content-between mb-2">
                    <div class="fw-semibold">{{ $item->task_name }}</div>
                    <span class="badge bg-light text-dark border">{{ $item->status }}</span>
                </div>
                <div class="text-muted small mb-3">
                    <div><i class="bi bi-kanban me-1"></i> {{ $item->project->project_name }}</div>
                    @if($item->due_date)<div><i class="bi bi-calendar-event me-1"></i> {{ optional($item->due_date)->format('d M Y') }}</div>@endif
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="small text-muted">Priority</span>
                    <span class="badge {{ $item->priority === 'High' ? 'bg-danger' : ($item->priority === 'Medium' ? 'bg-warning text-dark' : 'bg-info text-dark') }}">{{ $item->priority }}</span>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('tasks.edit',$item) }}" class="btn btn-sm btn-outline-secondary flex-fill">Edit</a>
                    <form method="POST" action="{{ route('tasks.destroy',$item) }}" class="flex-fill" data-confirm="Delete this task?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger w-100">Delete</button></form>
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
