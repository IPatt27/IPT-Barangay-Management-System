@extends('residents.form')

@section('form-title')
    Edit Resident
@endsection

@section('form-content')
    <form action="{{ route('residents.update', $resident->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Row 1: First Name and Last Name --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" value="{{ $resident->first_name }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" value="{{ $resident->last_name }}">
            </div>
        </div>

        {{-- Row 2: Age and Sex --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-control" value="{{ $resident->age }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Sex</label>
                <input type="text" name="sex" class="form-control" value="{{ $resident->sex }}">
            </div>
        </div>

        {{-- Row 3: Birthdate and Civil Status --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Birthdate</label>
                <input type="date" name="birthdate" class="form-control" value="{{ $resident->birthdate }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Civil Status</label>
                <input type="text" name="civil_status" class="form-control" value="{{ $resident->civil_status }}">
            </div>
        </div>

        {{-- Row 4: Address --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="{{ $resident->address }}">
            </div>
        </div>

        {{-- Row 5: Contact Number and Status --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control" value="{{ $resident->contact_number }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <input type="text" name="status" class="form-control" value="{{ $resident->status }}">
            </div>
        </div>

        {{-- Row 6: Purok and Household --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Purok</label>
                <select name="purok_id" class="form-control">
                    <option value="">Select Purok</option>
                    @foreach($puroks as $purok)
                        <option value="{{ $purok->id }}" {{ $resident->purok_id == $purok->id ? 'selected' : '' }}>
                            {{ $purok->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Household</label>
                <select name="household_id" class="form-control">
                    <option value="">Select Household</option>
                    @foreach($households as $household)
                        <option value="{{ $household->id }}" {{ $resident->household_id == $household->id ? 'selected' : '' }}>
                            {{ $household->household_code }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="form-buttons">
            <a href="{{ route('residents.index') }}" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-success">Update</button>
        </div>

    </form>
@endsection