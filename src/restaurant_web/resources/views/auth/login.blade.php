@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-bg d-flex align-items-center justify-content-center min-vh-100">
    <div class="auth-card">
        <div class="auth-tabs d-flex mb-4">
            <a href="{{ route('login') }}" class="auth-tab active">Login</a>
            <a href="{{ route('register') }}" class="auth-tab">Signup</a>
        </div>
        <div class="text-center mb-2">
            <i class="bi bi-person-circle" style="font-size: 2.8rem; color: #ffc107;"></i>
        </div>
        <h2 class="auth-title mb-3">Sign in to your account</h2>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('login.submit') }}" autocomplete="off">
            @csrf
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="Email Address" required autofocus>
                </div>
            </div>
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <a href="{{ route('password.request') }}" class="auth-link">Forgot?</a>
            </div>
            <button type="submit" class="btn btn-auth w-100 mb-3">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="{{ url('/') }}" class="auth-link d-inline-flex align-items-center"><i class="bi bi-house me-1"></i> Back to Website</a>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endpush

