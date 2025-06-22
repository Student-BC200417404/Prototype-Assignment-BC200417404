@extends('admin.layout.app')
@section('title', 'Create Subcategory')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Create New Subcategory</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.subcategories.index') }}">Subcategories</a></li>
                            <li class="breadcrumb-item active">Create</li>
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
                                <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">
                                    <i class="ri-arrow-left-line align-middle me-1"></i>
                                    Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="subcategory-form" action="{{ route('admin.subcategories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Subcategory Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" name="name" value="{{ old('name') }}" 
                                                       placeholder="Enter subcategory name" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="category_id" class="form-label">Parent Category <span class="text-danger">*</span></label>
                                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                                        id="category_id" name="category_id" required>
                                                    <option value="">Select Category</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" name="description" rows="4" 
                                                  placeholder="Enter subcategory description">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="display_order" class="form-label">Display Order</label>
                                                <input type="number" class="form-control @error('display_order') is-invalid @enderror" 
                                                       id="display_order" name="display_order" value="{{ old('display_order', 0) }}" 
                                                       min="0" placeholder="0">
                                                @error('display_order')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Status</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                                           value="1" {{ old('is_active') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">
                                                        Active
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Subcategory Image</label>
                                        <div class="dropzone-wrapper">
                                            <div class="dropzone" id="image-dropzone">
                                                <div class="dz-message">
                                                    <i class="ri-image-line fs-1 text-muted"></i>
                                                    <p class="mb-0">Drag & drop image here or click to browse</p>
                                                    <small class="text-muted">Supports: JPG, PNG, GIF (Max: 2MB)</small>
                                                </div>
                                            </div>
                                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                                   id="image" name="image" accept="image/*" style="display: none;">
                                            @error('image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <!-- Image Preview -->
                                        <div id="image-preview" class="mt-3" style="display: none;">
                                            <img id="preview-img" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                            <button type="button" class="btn btn-sm btn-danger mt-2" id="remove-image">
                                                <i class="ri-delete-bin-line"></i> Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">
                                            <i class="ri-close-line align-middle me-1"></i>
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="submit-btn">
                                            <i class="ri-save-line align-middle me-1"></i>
                                            Create Subcategory
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
    // Image upload handling
    $('#image-dropzone').on('click', function() {
        $('#image').click();
    });

    $('#image').on('change', function() {
        const file = this.files[0];
        if (file) {
            // Validate file type
            if (!file.type.match('image.*')) {
                Swal.fire('Error', 'Please select a valid image file.', 'error');
                return;
            }

            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire('Error', 'Image size should be less than 2MB.', 'error');
                return;
            }

            // Preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-img').attr('src', e.target.result);
                $('#image-preview').show();
                $('#image-dropzone').hide();
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove image
    $('#remove-image').on('click', function() {
        $('#image').val('');
        $('#image-preview').hide();
        $('#image-dropzone').show();
    });

    // Drag and drop functionality
    $('#image-dropzone').on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });

    $('#image-dropzone').on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });

    $('#image-dropzone').on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
        
        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            $('#image')[0].files = files;
            $('#image').trigger('change');
        }
    });

    // Form submission
    $('#subcategory-form').on('submit', function(e) {
        e.preventDefault();
        
        // Disable submit button
        $('#submit-btn').prop('disabled', true).html('<i class="ri-loader-4-line align-middle me-1"></i> Creating...');
        
        // Submit form via AJAX
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Success!',
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
                    Swal.fire('Error!', 'An error occurred while creating the subcategory.', 'error');
                }
            },
            complete: function() {
                // Re-enable submit button
                $('#submit-btn').prop('disabled', false).html('<i class="ri-save-line align-middle me-1"></i> Create Subcategory');
            }
        });
    });

    // Real-time name validation
    $('#name').on('blur', function() {
        const name = $(this).val();
        if (name) {
            $.ajax({
                url: '{{ route("admin.subcategories.check-name") }}',
                type: 'POST',
                data: {
                    name: name,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (!response.available) {
                        $('#name').addClass('is-invalid');
                        if (!$('#name').next('.invalid-feedback').length) {
                            $('#name').after('<div class="invalid-feedback">This subcategory name is already taken.</div>');
                        }
                    } else {
                        $('#name').removeClass('is-invalid');
                        $('#name').next('.invalid-feedback').remove();
                    }
                }
            });
        }
    });
});
</script>

<style>
.dropzone {
    border: 2px dashed #dee2e6;
    border-radius: 0.375rem;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.dropzone:hover, .dropzone.dragover {
    border-color: #0d6efd;
    background-color: #f8f9fa;
}

.dropzone .dz-message {
    margin: 0;
}

.dropzone .dz-message i {
    display: block;
    margin-bottom: 0.5rem;
}
</style>
@endpush 