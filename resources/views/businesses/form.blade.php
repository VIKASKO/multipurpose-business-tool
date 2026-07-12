@extends('layouts.app')
@section('content')
<h1 class="h4 mb-3">{{ $item->exists ? 'Edit Business' : 'Add Business' }}</h1>
<form method="POST" action="{{ $item->exists ? route('businesses.update',$item) : route('businesses.store') }}">@csrf @if($item->exists) @method('PUT') @endif
<div class="row g-3"><div class="col-md-6"><label class="form-label">Business Name</label><input class="form-control" name="business_name" value="{{ old('business_name',$item->business_name) }}" required></div>
<div class="col-md-3"><label class="form-label">Type</label><select class="form-select" name="business_type" required>@foreach(['Personal','Boutique','Freelance','Software','Investment','Other'] as $type)<option value="{{ $type }}" @selected(old('business_type',$item->business_type)===$type)>{{ $type }}</option>@endforeach</select></div>
<div class="col-md-3"><label class="form-label">Status</label><select class="form-select" name="status" required>@foreach(['Active','Inactive'] as $status)<option value="{{ $status }}" @selected(old('status',$item->status ?? 'Active')===$status)>{{ $status }}</option>@endforeach</select></div>
<div class="col-12"><label class="form-label">Description</label><textarea class="form-control" name="description">{{ old('description',$item->description) }}</textarea></div></div>
<button class="btn btn-primary mt-3">Save</button></form>
@endsection
