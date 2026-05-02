@extends('committee.form')

@section('form-title')
    View Committee
@endsection

@section('form-content')

    {{-- Committee Name --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <label class="form-label">Committee Name</label>
            <input type="text" class="form-control" value="{{ $committee->committee_name }}" disabled>
        </div>
    </div>

    {{-- Chairperson and Status --}}
    <div class="row mb-3">
        <div class="col-md-8">
            <label class="form-label">Chairperson</label>
            <input type="text" class="form-control" value="{{ $committee->chairperson }}" disabled>
        </div>
        <div class="col-md-4">
            <label class="form-label">Status</label>
            <input type="text" class="form-control" value="{{ $committee->status }}" disabled>
        </div>
    </div>

    {{-- Description --}}
    <div class="row mb-3">
        <div class="col-md-12">
            <label class="form-label">Description</label>
            <textarea class="form-control" rows="3" disabled>{{ $committee->description }}</textarea>
        </div>
    </div>

    {{-- Buttons --}}
    <div class="form-buttons">
        <a href="{{ route('committee.index') }}" class="btn btn-primary">Back</a>
        <a href="{{ route('committee.edit', $committee->id) }}" class="btn btn-success">Edit</a>
    </div>

@endsection
