@extends('layouts.user')

@section('title', 'My Profile')

@section('content')
<h1 class="portal-main-title">My Profile</h1>
<p class="portal-main-lead">
    Manage your personal information and contact details.
</p>

<div class="card">
    <div class="card-header">
        Edit Profile Information
    </div>
    <div class="card-body p-4">
        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="row g-3">
                {{-- First Name --}}
                <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $customer ? $customer->first_name : $user->name) }}" required>
                </div>
                {{-- Last Name --}}
                <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $customer ? $customer->last_name : '') }}">
                </div>
                {{-- Email --}}
                <div class="col-md-6">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $customer ? $customer->email : $user->email) }}" required>
                </div>
                {{-- Phone --}}
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $customer ? $customer->phone : '') }}">
                </div>
                {{-- Address --}}
                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $customer ? $customer->address : '') }}</textarea>
                </div>
                {{-- Date of Birth --}}
                <div class="col-md-6">
                    <label for="date_of_birth" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $customer && $customer->date_of_birth ? $customer->date_of_birth->format('Y-m-d') : '') }}">
                </div>
            </div>
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-portal-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection 