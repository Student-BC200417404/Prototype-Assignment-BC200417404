@extends('admin.layout.app')
@section('title', 'View Subcategory')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Subcategory Details: {{ $subcategory->name }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.subcategories.index') }}">Subcategories</a></li>
                            <li class="breadcrumb-item active">View</li>
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
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h4 class="card-title mb-0">Subcategory Information</h4>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">
                                        <i class="ri-arrow-left-line align-middle me-1"></i>
                                        Back to List
                                    </a>
                                    <a href="{{ route('admin.subcategories.edit', $subcategory->id) }}" class="btn btn-primary">
                                        <i class="ri-edit-line align-middle me-1"></i>
                                        Edit
                                    </a>
                                    <button type="button" class="btn btn-danger delete-btn" 
                                            data-id="{{ $subcategory->id }}" 
                                            data-name="{{ $subcategory->name }}">
                                        <i class="ri-delete-bin-line align-middle me-1"></i>
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Subcategory Name</label>
                                            <p class="form-control-plaintext">{{ $subcategory->name }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Parent Category</label>
                                            <p class="form-control-plaintext">
                                                @if($subcategory->category)
                                                    <span class="badge bg-primary">{{ $subcategory->category->name }}</span>
                                                @else
                                                    <span class="text-muted">No category assigned</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Description</label>
                                    <p class="form-control-plaintext">
                                        {{ $subcategory->description ?: 'No description provided' }}
                                    </p>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Display Order</label>
                                            <p class="form-control-plaintext">{{ $subcategory->display_order ?? 0 }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Status</label>
                                            <p class="form-control-plaintext">
                                                @if($subcategory->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Slug</label>
                                            <p class="form-control-plaintext">{{ $subcategory->slug }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Created At</label>
                                            <p class="form-control-plaintext">{{ $subcategory->created_at->format('M d, Y H:i:s') }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Last Updated</label>
                                            <p class="form-control-plaintext">{{ $subcategory->updated_at->format('M d, Y H:i:s') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Display -->
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Subcategory Image</label>
                                    @if($subcategory->image)
                                        <div class="text-center">
                                            <img src="{{ asset('storage/subcategories/' . $subcategory->image) }}" 
                                                 alt="{{ $subcategory->name }}" 
                                                 class="img-fluid rounded" 
                                                 style="max-height: 300px; max-width: 100%;">
                                            <p class="text-muted mt-2 mb-0">{{ $subcategory->image }}</p>
                                        </div>
                                    @else
                                        <div class="text-center p-4 border rounded bg-light">
                                            <i class="ri-image-line fs-1 text-muted"></i>
                                            <p class="text-muted mb-0">No image uploaded</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Related Data -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <hr>
                                <h5 class="mb-3">Related Information</h5>
                                
                                <!-- Menu Items Count -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="ri-restaurant-line fs-1 text-primary"></i>
                                                <h4 class="mt-2 mb-1">{{ $subcategory->menuItems()->count() ?? 0 }}</h4>
                                                <p class="text-muted mb-0">Menu Items</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="ri-eye-line fs-1 text-info"></i>
                                                <h4 class="mt-2 mb-1">{{ $subcategory->views ?? 0 }}</h4>
                                                <p class="text-muted mb-0">Total Views</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <i class="ri-calendar-line fs-1 text-success"></i>
                                                <h4 class="mt-2 mb-1">{{ $subcategory->created_at->diffForHumans() }}</h4>
                                                <p class="text-muted mb-0">Created</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete subcategory "<strong id="delete-name"></strong>"? This action cannot be undone.</p>
                <div class="alert alert-warning">
                    <i class="ri-error-warning-line me-1"></i>
                    <strong>Warning:</strong> This will also delete all associated menu items and images.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
$(document).ready(function() {
    // Delete functionality
    $('.delete-btn').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        $('#delete-name').text(name);
        $('#deleteModal').modal('show');
        
        $('#confirm-delete').off('click').on('click', function() {
            $.ajax({
                url: '/admin/subcategories/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            window.location.href = '{{ route("admin.subcategories.index") }}';
                        });
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error!', 'An error occurred while deleting the subcategory.', 'error');
                }
            });
        });
    });
});
</script>
@endpush 