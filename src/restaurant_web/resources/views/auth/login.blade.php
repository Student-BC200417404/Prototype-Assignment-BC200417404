@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="login-container">
    <div class="login-wrapper">
        <!-- Left Side - Food Image -->
        <div class="food-section">
            <div class="brand-logo">
                <!-- <img src="{{ asset('images/logo.png') }}" alt="Food Logo"> -->
                 <h2>EatzAI</h2>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="login-form-section">
            <div class="login-box">
                <h2>Login</h2>
                
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}" >
                    @csrf
                    <div class="form-group">
                        <input type="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" 
                               placeholder="Email"
                               required>
                    </div>

                    <div class="form-group">
                        <input type="password" 
                               name="password" 
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Password"
                               required>
                    </div>

                    <div class="form-group remember-forgot">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                    </div>

                    <button type="submit" class="sign-in-btn">Sign in</button>

                    <div class="social-login">
                        <p>or continue with</p>
                        <div class="social-buttons">
                            <a href="#" class="social-btn">
                                <i class="fab fa-google"></i>
                            </a>
                            <a href="#" class="social-btn">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="#" class="social-btn">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        </div>
                    </div>

                    <div class="register-link">
                        Don't have an account yet? <a href="{{ route('register') }}">Register for free</a>
                    </div>
                </form>
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

