@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Add New Purok</h2>
        <a href="{{ route('household.purok-index') }}" class="btn btn-danger">Cancel</a>
    </div>

    <div class="card p-4" style="max-width: 600px; margin: 0 auto;">
        <form action="{{ route('purok.store') }}" method="POST">
            @csrf

            {{-- Purok Name --}}
            <div class="mb-3">
                <label class="form-label">Purok Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter purok name">
            </div>

            {{-- Leader Name --}}
            <div class="mb-3">
                <label class="form-label">Leader Name</label>
                <input type="text" name="leader_name" class="form-control" placeholder="Enter leader name">
            </div>

            {{-- Buttons --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('household.purok-index') }}" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-success">Save</button>
            </div>

        </form>
    </div>

@endsection