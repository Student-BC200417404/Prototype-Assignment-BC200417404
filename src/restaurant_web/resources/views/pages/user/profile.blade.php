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
                {{-- Name --}}
                <div class="col-md-6">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                {{-- Phone --}}
                <div class="col-12">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                </div>

                {{-- Address --}}
                <div class="col-12">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-portal-primary">Save Changes</button>
            </div>
        </form>
    </div>
</div>
@endsection 