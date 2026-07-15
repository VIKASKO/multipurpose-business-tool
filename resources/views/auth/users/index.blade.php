@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="bi bi-people me-2"></i>User Management</h1>
    <p class="text-muted small">Manage who has access to this system.</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-1"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body p-0">
        {{-- Desktop table --}}
        <div class="d-none d-md-block table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Verified</th>
                        <th>Joined</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <form method="POST" action="{{ route('auth.users.update-role', $user) }}" class="d-inline">
                                @csrf @method('PATCH')
                                <select name="role" class="form-select form-select-sm w-auto d-inline-block"
                                    onchange="this.form.submit()" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                    <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                    <option value="staff" @selected($user->role === 'staff')>Staff</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="text-success small"><i class="bi bi-check-circle-fill"></i> Verified</span>
                            @else
                                <span class="text-warning small"><i class="bi bi-clock-fill"></i> Pending</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="text-end">
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('auth.users.toggle-active', $user) }}" class="d-inline">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm {{ $user->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                        {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('auth.users.destroy', $user) }}" class="d-inline"
                                    data-confirm="Delete {{ $user->name }}? This cannot be undone.">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @else
                                <span class="text-muted small">(You)</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile cards --}}
        <div class="d-md-none p-3">
            @forelse($users as $user)
            <div class="mobile-list-card mb-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <div class="fw-semibold">{{ $user->name }}</div>
                        <div class="text-muted small">{{ $user->email }}</div>
                    </div>
                    <div class="d-flex gap-1 flex-wrap justify-content-end">
                        <span class="badge {{ $user->role === 'admin' ? 'bg-primary' : 'bg-secondary' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                        <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                @if($user->id !== auth()->id())
                <div class="d-flex gap-2 mt-2">
                    <form method="POST" action="{{ route('auth.users.toggle-active', $user) }}" class="flex-fill">
                        @csrf @method('PATCH')
                        <button class="btn btn-sm w-100 {{ $user->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                            {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('auth.users.destroy', $user) }}" class="flex-fill"
                        data-confirm="Delete {{ $user->name }}?">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger w-100">Delete</button>
                    </form>
                </div>
                @endif
            </div>
            @empty
            <p class="text-muted text-center py-4">No users found.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
