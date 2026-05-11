@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        #business-table { opacity: 0.8; }
        .status-badge {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-active   { background: #d1fae5; color: #065f46; }
        .status-expired  { background: #fee2e2; color: #991b1b; }
        .status-revoked  { background: #f3f4f6; color: #6b7280; }
    </style>
@endsection

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="font-size:28px; font-weight:700; color:#1a1a1a;">Business Permit Management</h2>
        @hasanyrole('admin|secretary')
            <a href="{{ route('business.add') }}" class="btn btn-success">+ Register Business</a>
        @endhasanyrole
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <table id="business-table" class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Business Name</th>
                <th>Owner</th>
                <th>Type</th>
                <th>Permit No.</th>
                <th>Expiry Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#business-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('business.data') }}",
                columns: [
                    { data: 'id',            name: 'id' },
                    { data: 'business_name', name: 'business_name' },
                    { data: 'owner_name',    name: 'owner_name' },
                    { data: 'business_type', name: 'business_type' },
                    { data: 'permit_number', name: 'permit_number' },
                    { data: 'expiry_date',   name: 'expiry_date' },
                    { data: 'status',        name: 'status' },
                    { data: 'action',        name: 'action', orderable: false, searchable: false }
                ]
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