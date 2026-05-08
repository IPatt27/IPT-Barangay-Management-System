@extends('layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Change User Role</h2>
    </div>

    <div class="card p-4" style="max-width: 500px; margin: 0 auto;">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Name --}}
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" value="{{ $user->name }}" disabled>
            </div>

            {{-- Email --}}
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" value="{{ $user->email }}" disabled>
            </div>

            {{-- Current Role --}}
            <div class="mb-3">
                <label class="form-label">Current Role</label>
                <input type="text" class="form-control" value="{{ $user->getRoleNames()->implode(', ') ?: 'No Role' }}" disabled>
            </div>

            {{-- New Role --}}
            <div class="mb-3">
                <label class="form-label">Assign Role</label>
                <select name="role" class="form-control">
                    <option value="admin"     {{ $user->hasRole('admin')     ? 'selected' : '' }}>Admin</option>
                    <option value="secretary" {{ $user->hasRole('secretary') ? 'selected' : '' }}>Secretary</option>
                    <option value="committee" {{ $user->hasRole('committee') ? 'selected' : '' }}>Committee</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('users.index') }}" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-success">Update Role</button>
            </div>

        </form>
    </div>

@endsection