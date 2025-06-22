@extends('admin.layout.app')

@section('title', 'Create Category')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Create Category</h6>
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
            <li class="fw-medium">Create</li>
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
                    <h5 class="card-title mb-0">Category Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" data-ajax="true">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Category Name <span class="text-danger">*</span></label>
                                    <div class="icon-field">
                                        <span class="icon">
                                            <iconify-icon icon="solar:category-outline"></iconify-icon>
                                        </span>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                               placeholder="Enter category name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Synonym</label>
                                    <div class="icon-field">
                                        <span class="icon">
                                            <iconify-icon icon="solar:tag-outline"></iconify-icon>
                                        </span>
                                        <input type="text" name="snonym" class="form-control @error('snonym') is-invalid @enderror" 
                                               placeholder="Enter synonym" value="{{ old('snonym') }}">
                                        @error('snonym')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Description</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="solar:document-text-outline"></iconify-icon>
                                </span>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                          rows="4" placeholder="Enter description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Category Image</label>
                            <div class="upload-image-wrapper d-flex align-items-center gap-3">
                                <div class="uploaded-img d-none position-relative h-120-px w-120-px border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50">
                                    <button type="button" class="uploaded-img__remove position-absolute top-0 end-0 z-1 text-2xxl line-height-1 me-8 mt-8 d-flex">
                                        <iconify-icon icon="radix-icons:cross-2" class="text-xl text-danger-600"></iconify-icon>
                                    </button>
                                    <img id="uploaded-img__preview" class="w-100 h-100 object-fit-cover" src="#" alt="image preview">
                                </div>
                                <label class="upload-file h-120-px w-120-px border input-form-light radius-8 overflow-hidden border-dashed bg-neutral-50 bg-hover-neutral-200 d-flex align-items-center flex-column justify-content-center gap-1" for="upload-file">
                                    <iconify-icon icon="solar:camera-outline" class="text-xl text-secondary-light"></iconify-icon>
                                    <span class="fw-semibold text-secondary-light">Upload</span>
                                    <input id="upload-file" type="file" name="image" class="form-control @error('image') is-invalid @enderror" 
                                           accept="image/*" hidden>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </label>
                            </div>
                            <small class="form-text text-muted">Upload an image for this category (JPEG, PNG, JPG, GIF, WebP - Max 2MB)</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Display Order</label>
                                    <div class="icon-field">
                                        <span class="icon">
                                            <iconify-icon icon="solar:sort-outline"></iconify-icon>
                                        </span>
                                        <input type="number" name="display_order" class="form-control @error('display_order') is-invalid @enderror" 
                                               placeholder="0" value="{{ old('display_order', 0) }}" min="0" max="999">
                                        @error('display_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="icon-field">
                                        <span class="icon">
                                            <iconify-icon icon="solar:check-circle-outline"></iconify-icon>
                                        </span>
                                        <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('is_active')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                <i class="ri-close-line"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line"></i> Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Help & Guidelines</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="ri-information-line"></i> Category Guidelines</h6>
                        <ul class="mb-0">
                            <li>Category names should be descriptive and unique</li>
                            <li>Images should be high quality and relevant</li>
                            <li>Display order determines the sorting order</li>
                            <li>Inactive categories won't appear in the menu</li>
                            <li>Synonyms help with search functionality</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-warning">
                        <h6><i class="ri-alert-line"></i> Important Notes</h6>
                        <ul class="mb-0">
                            <li>Category names must be unique</li>
                            <li>Image size should not exceed 2MB</li>
                            <li>Supported formats: JPEG, PNG, JPG, GIF, WebP</li>
                            <li>Categories with menu items cannot be deleted</li>
                        </ul>
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
    // Image upload preview
    $('#upload-file').on('change', function(event) {
        const file = event.target.files[0];
        const preview = $('#uploaded-img__preview');
        const uploadedImgContainer = $('.uploaded-img');
        
        if (file) {
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                showNotification('Error', 'Image size should not exceed 2MB.', 'error');
                this.value = '';
                return;
            }
            
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                showNotification('Error', 'Please select a valid image file (JPEG, PNG, JPG, GIF, WebP).', 'error');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result);
                uploadedImgContainer.removeClass('d-none');
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove uploaded image
    $('.uploaded-img__remove').on('click', function() {
        const preview = $('#uploaded-img__preview');
        const uploadedImgContainer = $('.uploaded-img');
        preview.attr('src', '');
        uploadedImgContainer.addClass('d-none');
        $('#upload-file').val('');
    });
    
    // Form validation
    $('form[data-ajax="true"]').on('submit', function(e) {
        const name = $('input[name="name"]').val().trim();
        if (!name) {
            e.preventDefault();
            showNotification('Validation Error', 'Category name is required!', 'error');
            $('input[name="name"]').focus();
            return false;
        }
        
        // Check if name already exists (client-side validation)
        const nameInput = $('input[name="name"]');
        const nameValue = nameInput.val().trim();
        
        if (nameValue.length > 0) {
            $.ajax({
                url: '{{ route("admin.categories.check-name") }}',
                method: 'POST',
                data: { name: nameValue },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.exists) {
                        showNotification('Validation Error', 'Category name already exists!', 'error');
                        nameInput.focus();
                        return false;
                    }
                }
            });
        }
    });
});
</script>
@endpush