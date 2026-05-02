@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>View Household</h2>
    </div>

    <div class="card p-4" style="max-width: 600px; margin: 0 auto;">

        {{-- Household Code --}}
        <div class="mb-3">
            <label class="form-label">Household Code</label>
            <input type="text" class="form-control" value="{{ $household->household_code }}" disabled>
        </div>

        {{-- Purok --}}
        <div class="mb-3">
            <label class="form-label">Purok</label>
            <input type="text" class="form-control" value="{{ $household->purok->name ?? 'N/A' }}" disabled>
        </div>

        {{-- Head of Family --}}
        <div class="mb-3">
            <label class="form-label">Head of Family</label>
            <input type="text" class="form-control" value="{{ $household->head_of_family }}" disabled>
        </div>

        {{-- Family Size --}}
        <div class="mb-3">
            <label class="form-label">Family Size</label>
            <input type="text" class="form-control" value="{{ $household->family_size }}" disabled>
        </div>

        {{-- Voter Count --}}
        <div class="mb-3">
            <label class="form-label">Voter Count</label>
            <input type="text" class="form-control" value="{{ $household->voter_count }}" disabled>
        </div>

        {{-- Buttons --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('household.household-index') }}" class="btn btn-danger">Back</a>
            <a href="{{ route('household.edit', $household->id) }}" class="btn btn-success">Edit</a>
        </div>

    </div>

@endsection