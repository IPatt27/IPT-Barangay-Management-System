@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Blotter Management</h2>
    @hasanyrole('admin|secretary')
        <a href="{{ route('blotter.create') }}" class="btn btn-success">+ Record New Blotter</a>
    @endhasanyrole
</div>
{{-- Success message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Table --}}
<table id="blotterTable" class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>Case No.</th>
            <th>Incident Type</th>
            <th>Complainant(s)</th>
            <th>Respondent(s)</th>
            <th>Date of Incident</th>
            <th>Status</th>
            <th>Recorded By</th>
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
    $('#blotterTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("blotter.data") }}',
        columns: [
            { data: 'case_number',    name: 'case_number' },
            { data: 'incident_type',  name: 'incident_type' },
            { data: 'complainants',   name: 'complainants', orderable: false },
            { data: 'respondents',    name: 'respondents',  orderable: false },
            { data: 'incident_date',  name: 'incident_date' },
            { data: 'status_badge',   name: 'status', orderable: false },
            { data: 'recorded_by',    name: 'recorded_by' },
            { data: 'action',         name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection
