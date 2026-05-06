@extends('business.form')

@section('form-title')
    View Business Permit
@endsection

@section('form-content')

    {{-- Permit & Reference Number Badge --}}
    <div class="permit-badge">
        <div class="permit-badge-item">
            <label><i class="fa fa-id-card"></i> Permit Number</label>
            <span>{{ $business->permit_number }}</span>
        </div>
        <div class="permit-badge-item">
            <label><i class="fa fa-barcode"></i> Reference Number</label>
            <span>{{ $business->reference_number }}</span>
        </div>
        <div class="permit-badge-item">
            <label>Status</label>
            <span class="badge bg-{{ $business->status === 'Active' ? 'success' : ($business->status === 'Expired' ? 'danger' : 'secondary') }}">
                {{ $business->status }}
            </span>
        </div>
    </div>

    {{-- Business Name and Type --}}
    <div class="row mb-3">
        <div class="col-md-8">
            <label class="form-label">Business Name</label>
            <input type="text" class="form-control" value="{{ $business->business_name }}" disabled>
        </div>
        <div class="col-md-4">
            <label class="form-label">Business Type</label>
            <input type="text" class="form-control" value="{{ $business->business_type }}" disabled>
        </div>
    </div>

    {{-- Owner and Contact --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Owner Name</label>
            <input type="text" class="form-control" value="{{ $business->owner_name }}" disabled>
        </div>
        <div class="col-md-6">
            <label class="form-label">Contact Number</label>
            <input type="text" class="form-control" value="{{ $business->contact_number }}" disabled>
        </div>
    </div>

    {{-- Address --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <label class="form-label">Business Address</label>
            <input type="text" class="form-control" value="{{ $business->address }}" disabled>
        </div>
    </div>

    {{-- Dates --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Date Issued</label>
            <input type="text" class="form-control" value="{{ $business->issued_date }}" disabled>
        </div>
        <div class="col-md-4">
            <label class="form-label">Expiry Date</label>
            <input type="text" class="form-control" value="{{ $business->expiry_date }}" disabled>
        </div>
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <input type="text" class="form-control" value="{{ $business->status }}" disabled>
        </div>
    </div>

    {{-- Buttons --}}
    <div class="form-buttons">
        <a href="{{ route('business.index') }}" class="btn btn-primary">Back</a>

        @hasanyrole('admin|secretary')
        <a href="{{ route('business.edit', $business->id) }}" class="btn btn-success">Edit</a>
        @endhasanyrole
    </div>

@endsection
