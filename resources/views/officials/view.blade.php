@extends('layouts.app')

@section('styles')
<style>
    .info-label { font-size:12px; text-transform:uppercase; letter-spacing:.6px; color:#888; font-weight:600; }
    .info-value { font-size:14px; color:#1a1a1a; font-weight:500; margin-top:2px; }
</style>
@endsection

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('officials.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa fa-arrow-left"></i>
        </a>
        <h2 style="font-size:24px; font-weight:700; color:#1a1a1a; margin:0;">
            {{ $official->full_name }}
        </h2>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('officials.id', $official->id) }}" target="_blank"
           class="btn btn-info btn-sm text-white">
            <i class="fa fa-id-card me-1"></i> View Digital ID
        </a>
        <a href="{{ route('officials.edit', $official->id) }}" class="btn btn-warning btn-sm">
            <i class="fa fa-edit me-1"></i> Edit
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
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 text-center p-4">
            @php
                $photoSrc = $official->photo
                    ? asset('storage/' . $official->photo)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($official->first_name . '+' . $official->last_name) . '&background=2d6a4f&color=fff&size=128';
            @endphp
            <img src="{{ $photoSrc }}"
                 style="width:110px; height:110px; border-radius:50%; object-fit:cover;
                        border:3px solid #e5e5e5; margin:0 auto 16px;">
            <h5 class="fw-bold mb-0">{{ $official->full_name }}</h5>
            <p class="text-muted mb-2" style="font-size:14px;">{{ $official->position }}</p>
            @if($official->designation)
                <p class="text-muted" style="font-size:13px;">{{ $official->designation }}</p>
            @endif
            <span class="badge {{ $official->status === 'Active' ? 'bg-success' : 'bg-secondary' }}">
                {{ $official->status }}
            </span>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase text-muted mb-4" style="font-size:12px; letter-spacing:.8px;">
                    Personal Information
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-label">First Name</div>
                        <div class="info-value">{{ $official->first_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Last Name</div>
                        <div class="info-value">{{ $official->last_name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Birthdate</div>
                        <div class="info-value">
                            {{ $official->birthdate ? $official->birthdate->format('F d, Y') : '—' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Contact</div>
                        <div class="info-value">{{ $official->contact ?? '—' }}</div>
                    </div>
                    <div class="col-12">
                        <div class="info-label">Address</div>
                        <div class="info-value">{{ $official->address ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase text-muted mb-4" style="font-size:12px; letter-spacing:.8px;">
                    Role & Term
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="info-label">Position</div>
                        <div class="info-value">{{ $official->position }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-label">Designation / Committee</div>
                        <div class="info-value">{{ $official->designation ?? '—' }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Status</div>
                        <div class="info-value">{{ $official->status }}</div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Term Start</div>
                        <div class="info-value">
                            {{ $official->term_start ? $official->term_start->format('F d, Y') : '—' }}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="info-label">Term End</div>
                        <div class="info-value">
                            {{ $official->term_end ? $official->term_end->format('F d, Y') : '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <form action="{{ route('officials.delete', $official->id) }}" method="POST"
                  onsubmit="return confirm('Remove this official?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger btn-sm">
                    <i class="fa fa-trash me-1"></i> Delete Official
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
