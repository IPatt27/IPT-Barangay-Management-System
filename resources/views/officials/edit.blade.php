@extends('layouts.app')

@section('content')

<div class="d-flex align-items-center gap-3 mb-4">
    <a href="{{ route('officials.view', $official->id) }}" class="btn btn-outline-secondary btn-sm">
        <i class="fa fa-arrow-left"></i>
    </a>
    <h2 style="font-size:28px; font-weight:700; color:#1a1a1a; margin:0;">
        Edit — {{ $official->full_name }}
    </h2>
</div>

<div class="row justify-content-center">
<div class="col-lg-9">
<form action="{{ route('officials.update', $official->id) }}" method="POST" enctype="multipart/form-data">
@csrf @method('PUT')

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:12px; letter-spacing:.8px;">
                Personal Information
            </h6>
            <div class="row g-3">

                <div class="col-12 d-flex align-items-center gap-4 mb-2">
                    @php
                        $photoSrc = $official->photo
                            ? asset('storage/' . $official->photo)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($official->first_name . '+' . $official->last_name) . '&background=2d6a4f&color=fff&size=128';
                    @endphp
                    <img id="photoPreview" src="{{ $photoSrc }}"
                         style="width:80px; height:80px; border-radius:50%; object-fit:cover; border:2px solid #e5e5e5;">
                    <div>
                        <label class="form-label fw-semibold mb-1">Replace Photo <span class="text-muted small">(Optional)</span></label>
                        <input type="file" name="photo" class="form-control form-control-sm"
                               accept="image/jpg,image/jpeg,image/png" onchange="previewPhoto(this)">
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control"
                           value="{{ old('first_name', $official->first_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control"
                           value="{{ old('last_name', $official->last_name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Birthdate</label>
                    <input type="date" name="birthdate" class="form-control"
                           value="{{ old('birthdate', optional($official->birthdate)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Contact Number</label>
                    <input type="text" name="contact" class="form-control"
                           value="{{ old('contact', $official->contact) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Address</label>
                    <input type="text" name="address" class="form-control"
                           value="{{ old('address', $official->address) }}">
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size:12px; letter-spacing:.8px;">
                Role & Assignment
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Position <span class="text-danger">*</span></label>
                    <select name="position" class="form-select" required>
                        @foreach([
                            'Barangay Captain','Barangay Kagawad','SK Chairperson',
                            'Barangay Secretary','Barangay Treasurer',
                            'Barangay Health Worker','Barangay Tanod',
                            'Administrative Staff','Other',
                        ] as $pos)
                            <option value="{{ $pos }}"
                                {{ old('position', $official->position) == $pos ? 'selected' : '' }}>
                                {{ $pos }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Designation / Committee</label>
                    <input type="text" name="designation" class="form-control"
                           value="{{ old('designation', $official->designation) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="Active"   {{ old('status', $official->status) == 'Active'   ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $official->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Term Start</label>
                    <input type="date" name="term_start" class="form-control"
                           value="{{ old('term_start', optional($official->term_start)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Term End</label>
                    <input type="date" name="term_end" class="form-control"
                           value="{{ old('term_end', optional($official->term_end)->format('Y-m-d')) }}">
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('officials.view', $official->id) }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-success" style="background:#2d6a4f; border:none; font-weight:600;">
            <i class="fa fa-save me-1"></i> Save Changes
        </button>
    </div>

</form>
</div>
</div>

@endsection

@section('scripts')
<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('photoPreview').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
