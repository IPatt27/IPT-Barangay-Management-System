@extends('layouts.app')

@section('styles')
<style>
    .party-card {
        background: #f8f9fa; border: 1px solid #e5e5e5;
        border-radius: 10px; padding: 16px; margin-bottom: 12px; position: relative;
    }
    .remove-party { position: absolute; top:10px; right:12px; background:none; border:none; color:#dc3545; cursor:pointer; font-size:16px; }
    .role-badge { display:inline-block; padding:2px 10px; border-radius:20px; font-size:11px; font-weight:600; text-transform:uppercase; }
    .role-Complainant { background:#d4edda; color:#155724; }
    .role-Respondent  { background:#f8d7da; color:#721c24; }
    .role-Witness     { background:#fff3cd; color:#856404; }
</style>
@endsection

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('blotter.view', $blotter->id) }}" class="btn btn-outline-secondary btn-sm">
        <i class="fa fa-arrow-left"></i>
    </a>
    <h2 style="font-size:28px; font-weight:700; color:#1a1a1a; margin:0;">
        Edit — {{ $blotter->case_number }}
    </h2>
</div>

<form action="{{ route('blotter.update', $blotter->id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

<div class="row g-4">
    <div class="col-lg-8">

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:12px; letter-spacing:.8px;">Incident Details</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Incident Type <span class="text-danger">*</span></label>
                        <input type="text" name="incident_type" class="form-control"
                               value="{{ old('incident_type', $blotter->incident_type) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date & Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="incident_date" class="form-control"
                               value="{{ old('incident_date', $blotter->incident_date->format('Y-m-d\TH:i')) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Location <span class="text-danger">*</span></label>
                        <input type="text" name="incident_location" class="form-control"
                               value="{{ old('incident_location', $blotter->incident_location) }}" required>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                        <textarea name="incident_description" class="form-control" rows="5" required>{{ old('incident_description', $blotter->incident_description) }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Remarks</label>
                        <textarea name="remarks" class="form-control" rows="2">{{ old('remarks', $blotter->remarks) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Involved Parties --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-uppercase text-muted mb-0" style="font-size:12px; letter-spacing:.8px;">Involved Parties</h6>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="addParty('Complainant')">+ Complainant</button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="addParty('Respondent')">+ Respondent</button>
                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="addParty('Witness')">+ Witness</button>
                    </div>
                </div>
                <div id="partiesContainer">
                    @foreach($blotter->parties as $i => $party)
                    <div class="party-card" data-index="{{ $i }}">
                        <button type="button" class="remove-party" onclick="removeParty(this)">
                            <i class="fa fa-times-circle"></i>
                        </button>
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="role-badge role-{{ $party->role }}">{{ $party->role }}</span>
                        </div>
                        <input type="hidden" name="parties[{{ $i }}][role]" value="{{ $party->role }}">
                        <input type="hidden" name="parties[{{ $i }}][resident_id]" value="{{ $party->resident_id }}">
                        <div class="row g-2">
                            <div class="col-12">
                                <input type="text" name="parties[{{ $i }}][name]" class="form-control form-control-sm"
                                       placeholder="Full name *" value="{{ $party->name }}" required>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="parties[{{ $i }}][address]" class="form-control form-control-sm"
                                       placeholder="Address" value="{{ $party->address }}">
                            </div>
                            <div class="col-md-5">
                                <input type="text" name="parties[{{ $i }}][contact]" class="form-control form-control-sm"
                                       placeholder="Contact" value="{{ $party->contact }}">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Add More Attachments --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:12px; letter-spacing:.8px;">
                    Add More Attachments
                </h6>
                <input type="file" name="attachments[]" class="form-control" multiple
                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                <div class="text-muted small mt-1">Accepted: JPG, PNG, PDF, DOC, DOCX — max 5MB each</div>
            </div>
        </div>

    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:12px; letter-spacing:.8px;">Case Information</h6>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Case Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        @foreach(['Active','Under Investigation','Settled','Dismissed','Referred to Higher Authority'] as $s)
                            <option value="{{ $s }}" {{ old('status', $blotter->status) == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Recorded By <span class="text-danger">*</span></label>
                    <input type="text" name="recorded_by" class="form-control"
                           value="{{ old('recorded_by', $blotter->recorded_by) }}" required>
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success" style="background:#2d6a4f; border:none; font-weight:600;">
                <i class="fa fa-save me-1"></i> Save Changes
            </button>
            <a href="{{ route('blotter.view', $blotter->id) }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</div>
</form>

<template id="partyTemplate">
    <div class="party-card" data-index="__INDEX__">
        <button type="button" class="remove-party" onclick="removeParty(this)">
            <i class="fa fa-times-circle"></i>
        </button>
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="role-badge role-__ROLE__">__ROLE__</span>
        </div>
        <input type="hidden" name="parties[__INDEX__][role]" value="__ROLE__">
        <input type="hidden" name="parties[__INDEX__][resident_id]" value="">
        <div class="row g-2">
            <div class="col-12">
                <input type="text" name="parties[__INDEX__][name]" class="form-control form-control-sm" placeholder="Full name *" required>
            </div>
            <div class="col-md-7">
                <input type="text" name="parties[__INDEX__][address]" class="form-control form-control-sm" placeholder="Address">
            </div>
            <div class="col-md-5">
                <input type="text" name="parties[__INDEX__][contact]" class="form-control form-control-sm" placeholder="Contact">
            </div>
        </div>
    </div>
</template>

@endsection

@section('scripts')
<script>
    let partyIndex = {{ $blotter->parties->count() }};

    function addParty(role) {
        const html = document.getElementById('partyTemplate').innerHTML
            .replaceAll('__INDEX__', partyIndex)
            .replaceAll('__ROLE__', role);
        document.getElementById('partiesContainer').insertAdjacentHTML('beforeend', html);
        partyIndex++;
    }

    function removeParty(btn) {
        btn.closest('.party-card').remove();
    }
</script>
@endsection