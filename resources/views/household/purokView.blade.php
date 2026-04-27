@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>View Purok</h2>
        <a href="{{ route('household.purok-index') }}" class="btn btn-danger">Back</a>
    </div>

    <div class="card p-4" style="max-width: 600px; margin: 0 auto;">

        {{-- Purok Name --}}
        <div class="mb-3">
            <label class="form-label">Purok Name</label>
            <input type="text" class="form-control" value="{{ $purok->name }}" disabled>
        </div>

        {{-- Leader Name --}}
        <div class="mb-3">
            <label class="form-label">Leader Name</label>
            <input type="text" class="form-control" value="{{ $purok->leader_name }}" disabled>
        </div>

        {{-- Buttons --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('household.purok-index') }}" class="btn btn-danger">Back</a>
            <a href="{{ route('purok.edit', $purok->id) }}" class="btn btn-success">Edit</a>
        </div>

    </div>

@endsection