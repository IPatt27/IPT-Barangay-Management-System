@extends('residents.form')

@section('form-title')
    View Resident
@endsection

@section('form-content')

    {{-- Row 1: First Name and Last Name --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">First Name</label>
            <input type="text" class="form-control" value="{{ $resident->first_name }}" disabled>
        </div>
        <div class="col-md-6">
            <label class="form-label">Last Name</label>
            <input type="text" class="form-control" value="{{ $resident->last_name }}" disabled>
        </div>
    </div>

    {{-- Row 2: Age and Sex --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Age</label>
            <input type="text" class="form-control" value="{{ $resident->age }}" disabled>
        </div>
        <div class="col-md-6">
            <label class="form-label">Sex</label>
            <input type="text" class="form-control" value="{{ $resident->sex }}" disabled>
        </div>
    </div>

    {{-- Row 3: Birthdate and Civil Status --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Birthdate</label>
            <input type="text" class="form-control" value="{{ $resident->birthdate }}" disabled>
        </div>
        <div class="col-md-6">
            <label class="form-label">Civil Status</label>
            <input type="text" class="form-control" value="{{ $resident->civil_status }}" disabled>
        </div>
    </div>

    {{-- Row 4: Address --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <label class="form-label">Address</label>
            <input type="text" class="form-control" value="{{ $resident->address }}" disabled>
        </div>
    </div>

    {{-- Row 5: Contact Number and Status --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Contact Number</label>
            <input type="text" class="form-control" value="{{ $resident->contact_number }}" disabled>
        </div>
        <div class="col-md-6">
            <label class="form-label">Status</label>
            <input type="text" class="form-control" value="{{ $resident->status }}" disabled>
        </div>
    </div>

    {{-- Row 6: Purok and Household --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Purok</label>
            <input type="text" class="form-control" value="{{ $resident->purok->name ?? 'Not Assigned' }}" disabled>
        </div>
        <div class="col-md-6">
            <label class="form-label">Household</label>
            <input type="text" class="form-control" value="{{ $resident->household->household_code ?? 'Not Assigned' }}" disabled>
        </div>
    </div>

    {{-- Buttons --}}
    <div class="form-buttons">
        <a href="{{ route('residents.index') }}" class="btn btn-primary">Back</a>
        <a href="{{ route('residents.edit', $resident->id) }}" class="btn btn-success">Edit</a>
    </div>

@endsection