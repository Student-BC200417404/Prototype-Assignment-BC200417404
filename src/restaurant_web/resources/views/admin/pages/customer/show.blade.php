@extends('admin.layout.app')
@section('title', 'Customer Details')
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-gold d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="ri-user-3-line me-2"></i> Customer Details</h4>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary btn-sm"><i class="ri-arrow-left-line me-1"></i> Back to List</a>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Full Name</dt>
                        <dd class="col-sm-8">{{ $customer->first_name }} {{ $customer->last_name }}</dd>
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8">{{ $customer->email }}</dd>
                        <dt class="col-sm-4">Phone</dt>
                        <dd class="col-sm-8">{{ $customer->phone }}</dd>
                        <dt class="col-sm-4">Address</dt>
                        <dd class="col-sm-8">{{ $customer->address ?? '-' }}</dd>
                        <dt class="col-sm-4">Date of Birth</dt>
                        <dd class="col-sm-8">{{ $customer->date_of_birth ?? '-' }}</dd>
                        <dt class="col-sm-4">Membership</dt>
                        <dd class="col-sm-8">{{ $customer->membership ?? '-' }}</dd>
                        <dt class="col-sm-4">User Account</dt>
                        <dd class="col-sm-8">
                            @if($customer->user)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">No Account</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 