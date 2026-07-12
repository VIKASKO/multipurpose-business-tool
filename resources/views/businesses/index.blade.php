@extends('layouts.app')
@php($enableDataTables = true)
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Businesses</h1><a href="{{ route('businesses.create') }}" class="btn btn-primary btn-sm">Add Business</a></div>
<div class="table-responsive"><table class="table table-striped"><thead><tr><th>Name</th><th>Type</th><th>Status</th><th></th></tr></thead><tbody>@foreach($items as $item)<tr><td>{{ $item->business_name }}</td><td>{{ $item->business_type }}</td><td>{{ $item->status }}</td><td class="text-end"><a href="{{ route('businesses.edit',$item) }}" class="btn btn-sm btn-outline-secondary">Edit</a><form method="POST" action="{{ route('businesses.destroy',$item) }}" class="d-inline" data-confirm="Delete this business?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@endforeach</tbody></table></div>{{ $items->links() }}
@endsection
