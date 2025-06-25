@extends('layouts.user')
@section('title', 'My Orders')

@section('content')
<h1 class="portal-main-title">My Orders</h1>
<p class="portal-main-lead">
    Review your order history and check the status of current orders.
</p>

<div class="card">
    <div class="card-header">
        Order History
    </div>
    <div class="card-body">
        @if($orders->isEmpty())
            <div class="text-center p-4">
                <p>You haven't placed any orders yet.</p>
                <a href="#" class="btn btn-portal-primary mt-2">Order Now</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-end">Total</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td><span class="badge bg-{{ strtolower($order->status) == 'completed' ? 'success' : 'warning' }}">{{ $order->status }}</span></td>
                            <td class="text-end">${{ number_format($order->total, 2) }}</td>
                            <td class="text-center">
                                <a href="#" class="btn-portal-link">View Details</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 