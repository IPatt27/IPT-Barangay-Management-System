@extends('layouts.app')

@section('styles')
<style>
    .stat-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 10px;
        padding: 20px 24px;
        text-align: center;
    }
    .stat-card .stat-label {
        font-size: 12px;
        font-weight: 600;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-card .stat-value {
        font-size: 36px;
        font-weight: 700;
        color: #1a1a1a;
        line-height: 1.1;
        margin-top: 6px;
    }
    .stat-card .stat-sub {
        font-size: 12px;
        color: #aaa;
        margin-top: 4px;
    }
    .chart-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 10px;
        padding: 20px 24px;
    }
    .chart-card h5 {
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 16px;
        color: #1a1a1a;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Reports & Analytics</h2>
        <div class="d-flex gap-2">
            <button class="btn btn-danger" onclick="window.print()">
                <i class="fa fa-print me-1"></i> Print / Export PDF
            </button>
            <a href="{{ route('residents.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-table me-1"></i> View Full Table
            </a>
        </div>
    </div>

    {{-- ── STAT CARDS ────────────────────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-label">Total Population</div>
                <div class="stat-value">{{ $totalResidents }}</div>
                <div class="stat-sub">Registered Residents</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-label">Voters</div>
                <div class="stat-value">{{ $voters }}</div>
                <div class="stat-sub">{{ $totalResidents > 0 ? round($voters / $totalResidents * 100) : 0 }}% of population</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-label">Senior Citizens</div>
                <div class="stat-value">{{ $seniors }}</div>
                <div class="stat-sub">Age 60 and above</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-label">Minors</div>
                <div class="stat-value">{{ $minors }}</div>
                <div class="stat-sub">Age below 18</div>
            </div>
        </div>
    </div>

    {{-- ── CHARTS ROW 1 ──────────────────────────────────────────────────── --}}
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="chart-card">
                <h5>Gender Distribution</h5>
                <canvas id="genderChart" height="220"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-card">
                <h5>Voter Status</h5>
                <canvas id="voterChart" height="220"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-card">
                <h5>Age Groups</h5>
                <canvas id="ageChart" height="220"></canvas>
            </div>
        </div>
    </div>

    {{-- ── CHARTS ROW 2 ──────────────────────────────────────────────────── --}}
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="chart-card">
                <h5>Civil Status Breakdown</h5>
                <canvas id="civilChart" height="180"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-card">
                <h5>Resident Status</h5>
                <canvas id="statusChart" height="180"></canvas>
            </div>
        </div>
    </div>

    {{-- ── SUMMARY TABLE ─────────────────────────────────────────────────── --}}
    <div class="chart-card mb-4">
        <h5>Summary Table</h5>
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr><th>Category</th><th>Count</th><th>Percentage</th></tr>
            </thead>
            <tbody>
                <tr><td>Male</td><td>{{ $maleCount }}</td><td>{{ $totalResidents > 0 ? round($maleCount / $totalResidents * 100, 1) : 0 }}%</td></tr>
                <tr><td>Female</td><td>{{ $femaleCount }}</td><td>{{ $totalResidents > 0 ? round($femaleCount / $totalResidents * 100, 1) : 0 }}%</td></tr>
                <tr><td>Minors (0–17)</td><td>{{ $minors }}</td><td>{{ $totalResidents > 0 ? round($minors / $totalResidents * 100, 1) : 0 }}%</td></tr>
                <tr><td>Adults (18–59)</td><td>{{ $adults }}</td><td>{{ $totalResidents > 0 ? round($adults / $totalResidents * 100, 1) : 0 }}%</td></tr>
                <tr><td>Seniors (60+)</td><td>{{ $seniors }}</td><td>{{ $totalResidents > 0 ? round($seniors / $totalResidents * 100, 1) : 0 }}%</td></tr>
                <tr><td>Registered Voters</td><td>{{ $voters }}</td><td>{{ $totalResidents > 0 ? round($voters / $totalResidents * 100, 1) : 0 }}%</td></tr>
                <tr><td>Non-Voters</td><td>{{ $nonVoters }}</td><td>{{ $totalResidents > 0 ? round($nonVoters / $totalResidents * 100, 1) : 0 }}%</td></tr>
            </tbody>
        </table>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const COLORS = ['#4e73df','#f6c23e','#1cc88a','#e74a3b','#858796','#36b9cc'];

    // Gender
    new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{ data: [{{ $maleCount }}, {{ $femaleCount }}], backgroundColor: ['#4e73df','#f6c23e'] }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });

    // Voter
    new Chart(document.getElementById('voterChart'), {
        type: 'doughnut',
        data: {
            labels: ['Voters', 'Non-Voters'],
            datasets: [{ data: [{{ $voters }}, {{ $nonVoters }}], backgroundColor: ['#1cc88a','#e74a3b'] }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });

    // Age
    new Chart(document.getElementById('ageChart'), {
        type: 'bar',
        data: {
            labels: ['Minors (0–17)', 'Adults (18–59)', 'Seniors (60+)'],
            datasets: [{
                label: 'Count',
                data: [{{ $minors }}, {{ $adults }}, {{ $seniors }}],
                backgroundColor: ['#4e73df','#1cc88a','#f6c23e']
            }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    // Civil Status
    const civilLabels = {!! json_encode($civilStatus->keys()) !!};
    const civilData   = {!! json_encode($civilStatus->values()) !!};
    new Chart(document.getElementById('civilChart'), {
        type: 'bar',
        data: {
            labels: civilLabels,
            datasets: [{
                label: 'Count',
                data: civilData,
                backgroundColor: COLORS
            }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    // Resident Status
    const statusLabels = {!! json_encode($statusBreakdown->keys()) !!};
    const statusData   = {!! json_encode($statusBreakdown->values()) !!};
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{ data: statusData, backgroundColor: COLORS }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });
</script>
@endsection
