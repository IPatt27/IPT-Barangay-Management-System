@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-size:28px; font-weight:700; color:#1a1a1a;">Officials & Staff</h2>
    <a href="{{ route('officials.create') }}" class="btn btn-success" style="background:#2d6a4f; border:none; font-weight:600;">
        <i class="fa fa-plus me-1"></i> Add Official
    </a>
</div>
{{-- Success message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Table --}}
<table id="officialsTable" class="table table-hover align-middle w-100">
    <thead class="table-light">
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Position</th>
            <th>Designation / Committee</th>
            <th>Term</th>
            <th>Contact</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
</table>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    $('#officialsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("officials.data") }}',
        columns: [
            { data: 'photo_thumb',  name: 'photo',       orderable: false, searchable: false },
            { data: 'full_name',    name: 'first_name',  },
            { data: 'position',     name: 'position' },
            { data: 'designation',  name: 'designation', defaultContent: '—' },
            { data: 'term',         name: 'term_start',  orderable: false },
            { data: 'contact',      name: 'contact',     defaultContent: '—' },
            { data: 'status_badge', name: 'status',      orderable: false },
            { data: 'action',       name: 'action',      orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection
