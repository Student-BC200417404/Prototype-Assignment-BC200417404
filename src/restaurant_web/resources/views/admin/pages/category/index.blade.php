@extends('admin.layout.app')

@section('title', 'Categories Management')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Categories</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Categories</li>
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
                <h5 class="card-title mb-0">All Categories</h5>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-warning btn-sm" id="bulkStatusBtn" style="display: none;">
                        <i class="ri-settings-line"></i> Bulk Status
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn" style="display: none;">
                        <i class="ri-delete-bin-line"></i> Bulk Delete
                    </button>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                        <i class="ri-add-line"></i> Add Category
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped datatable" data-url="{{ route('admin.categories.data') }}">
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
                            <th>Synonym</th>
                            <th>Status</th>
                            <th>Display Order</th>
                            <th>Menu Items</th>
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
                <p>Update status for <span id="selectedCount">0</span> selected categories:</p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="bulkStatus" id="statusActive" value="1">
                    <label class="form-check-label" for="statusActive">
                        Active
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="bulkStatus" id="statusInactive" value="0">
                    <label class="form-check-label" for="statusInactive">
                        Inactive
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
    // Initialize DataTable
    const table = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: $('.datatable').data('url'),
            type: 'GET'
        },
        columns: [
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `<div class="form-check">
                                <input class="form-check-input category-checkbox" type="checkbox" value="${row.id}">
                            </div>`;
                }
            },
            {data: 'id', name: 'id'},
            {
                data: 'image_preview', 
                name: 'image',
                orderable: false,
                searchable: false
            },
            {data: 'name', name: 'name'},
            {data: 'snonym', name: 'snonym'},
            {data: 'status', name: 'is_active'},
            {data: 'display_order', name: 'display_order'},
            {data: 'menus_count', name: 'menus_count'},
            {data: 'created_at_formatted', name: 'created_at'},
            {
                data: 'action',
                name: 'actions',
                orderable: false,
                searchable: false
            }
        ],
        order: [[1, 'desc']],
        responsive: true,
        language: {
            search: "Search categories:",
            lengthMenu: "Show _MENU_ categories per page",
            info: "Showing _START_ to _END_ of _TOTAL_ categories",
            infoEmpty: "Showing 0 to 0 of 0 categories",
            infoFiltered: "(filtered from _MAX_ total categories)",
            processing: "Loading categories...",
            emptyTable: "No categories found",
            zeroRecords: "No matching categories found"
        }
    });
    
    // Handle select all checkbox
    $('#selectAll').on('change', function() {
        $('.category-checkbox').prop('checked', this.checked);
        updateBulkButtons();
    });
    
    // Handle individual checkboxes
    $(document).on('change', '.category-checkbox', function() {
        updateBulkButtons();
        
        // Update select all checkbox
        const totalCheckboxes = $('.category-checkbox').length;
        const checkedCheckboxes = $('.category-checkbox:checked').length;
        
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
        const selectedCount = $('.category-checkbox:checked').length;
        
        if (selectedCount > 0) {
            $('#bulkStatusBtn, #bulkDeleteBtn').show();
            $('#selectedCount').text(selectedCount);
        } else {
            $('#bulkStatusBtn, #bulkDeleteBtn').hide();
        }
    }
    
    // Handle bulk status button
    $('#bulkStatusBtn').on('click', function() {
        const selectedIds = $('.category-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        
        if (selectedIds.length === 0) {
            showNotification('No categories selected', 'Please select categories to update.', 'warning');
            return;
        }
        
        $('#bulkStatusModal').modal('show');
    });
    
    // Handle bulk status confirmation
    $('#confirmBulkStatus').on('click', function() {
        const selectedIds = $('.category-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        
        const status = $('input[name="bulkStatus"]:checked').val();
        
        if (!status) {
            showNotification('No status selected', 'Please select a status.', 'warning');
            return;
        }
        
        $.ajax({
            url: '{{ route("admin.categories.bulk-status") }}',
            method: 'POST',
            data: {
                ids: selectedIds,
                status: status
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#bulkStatusModal').modal('hide');
                    showNotification('Success', response.message, 'success');
                    table.ajax.reload();
                    $('.category-checkbox').prop('checked', false);
                    $('#selectAll').prop('checked', false);
                    updateBulkButtons();
                }
            },
            error: function(xhr) {
                let errorMessage = 'Failed to update categories.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                showNotification('Error', errorMessage, 'error');
            }
        });
    });
    
    // Handle bulk delete button
    $('#bulkDeleteBtn').on('click', function() {
        const selectedIds = $('.category-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        
        if (selectedIds.length === 0) {
            showNotification('No categories selected', 'Please select categories to delete.', 'warning');
            return;
        }
        
        showConfirmation(
            'Delete Categories?',
            `Are you sure you want to delete ${selectedIds.length} selected categories? This action cannot be undone.`,
            function() {
                $.ajax({
                    url: '{{ route("admin.categories.bulk-delete") }}',
                    method: 'POST',
                    data: { ids: selectedIds },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            showNotification('Success', response.message, 'success');
                            table.ajax.reload();
                            $('.category-checkbox').prop('checked', false);
                            $('#selectAll').prop('checked', false);
                            updateBulkButtons();
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Failed to delete categories.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        showNotification('Error', errorMessage, 'error');
                    }
                });
            }
        );
    });
    
    // Handle delete button clicks
    $(document).on('click', '.delete-btn', function() {
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
                            table.ajax.reload();
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
    
    // Handle status toggle
    $(document).on('click', '.status-toggle', function() {
        const id = $(this).data('id');
        const currentStatus = $(this).data('status');
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        
        $.ajax({
            url: `/admin/categories/${id}/toggle-status`,
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: { status: newStatus },
            success: function(response) {
                if (response.success) {
                    showNotification('Success', response.message, 'success');
                    table.ajax.reload();
                }
            },
            error: function(xhr) {
                showNotification('Error', 'Failed to update status.', 'error');
            }
        });
    });
});
</script>
@endpush
