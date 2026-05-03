@extends('layouts.print')

@php
    $backRoute = route('blotter.index');
    $backLabel = 'Back to Blotter Management Page';
@endphp

@section('title', 'Blotter Report — ' . $blotter->case_number)

@section('body')

<div class="page">
    <div class="watermark"><img src="/BarangayNewEra.jpg" alt="seal"></div>

    <div class="content">
        <img src="/BarangayNewEra.jpg" class="seal" alt="seal">

        {{-- Header --}}
        <div class="cert-header">
            <div class="republic">Republic of the Philippines</div>
            <div class="province">City of Quezon &bull; National Capital Region</div>
            <div class="brgy-name">Barangay New Era</div>
            <div class="brgy-address">District VI, Quezon City</div>
            <div class="brgy-address" style="margin-top:2px;">Barangay Hall, New Era, Quezon City</div>
        </div>

        <div class="cert-title" style="font-size:14pt;">Barangay Blotter Report</div>
        <div class="cert-subtitle">Office of the Punong Barangay — Blotter & Complaints Division</div>

        {{-- Case summary --}}
        <table style="width:100%; border-collapse:collapse; margin-bottom:18px; font-size:12pt;">
            <tr>
                <td style="padding:5px 8px; width:35%; color:#555; font-size:11pt;">Case Number</td>
                <td style="padding:5px 8px; font-weight:bold;">{{ $blotter->case_number }}</td>
                <td style="padding:5px 8px; width:25%; color:#555; font-size:11pt;">Status</td>
                <td style="padding:5px 8px; font-weight:bold;">{{ $blotter->status }}</td>
            </tr>
            <tr>
                <td style="padding:5px 8px; color:#555; font-size:11pt;">Incident Type</td>
                <td style="padding:5px 8px;">{{ $blotter->incident_type }}</td>
                <td style="padding:5px 8px; color:#555; font-size:11pt;">Date & Time</td>
                <td style="padding:5px 8px;">{{ $blotter->incident_date->format('M d, Y h:i A') }}</td>
            </tr>
            <tr>
                <td style="padding:5px 8px; color:#555; font-size:11pt;">Location</td>
                <td colspan="3" style="padding:5px 8px;">{{ $blotter->incident_location }}</td>
            </tr>
            <tr>
                <td style="padding:5px 8px; color:#555; font-size:11pt;">Recorded By</td>
                <td style="padding:5px 8px;">{{ $blotter->recorded_by }}</td>
                <td style="padding:5px 8px; color:#555; font-size:11pt;">Date Recorded</td>
                <td style="padding:5px 8px;">{{ $blotter->created_at->format('M d, Y') }}</td>
            </tr>
        </table>

        {{-- Description --}}
        <div style="margin-bottom:16px;">
            <div style="font-weight:bold; font-size:11pt; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px; border-bottom:1px solid #ccc; padding-bottom:3px;">
                Incident Description
            </div>
            <p style="font-size:12pt; line-height:1.8; text-align:justify;">{{ $blotter->incident_description }}</p>
        </div>

        @if($blotter->remarks)
        <div style="margin-bottom:16px;">
            <div style="font-weight:bold; font-size:11pt; text-transform:uppercase; letter-spacing:.5px; margin-bottom:4px; border-bottom:1px solid #ccc; padding-bottom:3px;">Remarks</div>
            <p style="font-size:12pt; line-height:1.8;">{{ $blotter->remarks }}</p>
        </div>
        @endif

        {{-- Parties --}}
        <div style="margin-bottom:16px;">
            <div style="font-weight:bold; font-size:11pt; text-transform:uppercase; letter-spacing:.5px; margin-bottom:6px; border-bottom:1px solid #ccc; padding-bottom:3px;">
                Involved Parties
            </div>
            <table style="width:100%; border-collapse:collapse; font-size:11pt;">
                <thead>
                    <tr style="background:#f0f0f0;">
                        <th style="padding:6px 8px; text-align:left; border:1px solid #ccc;">Role</th>
                        <th style="padding:6px 8px; text-align:left; border:1px solid #ccc;">Name</th>
                        <th style="padding:6px 8px; text-align:left; border:1px solid #ccc;">Address</th>
                        <th style="padding:6px 8px; text-align:left; border:1px solid #ccc;">Contact</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($blotter->parties as $party)
                    <tr>
                        <td style="padding:6px 8px; border:1px solid #ccc; font-weight:bold;">{{ $party->role }}</td>
                        <td style="padding:6px 8px; border:1px solid #ccc;">{{ $party->name }}</td>
                        <td style="padding:6px 8px; border:1px solid #ccc;">{{ $party->address ?? '—' }}</td>
                        <td style="padding:6px 8px; border:1px solid #ccc;">{{ $party->contact ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Signature --}}
        <div class="sig-right" style="margin-top:40px;">
            <div class="sig-block">
                <div style="height:36px;"></div>
                <div class="sig-name">Punong Barangay</div>
                <div class="sig-title">Barangay New Era, Quezon City</div>
            </div>
        </div>

        <div class="cert-footer-info">
            <span>Case No.: {{ $blotter->case_number }}</span>
            <span>Incident: {{ $blotter->incident_type }}</span>
            <span>Printed: {{ now()->format('M d, Y h:i A') }}</span>
        </div>

    </div>
</div>

@endsection
