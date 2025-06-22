@extends('admin.layout.app')

@section('title', 'Menu Management')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Menu Items</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Menu Items</li>
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

    <div class="card basic-data-table">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">All Menu Items</h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-warning btn-sm" id="bulkStatusBtn" style="display: none;">
                        <i class="ri-settings-line"></i> Bulk Status
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn" style="display: none;">
                        <i class="ri-delete-bin-line"></i> Bulk Delete
                    </button>
                    <a href="{{ route('admin.menu.create') }}" class="btn btn-primary btn-sm">
                        <i class="ri-add-line"></i> Add Menu Item
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="menu-datatable" class="table table-striped datatable" data-url="{{ route('admin.menu.data') }}">
                    <thead>
                        <tr>
                            <th width="50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Features</th>
                            <th>Created</th>
                            <th width="150">Actions</th>
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

<!-- Bulk Status Modal -->
<div class="modal fade" id="bulkStatusModal" tabindex="-1" aria-labelledby="bulkStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkStatusModalLabel">Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Update status for <span id="selectedCount">0</span> selected menu items:</p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="bulkStatus" id="statusAvailable" value="1">
                    <label class="form-check-label" for="statusAvailable">
                        Available
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="bulkStatus" id="statusUnavailable" value="0">
                    <label class="form-check-label" for="statusUnavailable">
                        Unavailable
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmBulkStatus">Update Status</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
$(document).ready(function() {
    // Handle select all checkbox
    $('#selectAll').on('change', function() {
        $('.menu-checkbox').prop('checked', this.checked);
        updateBulkButtons();
    });
    
    // Handle individual checkboxes
    $(document).on('change', '.menu-checkbox', function() {
        updateBulkButtons();
        
        // Update select all checkbox
        const totalCheckboxes = $('.menu-checkbox').length;
        const checkedCheckboxes = $('.menu-checkbox:checked').length;
        
        if (checkedCheckboxes === 0) {
            $('#selectAll').prop('indeterminate', false).prop('checked', false);
        } else if (checkedCheckboxes === totalCheckboxes) {
            $('#selectAll').prop('indeterminate', false).prop('checked', true);
        } else {
            $('#selectAll').prop('indeterminate', true);
        }
    });
    
    // Update bulk action buttons visibility
    function updateBulkButtons() {
        const selectedCount = $('.menu-checkbox:checked').length;
        
        if (selectedCount > 0) {
            $('#bulkStatusBtn, #bulkDeleteBtn').show();
            $('#selectedCount').text(selectedCount);
        } else {
            $('#bulkStatusBtn, #bulkDeleteBtn').hide();
        }
    }
    
    // Bulk status update
    $('#bulkStatusBtn').on('click', function() {
        const selectedIds = $('.menu-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        
        if (selectedIds.length === 0) {
            Swal.fire('Warning', 'Please select at least one menu item.', 'warning');
            return;
        }
        
        $('#bulkStatusModal').modal('show');
    });
    
    $('#confirmBulkStatus').on('click', function() {
        const selectedIds = $('.menu-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        
        const status = $('input[name="bulkStatus"]:checked').val();
        
        if (!status) {
            Swal.fire('Warning', 'Please select a status.', 'warning');
            return;
        }
        
        $.ajax({
            url: '{{ route("admin.menu.bulk-status") }}',
            method: 'POST',
            data: {
                ids: selectedIds,
                status: status
            },
            success: function(response) {
                $('#bulkStatusModal').modal('hide');
                $('.menu-checkbox').prop('checked', false);
                $('#selectAll').prop('checked', false);
                updateBulkButtons();
                reloadDataTable('#menu-datatable');
                
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Status updated successfully!',
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            error: function(xhr) {
                Swal.fire('Error', 'Failed to update status. Please try again.', 'error');
            }
        });
    });
    
    // Bulk delete
    $('#bulkDeleteBtn').on('click', function() {
        const selectedIds = $('.menu-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        
        if (selectedIds.length === 0) {
            Swal.fire('Warning', 'Please select at least one menu item.', 'warning');
            return;
        }
        
        Swal.fire({
            title: 'Are you sure?',
            text: `You want to delete ${selectedIds.length} menu item(s)? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete them!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.menu.bulk-delete") }}',
                    method: 'POST',
                    data: {
                        ids: selectedIds
                    },
                    success: function(response) {
                        $('.menu-checkbox').prop('checked', false);
                        $('#selectAll').prop('checked', false);
                        updateBulkButtons();
                        reloadDataTable('#menu-datatable');
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message || 'Menu items deleted successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Failed to delete menu items. Please try again.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush