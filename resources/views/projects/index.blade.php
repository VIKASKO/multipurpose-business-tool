@extends('layouts.app')
@php($enableDataTables = true)
@section('content')
<div class="d-flex justify-content-between mb-3"><h1 class="h4">Projects</h1><a href="{{ route('projects.create') }}" class="btn btn-primary btn-sm">Add Project</a></div>
<div class="table-responsive"><table class="table table-striped"><thead><tr><th>Project</th><th>Business</th><th>Client</th><th>Status</th><th>Value</th><th></th></tr></thead><tbody>@foreach($items as $item)<tr><td>{{ $item->project_name }}</td><td>{{ $item->business->business_name }}</td><td>{{ $item->client_name }}</td><td>{{ $item->status }}</td><td>{{ number_format((float)$item->project_value,2) }}</td><td class="text-end"><a href="{{ route('projects.edit',$item) }}" class="btn btn-sm btn-outline-secondary">Edit</a><form method="POST" action="{{ route('projects.destroy',$item) }}" class="d-inline" data-confirm="Delete this project?">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>@endforeach</tbody></table></div>{{ $items->links() }}
@endsection
