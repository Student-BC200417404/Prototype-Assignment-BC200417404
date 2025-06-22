@extends('admin.layout.app')

@section('title', 'Category Details')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Category Details</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin.categories.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:category-outline" class="icon text-lg"></iconify-icon>
                    Categories
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">{{ $category->name }}</li>
        </ul>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="ri-check-line"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ri-error-warning-line"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Category Information</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
                                <i class="ri-edit-line"></i> Edit
                            </a>
                            <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                    data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                <i class="ri-delete-bin-line"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="Category Image" 
                                         class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center mx-auto" 
                                         style="width: 200px; height: 200px;">
                                        <iconify-icon icon="solar:category-outline" class="text-muted" style="font-size: 4rem;"></iconify-icon>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td width="150"><strong>Name:</strong></td>
                                        <td>{{ $category->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Synonym:</strong></td>
                                        <td>{{ $category->snonym ?: 'Not specified' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Slug:</strong></td>
                                        <td><code>{{ $category->slug }}</code></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            @if($category->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Display Order:</strong></td>
                                        <td>{{ $category->display_order ?: '0' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Menu Items:</strong></td>
                                        <td>
                                            <span class="badge bg-info">{{ $category->menus_count ?? 0 }}</span>
                                            @if($category->menus_count > 0)
                                                <a href="{{ route('admin.menus.index', ['category' => $category->id]) }}" class="btn btn-sm btn-outline-primary ms-2">
                                                    View Items
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Created:</strong></td>
                                        <td>{{ $category->created_at->format('F d, Y \a\t g:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Updated:</strong></td>
                                        <td>{{ $category->updated_at->format('F d, Y \a\t g:i A') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    @if($category->description)
                        <hr>
                        <div class="mt-4">
                            <h6><strong>Description:</strong></h6>
                            <p class="text-muted">{{ $category->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-warning">
                            <i class="ri-edit-line"></i> Edit Category
                        </a>
                        <a href="{{ route('admin.menus.create', ['category_id' => $category->id]) }}" class="btn btn-primary">
                            <i class="ri-add-line"></i> Add Menu Item
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="ri-arrow-left-line"></i> Back to Categories
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">Category Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ $category->menus_count ?? 0 }}</h4>
                                <small class="text-muted">Menu Items</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-1">
                                @if($category->is_active)
                                    <i class="ri-check-line"></i>
                                @else
                                    <i class="ri-close-line"></i>
                                @endif
                            </h4>
                            <small class="text-muted">Status</small>
                        </div>
                    </div>
                </div>
            </div>
            
            @if($category->menus_count > 0)
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Recent Menu Items</h5>
                    </div>
                    <div class="card-body">
                        @php
                            $recentMenus = $category->menus()->latest()->take(5)->get();
                        @endphp
                        
                        @if($recentMenus->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($recentMenus as $menu)
                                    <div class="list-group-item d-flex align-items-center gap-3 px-0">
                                        <div class="flex-shrink-0">
                                            @if($menu->image)
                                                <img src="{{ asset('storage/' . $menu->image) }}" alt="Menu Image" 
                                                     class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <iconify-icon icon="solar:restaurant-outline" class="text-muted"></iconify-icon>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $menu->name }}</h6>
                                            <small class="text-muted">${{ number_format($menu->price, 2) }}</small>
                                        </div>
                                        <div class="flex-shrink-0">
                                            @if($menu->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.menus.index', ['category' => $category->id]) }}" class="btn btn-outline-primary btn-sm">
                                    View All Menu Items
                                </a>
                            </div>
                        @else
                            <p class="text-muted text-center mb-0">No menu items found.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
$(document).ready(function() {
    // Handle delete button click
    $('.delete-btn').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        showConfirmation(
            'Delete Category?',
            `Are you sure you want to delete "${name}"? This action cannot be undone.`,
            function() {
                $.ajax({
                    url: `/admin/categories/${id}`,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification('Success', response.message, 'success');
                            setTimeout(function() {
                                window.location.href = '{{ route("admin.categories.index") }}';
                            }, 1500);
                        } else {
                            showNotification('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'An error occurred while deleting the category.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showNotification('Error', errorMessage, 'error');
                    }
                });
            }
        );
    });
});
</script>
@endpush 