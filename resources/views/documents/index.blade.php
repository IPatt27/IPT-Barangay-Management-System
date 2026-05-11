@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css">
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="font-size:28px; font-weight:700; color:#1a1a1a;">Document Issuance</h2>

        <div class="d-flex gap-2">
            @role('admin')
            <button id="trashToggle" class="btn btn-outline-secondary">
                <i class="fa fa-trash me-1"></i> Show Trashed
            </button>
            @endrole

            @hasanyrole('admin|secretary')
            <a href="{{ route('documents.create') }}" class="btn btn-success" id="issueBtn">
                + Issue New Document
            </a>
            @endhasanyrole
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Trashed-view banner (hidden by default) --}}
    <div id="trashedBanner" class="alert alert-warning d-none" role="alert">
        <i class="fa fa-triangle-exclamation me-1"></i>
        You are viewing <strong>trashed documents</strong>. These have been soft-deleted and are
        not visible in normal operation.
    </div>

    <table id="documents-table" class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Resident Name</th>
                <th>Document Type</th>
                <th>Purpose</th>
                <th>OR No.</th>
                <th>Issued By</th>
                <th>Date Issued</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.js"></script>

    <script>
        let showingTrashed = false;
        let table;

        function buildTable(trashed) {
            if (table) {
                table.destroy();
            }

            table = $('#documents-table').DataTable({
                processing : true,
                serverSide : true,
                ajax       : {
                    url : "{{ route('documents.data') }}",
                    data: function (d) {
                        if (trashed) d.trashed = 1;
                    }
                },
                columns: [
                    { data: 'id',            name: 'id' },
                    { data: 'resident_name', name: 'resident_name', orderable: false },
                    { data: 'document_type', name: 'document_type' },
                    { data: 'purpose',       name: 'purpose' },
                    { data: 'or_number',     name: 'or_number', defaultContent: '—' },
                    { data: 'issued_by',     name: 'issued_by' },
                    { data: 'created_at',    name: 'created_at' },
                    { data: 'status',        name: 'status' },
                    { data: 'action',        name: 'action', orderable: false, searchable: false }
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
                    $('#issueBtn').addClass('d-none');   // hide Issue button in trashed view
                } else {
                    $(this).removeClass('btn-secondary').addClass('btn-outline-secondary');
                    $(this).html('<i class="fa fa-trash me-1"></i> Show Trashed');
                    $('#trashedBanner').addClass('d-none');
                    $('#issueBtn').removeClass('d-none');
                }

                buildTable(showingTrashed);
            });
        });

        function openPayModal(btn) {
            document.getElementById('payableType').value = btn.dataset.type;
            document.getElementById('payableId').value   = btn.dataset.id;
            document.getElementById('payName').value     = btn.dataset.name;
            document.getElementById('payDocType').value  = btn.dataset.doctype;
        }
    </script>
@endsection