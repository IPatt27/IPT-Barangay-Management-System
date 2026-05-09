@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css">
@endsection

@section('content')

<h2 class="mb-4" style="font-size:28px; font-weight:700; color:#1a1a1a;">Payment Records</h2>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<table id="payments-table" class="table table-bordered table-striped">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>OR Number</th>
            <th>Amount</th>
            <th>Status</th>
            <th>Date</th>
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
            $('#payments-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('payments.data') }}",
                columns: [
                    { data: 'id',               name: 'id' },
                    { data: 'name',             name: 'name',       orderable: false },
                    { data: 'type',             name: 'type',       orderable: false },
                    { data: 'or_number',        name: 'or_number',  defaultContent: '—' },
                    { data: 'amount_formatted', name: 'amount',     orderable: false },
                    { data: 'status_badge',     name: 'status',     orderable: false },
                    { data: 'created_at',       name: 'created_at' },
                    { data: 'action',           name: 'action',     orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection