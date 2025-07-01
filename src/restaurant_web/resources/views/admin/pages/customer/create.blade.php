@extends('admin.layout.app')
@section('title', 'Create Customer')
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-gold">
                    <h4 class="mb-0"><i class="ri-user-add-line me-2"></i> Create Customer</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.customers.store') }}" id="customer-create-form">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                @error('first_name')<span class="text-danger small">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')<span class="text-danger small">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')<span class="text-danger small">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')<span class="text-danger small">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}">
                            @error('address')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="create_user_account" name="create_user_account" value="1" {{ old('create_user_account') ? 'checked' : '' }}>
                            <label class="form-check-label" for="create_user_account">Create User Account</label>
                        </div>
                        <div class="mb-3" id="password-field" style="display: none;">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" minlength="8">
                            @error('password')<span class="text-danger small">{{ $message }}</span>@enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary"><i class="ri-arrow-left-line me-1"></i> Back to List</a>
                            <button type="submit" class="btn btn-primary"><i class="ri-save-line me-1"></i> Create Customer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('custom-scripts')
<script>
    $(function() {
        function togglePasswordField() {
            if ($('#create_user_account').is(':checked')) {
                $('#password-field').show();
                $('#password').attr('required', true);
            } else {
                $('#password-field').hide();
                $('#password').removeAttr('required');
            }
        }
        togglePasswordField();
        $('#create_user_account').on('change', togglePasswordField);
    });
</script>
@endpush
@endsection 