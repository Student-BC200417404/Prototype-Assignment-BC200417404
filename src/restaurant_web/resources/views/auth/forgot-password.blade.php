@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="user-login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="user-login-box">
                    <div class="user-login-header">
                        <h2>Forgot Password</h2>
                        <p>Enter your email to reset your password</p>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
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

                    <form method="POST" action="{{ route('password.email') }}" class="user-login-form">
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

                        <button type="submit" class="btn btn-primary w-100">Send Password Reset Link</button>
                    </form>

                    <div class="user-login-footer">
                        <p>Remember your password? <a href="{{ route('login') }}">Back to Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Use the same CSS as login page */
</style>
@endpush 