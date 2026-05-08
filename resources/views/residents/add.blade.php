@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center gap-2 mb-3">
    <h2 class="mb-0">Add New Resident</h2>
</div>

<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card shadow-sm">
<div class="card-body">

<form action="{{ route('residents.store') }}" method="POST">
@csrf

{{-- First and Last Name --}}
<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">First Name</label>
        <input type="text" name="first_name" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Last Name</label>
        <input type="text" name="last_name" class="form-control">
    </div>
</div>

{{-- Age and Sex --}}
<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Age</label>
        <input type="number" name="age" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Sex</label>
        <input type="text" name="sex" class="form-control">
    </div>
</div>

{{-- Birthdate and Civil Status --}}
<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Birthdate</label>
        <input type="date" name="birthdate" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Civil Status</label>
        <input type="text" name="civil_status" class="form-control">
    </div>
</div>

{{-- Address --}}
<div class="mb-3">
    <label class="form-label">Address</label>
    <input type="text" name="address" class="form-control">
</div>

{{-- Contact and Status --}}
<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Contact Number</label>
        <input type="text" name="contact_number" class="form-control">
    </div>
    <div class="col-md-6">
        <label class="form-label">Status</label>
        <input type="text" name="status" class="form-control">
    </div>
</div>

{{-- Purok and Household --}}
<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Purok</label>
        <select name="purok_id" class="form-select">
            <option value="">Select Purok</option>
            @foreach($puroks as $purok)
                <option value="{{ $purok->id }}">{{ $purok->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Household</label>
        <select name="household_id" class="form-select">
            <option value="">Select Household</option>
            @foreach($households as $household)
                <option value="{{ $household->id }}">{{ $household->household_code }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- Voter Status --}}
<div class="row mb-3">
    <div class="col-md-6">
        <label class="form-label">Voter Status</label>
        <select name="is_voter" class="form-select">
            <option value="0">Not Registered</option>
            <option value="1">Registered Voter</option>
        </select>
    </div>
</div>

<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('residents.index') }}" class="btn btn-danger">Cancel</a>
    <button type="submit" class="btn btn-success">Save</button>
</div>

</form>

</div>
</div>
</div>
</div>

@endsection