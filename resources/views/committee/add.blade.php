@extends('committee.form')

@section('form-title')
    Add Committee
@endsection

@section('form-content')
    <form action="{{ route('committee.store') }}" method="POST">
        @csrf

        {{-- Committee Name --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Committee Name</label>
                <input type="text" name="committee_name" class="form-control" placeholder="Enter committee name">
            </div>
        </div>

        {{-- Chairperson --}}
        <div class="row mb-3">
            <div class="col-md-8">
                <label class="form-label">Chairperson</label>
                <input type="text" name="chairperson" class="form-control" placeholder="Enter chairperson name (e.g. Kgd Juan dela Cruz)">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>

        {{-- Description --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Brief description of the committee's responsibilities"></textarea>
            </div>
        </div>

        {{-- Buttons --}}
        <div class="form-buttons">
            <a href="{{ route('committee.index') }}" class="btn btn-danger">Cancel</a>
            <button type="submit" class="btn btn-success">Save</button>
        </div>

    </form>
@endsection
