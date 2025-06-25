@extends('layouts.user')
@section('title', 'Change Password')

@section('content')
<h1 class="portal-main-title">Change Password</h1>
<p class="portal-main-lead">
    For your security, choose a strong password that you haven't used before.
</p>

<div class="card">
    <div class="card-header">
        Update Your Password
    </div>
    <div class="card-body p-4">
        <form action="{{ route('user.password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">
                {{-- Current Password --}}
                <div class="col-12">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                </div>

                {{-- New Password --}}
                <div class="col-md-6">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                {{-- Confirm New Password --}}
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-portal-primary">Update Password</button>
            </div>
        </form>
    </div>
</div>
@endsection 