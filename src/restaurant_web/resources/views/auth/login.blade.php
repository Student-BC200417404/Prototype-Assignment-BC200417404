@extends('layouts.auth')

@section('title', 'Login')

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
            <!-- Right: Login Form -->
            <div class="col-md-6 d-flex align-items-center justify-content-center bg-dark p-4">
                <div class="w-100" style="max-width: 350px;">
                    <h2 class="fw-bold mb-4 text-white text-center">Login</h2>
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
                        <div class="mb-3 position-relative">
                            <input type="email" name="email" class="form-control form-control-lg bg-light @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email" required autofocus>
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="password" name="password" class="form-control form-control-lg bg-light @error('password') is-invalid @enderror" placeholder="Password" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label text-white-50" for="remember">Remember me</label>
                            </div>
                            <a href="{{ route('password.request') }}" class="text-decoration-none text-white-50">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn btn-warning w-100 py-2 fw-bold mb-3">Sign in</button>
                        <div class="text-center text-white-50 mb-2">or continue with</div>
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <button type="button" class="btn btn-light rounded-pill px-3"><i class="fab fa-google"></i></button>
                            <button type="button" class="btn btn-light rounded-pill px-3"><i class="fab fa-github"></i></button>
                            <button type="button" class="btn btn-light rounded-pill px-3"><i class="fab fa-facebook-f"></i></button>
                        </div>
                        <div class="text-center mt-3">
                            <span class="text-white-50">Don't have an account yet?</span>
                            <a href="{{ route('register') }}" class="fw-semibold text-warning text-decoration-none">Register for free</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.login-container {
    min-height: 100vh;
    background-image: url('{{ asset("images/hero-bg.jpg") }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    position: relative;
}

.login-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
}

.login-wrapper {
    position: relative;
    width: 100%;
    max-width: 400px;
    background: rgba(28, 28, 28, 0.95);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.brand-logo {
    text-align: center;
    margin-bottom: 30px;
}

.brand-logo img {
    height: 50px;
}

.login-box h2 {
    color: #fff;
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 30px;
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
}

.form-control {
    width: 100%;
    padding: 15px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    color: #fff;
    font-size: 15px;
    transition: all 0.3s ease;
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(255, 75, 43, 0.2);
    outline: none;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.remember-forgot {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.remember-me {
    display: flex;
    align-items: center;
    gap: 8px;
}

.remember-me label {
    color: #fff;
    font-size: 14px;
}

.forgot-link {
    color: var(--primary-color);
    font-size: 14px;
    text-decoration: none;
    transition: color 0.3s ease;
}

.forgot-link:hover {
    color: #ff3b1b;
}

.sign-in-btn {
    width: 100%;
    padding: 15px;
    background: var(--primary-color, #ff4b2b);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.sign-in-btn:hover {
    background: #ff3b1b;
    transform: translateY(-2px);
}

.social-login {
    text-align: center;
    margin-top: 25px;
}

.social-login p {
    color: rgba(255, 255, 255, 0.6);
    font-size: 14px;
    margin-bottom: 15px;
    position: relative;
}

.social-login p::before,
.social-login p::after {
    content: '';
    position: absolute;
    top: 50%;
    width: 30%;
    height: 1px;
    background: rgba(255, 255, 255, 0.2);
}

.social-login p::before {
    left: 0;
}

.social-login p::after {
    right: 0;
}

.social-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.social-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    color: #fff;
    font-size: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.social-btn:hover {
    transform: translateY(-2px);
    background: rgba(255, 255, 255, 0.2);
}

.register-link {
    text-align: center;
    margin-top: 25px;
    color: rgba(255, 255, 255, 0.6);
    font-size: 14px;
}

.register-link a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
}

.register-link a:hover {
    text-decoration: underline;
}

/* Alert Styling */
.alert-danger {
    background: rgba(220, 53, 69, 0.1);
    border: 1px solid #dc3545;
    color: #dc3545;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 20px;
}

.alert-danger ul {
    margin: 0;
    padding-left: 20px;
}

@media (max-width: 768px) {
    .login-wrapper {
        padding: 30px 20px;
    }
}
</style>
@endpush

