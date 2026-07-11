@extends('layouts.app')
@section('content')
<h1 class="h4 mb-3">{{ $item->exists ? 'Edit Account' : 'Add Account' }}</h1>
<form method="POST" action="{{ $item->exists ? route('accounts.update',$item) : route('accounts.store') }}">@csrf @if($item->exists) @method('PUT') @endif
<div class="row g-3"><div class="col-md-4"><label class="form-label">Business</label><select class="form-select" name="business_id" required>@foreach($businesses as $business)<option value="{{ $business->id }}" @selected(old('business_id',$item->business_id)===$business->id)>{{ $business->business_name }}</option>@endforeach</select></div>
<div class="col-md-4"><label class="form-label">Account Name</label><input class="form-control" name="account_name" value="{{ old('account_name',$item->account_name) }}" required></div>
<div class="col-md-4"><label class="form-label">Type</label><select class="form-select" name="account_type" required>@foreach(['Cash','Bank','UPI','Wallet','Business Account'] as $type)<option value="{{ $type }}" @selected(old('account_type',$item->account_type)===$type)>{{ $type }}</option>@endforeach</select></div>
<div class="col-12"><label class="form-label">Notes</label><textarea class="form-control" name="notes">{{ old('notes',$item->notes) }}</textarea></div></div>
<button class="btn btn-primary mt-3">Save</button></form>
@endsection
