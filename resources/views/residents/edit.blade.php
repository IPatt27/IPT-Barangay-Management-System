@extends('layouts.app')

@section('content')

<h4 class="mb-4">Edit Resident</h4>

<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card shadow-sm">
<div class="card-body">

    <form action="{{ route('residents.update', $resident->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $resident->first_name) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $resident->last_name) }}">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Age</label>
            <input type="number" name="age" class="form-control" value="{{ old('age', $resident->age) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Sex</label>
            <input type="text" name="sex" class="form-control" value="{{ old('sex', $resident->sex) }}">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Birthdate</label>
            <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $resident->birthdate) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Civil Status</label>
            <input type="text" name="civil_status" class="form-control" value="{{ old('civil_status', $resident->civil_status) }}">
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Address</label>
        <input type="text" name="address" class="form-control" value="{{ old('address', $resident->address) }}">
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Contact Number</label>
            <input type="text" name="contact_number" class="form-control" value="{{ old('contact_number', $resident->contact_number) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Status</label>
            <input type="text" name="status" class="form-control" value="{{ old('status', $resident->status) }}">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Purok</label>
            <select name="purok_id" class="form-select">
                <option value="">Select Purok</option>
                @foreach($puroks as $purok)
                    <option value="{{ $purok->id }}" {{ old('purok_id', $resident->purok_id) == $purok->id ? 'selected' : '' }}>
                        {{ $purok->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Household</label>
            <select name="household_id" class="form-select">
                <option value="">Select Household</option>
                @foreach($households as $household)
                    <option value="{{ $household->id }}" {{ old('household_id', $resident->household_id) == $household->id ? 'selected' : '' }}>
                        {{ $household->household_code }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('residents.index', $resident->id) }}" class="btn btn-danger">Cancel</a>
        <button type="submit" class="btn btn-success">Save Changes</button>
    </div>

    </form>

</div>
</div>
</div>
</div>

@endsection