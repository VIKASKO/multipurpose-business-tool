@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Accounts</h1><a href="{{ route('accounts.create') }}" class="btn btn-primary btn-sm">Add Account</a></div>
<div class="table-responsive"><table class="table table-striped"><thead><tr><th>Business</th><th>Name</th><th>Type</th><th>Balance</th><th></th></tr></thead><tbody>@foreach($items as $item)<tr><td>{{ $item->business->business_name }}</td><td>{{ $item->account_name }}</td><td>{{ $item->account_type }}</td><td>{{ number_format($item->balance,2) }}</td><td class="text-end"><a href="{{ route('accounts.edit',$item) }}" class="btn btn-sm btn-outline-secondary">Edit</a><form method="POST" action="{{ route('accounts.destroy',$item) }}" class="d-inline" data-confirm="Delete this account?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@endforeach</tbody></table></div>{{ $items->links() }}
@endsection
