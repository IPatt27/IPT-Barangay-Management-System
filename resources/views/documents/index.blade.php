@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css">
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Document Issuance</h2>

        @hasanyrole('admin|secretary')
        <a href="{{ route('documents.create') }}" class="btn btn-success">+ Issue New Document</a>
        @endhasanyrole
        
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Table --}}
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
        $(document).ready(function() {
            $('#documents-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('documents.data') }}",
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
        });
    </script>
@endsection