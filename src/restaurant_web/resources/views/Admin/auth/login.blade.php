@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
<div class="admin-login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="admin-login-box">
                    <div class="admin-login-header">
                        <h2>EatzAI Admin</h2>
                        <p>Administrator Access Portal</p>
                    </div>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.submit') }}" class="admin-login-form">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Enter your email"
                                       required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       placeholder="Enter your password"
                                       required>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Sign In as Administrator
                        </button>
                    </form>

                    <div class="admin-login-footer">
                        <p>Return to <a href="{{ route('home') }}">Main Site</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.admin-login-section {
    min-height: 100vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 40px 0;
}

.admin-login-box {
    background: #ffffff;
    border-radius: 10px;
    padding: 40px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.admin-login-header {
    text-align: center;
    margin-bottom: 30px;
}

.admin-login-header h2 {
    color: #333;
    font-weight: 600;
    margin-bottom: 10px;
}

.admin-login-header p {
    color: #6c757d;
}

.admin-login-form .form-label {
    font-weight: 500;
    color: #495057;
}

.admin-login-form .input-group-text {
    background: #f8f9fa;
    border-right: none;
}

.admin-login-form .form-control {
    border-left: none;
}

.admin-login-form .form-control:focus {
    box-shadow: none;
    border-color: #ced4da;
}

.forgot-password {
    color: #6c757d;
    text-decoration: none;
    font-size: 0.9rem;
}

.forgot-password:hover {
    color: #007bff;
}

.btn-primary {
    padding: 12px;
    font-weight: 500;
    background: #007bff;
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #0056b3;
    transform: translateY(-1px);
}

.admin-login-footer {
    text-align: center;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #dee2e6;
}

.admin-login-footer p {
    margin: 0;
    color: #6c757d;
}

.admin-login-footer a {
    color: #007bff;
    text-decoration: none;
}

.alert {
    border-radius: 5px;
    margin-bottom: 20px;
}

.alert ul {
    padding-left: 20px;
}
</style>
@endpush 