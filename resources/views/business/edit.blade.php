@extends('business.form')

@section('form-title')
    Edit Business Permit
@endsection

@section('form-content')
    <form action="{{ route('business.update', $business->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Permit Badge (read-only) --}}
        <div class="permit-badge">
            <div class="permit-badge-item">
                <label><i class="fa fa-id-card"></i> Permit Number</label>
                <span>{{ $business->permit_number }}</span>
            </div>
            <div class="permit-badge-item">
                <label><i class="fa fa-barcode"></i> Reference Number</label>
                <span>{{ $business->reference_number }}</span>
            </div>
        </div>

        {{-- Business Name and Type --}}
        <div class="row mb-3">
            <div class="col-md-8">
                <label class="form-label">Business Name</label>
                <input type="text" name="business_name" class="form-control" value="{{ $business->business_name }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Business Type</label>
                <select name="business_type" class="form-select">
                    @foreach(['Sari-sari Store','Restaurant / Food','Retail / Trading','Services','Manufacturing','Salon / Barbershop','Repair Shop','Other'] as $type)
                        <option value="{{ $type }}" {{ $business->business_type === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Owner and Contact --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Owner Name</label>
                <input type="text" name="owner_name" class="form-control" value="{{ $business->owner_name }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control" value="{{ $business->contact_number }}">
            </div>
        </div>

        {{-- Address --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Business Address</label>
                <input type="text" name="address" class="form-control" value="{{ $business->address }}">
            </div>
        </div>

        {{-- Dates and Status --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Date Issued</label>
                <input type="date" name="issued_date" class="form-control" value="{{ $business->issued_date }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control" value="{{ $business->expiry_date }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    @foreach(['Active','Expired','Revoked'] as $status)
                        <option value="{{ $status }}" {{ $business->status === $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="form-buttons">
            <a href="{{ route('business.index') }}" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-success">Update</button>
        </div>

    </form>
@endsection
