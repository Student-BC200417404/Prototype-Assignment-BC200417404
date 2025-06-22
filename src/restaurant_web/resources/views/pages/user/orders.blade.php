@extends('layouts.user')
@section('title', 'My Orders')
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
                        <div class="card-header">My Orders</div>
                        <div class="card-body table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>#1001</td>
                                        <td>2024-06-01</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                        <td>$120.00</td>
                                    </tr>
                                    <tr>
                                        <td>#1002</td>
                                        <td>2024-05-30</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>$85.50</td>
                                    </tr>
                                    <tr>
                                        <td>#1003</td>
                                        <td>2024-05-28</td>
                                        <td><span class="badge bg-danger">Cancelled</span></td>
                                        <td>$45.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 