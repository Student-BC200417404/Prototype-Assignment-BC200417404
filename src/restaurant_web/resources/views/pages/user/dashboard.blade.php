@extends('layouts.user')
@section('title', 'User Dashboard')
@push('styles')
<style>
.user-sidebar {
    background: #181818;
    color: #fff;
    min-height: 100vh;
    border-radius: 18px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.08);
    padding: 0;
}
.user-sidebar .profile-card {
    background: #222;
    border-radius: 18px 18px 0 0;
    padding: 2rem 1rem 1rem 1rem;
    text-align: center;
    border-bottom: 1px solid #292929;
}
.user-sidebar .profile-card .avatar {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #ff7a00;
    margin-bottom: 0.5rem;
}
.user-sidebar .profile-card .name {
    font-weight: 600;
    font-size: 1.1rem;
    color: #fff;
}
.user-sidebar .profile-card .email {
    font-size: 0.95rem;
    color: #ff7a00;
}
.user-sidebar .list-group {
    border-radius: 0 0 18px 18px;
    background: transparent;
}
.user-sidebar .list-group-item {
    background: transparent;
    color: #fff;
    border: none;
    font-size: 1.05rem;
    padding: 1rem 1.5rem;
    transition: background 0.2s, color 0.2s;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.user-sidebar .list-group-item.active, .user-sidebar .list-group-item:hover {
    background: #ff7a00;
    color: #fff;
}
.user-sidebar .list-group-item i {
    font-size: 1.2rem;
}
@media (max-width: 991px) {
    .user-sidebar { min-height: auto; }
}
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
                    <div class="card mb-4">
                        <div class="card-body text-center">
                            <h2 class="mb-3">Welcome, {{ Auth::user()->name ?? 'User' }}!</h2>
                            <p class="lead">Access your profile, orders, and reservations from your dashboard.</p>
                            <div class="d-flex justify-content-center gap-3 mt-4">
                                <a href="{{ route('user.profile') }}" class="btn btn-primary">My Profile</a>
                                <a href="{{ route('user.orders') }}" class="btn btn-success">My Orders</a>
                                <a href="{{ route('user.reservations') }}" class="btn btn-info">My Reservations</a>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">Recent Activity</div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">Order #1234 placed on 2024-06-01</li>
                                <li class="list-group-item">Reservation for 2 on 2024-06-02 at 7:00 PM</li>
                                <li class="list-group-item">Profile updated on 2024-05-30</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 