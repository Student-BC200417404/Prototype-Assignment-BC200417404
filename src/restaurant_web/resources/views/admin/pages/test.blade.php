@extends('admin.layout.app')

@section('title', 'AJAX & SweetAlert Test')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">AJAX & SweetAlert Test Page</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Test Page</li>
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
        <!-- AJAX Form Test -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">AJAX Form Submission Test</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" data-ajax="true">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label class="form-label">Test Name <span class="text-danger">*</span></label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="solar:category-outline"></iconify-icon>
                                </span>
                                <input type="text" name="name" class="form-control" placeholder="Enter test name" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Test Description</label>
                            <div class="icon-field">
                                <span class="icon">
                                    <iconify-icon icon="solar:document-text-outline"></iconify-icon>
                                </span>
                                <textarea name="description" class="form-control" rows="3" placeholder="Enter description"></textarea>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Test Image</label>
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
                                    <input id="upload-file" type="file" name="image" accept="image/*" hidden>
                                </label>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="testActive" checked>
                            <label class="form-check-label" for="testActive">
                                Active Status
                            </label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" onclick="resetForm()">
                                <i class="ri-refresh-line"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-send-plane-line"></i> Submit via AJAX
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- SweetAlert Test -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">SweetAlert Test Buttons</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" onclick="testSuccessAlert()">
                            <i class="ri-check-line"></i> Success Alert
                        </button>
                        
                        <button type="button" class="btn btn-danger" onclick="testErrorAlert()">
                            <i class="ri-error-warning-line"></i> Error Alert
                        </button>
                        
                        <button type="button" class="btn btn-warning" onclick="testWarningAlert()">
                            <i class="ri-alert-line"></i> Warning Alert
                        </button>
                        
                        <button type="button" class="btn btn-info" onclick="testInfoAlert()">
                            <i class="ri-information-line"></i> Info Alert
                        </button>
                        
                        <button type="button" class="btn btn-primary" onclick="testConfirmation()">
                            <i class="ri-question-line"></i> Confirmation Dialog
                        </button>
                        
                        <button type="button" class="btn btn-secondary" onclick="testDeleteConfirmation()">
                            <i class="ri-delete-bin-line"></i> Delete Confirmation
                        </button>
                        
                        <button type="button" class="btn btn-dark" onclick="testNotification()">
                            <i class="ri-notification-line"></i> Toast Notification
                        </button>
                        
                        <button type="button" class="btn btn-outline-primary" onclick="testLoading()">
                            <i class="ri-loader-line"></i> Loading Overlay
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables Test -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">DataTables Test</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped datatable" data-url="{{ route('admin.categories.data') }}">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Utility Functions Test -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Utility Functions Test</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-primary w-100 mb-2" onclick="testFormatCurrency()">
                                Format Currency
                            </button>
                            <div id="currencyResult" class="text-muted small"></div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-success w-100 mb-2" onclick="testFormatDate()">
                                Format Date
                            </button>
                            <div id="dateResult" class="text-muted small"></div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-warning w-100 mb-2" onclick="testEmailValidation()">
                                Email Validation
                            </button>
                            <div id="emailResult" class="text-muted small"></div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-info w-100 mb-2" onclick="testPhoneValidation()">
                                Phone Validation
                            </button>
                            <div id="phoneResult" class="text-muted small"></div>
                        </div>
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
    // Initialize DataTable
    const table = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: $('.datatable').data('url'),
            type: 'GET'
        },
        columns: [
            {data: 'id', name: 'id'},
            {
                data: 'image_preview', 
                name: 'image',
                orderable: false,
                searchable: false
            },
            {data: 'name', name: 'name'},
            {data: 'status', name: 'is_active'},
            {data: 'created_at_formatted', name: 'created_at'},
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ],
        order: [[0, 'desc']],
        responsive: true,
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries per page",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            processing: "Processing...",
            emptyTable: "No data available in table",
            zeroRecords: "No matching records found"
        }
    });

    // Image upload preview
    $('#upload-file').on('change', function(event) {
        const file = event.target.files[0];
        const preview = $('#uploaded-img__preview');
        const uploadedImgContainer = $('.uploaded-img');
        
        if (file) {
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
});

// SweetAlert Test Functions
function testSuccessAlert() {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: 'This is a success message.',
        timer: 2000,
        showConfirmButton: false
    });
}

function testErrorAlert() {
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: 'This is an error message.',
        confirmButtonColor: '#d33'
    });
}

function testWarningAlert() {
    Swal.fire({
        icon: 'warning',
        title: 'Warning!',
        text: 'This is a warning message.',
        confirmButtonColor: '#f39c12'
    });
}

function testInfoAlert() {
    Swal.fire({
        icon: 'info',
        title: 'Information',
        text: 'This is an information message.',
        confirmButtonColor: '#17a2b8'
    });
}

function testConfirmation() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, do it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Done!',
                'Your action has been completed.',
                'success'
            );
        }
    });
}

function testDeleteConfirmation() {
    showConfirmation(
        'Delete Item?',
        'Are you sure you want to delete this item? This action cannot be undone.',
        function() {
            showNotification('Success', 'Item deleted successfully!', 'success');
        }
    );
}

function testNotification() {
    showNotification('Test Notification', 'This is a toast notification!', 'info');
}

function testLoading() {
    showLoading();
    setTimeout(function() {
        hideLoading();
        showNotification('Loading Complete', 'Loading overlay test completed!', 'success');
    }, 2000);
}

// Utility Function Tests
function testFormatCurrency() {
    const amount = 1234.56;
    const formatted = formatCurrency(amount);
    $('#currencyResult').text(formatted);
}

function testFormatDate() {
    const date = new Date();
    const formatted = formatDate(date);
    $('#dateResult').text(formatted);
}

function testEmailValidation() {
    const emails = ['test@example.com', 'invalid-email', 'user@domain.co.uk'];
    let result = '';
    emails.forEach(email => {
        result += `${email}: ${isValidEmail(email) ? 'Valid' : 'Invalid'}\n`;
    });
    $('#emailResult').text(result);
}

function testPhoneValidation() {
    const phones = ['+1234567890', '123-456-7890', 'invalid', '+44 20 7946 0958'];
    let result = '';
    phones.forEach(phone => {
        result += `${phone}: ${isValidPhone(phone) ? 'Valid' : 'Invalid'}\n`;
    });
    $('#phoneResult').text(result);
}

function resetForm() {
    $('form[data-ajax="true"]')[0].reset();
    $('.uploaded-img').addClass('d-none');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
}
</script>
@endpush 