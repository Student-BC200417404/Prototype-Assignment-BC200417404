@extends('admin.layout.app')

@section('content')
<div class="container">
   <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Categories</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Categories
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Create</li>
        </ul>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row gy-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Add New Category</h5>
                </div>
                <div class="card-body">
                    <form id="categoryForm" method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-12">
                                <label class="form-label">Name</label>
                                <div class="icon-field">
                                    <span class="icon">
                                        <iconify-icon icon="f7:person"></iconify-icon>
                                    </span>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Category Name" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <div class="icon-field">
                                    <span class="icon">
                                        <iconify-icon icon="f7:document-text"></iconify-icon>
                                    </span>
                                    <textarea name="description" class="form-control" placeholder="Enter Description"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Image Upload</label>
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
                                        <input id="upload-file" type="file" name="image" class="form-control" accept="image/*" required hidden>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Display Order</label>
                                <div class="icon-field">
                                    <span class="icon">
                                        <iconify-icon icon="f7:arrow-up"></iconify-icon>
                                    </span>
                                    <input type="number" name="display_order" class="form-control" placeholder="Optional">
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Active</label>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="card-footer d-flex justify-content-end">
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Save Category</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 
@push('custom-scripts')
    
<script>
    // Image upload preview
    document.getElementById('upload-file').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('uploaded-img__preview');
        const uploadedImgContainer = document.querySelector('.uploaded-img');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                uploadedImgContainer.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    // Remove uploaded image
    document.querySelector('.uploaded-img__remove').addEventListener('click', function() {
        const preview = document.getElementById('uploaded-img__preview');
        const uploadedImgContainer = document.querySelector('.uploaded-img');
        preview.src = '';
        uploadedImgContainer.classList.add('d-none');
        document.getElementById('upload-file').value = ''; // Clear the file input
    });

    $(document).ready(function() {
        $('#categoryForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            $.ajax({
                url: $(this).attr('action'), // Get the action URL from the form
                type: 'POST',
                data: new FormData(this), // Send the form data
                contentType: false, // Prevent jQuery from overriding the content type
                processData: false, // Prevent jQuery from processing the data
                success: function(data) {
                    if (data.success) {
                        // Show success message with SweetAlert
                        Swal.fire({
                            title: 'Success!',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('admin.categories.index') }}"; // Redirect to categories index
                            }
                        });
                    } else {
                        // Show error message with SweetAlert
                        Swal.fire({
                            title: 'Error!',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    
                    // Extract the error message from the response
                    const response = xhr.responseJSON;
                    const errorMessage = response ? response.message : 'An error occurred while submitting the form.';
                    
                    // Show error message with SweetAlert
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>



@endpush