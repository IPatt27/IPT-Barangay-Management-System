@extends('layouts.print')

@section('title', $document->document_type . ' — ' . $document->resident->first_name . ' ' . $document->resident->last_name)

@section('body')

@php
    $resident = $document->resident;
    $fullName = strtoupper($resident->first_name . ' ' . $resident->last_name);
    $date     = $document->created_at->format('F d, Y');
    $type     = $document->document_type;
@endphp

<div class="page">

    {{-- Watermark --}}
    <div class="watermark">
        <img src="/BarangayNewEra.jpg" alt="seal">
    </div>

    <div class="content">

        {{-- Seal (top-left) --}}
        <img src="/BarangayNewEra.jpg" class="seal" alt="Barangay Seal">

        {{-- Header --}}
        <div class="cert-header">
            <div class="republic">Republic of the Philippines</div>
            <div class="province">City of Quezon &bull; National Capital Region</div>
            <div class="brgy-name">Barangay New Era</div>
            <div class="brgy-address">District VI, Quezon City</div>
            <div class="brgy-address" style="margin-top:2px;">
                Barangay Hall, New Era, Quezon City &bull; Tel. No.: (02) 000-0000
            </div>
        </div>

        {{-- Certificate Title --}}
        <div class="cert-title">{{ $type }}</div>
        <div class="cert-subtitle">Office of the Punong Barangay</div>

        {{-- Certificate Body — switches based on document type --}}
        <div class="cert-body">

            <p>TO WHOM IT MAY CONCERN:</p>
            <br>

            @if($type === 'Barangay Clearance')

                <p>
                    This is to certify that <span class="name">{{ $fullName }}</span>,
                    {{ $resident->age }} years old, <em>{{ $resident->civil_status }}</em>,
                    is a bonafide resident of <strong>{{ $resident->address }}</strong>,
                    Barangay New Era, Quezon City.
                </p>
                <br>
                <p>
                    Based on available records of this Barangay, said person has no derogatory
                    record and has not been involved in any criminal or civil case pending
                    before this office.
                </p>

            @elseif($type === 'Certificate of Residency')

                <p>
                    This is to certify that <span class="name">{{ $fullName }}</span>,
                    {{ $resident->age }} years old, born on
                    {{ \Carbon\Carbon::parse($resident->birthdate)->format('F d, Y') }},
                    is a bonafide and registered resident of
                    <strong>{{ $resident->address }}</strong>,
                    Barangay New Era, District VI, Quezon City.
                </p>
                <br>
                <p>
                    Said person has been residing in this barangay and is known to be
                    a law-abiding citizen of this community.
                </p>

            @elseif($type === 'Certificate of Indigency')

                <p>
                    This is to certify that <span class="name">{{ $fullName }}</span>,
                    {{ $resident->age }} years old, <em>{{ $resident->civil_status }}</em>,
                    is a resident of <strong>{{ $resident->address }}</strong>,
                    Barangay New Era, Quezon City.
                </p>
                <br>
                <p>
                    Based on our records and personal knowledge, the aforementioned person
                    belongs to the indigent sector of our community and is not capable of
                    funding his/her own needs without assistance.
                </p>

            @elseif($type === 'Good Moral Character')

                <p>
                    This is to certify that <span class="name">{{ $fullName }}</span>,
                    {{ $resident->age }} years old, <em>{{ $resident->civil_status }}</em>,
                    a resident of <strong>{{ $resident->address }}</strong>,
                    Barangay New Era, Quezon City, is a person of <strong>good moral character</strong>
                    and has no known derogatory record in this barangay.
                </p>
                <br>
                <p>
                    Said person is known in this community to be law-abiding, responsible,
                    and of good standing.
                </p>

            @elseif($type === 'Business Clearance')

                <p>
                    This is to certify that <span class="name">{{ $fullName }}</span>,
                    of legal age, a resident of <strong>{{ $resident->address }}</strong>,
                    Barangay New Era, Quezon City, has applied for and is hereby granted
                    <strong>Barangay Business Clearance</strong>.
                </p>
                <br>
                <p>
                    This clearance is issued after verification that the applicant has no
                    pending case or complaint filed in this Barangay.
                </p>

            @endif

            {{-- Purpose --}}
            <div class="cert-purpose">
                <p>
                    This certification is issued upon the request of the above-named person
                    for the purpose of <span class="blank">{{ $document->purpose }}</span>
                    and for whatever legal purpose it may serve.
                </p>
            </div>

            {{-- Date --}}
            <div class="cert-date">
                <p>Issued this <strong>{{ $document->created_at->format('d') }}</strong> day of
                   <strong>{{ $document->created_at->format('F Y') }}</strong>
                   at Barangay New Era, Quezon City.</p>
            </div>

        </div>{{-- /cert-body --}}

        {{-- Signature Block --}}
        <div class="sig-right" style="margin-top: 50px;">
            <div class="sig-block">
                <div style="height: 40px;"></div>{{-- space for actual signature --}}
                <div class="sig-name">{{ $document->issued_by ?? 'PUNONG BARANGAY' }}</div>
                <div class="sig-title">{{ $document->position ?? 'Barangay Captain' }}</div>
                <div class="sig-title">Barangay New Era, Quezon City</div>
            </div>
        </div>

        {{-- Footer info: OR number, control no, date --}}
        <div class="cert-footer-info">
            <span>
                @if($document->or_number)
                    OR No.: {{ $document->or_number }}
                @else
                    OR No.: —
                @endif
            </span>
            <span>Doc. Control No.: {{ str_pad($document->id, 6, '0', STR_PAD_LEFT) }}</span>
            <span>Date Issued: {{ $date }}</span>
        </div>

    </div>{{-- /content --}}
</div>{{-- /page --}}

@endsection
