@extends('layouts.app')

@section('content')
<div class="container-fluid p-4">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <h2 class="mb-4 fw-bold">Technical Specs & Maintenance</h2>

    <div class="row g-4">

        {{-- ── DATABASE BACKUP ─────────────────────────────────────────── --}}
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-bold">Database Backup</div>
                <div class="card-body">
                    <p class="text-muted">Create a full SQL backup of the barangay database.</p>
                    <p class="text-muted small">Last backup: <strong>{{ $systemInfo['last_backup'] }}</strong></p>

                    <form action="{{ route('technical.backup') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success me-2"
                                onclick="return confirm('Create a new backup now?')">
                            <i class="fa fa-database me-1"></i> Create New Backup
                        </button>
                    </form>

                    <a href="{{ route('technical.backup.download') }}" class="btn btn-outline-primary">
                        <i class="fa fa-download me-1"></i> Download Last Backup
                    </a>
                </div>
            </div>
        </div>

        {{-- ── DATABASE RESTORE ────────────────────────────────────────── --}}
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white fw-bold">Restore Database</div>
                <div class="card-body">
                    <p class="text-muted">Upload a <code>.sql</code> backup file to restore the database.</p>
                    <div class="alert alert-warning py-2 small">
                        <i class="fa fa-triangle-exclamation me-1"></i>
                        <strong>Warning:</strong> This will overwrite current data. Make sure to backup first.
                    </div>
                    <form action="{{ route('technical.restore') }}" method="POST" enctype="multipart/form-data"
                          onsubmit="return confirm('This will overwrite your current database. Are you sure?')">
                        @csrf
                        @if($errors->has('backup_file'))
                            <div class="text-danger small mb-2">{{ $errors->first('backup_file') }}</div>
                        @endif
                        <input type="file" name="backup_file" class="form-control mb-2" accept=".sql,.txt" required>
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa fa-upload me-1"></i> Upload & Restore
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ── SYSTEM STATUS ────────────────────────────────────────────── --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">System Status</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Laravel Version</span>
                            <strong>{{ $systemInfo['laravel_version'] }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>PHP Version</span>
                            <strong>{{ $systemInfo['php_version'] }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Database</span>
                            <strong>{{ $systemInfo['database'] }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Environment</span>
                            <strong>{{ app()->environment() }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Debug Mode</span>
                            <strong>{{ config('app.debug') ? 'ON' : 'OFF' }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Last Backup</span>
                            <strong>{{ $systemInfo['last_backup'] }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- ── ARTISAN QUICK ACTIONS ────────────────────────────────────── --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white fw-bold">Quick Info</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total Residents</span>
                            <strong>{{ \App\Models\Resident::count() }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Registered Voters</span>
                            <strong>{{ \App\Models\Resident::where('is_voter', 1)->count() }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total Users</span>
                            <strong>{{ \App\Models\User::count() }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>App URL</span>
                            <strong>{{ config('app.url') }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Timezone</span>
                            <strong>{{ config('app.timezone') }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
