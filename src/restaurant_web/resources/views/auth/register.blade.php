@extends('layouts.auth')

@section('title', 'Register')

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
    max-width: 500px;
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
    margin-bottom: 10px;
    text-align: center;
}

.welcome-text {
    color: rgba(255, 255, 255, 0.6);
    text-align: center;
    margin-bottom: 30px;
    font-size: 15px;
}

.form-row {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    margin-bottom: 0;
}

.input-with-icon {
    position: relative;
}

.input-with-icon i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: rgba(255, 255, 255, 0.4);
    font-size: 16px;
}

.form-control {
    width: 100%;
    padding: 15px 15px 15px 45px;
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

.terms-group {
    margin: 20px 0;
}

.custom-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

.custom-checkbox input[type="checkbox"] {
    width: 18px;
    height: 18px;
    margin-top: 3px;
}

.custom-checkbox label {
    color: rgba(255, 255, 255, 0.8);
    font-size: 14px;
    line-height: 1.4;
}

.terms-link {
    color: var(--primary-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

.terms-link:hover {
    color: #ff3b1b;
    text-decoration: underline;
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
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.sign-in-btn:hover {
    background: #ff3b1b;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 75, 43, 0.3);
}

.social-login {
    text-align: center;
    margin-top: 25px;
    position: relative;
}

.social-login p {
    color: rgba(255, 255, 255, 0.6);
    font-size: 14px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.social-login p::before,
.social-login p::after {
    content: '';
    flex: 1;
    height: 1px;
    background: rgba(255, 255, 255, 0.2);
    margin: 0 15px;
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
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
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
    transition: color 0.3s ease;
}

.register-link a:hover {
    color: #ff3b1b;
    text-decoration: underline;
}

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

/* Add smooth animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.login-wrapper {
    animation: fadeIn 0.6s ease-out;
}

.form-control, .sign-in-btn, .social-btn {
    transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
}

/* Add focus styles for accessibility */
.form-control:focus-visible,
.social-btn:focus-visible,
.sign-in-btn:focus-visible {
    outline: 2px solid var(--primary-color);
    outline-offset: 2px;
}
</style>
@endpush

@section('content')
<div class="login-container">
    <div class="login-wrapper">
        <!-- Logo Section -->
        <div class="brand-logo">
            <img src="{{ asset('images/logo.png') }}" alt="Food Logo">
        </div>

        <!-- Register Form Section -->
        <div class="login-box">
            <h2>Create Account</h2>
            <p class="welcome-text">Join us and start your culinary journey</p>
            
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="register-form">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <div class="input-with-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" 
                                   placeholder="Full Name"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" 
                                   placeholder="Email Address"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" 
                                   name="password" 
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Password"
                                   required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" 
                                   name="password_confirmation" 
                                   class="form-control"
                                   placeholder="Confirm Password"
                                   required>
                        </div>
                    </div>
                </div>

                <div class="form-group terms-group">
                    <div class="custom-checkbox">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            I agree to the <a href="#" class="terms-link">Terms of Service</a> and 
                            <a href="#" class="terms-link">Privacy Policy</a>
                        </label>
                    </div>
                </div>

                <button type="submit" class="sign-in-btn">Create Account</button>

                <div class="social-login">
                    <p>or register with</p>
                    <div class="social-buttons">
                        <a href="#" class="social-btn" title="Register with Google">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-btn" title="Register with Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-btn" title="Register with Apple">
                            <i class="fab fa-apple"></i>
                        </a>
                    </div>
                </div>

                <div class="register-link">
                    Already have an account? <a href="{{ route('login') }}">Sign In</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
@endpush 