@extends('admin.layout.app')

@section('title', 'View Menu Item')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Menu Item Details</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin.menu.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    Menu Items
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">{{ $menu->name }}</li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Menu Item Information</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-warning btn-sm">
                                <i class="ri-edit-line"></i> Edit
                            </a>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                    data-id="{{ $menu->id }}" data-name="{{ $menu->name }}"
                                    data-url="{{ route('admin.menu.destroy', $menu->id) }}">
                                <i class="ri-delete-bin-line"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold" width="150">ID:</td>
                                    <td>{{ $menu->id }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Name:</td>
                                    <td>{{ $menu->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Category:</td>
                                    <td>
                                        @if($menu->category)
                                            <span class="badge bg-primary">{{ $menu->category->name }}</span>
                                        @else
                                            <span class="text-muted">No Category</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Synonym:</td>
                                    <td>{{ $menu->snonym ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Price:</td>
                                    <td>
                                        <span class="fw-bold text-success">${{ number_format($menu->price, 2) }}</span>
                                        @if($menu->discount_price)
                                            <br><small class="text-muted">
                                                <del>${{ number_format($menu->discount_price, 2) }}</del>
                                            </small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Status:</td>
                                    <td>
                                        @if($menu->is_available)
                                            <span class="badge bg-success">Available</span>
                                        @else
                                            <span class="badge bg-danger">Unavailable</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td class="fw-semibold" width="150">Preparation Time:</td>
                                    <td>
                                        @if($menu->preparation_time)
                                            {{ $menu->preparation_time }} minutes
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Display Order:</td>
                                    <td>{{ $menu->display_order ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Features:</td>
                                    <td>
                                        @if($menu->is_vegetarian)
                                            <span class="badge bg-success me-1">Vegetarian</span>
                                        @endif
                                        @if($menu->is_spicy)
                                            <span class="badge bg-warning me-1">Spicy</span>
                                        @endif
                                        @if($menu->is_featured)
                                            <span class="badge bg-info me-1">Featured</span>
                                        @endif
                                        @if(!$menu->is_vegetarian && !$menu->is_spicy && !$menu->is_featured)
                                            <span class="text-muted">No special features</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Created:</td>
                                    <td>{{ $menu->created_at->format('M d, Y \a\t h:i A') }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold">Updated:</td>
                                    <td>{{ $menu->updated_at->format('M d, Y \a\t h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($menu->description)
                        <div class="mt-4">
                            <h6 class="fw-semibold">Description:</h6>
                            <p class="text-muted">{{ $menu->description }}</p>
                        </div>
                    @endif

                    @if($menu->ingredients)
                        <div class="mt-4">
                            <h6 class="fw-semibold">Ingredients:</h6>
                            <p class="text-muted">{{ $menu->ingredients }}</p>
                        </div>
                    @endif

                    @if($menu->nutritional_info)
                        <div class="mt-4">
                            <h6 class="fw-semibold">Nutritional Information:</h6>
                            <p class="text-muted">{{ $menu->nutritional_info }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Menu Image</h6>
                </div>
                <div class="card-body text-center">
                    @if($menu->image)
                        <img src="{{ $menu->image }}" alt="{{ $menu->name }}" 
                             class="img-fluid rounded" style="max-height: 300px;">
                    @else
                        <div class="text-muted py-5">
                            <i class="ri-image-line" style="font-size: 3rem;"></i>
                            <p class="mt-2">No image available</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.menu.edit', $menu->id) }}" class="btn btn-warning btn-sm">
                            <i class="ri-edit-line"></i> Edit Menu Item
                        </a>
                        <button type="button" class="btn btn-outline-secondary btn-sm status-toggle-btn" 
                                data-id="{{ $menu->id }}" 
                                data-url="{{ route('admin.menu.toggle-status', $menu->id) }}"
                                data-current-status="{{ $menu->is_available }}">
                            <i class="ri-toggle-line"></i> 
                            {{ $menu->is_available ? 'Mark Unavailable' : 'Mark Available' }}
                        </button>
                        <a href="{{ route('admin.menu.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="ri-arrow-left-line"></i> Back to Menu List
                        </a>
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
    // Status toggle functionality
    $('.status-toggle-btn').on('click', function() {
        const btn = $(this);
        const id = btn.data('id');
        const url = btn.data('url');
        const currentStatus = btn.data('current-status');
        const newStatus = currentStatus ? 0 : 1;
        
        Swal.fire({
            title: 'Update Status',
            text: `Are you sure you want to mark this menu item as ${newStatus ? 'available' : 'unavailable'}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'PATCH',
                    data: {
                        status: newStatus
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: response.message || 'Status updated successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Failed to update status. Please try again.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush 