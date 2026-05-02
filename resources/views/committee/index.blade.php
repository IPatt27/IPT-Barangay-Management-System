@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        #committee-table { opacity: 0.8; }
    </style>
@endsection

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Committee Management</h2>
        <a href="{{ route('committee.add') }}" class="btn btn-success">+ Add Committee</a>
    </div>

    {{-- Table --}}
    <table id="committee-table" class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Committee Name</th>
                <th>Chairperson</th>
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
            $('#committee-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('committee.data') }}",
                columns: [
                    { data: 'id',             name: 'id' },
                    { data: 'committee_name', name: 'committee_name' },
                    { data: 'chairperson',    name: 'chairperson' },
                    { data: 'status',         name: 'status' },
                    { data: 'action',         name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection
