@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center gap-2 mb-3">
    <h2 class="mb-0">Issue New Document</h2>
</div>

<div class="row justify-content-center">
<div class="col-lg-8">

<div class="card shadow-sm">
<div class="card-body">

<form action="{{ route('documents.store') }}" method="POST">
@csrf

{{-- STEP 1 --}}
<h6 class="text-uppercase text-muted mb-3">Step 1 — Select Resident</h6>

<div class="mb-3">
    <label class="form-label">Resident <span class="text-danger">*</span></label>
    <select name="resident_id" id="residentSelect" class="form-select" required>
        <option value="">— Select a resident —</option>
        @foreach($residents as $resident)
            <option value="{{ $resident->id }}"
                data-age="{{ $resident->age }}"
                data-sex="{{ $resident->sex }}"
                data-civil="{{ $resident->civil_status }}"
                data-address="{{ $resident->address }}"
                data-birthdate="{{ $resident->birthdate }}"
                {{ old('resident_id') == $resident->id ? 'selected' : '' }}>
                {{ $resident->last_name }}, {{ $resident->first_name }}
            </option>
        @endforeach
    </select>
</div>

{{-- Preview --}}
<div id="residentPreview" class="bg-light p-3 rounded mb-4 d-none">
    <div class="row small">
        <div class="col-6">Age: <strong id="prev_age"></strong></div>
        <div class="col-6">Sex: <strong id="prev_sex"></strong></div>
        <div class="col-6">Civil: <strong id="prev_civil"></strong></div>
        <div class="col-6">Birthdate: <strong id="prev_birthdate"></strong></div>
        <div class="col-12">Address: <strong id="prev_address"></strong></div>
    </div>
</div>

<hr>

{{-- STEP 2 --}}
<h6 class="text-uppercase text-muted mb-3">Step 2 — Document Details</h6>

<div class="mb-3">
    <label class="form-label">Document Type</label>
    <select name="document_type" class="form-select" required>
        <option value="">— Select —</option>
        @foreach([
            'Barangay Clearance',
            'Certificate of Residency',
            'Certificate of Indigency',
            'Good Moral Character',
            'Business Clearance'
        ] as $type)
            <option value="{{ $type }}" {{ old('document_type') == $type ? 'selected' : '' }}>
                {{ $type }}
            </option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Purpose</label>
    <input type="text" name="purpose" class="form-control"
           value="{{ old('purpose') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">OR Number</label>
    <input type="text" name="or_number" class="form-control"
           value="{{ old('or_number') }}">
</div>

<hr>

{{-- STEP 3 --}}
<h6 class="text-uppercase text-muted mb-3">Step 3 — Signing Official</h6>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Issued By</label>
        <input type="text" name="issued_by" class="form-control"
               value="{{ old('issued_by') }}" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Position</label>
        <input type="text" name="position" class="form-control"
               value="{{ old('position', 'Barangay Captain') }}">
    </div>
</div>

<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('documents.index') }}" class="btn btn-danger">Cancel</a>
    <button type="submit" class="btn btn-success">Issue & Print</button>
</div>

</form>

</div>
</div>
</div>
</div>

@endsection

@section('scripts')
<script>
document.getElementById('residentSelect').addEventListener('change', function () {
    const opt = this.options[this.selectedIndex];
    const preview = document.getElementById('residentPreview');

    if (this.value) {
        prev_age.textContent = opt.dataset.age || '—';
        prev_sex.textContent = opt.dataset.sex || '—';
        prev_civil.textContent = opt.dataset.civil || '—';
        prev_birthdate.textContent = opt.dataset.birthdate || '—';
        prev_address.textContent = opt.dataset.address || '—';
        preview.classList.remove('d-none');
    } else {
        preview.classList.add('d-none');
    }
});
</script>
@endsection