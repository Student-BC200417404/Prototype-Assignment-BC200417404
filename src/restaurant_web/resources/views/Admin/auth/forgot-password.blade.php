@extends('layouts.app')

@section('title', 'Admin Forgot Password')

@section('content')
<div class="admin-login-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="admin-login-box">
                    <div class="admin-login-header">
                        <h2>Admin Password Reset</h2>
                        <p>Enter your administrator email</p>
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

                    <form method="POST" action="{{ route('admin.password.email') }}" class="admin-login-form">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="email" class="form-label">Admin Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Enter your admin email"
                                       required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                    </form>

                    <div class="admin-login-footer">
                        <p>Remember your password? <a href="{{ route('admin.login') }}">Back to Admin Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Use the same CSS as admin login page */
</style>
@endpush 