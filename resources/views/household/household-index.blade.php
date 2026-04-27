@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-1.13.6/datatables.min.css">
@endsection

@section('content')

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Household Management</h2>
        <a href="{{ route('household.add') }}" class="btn btn-success">+ Add New Household</a>
    </div>

    {{-- Table --}}
    <table id="household-table" class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Household Code</th>
                <th>Purok</th>
                <th>Head of Family</th>
                <th>Family Size</th>
                <th>Voter Count</th>
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
            $('#household-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('household.data') }}",
                columns: [
                    { data: 'id',               name: 'id' },
                    { data: 'household_code',   name: 'household_code' },
                    { data: 'purok_name',       name: 'purok_name', orderable: false, searchable: false },
                    { data: 'head_of_family',   name: 'head_of_family' },
                    { data: 'family_size',      name: 'family_size' },
                    { data: 'voter_count',      name: 'voter_count' },
                    { data: 'action',           name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endsection