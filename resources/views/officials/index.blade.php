@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Officials & Staff</h2>

    <div class="d-flex gap-2">
        @role('admin')
        <button id="trashToggle" class="btn btn-outline-secondary">
            <i class="fa fa-trash me-1"></i> Show Trashed
        </button>
        @endrole

        @hasanyrole('admin|secretary')
        <a href="{{ route('officials.create') }}" class="btn btn-success" id="addBtn">
            + Add Official
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
    You are viewing <strong>trashed officials</strong>. These have been soft-deleted and are
    not visible in the active records list.
</div>

<table id="officialsTable" class="table table-bordered table-striped table-hover align-middle w-100">
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
    let showingTrashed = false;
    let table;

    function buildTable(trashed) {
        if (table) {
            table.destroy();
        }

        table = $('#officialsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url : "{{ route('officials.data') }}",
                data: function (d) {
                    if (trashed) d.trashed = 1;
                }
            },
            columns: [
                { data: 'photo_thumb',  name: 'photo',       orderable: false, searchable: false },
                { data: 'full_name',    name: 'first_name' },
                { data: 'position',     name: 'position' },
                { data: 'designation',  name: 'designation', defaultContent: '—' },
                { data: 'term',         name: 'term_start',  orderable: false },
                { data: 'contact',      name: 'contact',     defaultContent: '—' },
                { data: 'status_badge', name: 'status',      orderable: false },
                { data: 'action',       name: 'action',      orderable: false, searchable: false },
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
                $('#addBtn').addClass('d-none');        // hide Add button in trashed view
            } else {
                $(this).removeClass('btn-secondary').addClass('btn-outline-secondary');
                $(this).html('<i class="fa fa-trash me-1"></i> Show Trashed');
                $('#trashedBanner').addClass('d-none');
                $('#addBtn').removeClass('d-none');
            }

            buildTable(showingTrashed);
        });
    });
</script>
@endsection