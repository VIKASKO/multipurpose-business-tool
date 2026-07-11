@extends('layouts.app')
@php($enableDataTables = true)
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Customers</h1><a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm">Add Customer</a></div>
<form method="GET" class="mb-3"><div class="input-group"><input class="form-control form-control-sm" placeholder="Search name/mobile/email" name="search" value="{{ request('search') }}"><button class="btn btn-sm btn-outline-primary">Search</button></div></form>
<div class="table-responsive"><table class="table table-striped"><thead><tr><th>Business</th><th>Name</th><th>Mobile</th><th>Email</th><th></th></tr></thead><tbody>@foreach($items as $item)<tr><td>{{ $item->business->business_name }}</td><td>{{ $item->customer_name }}</td><td>{{ $item->mobile }}</td><td>{{ $item->email }}</td><td class="text-end"><a href="{{ route('customers.edit',$item) }}" class="btn btn-sm btn-outline-secondary">Edit</a><form method="POST" action="{{ route('customers.destroy',$item) }}" class="d-inline" data-confirm="Delete this customer?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@endforeach</tbody></table></div>{{ $items->links() }}
@endsection
