@extends('layouts.app')

@section('content')
<div class="container p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Payment Records</h2>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Resident</th>
                        <th>Purpose</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                        <td>{{ $payment->resident->first_name }} {{ $payment->resident->last_name }}</td>
                        <td>{{ $payment->type }}</td>
                        <td>₱{{ number_format($payment->amount, 2) }}</td>
                        <td><span class="badge bg-success">{{ $payment->status }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection