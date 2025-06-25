@extends('layouts.user')
@section('title', 'My Reservations')

@section('content')
<h1 class="portal-main-title">My Reservations</h1>
<p class="portal-main-lead">
    Manage your upcoming and past table reservations.
</p>

<div class="card">
    <div class="card-header">
        Reservation History
    </div>
    <div class="card-body">
        @if($reservations->isEmpty())
        <div class="text-center p-4">
            <p>You haven't made any reservations yet.</p>
            <a href="#" class="btn btn-portal-primary mt-2">Make a Reservation</a>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Date & Time</th>
                        <th>Guests</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $reservation)
                    <tr>
                        <td>#{{ $reservation->id }}</td>
                        <td>{{ $reservation->reservation_time->format('M d, Y @ h:i A') }}</td>
                        <td>{{ $reservation->number_of_people }}</td>
                        <td><span class="badge bg-{{ strtolower($reservation->status) == 'confirmed' ? 'success' : 'info' }}">{{ $reservation->status }}</span></td>
                        <td class="text-center">
                            <a href="#" class="btn-portal-link">View Details</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $reservations->links() }}
        </div>
        @endif
    </div>
</div>
@endsection 