@extends('pages.layout')
@section('title', 'User Dashboard')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
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
@endsection 