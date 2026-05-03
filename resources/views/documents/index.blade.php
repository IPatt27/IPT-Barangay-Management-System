@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endsection

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 style="font-size: 28px; font-weight: 700; color: #1a1a1a;">Document Issuance</h2>
    <a href="{{ route('documents.create') }}" class="btn btn-success" style="background:#2d6a4f; border:none; font-weight:600;">
        <i class="fa fa-plus me-1"></i> Issue New Document
    </a>
</div>

{{-- Success message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card shadow-sm border-0">
    <div class="card-body">
        <table id="documentsTable" class="table table-hover align-middle w-100">
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
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#documentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("documents.data") }}',
        columns: [
            { data: 'id',            name: 'id' },
            { data: 'resident_name', name: 'resident_name', orderable: false },
            { data: 'document_type', name: 'document_type' },
            { data: 'purpose',       name: 'purpose' },
            { data: 'or_number',     name: 'or_number', defaultContent: '—' },
            { data: 'issued_by',     name: 'issued_by' },
            { data: 'created_at',    name: 'created_at' },
            { data: 'status',        name: 'status' },
            { data: 'action',        name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endsection
