@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    .stat-card {
        background: #fff;
        border: 1px solid #e5e5e5;
        border-radius: 10px;
        padding: 20px 24px;
        text-align: center;
        transition: box-shadow .2s;
    }
    .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.08); }
    .stat-value { font-size: 32px; font-weight: 700; color: #1a1a1a; margin-top: 6px; }
    .stat-label { font-size: 11px; letter-spacing: .5px; }
    .chart-card { background: #fff; border: 1px solid #e5e5e5; border-radius: 10px; padding: 20px 24px; }
    .section-title { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
                     color: #6c757d; margin: 28px 0 12px; }
    .export-btn { font-size: 13px; padding: 6px 16px; border-radius: 6px; }
    .period-btn.active { background: #0d6efd; color: #fff; border-color: #0d6efd; }
</style>
@endsection

@section('content')
<div class="container-fluid p-4">

    {{-- ── HEADER ── --}}
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <h2 class="fw-bold mb-0">Reports & Analytics</h2>

        {{-- Export Buttons --}}
        <div class="d-flex gap-2">
            <a href="{{ route('reports.export.pdf', ['period' => $period]) }}"
               class="btn btn-danger export-btn">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
            <a href="{{ route('reports.export.excel', ['period' => $period]) }}"
               class="btn btn-success export-btn">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
        </div>
    </div>

    {{-- ── PERIOD FILTER ── --}}
    <div class="mb-4">
        <span class="section-title d-block mb-2">Filter by Period</span>
        <div class="btn-group" role="group">
            @foreach(['all' => 'All Time', 'monthly' => 'This Month', 'quarterly' => 'This Quarter', 'annual' => 'This Year'] as $key => $label)
                <a href="{{ route('reports.index', ['period' => $key]) }}"
                   class="btn btn-outline-primary period-btn {{ $period === $key ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- ── POPULATION SUMMARY ── --}}
    <p class="section-title">Population Summary</p>
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-label fw-bold text-muted">TOTAL POPULATION</div>
                <div class="stat-value text-primary">{{ $totalResidents }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-label fw-bold text-muted">REGISTERED VOTERS</div>
                <div class="stat-value text-success">{{ $voters }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-label fw-bold text-muted">NON-VOTERS</div>
                <div class="stat-value text-secondary">{{ $nonVoters }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-label fw-bold text-muted">VOTER RATE</div>
                <div class="stat-value text-info">
                    {{ $totalResidents > 0 ? round(($voters / $totalResidents) * 100) : 0 }}%
                </div>
            </div>
        </div>
    </div>

    {{-- ── AGE & GENDER SUMMARY ── --}}
    <p class="section-title">Age Group & Gender</p>
    <div class="row g-3 mb-4">
        @foreach(['MINORS (< 18)' => [$minors, 'warning'], 'ADULTS (18–59)' => [$adults, 'primary'], 'SENIORS (60+)' => [$seniors, 'danger'], 'MALE' => [$male, 'info'], 'FEMALE' => [$female, 'pink']] as $label => [$val, $color])
        <div class="col-6 col-md">
            <div class="stat-card">
                <div class="stat-label fw-bold text-muted">{{ $label }}</div>
                <div class="stat-value text-{{ $color === 'pink' ? 'danger' : $color }}">{{ $val }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── CHARTS ── --}}
    <p class="section-title">Demographics Charts</p>
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="chart-card">
                <h6 class="fw-bold mb-3">Age Groups</h6>
                <canvas id="ageChart"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-card">
                <h6 class="fw-bold mb-3">Gender Distribution</h6>
                <canvas id="genderChart"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-card">
                <h6 class="fw-bold mb-3">Voter Status</h6>
                <canvas id="voterChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="chart-card">
                <h6 class="fw-bold mb-3">Civil Status</h6>
                <canvas id="civilChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-card">
                <h6 class="fw-bold mb-3">Resident Status</h6>
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ── DETAILED TABLE ── --}}
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
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function () {

    // ── DataTable ──
    $('#reports-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('reports.data') }}",
            data: { period: "{{ $period }}" }
        },
        columns: [
            { data: 'full_name',    name: 'first_name' },
            { data: 'age',          name: 'age' },
            { data: 'sex',          name: 'sex' },
            { data: 'is_voter',     name: 'is_voter' },
            { data: 'civil_status', name: 'civil_status' },
            { data: 'status',       name: 'status' }
        ]
    });

    const COLORS = ['#4e73df','#1cc88a','#f6c23e','#e74a3b','#858796','#36b9cc','#fd7e14'];

    // ── Age Chart ──
    new Chart(document.getElementById('ageChart'), {
        type: 'bar',
        data: {
            labels: ['Minors', 'Adults', 'Seniors'],
            datasets: [{ label: 'Residents', data: [{{ $minors }}, {{ $adults }}, {{ $seniors }}],
                backgroundColor: ['#f6c23e','#4e73df','#e74a3b'] }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

    // ── Gender Chart ──
    new Chart(document.getElementById('genderChart'), {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{ data: [{{ $male }}, {{ $female }}],
                backgroundColor: ['#4e73df','#e74a3b'] }]
        }
    });

    // ── Voter Chart ──
    new Chart(document.getElementById('voterChart'), {
        type: 'doughnut',
        data: {
            labels: ['Registered', 'Not Registered'],
            datasets: [{ data: [{{ $voters }}, {{ $nonVoters }}],
                backgroundColor: ['#1cc88a','#858796'] }]
        }
    });

    // ── Civil Status Chart ──
    new Chart(document.getElementById('civilChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($civilStatus->keys()) !!},
            datasets: [{ data: {!! json_encode($civilStatus->values()) !!},
                backgroundColor: COLORS }]
        }
    });

    // ── Status Breakdown Chart ──
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($statusBreakdown->keys()) !!},
            datasets: [{ label: 'Count', data: {!! json_encode($statusBreakdown->values()) !!},
                backgroundColor: COLORS }]
        },
        options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });

});
</script>
@endsection
