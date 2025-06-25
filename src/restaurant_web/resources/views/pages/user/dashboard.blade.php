@extends('layouts.user')

@section('title', 'User Dashboard')

@section('content')
<h1 class="portal-main-title">Dashboard</h1>
<p class="portal-main-lead">
    Welcome back, {{ Auth::user()->name }}! Here's a summary of your account activity.
</p>

{{-- Stat Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card stat-card h-100">
            <div class="card-body text-center">
                <div class="stat-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <p class="stat-number">{{ $kpis['total_orders'] }}</p>
                <p class="stat-label">Total Orders</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card h-100">
            <div class="card-body text-center">
                <div class="stat-icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <p class="stat-number">${{ number_format($kpis['total_spent'], 2) }}</p>
                <p class="stat-label">Total Spent</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stat-card h-100">
            <div class="card-body text-center">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <p class="stat-number">{{ $kpis['total_reservations'] }}</p>
                <p class="stat-label">Total Reservations</p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Recent Orders --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                Recent Orders
            </div>
            <div class="card-body">
                @if($recent_orders->isEmpty())
                    <p>No recent orders found.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_orders as $order)
                                <tr>
                                    <td>#{{ $order->id }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td><span class="badge bg-{{ strtolower($order->status) == 'completed' ? 'success' : 'warning' }}">{{ $order->status }}</span></td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Recent Reservations --}}
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                Recent Reservations
            </div>
            <div class="card-body">
                @if($recent_reservations->isEmpty())
                    <p>No recent reservations found.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Guests</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->number_of_people }}</td>
                                    <td><span class="badge bg-{{ strtolower($reservation->status) == 'confirmed' ? 'success' : 'info' }}">{{ $reservation->status }}</span></td>
                                    <td>{{ $reservation->reservation_time->format('M d, Y @ h:i A') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection