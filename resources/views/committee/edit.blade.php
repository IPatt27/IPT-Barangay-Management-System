@extends('committee.form')

@section('form-title')
    Edit Committee
@endsection

@section('form-content')
    <form action="{{ route('committee.update', $committee->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Committee Name --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Committee Name</label>
                <input type="text" name="committee_name" class="form-control" value="{{ $committee->committee_name }}">
            </div>
        </div>

        {{-- Chairperson and Status --}}
        <div class="row mb-3">
            <div class="col-md-8">
                <label class="form-label">Chairperson</label>
                <input type="text" name="chairperson" class="form-control" value="{{ $committee->chairperson }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Active"   {{ $committee->status === 'Active'   ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ $committee->status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        {{-- Description --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ $committee->description }}</textarea>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="form-buttons">
            <a href="{{ route('committee.index') }}" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-success">Update</button>
        </div>

    </form>
@endsection
