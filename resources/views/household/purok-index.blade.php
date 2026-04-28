@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css">
@endsection

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Purok Management</h2>
        <a href="{{ route('purok.add') }}" class="btn btn-success">+ Add New Purok</a>
    </div>

    {{-- Table --}}
    <table id="purok-table" class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Purok Name</th>
                <th>Leader</th>
                <th>No. of Households</th>
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
            $('#purok-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('purok.data') }}",
                columns: [
                    { data: 'id',                name: 'id' },
                    { data: 'name',              name: 'name' },
                    { data: 'leader_name',        name: 'leader_name' },
                    { data: 'households_count',  name: 'households_count', orderable: false, searchable: false },
                    { data: 'action',            name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection