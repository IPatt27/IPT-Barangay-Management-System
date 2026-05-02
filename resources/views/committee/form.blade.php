@extends('layouts.app')

@section('styles')
<style>
    .form-container {
        background: #ffffff;
        border: 1px solid #e5e5e5;
        border-radius: 10px;
        padding: 32px;
        max-width: 800px;
        margin: 0 auto;
    }

    .form-title {
        font-size: 28px;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 24px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e5e5e5;
    }

    .form-label {
        font-size: 19px;
        font-weight: 600;
        color: #555;
        margin-bottom: 4px;
    }

    .form-control, .form-select {
        font-size: 18px;
        border: 1px solid #e5e5e5;
        border-radius: 7px;
        padding: 14px 18px;
        color: #1a1a1a;
        font-family: 'DM Sans', sans-serif;
    }

    .form-control:focus, .form-select:focus {
        border-color: #1a3a5c;
        box-shadow: none;
    }

    .form-control:disabled, .form-select:disabled {
        background: #f9f9f9;
        color: #555;
    }

    .form-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 24px;
        padding-top: 16px;
        border-top: 1px solid #e5e5e5;
    }
</style>
@endsection

@section('content')
    <div class="form-container">
        <div class="form-title">@yield('form-title')</div>
        @yield('form-content')
    </div>
@endsection
