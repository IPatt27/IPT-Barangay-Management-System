<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; max-width: 600px; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h2 { margin: 0; }
        .header p { margin: 4px 0; color: #555; }
        .divider { border-top: 2px solid #1a3a5c; margin: 20px 0; }
        .row { display: flex; justify-content: space-between; margin: 10px 0; }
        .label { color: #555; }
        .value { font-weight: bold; }
        .amount { font-size: 24px; color: #2d6a4f; text-align: center; margin: 20px 0; }
        .footer { text-align: center; margin-top: 40px; color: #888; font-size: 12px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>

<div class="header">
    <h2>Barangay New Era</h2>
    <p>District VI, Quezon City</p>
    <h3>Official Payment Receipt</h3>
</div>

<div class="divider"></div>

<div class="row">
    <span class="label">Receipt No.</span>
    <span class="value">#{{ $payment->id }}</span>
</div>
<div class="row">
    <span class="label">OR Number</span>
    <span class="value">{{ $payment->or_number ?? '—' }}</span>
</div>
<div class="row">
    <span class="label">Date</span>
    <span class="value">{{ $payment->paid_at?->format('F d, Y h:i A') ?? $payment->created_at->format('F d, Y h:i A') }}</span>
</div>

<div class="divider"></div>

@if($payment->payable_type === 'App\Models\Document')
<div class="row">
    <span class="label">Resident Name</span>
    <span class="value">{{ $payment->payable->resident->first_name }} {{ $payment->payable->resident->last_name }}</span>
</div>
<div class="row">
    <span class="label">Document Type</span>
    <span class="value">{{ $payment->payable->document_type }}</span>
</div>
<div class="row">
    <span class="label">Purpose</span>
    <span class="value">{{ $payment->payable->purpose }}</span>
</div>
@else
<div class="row">
    <span class="label">Business Owner</span>
    <span class="value">{{ $payment->payable->owner_name }}</span>
</div>
<div class="row">
    <span class="label">Business Name</span>
    <span class="value">{{ $payment->payable->business_name }}</span>
</div>
<div class="row">
    <span class="label">Permit Type</span>
    <span class="value">{{ $payment->payable->business_type }} Permit</span>
</div>
@endif

<div class="divider"></div>

<div class="amount">₱{{ number_format($payment->amount, 2) }}</div>

<div class="divider"></div>

<div class="footer">
    <p>This is an official receipt issued by Barangay New Era.</p>
    <p>Thank you!</p>
</div>

<div class="no-print" style="text-align:center; margin-top:30px;">
    <button onclick="window.print()" class="btn btn-primary">🖨️ Print Receipt</button>
</div>

</body>
</html>