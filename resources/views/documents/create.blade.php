@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fa fa-arrow-left"></i>
    </a>
    <h2 style="font-size: 28px; font-weight: 700; color: #1a1a1a; margin: 0;">Issue New Document</h2>
</div>

<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card shadow-sm border-0">
<div class="card-body p-4">

    <form action="{{ route('documents.store') }}" method="POST">
        @csrf

        {{-- STEP 1: Select Resident --}}
        <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:12px; letter-spacing:.8px;">
            Step 1 — Select Resident
        </h6>

        <div class="mb-3">
            <label class="form-label fw-semibold">Resident <span class="text-danger">*</span></label>
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
            @error('resident_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        {{-- Auto-filled resident info preview --}}
        <div id="residentPreview" class="p-3 mb-4 rounded" style="background:#f8f9fa; display:none; font-size:13.5px;">
            <div class="row g-2">
                <div class="col-6"><span class="text-muted">Age:</span> <strong id="prev_age"></strong></div>
                <div class="col-6"><span class="text-muted">Sex:</span> <strong id="prev_sex"></strong></div>
                <div class="col-6"><span class="text-muted">Civil Status:</span> <strong id="prev_civil"></strong></div>
                <div class="col-6"><span class="text-muted">Birthdate:</span> <strong id="prev_birthdate"></strong></div>
                <div class="col-12"><span class="text-muted">Address:</span> <strong id="prev_address"></strong></div>
            </div>
        </div>

        <hr class="my-4">

        {{-- STEP 2: Document Details --}}
        <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:12px; letter-spacing:.8px;">
            Step 2 — Document Details
        </h6>

        <div class="mb-3">
            <label class="form-label fw-semibold">Document Type <span class="text-danger">*</span></label>
            <select name="document_type" class="form-select" required>
                <option value="">— Select document type —</option>
                <option value="Barangay Clearance"         {{ old('document_type') == 'Barangay Clearance'         ? 'selected' : '' }}>Barangay Clearance</option>
                <option value="Certificate of Residency"   {{ old('document_type') == 'Certificate of Residency'   ? 'selected' : '' }}>Certificate of Residency</option>
                <option value="Certificate of Indigency"   {{ old('document_type') == 'Certificate of Indigency'   ? 'selected' : '' }}>Certificate of Indigency</option>
                <option value="Good Moral Character"       {{ old('document_type') == 'Good Moral Character'       ? 'selected' : '' }}>Good Moral Character</option>
                <option value="Business Clearance"         {{ old('document_type') == 'Business Clearance'         ? 'selected' : '' }}>Business Clearance</option>
            </select>
            @error('document_type') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Purpose <span class="text-danger">*</span></label>
            <input type="text" name="purpose" class="form-control"
                   placeholder="e.g. For employment, For loan application..."
                   value="{{ old('purpose') }}" required>
            @error('purpose') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Official Receipt (OR) Number <span class="text-muted small">(Optional)</span></label>
            <input type="text" name="or_number" class="form-control"
                   placeholder="e.g. 2025-00123"
                   value="{{ old('or_number') }}">
        </div>

        <hr class="my-4">

        {{-- STEP 3: Signing Official --}}
        <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:12px; letter-spacing:.8px;">
            Step 3 — Signing Official
        </h6>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Issued By <span class="text-danger">*</span></label>
                <input type="text" name="issued_by" class="form-control"
                       placeholder="Full name of signing official"
                       value="{{ old('issued_by') }}" required>
                @error('issued_by') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Position / Title</label>
                <input type="text" name="position" class="form-control"
                       placeholder="e.g. Barangay Captain"
                       value="{{ old('position', 'Barangay Captain') }}">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('documents.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-success" style="background:#2d6a4f; border:none;">
                <i class="fa fa-file-alt me-1"></i> Issue & Print Document
            </button>
        </div>

    </form>
</div>
</div>
</div>
</div>

@endsection

@section('scripts')
<script>
    // Auto-fill resident info preview when a resident is selected
    document.getElementById('residentSelect').addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        const preview = document.getElementById('residentPreview');

        if (this.value) {
            document.getElementById('prev_age').textContent       = opt.dataset.age       || '—';
            document.getElementById('prev_sex').textContent       = opt.dataset.sex       || '—';
            document.getElementById('prev_civil').textContent     = opt.dataset.civil     || '—';
            document.getElementById('prev_birthdate').textContent = opt.dataset.birthdate || '—';
            document.getElementById('prev_address').textContent   = opt.dataset.address   || '—';
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });
</script>
@endsection
