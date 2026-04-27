@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Purok</h2>
        <a href="{{ route('household.purok-index') }}" class="btn btn-danger">Back</a>
    </div>

    <div class="card p-4" style="max-width: 600px; margin: 0 auto;">
        <form action="{{ route('purok.update', $purok->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Purok Name --}}
            <div class="mb-3">
                <label class="form-label">Purok Name</label>
                <input type="text" name="name" class="form-control" value="{{ $purok->name }}">
            </div>

            {{-- Leader Name --}}
            <div class="mb-3">
                <label class="form-label">Leader Name</label>
                <input type="text" name="leader_name" class="form-control" value="{{ $purok->leader_name }}">
            </div>

            {{-- Buttons --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('household.purok-index') }}" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-success">Update</button>
            </div>

        </form>
    </div>

@endsection