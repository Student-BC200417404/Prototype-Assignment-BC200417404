@extends('layouts.user')
@section('title', 'Change Password')
@push('styles')
<style>
.user-portal-bg { background: #f7f8fa; min-height: 100vh; }
.user-main-card { background: #fff; border-radius: 18px; box-shadow: 0 2px 16px rgba(0,0,0,0.08); padding: 2rem 2rem 1.5rem 2rem; margin-top: 2.5rem; }
@media (max-width: 991px) { .user-main-card { padding: 1rem; margin-top: 1rem; } }
</style>
@endpush
@section('content')
<div class="container-fluid user-portal-bg py-0 px-0">
    <div class="container py-5">
        <div class="row gx-5">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4 mb-md-0">
                @include('pages.user.sidebar')
            </div>
            <!-- Main Content -->
            <div class="col-md-9">
                <div class="user-main-card">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="card">
                        <div class="card-header">Change Password</div>
                        <div class="card-body">
                            <form method="POST" action="#">
                                @csrf
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password">
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password">
                                </div>
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                                </div>
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 