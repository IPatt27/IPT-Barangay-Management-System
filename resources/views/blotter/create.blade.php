@extends('layouts.app')

@section('styles')
<style>
    .party-card {
        background: #f8f9fa;
        border: 1px solid #e5e5e5;
        border-radius: 10px;
        padding: 16px;
        margin-bottom: 12px;
        position: relative;
    }
    .remove-party {
        position: absolute;
        top: 10px;
        right: 12px;
        background: none;
        border: none;
        color: #dc3545;
        cursor: pointer;
        font-size: 16px;
    }
    .role-badge {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }
    .role-Complainant { background: #d4edda; color: #155724; }
    .role-Respondent  { background: #f8d7da; color: #721c24; }
    .role-Witness     { background: #fff3cd; color: #856404; }
</style>
@endsection

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('blotter.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fa fa-arrow-left"></i>
    </a>
    <h2 style="font-size:28px; font-weight:700; color:#1a1a1a; margin:0;">Record New Blotter Entry</h2>
</div>

<form action="{{ route('blotter.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="row g-4">

    {{-- LEFT COLUMN --}}
    <div class="col-lg-8">

        {{-- Incident Details --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:12px; letter-spacing:.8px;">
                    Incident Details
                </h6>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Incident Type <span class="text-danger">*</span></label>
                        <input type="text" name="incident_type" class="form-control"
                               placeholder="e.g. Noise Complaint, Physical Assault"
                               value="{{ old('incident_type') }}" required>
                        @error('incident_type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Date & Time of Incident <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="incident_date" class="form-control"
                               value="{{ old('incident_date') }}" required>
                        @error('incident_date') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Location of Incident <span class="text-danger">*</span></label>
                        <input type="text" name="incident_location" class="form-control"
                               placeholder="e.g. Purok 3, New Era, Quezon City"
                               value="{{ old('incident_location') }}" required>
                        @error('incident_location') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Incident Description <span class="text-danger">*</span></label>
                        <textarea name="incident_description" class="form-control" rows="5"
                                  placeholder="Describe the incident in detail..." required>{{ old('incident_description') }}</textarea>
                        @error('incident_description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Remarks <span class="text-muted small">(Optional)</span></label>
                        <textarea name="remarks" class="form-control" rows="2"
                                  placeholder="Any additional notes...">{{ old('remarks') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Involved Parties --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-bold text-uppercase text-muted mb-0" style="font-size:12px; letter-spacing:.8px;">
                        Involved Parties
                    </h6>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-success" onclick="addParty('Complainant')">
                            + Complainant
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="addParty('Respondent')">
                            + Respondent
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-warning" onclick="addParty('Witness')">
                            + Witness
                        </button>
                    </div>
                </div>

                @error('parties') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

                <div id="partiesContainer">
                    {{-- Default: one complainant and one respondent --}}
                </div>

                <div id="noPartyMsg" class="text-muted text-center py-3" style="font-size:13px; display:none;">
                    No parties added yet. Use the buttons above to add complainants, respondents, or witnesses.
                </div>
            </div>
        </div>

        {{-- Supporting Attachments --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:12px; letter-spacing:.8px;">
                    Supporting Documents / Attachments
                </h6>
                <input type="file" name="attachments[]" class="form-control" multiple
                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                <div class="text-muted small mt-1">
                    Accepted: JPG, PNG, PDF, DOC, DOCX — max 5MB each
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT COLUMN --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:12px; letter-spacing:.8px;">
                    Case Information
                </h6>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Case Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="Active"                       {{ old('status','Active') == 'Active'                       ? 'selected' : '' }}>Active</option>
                        <option value="Under Investigation"          {{ old('status') == 'Under Investigation'                   ? 'selected' : '' }}>Under Investigation</option>
                        <option value="Settled"                      {{ old('status') == 'Settled'                               ? 'selected' : '' }}>Settled</option>
                        <option value="Dismissed"                    {{ old('status') == 'Dismissed'                             ? 'selected' : '' }}>Dismissed</option>
                        <option value="Referred to Higher Authority" {{ old('status') == 'Referred to Higher Authority'          ? 'selected' : '' }}>Referred to Higher Authority</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Recorded By <span class="text-danger">*</span></label>
                    <input type="text" name="recorded_by" class="form-control"
                           placeholder="Name of barangay staff"
                           value="{{ old('recorded_by') }}" required>
                    @error('recorded_by') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="alert alert-info" style="font-size:12.5px;">
                    <i class="fa fa-info-circle me-1"></i>
                    The case number will be automatically generated upon saving.
                </div>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success" style="background:#2d6a4f; border:none; font-weight:600;">
                <i class="fa fa-save me-1"></i> Save Blotter Entry
            </button>
            <a href="{{ route('blotter.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>

</div>
</form>

{{-- Party template (hidden, cloned by JS) --}}
<template id="partyTemplate">
    <div class="party-card" data-index="__INDEX__">
        <button type="button" class="remove-party" onclick="removeParty(this)">
            <i class="fa fa-times-circle"></i>
        </button>

        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="role-badge role-__ROLE__">__ROLE__</span>
        </div>

        <input type="hidden" name="parties[__INDEX__][role]" value="__ROLE__">

        <div class="row g-2">
            <div class="col-12">
                <label class="form-label fw-semibold" style="font-size:13px;">
                    Select Registered Resident <span class="text-muted small">(Optional)</span>
                </label>
                <select class="form-select form-select-sm resident-select" onchange="autofillParty(this, __INDEX__)">
                    <option value="">— Select a resident or fill manually —</option>
                    @foreach($residents as $resident)
                        <option value="{{ $resident->id }}"
                            data-name="{{ $resident->first_name }} {{ $resident->last_name }}"
                            data-address="{{ $resident->address }}"
                            data-contact="{{ $resident->contact_number }}">
                            {{ $resident->last_name }}, {{ $resident->first_name }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="parties[__INDEX__][resident_id]" class="resident-id-input">
            </div>
            <div class="col-12">
                <input type="text" name="parties[__INDEX__][name]" class="form-control form-control-sm party-name"
                       placeholder="Full name *" required>
            </div>
            <div class="col-md-7">
                <input type="text" name="parties[__INDEX__][address]" class="form-control form-control-sm party-address"
                       placeholder="Address">
            </div>
            <div class="col-md-5">
                <input type="text" name="parties[__INDEX__][contact]" class="form-control form-control-sm party-contact"
                       placeholder="Contact number">
            </div>
        </div>
    </div>
</template>

@endsection

@section('scripts')
<script>
    let partyIndex = 0;

    function addParty(role) {
        const template = document.getElementById('partyTemplate').innerHTML;
        const html = template
            .replaceAll('__INDEX__', partyIndex)
            .replaceAll('__ROLE__', role);

        const container = document.getElementById('partiesContainer');
        container.insertAdjacentHTML('beforeend', html);
        document.getElementById('noPartyMsg').style.display = 'none';
        partyIndex++;
    }

    function removeParty(btn) {
        btn.closest('.party-card').remove();
        if (document.querySelectorAll('.party-card').length === 0) {
            document.getElementById('noPartyMsg').style.display = 'block';
        }
    }

    function autofillParty(select, index) {
        const opt     = select.options[select.selectedIndex];
        const card    = select.closest('.party-card');
        const nameInput    = card.querySelector('.party-name');
        const addressInput = card.querySelector('.party-address');
        const contactInput = card.querySelector('.party-contact');
        const resIdInput   = card.querySelector('.resident-id-input');

        if (select.value) {
            nameInput.value    = opt.dataset.name    || '';
            addressInput.value = opt.dataset.address || '';
            contactInput.value = opt.dataset.contact || '';
            resIdInput.value   = select.value;
        } else {
            nameInput.value = addressInput.value = contactInput.value = resIdInput.value = '';
        }
    }

    // Pre-add one complainant and one respondent by default
    document.addEventListener('DOMContentLoaded', function () {
        addParty('Complainant');
        addParty('Respondent');
    });
</script>
@endsection