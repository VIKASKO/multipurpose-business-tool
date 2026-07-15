@extends('layouts.app')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center text-center vh-100 py-5">
    <div class="mb-4">
        <i class="bi bi-file-earmark-x text-muted" style="font-size: 5rem;"></i>
    </div>
    <h1 class="display-4 fw-bold mb-3">404</h1>
    <h2 class="h4 mb-4 text-muted">Page Not Found</h2>
    <p class="mb-4 text-muted mx-auto" style="max-width: 400px;">
        The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
    </p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 py-2">
        <i class="bi bi-house me-2"></i> Back to Dashboard
    </a>
</div>
@endsection
