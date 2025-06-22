@extends('pages.layout')
@section('title', 'My Orders')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
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
@endsection 