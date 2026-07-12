@extends('layouts.app')
@php($enableDataTables = true)
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Orders</h1><a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">Add Order</a></div>
<div class="table-responsive"><table class="table table-striped"><thead><tr><th>Order #</th><th>Business</th><th>Customer</th><th>Status</th><th>Total</th><th></th></tr></thead><tbody>@foreach($items as $item)<tr><td>{{ $item->order_number }}</td><td>{{ $item->business->business_name }}</td><td>{{ $item->customer->customer_name }}</td><td>{{ $item->status }}</td><td>{{ number_format((float)$item->total_amount,2) }}</td><td class="text-end"><a href="{{ route('orders.edit',$item) }}" class="btn btn-sm btn-outline-secondary">Edit</a><form method="POST" action="{{ route('orders.destroy',$item) }}" class="d-inline" data-confirm="Delete this order?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@endforeach</tbody></table></div>{{ $items->links() }}
@endsection
