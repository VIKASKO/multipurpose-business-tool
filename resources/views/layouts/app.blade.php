<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - ERP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-md-block bg-light sidebar collapse min-vh-100">
            <div class="position-sticky p-3">
                <h6 class="mb-3">Business ERP</h6>
                <div class="nav flex-column nav-pills gap-1">
                    <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="nav-link" href="{{ route('businesses.index') }}">Businesses</a>
                    <a class="nav-link" href="{{ route('accounts.index') }}">Accounts</a>
                    <a class="nav-link" href="{{ route('incomes.index') }}">Income</a>
                    <a class="nav-link" href="{{ route('expenses.index') }}">Expenses</a>
                    <a class="nav-link" href="{{ route('customers.index') }}">Customers</a>
                    <a class="nav-link" href="{{ route('orders.index') }}">Orders</a>
                    <a class="nav-link" href="{{ route('projects.index') }}">Projects</a>
                    <a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a>
                    <a class="nav-link" href="{{ route('reports.index') }}">Reports</a>
                </div>
            </div>
        </nav>
        <main class="col-md-10 ms-sm-auto px-4 py-4">
            @if (session('success'))
                <div class="toast align-items-center text-bg-success border-0 show mb-3" role="alert">
                    <div class="d-flex">
                        <div class="toast-body">{{ session('success') }}</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script>
    document.querySelectorAll('form[data-confirm]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!confirm(form.dataset.confirm)) {
                event.preventDefault();
            }
        });
    });

    $('table.table.table-striped').DataTable({
        paging: false,
        info: false,
    });
</script>
@stack('scripts')
</body>
</html>
