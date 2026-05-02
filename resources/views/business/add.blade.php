@extends('business.form')

@section('form-title')
    Register New Business
@endsection

@section('form-content')
    <form action="{{ route('business.store') }}" method="POST">
        @csrf

        {{-- Business Name and Type --}}
        <div class="row mb-3">
            <div class="col-md-8">
                <label class="form-label">Business Name</label>
                <input type="text" name="business_name" class="form-control" placeholder="Enter business name">
            </div>
            <div class="col-md-4">
                <label class="form-label">Business Type</label>
                <select name="business_type" class="form-select">
                    <option value="" disabled selected>Select type</option>
                    <option value="Sari-sari Store">Sari-sari Store</option>
                    <option value="Restaurant / Food">Restaurant / Food</option>
                    <option value="Retail / Trading">Retail / Trading</option>
                    <option value="Services">Services</option>
                    <option value="Manufacturing">Manufacturing</option>
                    <option value="Salon / Barbershop">Salon / Barbershop</option>
                    <option value="Repair Shop">Repair Shop</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>

        {{-- Owner Name and Contact --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Owner Name</label>
                <input type="text" name="owner_name" class="form-control" placeholder="Enter owner's full name">
            </div>
            <div class="col-md-6">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control" placeholder="Enter contact number">
            </div>
        </div>

        {{-- Address --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Business Address</label>
                <input type="text" name="address" class="form-control" placeholder="Enter complete business address">
            </div>
        </div>

        {{-- Issued Date, Expiry Date, Status --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Date Issued</label>
                <input type="date" name="issued_date" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Expiry Date</label>
                <input type="date" name="expiry_date" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Active">Active</option>
                    <option value="Expired">Expired</option>
                    <option value="Revoked">Revoked</option>
                </select>
            </div>
        </div>

        <p class="text-muted" style="font-size: 13px;">
            <i class="fa fa-info-circle"></i>
            A Permit Number and Reference Number will be automatically generated upon saving.
        </p>

        {{-- Buttons --}}
        <div class="form-buttons">
            <a href="{{ route('business.index') }}" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-success">Save & Issue Permit</button>
        </div>

    </form>
@endsection
