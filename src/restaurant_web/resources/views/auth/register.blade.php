@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center bg-dark" style="background: #181818;">
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden" style="max-width: 900px; width: 100%;">
        <div class="row g-0 align-items-stretch">
            <!-- Left: Logo and Food Image -->
            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center bg-black p-4" style="background: #111;">
                <div class="w-100 text-start mb-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="max-width: 100px;">
                </div>
                <img src="{{ asset('images/hero-img.jpg') }}" alt="Food" class="img-fluid mb-3" style="max-width: 320px;">
            </div>
            <!-- Right: Register Form -->
            <div class="col-md-6 d-flex align-items-center justify-content-center bg-dark p-4">
                <div class="w-100" style="max-width: 350px;">
                    <h2 class="fw-bold mb-4 text-white text-center">Register</h2>
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
                    <form method="POST" action="{{ route('register.submit') }}" autocomplete="off">
                        @csrf
                        <div class="mb-3 position-relative">
                            <input type="text" name="name" class="form-control form-control-lg bg-light @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Full Name" required autofocus>
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="email" name="email" class="form-control form-control-lg bg-light @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" required>
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="password" name="password" class="form-control form-control-lg bg-light @error('password') is-invalid @enderror" placeholder="Password" required>
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="password" name="password_confirmation" class="form-control form-control-lg bg-light" placeholder="Confirm Password" required>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 py-2 fw-bold mb-3">Register</button>
                        <div class="text-center text-white-50 mb-2">or continue with</div>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <button type="button" class="btn btn-light rounded-pill px-3"><i class="fab fa-google"></i></button>
                            <button type="button" class="btn btn-light rounded-pill px-3"><i class="fab fa-github"></i></button>
                            <button type="button" class="btn btn-light rounded-pill px-3"><i class="fab fa-facebook-f"></i></button>
                        </div>
                        <div class="text-center mt-3">
                            <span class="text-white-50">Already have an account?</span>
                            <a href="{{ route('login') }}" class="fw-semibold text-warning text-decoration-none">Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 