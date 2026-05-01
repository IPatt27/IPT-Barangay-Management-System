@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Add New Household</h2>
        <a href="{{ route('household.household-index') }}" class="btn btn-danger">Cancel</a>
    </div>

    <div class="card p-4" style="max-width: 600px; margin: 0 auto;">
        <form action="{{ route('household.store') }}" method="POST">
            @csrf

            {{-- Purok --}}
            <div class="mb-3">
                <label class="form-label">Purok</label>
                <select name="purok_id" class="form-control">
                    <option value="">Select Purok</option>
                    @foreach($puroks as $purok)
                        <option value="{{ $purok->id }}">{{ $purok->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Head of Family --}}
            <div class="mb-3">
                <label class="form-label">Head of Family</label>
                <input type="text" name="head_of_family" class="form-control" placeholder="Enter head of family">
            </div>

            {{-- Family Size --}}
            <div class="mb-3">
                <label class="form-label">Family Size</label>
                <input type="number" name="family_size" class="form-control" placeholder="Enter family size">
            </div>

            {{-- Voter Count --}}
            <div class="mb-3">
                <label class="form-label">Voter Count</label>
                <input type="number" name="voter_count" class="form-control" placeholder="Enter voter count">
            </div>

            {{-- Buttons --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('household.household-index') }}" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-success">Save</button>
            </div>

        </form>
    </div>

@endsection