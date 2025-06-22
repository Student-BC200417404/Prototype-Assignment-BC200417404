@extends('admin.layout.app')
@section('title', 'Settings')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">System Settings</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Settings</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="ri-check-double-line me-1 align-middle"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="ri-error-warning-line me-1 align-middle"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Main Content -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">General Settings</h4>
                    </div>
                    <div class="card-body">
                        <form id="settings-form" action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <!-- Restaurant Information -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-3">Restaurant Information</h5>
                                    
                                    <div class="mb-3">
                                        <label for="restaurant_name" class="form-label">Restaurant Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('restaurant_name') is-invalid @enderror" 
                                               id="restaurant_name" name="restaurant_name" 
                                               value="{{ old('restaurant_name', $settings['restaurant_name'] ?? 'SpicyHunt Restaurant') }}" required>
                                        @error('restaurant_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="restaurant_tagline" class="form-label">Tagline</label>
                                        <input type="text" class="form-control @error('restaurant_tagline') is-invalid @enderror" 
                                               id="restaurant_tagline" name="restaurant_tagline" 
                                               value="{{ old('restaurant_tagline', $settings['restaurant_tagline'] ?? 'Delicious Food, Great Service') }}">
                                        @error('restaurant_tagline')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="restaurant_description" class="form-label">Description</label>
                                        <textarea class="form-control @error('restaurant_description') is-invalid @enderror" 
                                                  id="restaurant_description" name="restaurant_description" rows="3">{{ old('restaurant_description', $settings['restaurant_description'] ?? '') }}</textarea>
                                        @error('restaurant_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="mb-3">Contact Information</h5>
                                    
                                    <div class="mb-3">
                                        <label for="restaurant_email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('restaurant_email') is-invalid @enderror" 
                                               id="restaurant_email" name="restaurant_email" 
                                               value="{{ old('restaurant_email', $settings['restaurant_email'] ?? 'info@spicyhunt.com') }}" required>
                                        @error('restaurant_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="restaurant_phone" class="form-label">Phone <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('restaurant_phone') is-invalid @enderror" 
                                               id="restaurant_phone" name="restaurant_phone" 
                                               value="{{ old('restaurant_phone', $settings['restaurant_phone'] ?? '+1 234 567 8900') }}" required>
                                        @error('restaurant_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="restaurant_address" class="form-label">Address</label>
                                        <textarea class="form-control @error('restaurant_address') is-invalid @enderror" 
                                                  id="restaurant_address" name="restaurant_address" rows="3">{{ old('restaurant_address', $settings['restaurant_address'] ?? '') }}</textarea>
                                        @error('restaurant_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- Business Hours -->
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-3">Business Hours</h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="opening_time" class="form-label">Opening Time</label>
                                                <input type="time" class="form-control @error('opening_time') is-invalid @enderror" 
                                                       id="opening_time" name="opening_time" 
                                                       value="{{ old('opening_time', $settings['opening_time'] ?? '09:00') }}">
                                                @error('opening_time')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="closing_time" class="form-label">Closing Time</label>
                                                <input type="time" class="form-control @error('closing_time') is-invalid @enderror" 
                                                       id="closing_time" name="closing_time" 
                                                       value="{{ old('closing_time', $settings['closing_time'] ?? '22:00') }}">
                                                @error('closing_time')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Operating Days</label>
                                        <div class="row">
                                            @php
                                                $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
                                                $operatingDays = old('operating_days', $settings['operating_days'] ?? ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']);
                                            @endphp
                                            @foreach($days as $day)
                                                <div class="col-md-3 mb-2">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" 
                                                               id="operating_days_{{ $day }}" name="operating_days[]" 
                                                               value="{{ $day }}" 
                                                               {{ in_array($day, $operatingDays) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="operating_days_{{ $day }}">
                                                            {{ ucfirst($day) }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- System Settings -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-3">System Settings</h5>
                                    
                                    <div class="mb-3">
                                        <label for="currency" class="form-label">Currency</label>
                                        <select class="form-select @error('currency') is-invalid @enderror" id="currency" name="currency">
                                            <option value="USD" {{ (old('currency', $settings['currency'] ?? 'USD') == 'USD') ? 'selected' : '' }}>USD ($)</option>
                                            <option value="EUR" {{ (old('currency', $settings['currency'] ?? 'USD') == 'EUR') ? 'selected' : '' }}>EUR (€)</option>
                                            <option value="GBP" {{ (old('currency', $settings['currency'] ?? 'USD') == 'GBP') ? 'selected' : '' }}>GBP (£)</option>
                                            <option value="CAD" {{ (old('currency', $settings['currency'] ?? 'USD') == 'CAD') ? 'selected' : '' }}>CAD (C$)</option>
                                        </select>
                                        @error('currency')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="timezone" class="form-label">Timezone</label>
                                        <select class="form-select @error('timezone') is-invalid @enderror" id="timezone" name="timezone">
                                            <option value="America/New_York" {{ (old('timezone', $settings['timezone'] ?? 'America/New_York') == 'America/New_York') ? 'selected' : '' }}>Eastern Time</option>
                                            <option value="America/Chicago" {{ (old('timezone', $settings['timezone'] ?? 'America/New_York') == 'America/Chicago') ? 'selected' : '' }}>Central Time</option>
                                            <option value="America/Denver" {{ (old('timezone', $settings['timezone'] ?? 'America/New_York') == 'America/Denver') ? 'selected' : '' }}>Mountain Time</option>
                                            <option value="America/Los_Angeles" {{ (old('timezone', $settings['timezone'] ?? 'America/New_York') == 'America/Los_Angeles') ? 'selected' : '' }}>Pacific Time</option>
                                            <option value="Europe/London" {{ (old('timezone', $settings['timezone'] ?? 'America/New_York') == 'Europe/London') ? 'selected' : '' }}>London</option>
                                            <option value="Europe/Paris" {{ (old('timezone', $settings['timezone'] ?? 'America/New_York') == 'Europe/Paris') ? 'selected' : '' }}>Paris</option>
                                        </select>
                                        @error('timezone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="date_format" class="form-label">Date Format</label>
                                        <select class="form-select @error('date_format') is-invalid @enderror" id="date_format" name="date_format">
                                            <option value="Y-m-d" {{ (old('date_format', $settings['date_format'] ?? 'Y-m-d') == 'Y-m-d') ? 'selected' : '' }}>YYYY-MM-DD</option>
                                            <option value="m/d/Y" {{ (old('date_format', $settings['date_format'] ?? 'Y-m-d') == 'm/d/Y') ? 'selected' : '' }}>MM/DD/YYYY</option>
                                            <option value="d/m/Y" {{ (old('date_format', $settings['date_format'] ?? 'Y-m-d') == 'd/m/Y') ? 'selected' : '' }}>DD/MM/YYYY</option>
                                        </select>
                                        @error('date_format')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="mb-3">Order Settings</h5>
                                    
                                    <div class="mb-3">
                                        <label for="max_reservation_days" class="form-label">Max Reservation Days Ahead</label>
                                        <input type="number" class="form-control @error('max_reservation_days') is-invalid @enderror" 
                                               id="max_reservation_days" name="max_reservation_days" 
                                               value="{{ old('max_reservation_days', $settings['max_reservation_days'] ?? 30) }}" min="1" max="365">
                                        @error('max_reservation_days')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="order_timeout_minutes" class="form-label">Order Timeout (Minutes)</label>
                                        <input type="number" class="form-control @error('order_timeout_minutes') is-invalid @enderror" 
                                               id="order_timeout_minutes" name="order_timeout_minutes" 
                                               value="{{ old('order_timeout_minutes', $settings['order_timeout_minutes'] ?? 15) }}" min="5" max="60">
                                        @error('order_timeout_minutes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="delivery_radius_km" class="form-label">Delivery Radius (KM)</label>
                                        <input type="number" class="form-control @error('delivery_radius_km') is-invalid @enderror" 
                                               id="delivery_radius_km" name="delivery_radius_km" 
                                               value="{{ old('delivery_radius_km', $settings['delivery_radius_km'] ?? 10) }}" min="1" max="50" step="0.5">
                                        @error('delivery_radius_km')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="enable_delivery" name="enable_delivery" 
                                                   value="1" {{ old('enable_delivery', $settings['enable_delivery'] ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="enable_delivery">
                                                Enable Delivery Service
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="enable_pickup" name="enable_pickup" 
                                                   value="1" {{ old('enable_pickup', $settings['enable_pickup'] ?? true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="enable_pickup">
                                                Enable Pickup Service
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- Social Media -->
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-3">Social Media Links</h5>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="facebook_url" class="form-label">Facebook URL</label>
                                                <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" 
                                                       id="facebook_url" name="facebook_url" 
                                                       value="{{ old('facebook_url', $settings['facebook_url'] ?? '') }}" 
                                                       placeholder="https://facebook.com/yourpage">
                                                @error('facebook_url')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="instagram_url" class="form-label">Instagram URL</label>
                                                <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" 
                                                       id="instagram_url" name="instagram_url" 
                                                       value="{{ old('instagram_url', $settings['instagram_url'] ?? '') }}" 
                                                       placeholder="https://instagram.com/yourpage">
                                                @error('instagram_url')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="twitter_url" class="form-label">Twitter URL</label>
                                                <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" 
                                                       id="twitter_url" name="twitter_url" 
                                                       value="{{ old('twitter_url', $settings['twitter_url'] ?? '') }}" 
                                                       placeholder="https://twitter.com/yourpage">
                                                @error('twitter_url')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="youtube_url" class="form-label">YouTube URL</label>
                                                <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" 
                                                       id="youtube_url" name="youtube_url" 
                                                       value="{{ old('youtube_url', $settings['youtube_url'] ?? '') }}" 
                                                       placeholder="https://youtube.com/yourchannel">
                                                @error('youtube_url')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-secondary" id="reset-btn">
                                            <i class="ri-refresh-line align-middle me-1"></i>
                                            Reset to Defaults
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="save-btn">
                                            <i class="ri-save-line align-middle me-1"></i>
                                            Save Settings
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
$(document).ready(function() {
    // Form submission
    $('#settings-form').on('submit', function(e) {
        e.preventDefault();
        
        // Disable submit button
        $('#save-btn').prop('disabled', true).html('<i class="ri-loader-4-line align-middle me-1"></i> Saving...');
        
        // Submit form via AJAX
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Please correct the following errors:\n';
                    
                    Object.keys(errors).forEach(function(key) {
                        errorMessage += '- ' + errors[key][0] + '\n';
                    });
                    
                    Swal.fire('Validation Error', errorMessage, 'error');
                } else {
                    Swal.fire('Error!', 'An error occurred while saving settings.', 'error');
                }
            },
            complete: function() {
                // Re-enable submit button
                $('#save-btn').prop('disabled', false).html('<i class="ri-save-line align-middle me-1"></i> Save Settings');
            }
        });
    });

    // Reset to defaults
    $('#reset-btn').on('click', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will reset all settings to their default values. This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, reset them!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.settings.reset") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Reset!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'An error occurred while resetting settings.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush 