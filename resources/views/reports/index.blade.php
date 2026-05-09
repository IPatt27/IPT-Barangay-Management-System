@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    .stat-card { background: #fff; border: 1px solid #e5e5e5; border-radius: 10px; padding: 20px 24px; text-align: center; }
    .stat-value { font-size: 36px; font-weight: 700; color: #1a1a1a; margin-top: 6px; }
    .chart-card { background: #fff; border: 1px solid #e5e5e5; border-radius: 10px; padding: 20px 24px; }
</style>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Report and Analytics</h2>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-label small fw-bold text-muted">TOTAL POPULATION</div>
                <div class="stat-value">{{ $totalResidents }}</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-label small fw-bold text-muted">REGISTERED VOTERS</div>
                <div class="stat-value">{{ $voters }}</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="chart-card">
                <h5>Age Demographics</h5>
                <canvas id="ageChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-card">
                <h5>Civil Status</h5>
                <canvas id="civilChart"></canvas>
            </div>
        </div>
    </div>

    <div class="chart-card mb-4">
        <h5 class="fw-bold mb-3">Detailed Resident Report</h5>
        <div class="table-responsive">
            <table id="reports-table" class="table table-hover table-bordered w-100">
                <thead class="table-light">
                    <tr>
                        <th>Full Name</th>
                        <th>Age</th>
                        <th>Sex</th>
                        <th>Voter Status</th>
                        <th>Civil Status</th>
                        <th>Status</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- scripts here --}}
@endsection