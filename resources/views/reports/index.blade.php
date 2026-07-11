@extends('layouts.app')
@php($enableDataTables = true)

@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Reports</h1></div>
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-2"><input type="date" name="from" value="{{ $from->format('Y-m-d') }}" class="form-control form-control-sm"></div>
    <div class="col-md-2"><input type="date" name="to" value="{{ $to->format('Y-m-d') }}" class="form-control form-control-sm"></div>
    <div class="col-md-3"><select name="source_id" class="form-select form-select-sm"><option value="">All Income Sources</option>@foreach($sources as $source)<option value="{{ $source->id }}" @selected((int)request('source_id') === $source->id)>{{ $source->source_name }}</option>@endforeach</select></div>
    <div class="col-md-3"><select name="category_id" class="form-select form-select-sm"><option value="">All Expense Categories</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected((int)request('category_id') === $category->id)>{{ $category->category_name }}</option>@endforeach</select></div>
    <div class="col-md-2"><button class="btn btn-sm btn-primary">Apply</button></div>
</form>
<div class="row g-3 mb-3">
    <div class="col-md-4"><div class="card"><div class="card-body"><div class="small text-muted">Income Report</div><div class="h5 mb-0">{{ number_format($incomeTotal,2) }}</div></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body"><div class="small text-muted">Expense Report</div><div class="h5 mb-0">{{ number_format($expenseTotal,2) }}</div></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body"><div class="small text-muted">Profit Report</div><div class="h5 mb-0">{{ number_format($profitTotal,2) }}</div></div></div></div>
</div>
<div class="row g-3">
    <div class="col-md-6"><div class="card"><div class="card-header">Orders by Status</div><div class="table-responsive"><table class="table table-striped mb-0"><thead><tr><th>Status</th><th>Total</th></tr></thead><tbody>@foreach($ordersByStatus as $status => $total)<tr><td>{{ $status }}</td><td>{{ $total }}</td></tr>@endforeach</tbody></table></div></div></div>
    <div class="col-md-6"><div class="card"><div class="card-header">Revenue by Month</div><div class="table-responsive"><table class="table table-striped mb-0"><thead><tr><th>Month</th><th>Revenue</th></tr></thead><tbody>@foreach($monthlyRevenue as $month => $total)<tr><td>{{ $month }}</td><td>{{ number_format((float)$total,2) }}</td></tr>@endforeach</tbody></table></div></div></div>
</div>
@endsection
