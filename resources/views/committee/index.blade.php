@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Committee Management</h2>
</div>

<div class="row g-3">
    @foreach($committees as $slug => $committee)
    <div class="col-md-3">
        <a href="{{ route('committee.view', $slug) }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm border-0" style="border-radius: 12px; transition: transform 0.2s;"
                 onmouseover="this.style.transform='translateY(-4px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fa-solid {{ $committee['icon'] }}" style="font-size: 40px; color: #1a3a5c;"></i>
                    </div>
                    <h5 class="fw-bold text-dark">{{ $committee['name'] }}</h5>
                    <p class="text-muted small mb-0">{{ $committee['chair'] }}</p>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

@endsection