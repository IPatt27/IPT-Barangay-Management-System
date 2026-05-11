@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 style="font-size:28px; font-weight:700; color:#1a1a1a;">Blotter Management</h2>

    <div class="d-flex gap-2">
        @role('admin')
        <button id="trashToggle" class="btn btn-outline-secondary">
            <i class="fa fa-trash me-1"></i> Show Trashed
        </button>
        @endrole

        @hasanyrole('admin|secretary')
        <a href="{{ route('blotter.create') }}" class="btn btn-success" id="recordBtn">
            + Record New Blotter
        </a>
        @endhasanyrole
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Trashed-view banner (hidden by default) --}}
<div id="trashedBanner" class="alert alert-warning d-none" role="alert">
    <i class="fa fa-triangle-exclamation me-1"></i>
    You are viewing <strong>trashed blotter entries</strong>. These have been soft-deleted and are
    not visible in the active records list.
</div>

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
    let showingTrashed = false;
    let table;

    function buildTable(trashed) {
        if (table) {
            table.destroy();
        }

        table = $('#blotterTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : "{{ route('blotter.data') }}",
                data: function (d) {
                    if (trashed) d.trashed = 1;
                }
            },
            columns: [
                { data: 'case_number',   name: 'case_number' },
                { data: 'incident_type', name: 'incident_type' },
                { data: 'complainants',  name: 'complainants', orderable: false },
                { data: 'respondents',   name: 'respondents',  orderable: false },
                { data: 'incident_date', name: 'incident_date' },
                { data: 'status_badge',  name: 'status', orderable: false },
                { data: 'recorded_by',   name: 'recorded_by' },
                { data: 'action',        name: 'action', orderable: false, searchable: false },
            ]
        });
    }

    $(document).ready(function () {
        buildTable(false);

        $('#trashToggle').on('click', function () {
            showingTrashed = !showingTrashed;

            if (showingTrashed) {
                $(this).removeClass('btn-outline-secondary').addClass('btn-secondary');
                $(this).html('<i class="fa fa-list me-1"></i> Show Active');
                $('#trashedBanner').removeClass('d-none');
                $('#recordBtn').addClass('d-none');      // hide Record button in trashed view
            } else {
                $(this).removeClass('btn-secondary').addClass('btn-outline-secondary');
                $(this).html('<i class="fa fa-trash me-1"></i> Show Trashed');
                $('#trashedBanner').addClass('d-none');
                $('#recordBtn').removeClass('d-none');
            }

            buildTable(showingTrashed);
        });
    });
</script>
@endsection