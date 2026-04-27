@extends('layouts.app')

@section('styles')
    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css">
    
    <style>
    #residents-table 
    {
        opacity: 0.8;
    }
    </style>
@endsection

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Resident Management</h2>
        <a href="{{ route('residents.add') }}" class="btn btn-success">+ Add New Resident</a>
    </div>

    {{-- Table --}}
    <table id="residents-table" class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Sex</th>
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
            $('#residents-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('residents.data') }}",
                columns: [
                    { data: 'id',         name: 'id' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name',  name: 'last_name' },
                    { data: 'age',        name: 'age' },
                    { data: 'sex',        name: 'sex' },
                    { data: 'status',     name: 'status' },
                    { data: 'action',     name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection