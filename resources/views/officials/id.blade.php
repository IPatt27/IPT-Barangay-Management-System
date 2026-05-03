<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Digital ID — {{ $official->full_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #f0f0f0;
            font-family: 'DM Sans', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px 80px;
        }

        /* Print bar */
        .print-bar {
            position: fixed;
            top: 0; left: 0; right: 0;
            background: #2d6a4f;
            color: #fff;
            padding: 10px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
            font-family: 'DM Sans', sans-serif;
        }
        .btn-print {
            background: #fff; color: #2d6a4f;
            border: none; padding: 7px 18px;
            border-radius: 6px; font-weight: 700;
            cursor: pointer; font-size: 13px;
        }
        .btn-back {
            background: transparent; color: #fff;
            border: 1px solid rgba(255,255,255,.5);
            padding: 7px 18px; border-radius: 6px;
            font-weight: 600; cursor: pointer;
            font-size: 13px; text-decoration: none;
        }
        .btn-back:hover { background: rgba(255,255,255,.1); }

        /* ID card wrapper - shows front and back side by side */
        .id-wrapper {
            display: flex;
            gap: 24px;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 60px;
        }

        /* ID card */
        .id-card {
            width: 86mm;
            height: 54mm;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 8px 24px rgba(0,0,0,.18);
            position: relative;
        }

        /* FRONT */
        .id-front {
            background: linear-gradient(135deg, #1a3a2a 0%, #2d6a4f 60%, #40916c 100%);
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px 12px 8px;
        }

        .id-front .brgy-header {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 7px;
        }

        .id-front .brgy-header img {
            width: 28px; height: 28px;
            border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,.5);
        }

        .id-front .brgy-header .brgy-text {
            font-size: 7pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            line-height: 1.2;
        }

        .id-front .brgy-header .brgy-sub {
            font-size: 5.5pt;
            opacity: .75;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .id-front .photo-circle {
            width: 44px; height: 44px;
            border-radius: 50%;
            border: 2.5px solid rgba(255,255,255,.8);
            object-fit: cover;
            margin-bottom: 6px;
        }

        .id-front .official-name {
            font-size: 9pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            text-align: center;
        }

        .id-front .official-position {
            font-size: 7pt;
            opacity: .85;
            text-align: center;
            margin-top: 1px;
        }

        .id-front .official-designation {
            font-size: 6pt;
            opacity: .7;
            text-align: center;
            margin-top: 2px;
            font-style: italic;
        }

        /* Decorative circles */
        .id-front::before, .id-front::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
        }
        .id-front::before { width: 80px; height: 80px; top: -20px; right: -20px; }
        .id-front::after  { width: 60px; height: 60px; bottom: -15px; left: -15px; }

        /* BACK */
        .id-back {
            background: #fff;
            display: flex;
            flex-direction: column;
            padding: 10px 14px;
        }

        .id-back .back-header {
            display: flex;
            align-items: center;
            gap: 6px;
            border-bottom: 1.5px solid #2d6a4f;
            padding-bottom: 6px;
            margin-bottom: 8px;
        }

        .id-back .back-header img {
            width: 22px; height: 22px; border-radius: 50%;
        }

        .id-back .back-header span {
            font-size: 6.5pt;
            font-weight: 700;
            text-transform: uppercase;
            color: #2d6a4f;
            letter-spacing: .4px;
        }

        .id-back .info-row {
            display: flex;
            gap: 6px;
            margin-bottom: 4px;
            font-size: 6.5pt;
            color: #333;
        }

        .id-back .info-row .lbl {
            color: #888;
            min-width: 52px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .id-back .sig-section {
            margin-top: auto;
            padding-top: 6px;
            border-top: 1px solid #e5e5e5;
            display: flex;
            justify-content: flex-end;
        }

        .id-back .sig-box {
            text-align: center;
            min-width: 80px;
        }

        .id-back .sig-line {
            border-top: 1px solid #333;
            margin-bottom: 2px;
        }

        .id-back .sig-label {
            font-size: 5.5pt;
            color: #555;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        /* Print styles */
        @media print {
            .print-bar { display: none !important; }
            body { background: #fff; padding: 10mm; }
            .id-wrapper { margin-top: 0; }
        }

        @media screen {
            body { padding-top: 70px; }
        }
    </style>
</head>
<body>

{{-- Print bar --}}
<div class="print-bar">
    <span style="font-weight:600;">🪪 &nbsp; Digital ID — {{ $official->full_name }}</span>
    <div style="display:flex; gap:10px;">
        <a href="{{ route('officials.view', $official->id) }}" class="btn-back">← Back to Profile</a>
        <button class="btn-print" onclick="window.print()">Print ID</button>
    </div>
</div>

@php
    $photoSrc = $official->photo
        ? asset('storage/' . $official->photo)
        : 'https://ui-avatars.com/api/?name=' . urlencode($official->first_name . '+' . $official->last_name) . '&background=2d6a4f&color=fff&size=128';
@endphp

<div class="id-wrapper">

    {{-- FRONT --}}
    <div class="id-card id-front">
        <div class="brgy-header">
            <img src="/BarangayNewEra.jpg" alt="seal">
            <div>
                <div class="brgy-text">Barangay New Era</div>
                <div class="brgy-sub">District VI, Quezon City</div>
            </div>
        </div>

        <img src="{{ $photoSrc }}" class="photo-circle" alt="photo">

        <div class="official-name">{{ $official->full_name }}</div>
        <div class="official-position">{{ $official->position }}</div>
        @if($official->designation)
            <div class="official-designation">{{ $official->designation }}</div>
        @endif
    </div>

    {{-- BACK --}}
    <div class="id-card id-back">
        <div class="back-header">
            <img src="/BarangayNewEra.jpg" alt="seal">
            <span>Barangay New Era — Official ID</span>
        </div>

        <div class="info-row">
            <span class="lbl">Status</span>
            <span>{{ $official->status }}</span>
        </div>

        @if($official->birthdate)
        <div class="info-row">
            <span class="lbl">Birthdate</span>
            <span>{{ $official->birthdate->format('M d, Y') }}</span>
        </div>
        @endif

        @if($official->contact)
        <div class="info-row">
            <span class="lbl">Contact</span>
            <span>{{ $official->contact }}</span>
        </div>
        @endif

        @if($official->address)
        <div class="info-row">
            <span class="lbl">Address</span>
            <span>{{ $official->address }}</span>
        </div>
        @endif

        @if($official->term_start && $official->term_end)
        <div class="info-row">
            <span class="lbl">Term</span>
            <span>{{ $official->term_start->format('M Y') }} – {{ $official->term_end->format('M Y') }}</span>
        </div>
        @endif

        <div class="sig-section">
            <div class="sig-box">
                <div class="sig-line"></div>
                <div class="sig-label">Punong Barangay</div>
            </div>
        </div>
    </div>

</div>

</body>
</html>
