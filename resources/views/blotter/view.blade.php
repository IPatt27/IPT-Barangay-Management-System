@extends('layouts.app')

@section('styles')
<style>
    .info-label { font-size: 12px; text-transform: uppercase; letter-spacing: .6px; color: #888; font-weight: 600; }
    .info-value { font-size: 14px; color: #1a1a1a; font-weight: 500; }
    .party-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 12px; border-radius: 20px; font-size: 13px; margin: 3px;
    }
    .pill-Complainant { background: #d4edda; color: #155724; }
    .pill-Respondent  { background: #f8d7da; color: #721c24; }
    .pill-Witness     { background: #fff3cd; color: #856404; }
    .status-badge {
        padding: 4px 14px; border-radius: 20px; font-size: 12px; font-weight: 600;
    }
</style>
@endsection

@section('content')

@php
    $statusColors = [
        'Active'                        => ['bg' => '#fee2e2', 'text' => '#991b1b'],
        'Under Investigation'           => ['bg' => '#fef9c3', 'text' => '#854d0e'],
        'Settled'                       => ['bg' => '#dcfce7', 'text' => '#166534'],
        'Dismissed'                     => ['bg' => '#f3f4f6', 'text' => '#4b5563'],
        'Referred to Higher Authority'  => ['bg' => '#dbeafe', 'text' => '#1e40af'],
    ];
    $sc = $statusColors[$blotter->status] ?? ['bg' => '#f3f4f6', 'text' => '#333'];
@endphp

{{-- Top bar --}}
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('blotter.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left"></i>
        </a>
        <div>
            <h2 style="font-size:24px; font-weight:700; color:#1a1a1a; margin:0;">
                {{ $blotter->case_number }}
            </h2>
            <span class="text-muted" style="font-size:13px;">{{ $blotter->incident_type }}</span>
        </div>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <span class="status-badge" style="background:{{ $sc['bg'] }}; color:{{ $sc['text'] }};">
            {{ $blotter->status }}
        </span>

        @hasanyrole('admin|secretary')
        <a href="{{ route('blotter.edit', $blotter->id) }}" class="btn btn-warning btn-sm">
            <i class="fa fa-edit"></i> Edit
        </a>
        @endhasanyrole

        <a href="{{ route('blotter.print', $blotter->id) }}" class="btn btn-success btn-sm" target="_blank"
           style="background:#2d6a4f; border:none;">
            <i class="fa fa-print"></i> Print Report
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">

    {{-- Incident Info --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase text-muted mb-4" style="font-size:12px; letter-spacing:.8px;">
                    Incident Details
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-label">Incident Type</div>
                        <div class="info-value">{{ $blotter->incident_type }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Date & Time</div>
                        <div class="info-value">{{ $blotter->incident_date->format('F d, Y — h:i A') }}</div>
                    </div>
                    <div class="col-12">
                        <div class="info-label">Location</div>
                        <div class="info-value">{{ $blotter->incident_location }}</div>
                    </div>
                    <div class="col-12">
                        <div class="info-label">Description</div>
                        <div class="info-value" style="line-height:1.7; white-space:pre-wrap;">{{ $blotter->incident_description }}</div>
                    </div>
                    @if($blotter->remarks)
                    <div class="col-12">
                        <div class="info-label">Remarks</div>
                        <div class="info-value" style="white-space:pre-wrap;">{{ $blotter->remarks }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Involved Parties --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:12px; letter-spacing:.8px;">
                    Involved Parties
                </h6>
                @forelse($blotter->parties as $party)
                    <div class="d-flex align-items-start gap-3 mb-3 pb-3 border-bottom">
                        <span class="party-pill pill-{{ $party->role }}">{{ $party->role }}</span>
                        <div>
                            <div class="fw-semibold">{{ $party->name }}</div>
                            @if($party->address)
                                <div class="text-muted small">{{ $party->address }}</div>
                            @endif
                            @if($party->contact)
                                <div class="text-muted small"><i class="fa fa-phone fa-xs me-1"></i>{{ $party->contact }}</div>
                            @endif
                            @if($party->resident_id)
                                <span class="badge bg-light text-dark border" style="font-size:10px;">Registered Resident</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted" style="font-size:13px;">No parties recorded.</p>
                @endforelse
            </div>
        </div>

        {{-- Attachments --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:12px; letter-spacing:.8px;">
                    Supporting Documents
                </h6>
                @forelse($blotter->attachments as $att)
                    <div class="d-flex align-items-center justify-content-between mb-2 p-2 rounded" style="background:#f8f9fa;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa fa-paperclip text-muted"></i>
                            <a href="{{ asset('storage/' . $att->file_path) }}" target="_blank" style="font-size:13px;">
                                {{ $att->file_name }}
                            </a>
                        </div>
                        <form action="{{ route('blotter.attachment.delete', $att->id) }}" method="POST"
                              onsubmit="return confirm('Remove this attachment?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" style="font-size:11px; padding: 2px 8px;">
                                Remove
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-muted" style="font-size:13px;">No attachments uploaded.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Right sidebar --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase text-muted mb-4" style="font-size:12px; letter-spacing:.8px;">
                    Case Information
                </h6>
                <div class="mb-3">
                    <div class="info-label">Case Number</div>
                    <div class="info-value">{{ $blotter->case_number }}</div>
                </div>
                <div class="mb-3">
                    <div class="info-label">Status</div>
                    <span class="status-badge" style="background:{{ $sc['bg'] }}; color:{{ $sc['text'] }};">
                        {{ $blotter->status }}
                    </span>
                </div>
                <div class="mb-3">
                    <div class="info-label">Recorded By</div>
                    <div class="info-value">{{ $blotter->recorded_by }}</div>
                </div>
                <div class="mb-3">
                    <div class="info-label">Date Recorded</div>
                    <div class="info-value">{{ $blotter->created_at->format('F d, Y') }}</div>
                </div>
                <div class="mb-3">
                    <div class="info-label">Last Updated</div>
                    <div class="info-value">{{ $blotter->updated_at->format('F d, Y h:i A') }}</div>
                </div>

                @hasanyrole('admin')
                <hr>
                {{--
                    Soft-delete: moves to trash, recoverable from /blotter/trash.
                    Use the trash page for permanent deletion.
                --}}
                <form action="{{ route('blotter.delete', $blotter->id) }}" method="POST"
                      onsubmit="return confirm('Move this blotter entry to trash? It can be restored later.')">
                    @csrf @method('DELETE')
                    <button class="btn btn-outline-danger w-100 btn-sm">
                        <i class="fa fa-trash me-1"></i> Move to Trash
                    </button>
                </form>
                @endhasanyrole
            </div>
        </div>
    </div>

</div>

@endsection