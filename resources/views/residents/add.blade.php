@extends('residents.form')

@section('form-title')
    Add New Resident
@endsection

@section('form-content')
    <form action="{{ route('residents.store') }}" method="POST">
        @csrf

        {{--First nad Last Name--}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control" placeholder="Enter first name">
            </div>
            <div class="col-md-6">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control" placeholder="Enter last name">
            </div>
        </div>

        {{--Age and Sex--}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-control" placeholder="Enter age">
            </div>
            <div class="col-md-6">
                <label class="form-label">Sex</label>
                <input type="text" name="sex" class="form-control" placeholder="Male / Female">
            </div>
        </div>

        {{--Birthdate and Civil Status--}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Birthdate</label>
                <input type="date" name="birthdate" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Civil Status</label>
                <input type="text" name="civil_status" class="form-control" placeholder="Single / Married / Widowed">
            </div>
        </div>

        {{--Address--}}
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" placeholder="Enter address">
            </div>
        </div>

        {{--Contact Number and Status--}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control" placeholder="Enter contact number">
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <input type="text" name="status" class="form-control" placeholder="Active / Deceased / Transferred">
            </div>
        </div>

        {{--Purok and Household--}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Purok</label>
                <select name="purok_id" class="form-control">
                    <option value="">Select Purok</option>
                    @foreach($puroks as $purok)
                        <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Household</label>
                <select name="household_id" class="form-control">
                    <option value="">Select Household</option>
                    @foreach($households as $household)
                        <option value="{{ $household->id }}">{{ $household->household_code }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{--Btn--}}
        <div class="form-buttons">
            <a href="{{ route('residents.index') }}" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>

    </form>
@endsection