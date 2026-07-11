@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Dashboard</h1>
        <form method="GET" class="d-flex gap-2">
            <select name="business_id" class="form-select form-select-sm">
                <option value="">All Businesses</option>
                @foreach($businesses as $business)
                    <option value="{{ $business->id }}" @selected($selectedBusinessId === $business->id)>{{ $business->business_name }}</option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-primary">Filter</button>
        </form>
    </div>

    <div class="row g-3 mb-4">
        @foreach([
            'Total Income' => $overall['total_income'],
            'Total Expenses' => $overall['total_expenses'],
            'Net Profit' => $overall['net_profit'],
            'Total Customers' => $overall['total_customers'],
            'New Customers This Month' => $overall['new_customers_this_month'],
            'Active Projects' => $overall['active_projects'],
            'Completed Projects' => $overall['completed_projects'],
            'Pending Tasks' => $overall['pending_tasks'],
            'Overdue Tasks' => $overall['overdue_tasks'],
            'New Orders' => $overall['new_orders'],
            'Pending Orders' => $overall['pending_orders'],
            'Delivered Orders' => $overall['delivered_orders'],
        ] as $label => $value)
            <div class="col-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <p class="text-muted small mb-1">{{ $label }}</p>
                        <h2 class="h5 mb-0">{{ is_numeric($value) ? number_format((float)$value, 2) : $value }}</h2>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-3">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Account Balances</div>
                <ul class="list-group list-group-flush">
                    @forelse($overall['account_balances'] as $name => $balance)
                        <li class="list-group-item d-flex justify-content-between"><span>{{ $name }}</span><span>{{ number_format((float)$balance, 2) }}</span></li>
                    @empty
                        <li class="list-group-item text-muted">No accounts found.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">Profit by Business</div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead><tr><th>Business</th><th>Income</th><th>Expense</th><th>Profit</th></tr></thead>
                        <tbody>
                        @foreach($profitByBusiness as $row)
                            <tr>
                                <td>{{ $row['business'] }}</td>
                                <td>{{ number_format($row['income'], 2) }}</td>
                                <td>{{ number_format($row['expense'], 2) }}</td>
                                <td>{{ number_format($row['profit'], 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
