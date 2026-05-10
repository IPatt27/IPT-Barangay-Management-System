<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    body { font-family: Arial, sans-serif; font-size: 12px; color: #222; }
    h2 { text-align: center; margin-bottom: 4px; }
    .subtitle { text-align: center; color: #666; font-size: 11px; margin-bottom: 20px; }
    .summary { display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
    .stat { background: #f4f6fb; border-radius: 6px; padding: 10px 16px; text-align: center; flex: 1; min-width: 100px; }
    .stat-val { font-size: 22px; font-weight: 700; color: #1a1a1a; }
    .stat-lbl { font-size: 10px; color: #888; }
    table { width: 100%; border-collapse: collapse; font-size: 11px; }
    th { background: #4e73df; color: #fff; padding: 6px 8px; text-align: left; }
    td { padding: 5px 8px; border-bottom: 1px solid #e5e5e5; }
    tr:nth-child(even) td { background: #f9f9f9; }
    .footer { text-align: center; margin-top: 20px; font-size: 10px; color: #aaa; }
</style>
</head>
<body>

<h2>Barangay Resident Report</h2>
<div class="subtitle">
    Period: {{ ucfirst($summary['period']) === 'All' ? 'All Time' : ucfirst($summary['period']) }}
    &nbsp;|&nbsp; Generated: {{ now()->format('F d, Y h:i A') }}
</div>

<div class="summary">
    <div class="stat"><div class="stat-val">{{ $summary['total'] }}</div><div class="stat-lbl">Total</div></div>
    <div class="stat"><div class="stat-val">{{ $summary['voters'] }}</div><div class="stat-lbl">Voters</div></div>
    <div class="stat"><div class="stat-val">{{ $summary['minors'] }}</div><div class="stat-lbl">Minors</div></div>
    <div class="stat"><div class="stat-val">{{ $summary['adults'] }}</div><div class="stat-lbl">Adults</div></div>
    <div class="stat"><div class="stat-val">{{ $summary['seniors'] }}</div><div class="stat-lbl">Seniors</div></div>
    <div class="stat"><div class="stat-val">{{ $summary['male'] }}</div><div class="stat-lbl">Male</div></div>
    <div class="stat"><div class="stat-val">{{ $summary['female'] }}</div><div class="stat-lbl">Female</div></div>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Age</th>
            <th>Sex</th>
            <th>Civil Status</th>
            <th>Voter</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($residents as $i => $r)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $r->first_name }} {{ $r->last_name }}</td>
            <td>{{ $r->age }}</td>
            <td>{{ $r->sex }}</td>
            <td>{{ $r->civil_status }}</td>
            <td>{{ $r->is_voter ? 'Yes' : 'No' }}</td>
            <td>{{ $r->status }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">Barangay Management System &mdash; Confidential</div>
</body>
</html>
