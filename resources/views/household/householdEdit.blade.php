@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Household</h2>
    </div>

    <div class="card p-4" style="max-width: 600px; margin: 0 auto;">
        <form action="{{ route('household.update', $household->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Household Code --}}
            <div class="mb-3">
                <label class="form-label">Household Code</label>
                <input type="text" name="household_code" class="form-control" value="{{ $household->household_code }}" disabled>
            </div>

            {{-- Purok --}}
            <div class="mb-3">
                <label class="form-label">Purok</label>
                <select name="purok_id" class="form-control">
                    @foreach($puroks as $purok)
                        <option value="{{ $purok->id }}" {{ $household->purok_id == $purok->id ? 'selected' : '' }}>
                            {{ $purok->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Head of Family --}}
            <div class="mb-3">
                <label class="form-label">Head of Family</label>
                <input type="text" name="head_of_family" class="form-control" value="{{ $household->head_of_family }}">
            </div>

            {{-- Family Size --}}
            <div class="mb-3">
                <label class="form-label">Family Size</label>
                <input type="number" name="family_size" class="form-control" value="{{ $household->family_size }}">
            </div>

            {{-- Voter Count --}}
            <div class="mb-3">
                <label class="form-label">Voter Count</label>
                <input type="number" name="voter_count" class="form-control" value="{{ $household->voter_count }}">
            </div>

            {{-- Buttons --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('household.household-index') }}" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-success">Update</button>
            </div>

        </form>
    </div>

@endsection