@extends('admin.layout.app')

@section('title', 'Reservations Management')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Reservations</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Reservations</li>
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

    <!-- Reservation Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Reservations</h6>
                            <h3 class="mb-0">{{ $totalReservations ?? 0 }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-calendar-line" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Pending Reservations</h6>
                            <h3 class="mb-0">{{ $pendingReservations ?? 0 }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-time-line" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Confirmed Reservations</h6>
                            <h3 class="mb-0">{{ $confirmedReservations ?? 0 }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-check-double-line" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Today's Reservations</h6>
                            <h3 class="mb-0">{{ $todayReservations ?? 0 }}</h3>
                        </div>
                        <div class="align-self-center">
                            <i class="ri-calendar-todo-line" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card basic-data-table">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">All Reservations</h5>
                <div class="d-flex gap-2">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.reservations.index') }}" 
                           class="btn btn-sm {{ request()->routeIs('admin.reservations.index') ? 'btn-primary' : 'btn-outline-primary' }}">
                            All Reservations
                        </a>
                        <a href="{{ route('admin.reservations.pending') }}" 
                           class="btn btn-sm {{ request()->routeIs('admin.reservations.pending') ? 'btn-primary' : 'btn-outline-primary' }}">
                            Pending
                        </a>
                        <a href="{{ route('admin.reservations.completed') }}" 
                           class="btn btn-sm {{ request()->routeIs('admin.reservations.completed') ? 'btn-primary' : 'btn-outline-primary' }}">
                            Completed
                        </a>
                    </div>
                    <button type="button" class="btn btn-warning btn-sm" id="bulkStatusBtn" style="display: none;">
                        <i class="ri-settings-line"></i> Bulk Status
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn" style="display: none;">
                        <i class="ri-delete-bin-line"></i> Bulk Delete
                    </button>
                    <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary btn-sm">
                        <i class="ri-add-line"></i> Add Reservation
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped datatable" data-url="{{ route('admin.reservations.data') }}">
                    <thead>
                        <tr>
                            <th width="50">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Date & Time</th>
                            <th>Guests</th>
                            <th>Table</th>
                            <th>Status</th>
                            <th>Special Requests</th>
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
                <h5 class="modal-title" id="bulkStatusModalLabel">Update Reservation Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Update status for <span id="selectedCount">0</span> selected reservations:</p>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="bulkStatus" id="statusPending" value="pending">
                    <label class="form-check-label" for="statusPending">
                        Pending
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="bulkStatus" id="statusConfirmed" value="confirmed">
                    <label class="form-check-label" for="statusConfirmed">
                        Confirmed
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="bulkStatus" id="statusCompleted" value="completed">
                    <label class="form-check-label" for="statusCompleted">
                        Completed
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="bulkStatus" id="statusCancelled" value="cancelled">
                    <label class="form-check-label" for="statusCancelled">
                        Cancelled
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
                                <input class="form-check-input reservation-checkbox" type="checkbox" value="${row.id}">
                            </div>`;
                }
            },
            {data: 'id', name: 'id'},
            {data: 'customer_name', name: 'customer.name'},
            {
                data: 'reservation_datetime', 
                name: 'reservation_datetime',
                render: function(data, type, row) {
                    return moment(data).format('MMM DD, YYYY h:mm A');
                }
            },
            {data: 'guests_count', name: 'guests_count'},
            {data: 'table_name', name: 'table.name'},
            {data: 'status', name: 'status'},
            {
                data: 'special_requests', 
                name: 'special_requests',
                render: function(data, type, row) {
                    if (data && data.length > 50) {
                        return data.substring(0, 50) + '...';
                    }
                    return data || 'N/A';
                }
            },
            {
                data: 'created_at', 
                name: 'created_at',
                render: function(data, type, row) {
                    return moment(data).format('MMM DD, YYYY');
                }
            },
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
            search: "Search reservations:",
            lengthMenu: "Show _MENU_ reservations per page",
            info: "Showing _START_ to _END_ of _TOTAL_ reservations",
            infoEmpty: "Showing 0 to 0 of 0 reservations",
            infoFiltered: "(filtered from _MAX_ total reservations)",
            processing: "Loading reservations...",
            emptyTable: "No reservations found",
            zeroRecords: "No matching reservations found"
        }
    });
    
    // Handle select all checkbox
    $('#selectAll').on('change', function() {
        $('.reservation-checkbox').prop('checked', this.checked);
        updateBulkButtons();
    });
    
    // Handle individual checkboxes
    $(document).on('change', '.reservation-checkbox', function() {
        updateBulkButtons();
        
        // Update select all checkbox
        const totalCheckboxes = $('.reservation-checkbox').length;
        const checkedCheckboxes = $('.reservation-checkbox:checked').length;
        
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
        const selectedCount = $('.reservation-checkbox:checked').length;
        
        if (selectedCount > 0) {
            $('#bulkStatusBtn, #bulkDeleteBtn').show();
            $('#selectedCount').text(selectedCount);
        } else {
            $('#bulkStatusBtn, #bulkDeleteBtn').hide();
        }
    }
    
    // Bulk status update
    $('#bulkStatusBtn').on('click', function() {
        const selectedIds = $('.reservation-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        
        if (selectedIds.length === 0) {
            Swal.fire('Warning', 'Please select at least one reservation.', 'warning');
            return;
        }
        
        $('#bulkStatusModal').modal('show');
    });
    
    $('#confirmBulkStatus').on('click', function() {
        const selectedIds = $('.reservation-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        
        const status = $('input[name="bulkStatus"]:checked').val();
        
        if (!status) {
            Swal.fire('Warning', 'Please select a status.', 'warning');
            return;
        }
        
        $.ajax({
            url: '{{ route("admin.reservations.bulk-status") }}',
            method: 'POST',
            data: {
                ids: selectedIds,
                status: status
            },
            success: function(response) {
                $('#bulkStatusModal').modal('hide');
                $('.reservation-checkbox').prop('checked', false);
                $('#selectAll').prop('checked', false);
                updateBulkButtons();
                table.ajax.reload();
                
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
        const selectedIds = $('.reservation-checkbox:checked').map(function() {
            return $(this).val();
        }).get();
        
        if (selectedIds.length === 0) {
            Swal.fire('Warning', 'Please select at least one reservation.', 'warning');
            return;
        }
        
        Swal.fire({
            title: 'Are you sure?',
            text: `You want to delete ${selectedIds.length} reservation(s)? This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete them!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.reservations.bulk-delete") }}',
                    method: 'POST',
                    data: {
                        ids: selectedIds
                    },
                    success: function(response) {
                        $('.reservation-checkbox').prop('checked', false);
                        $('#selectAll').prop('checked', false);
                        updateBulkButtons();
                        table.ajax.reload();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message || 'Reservations deleted successfully!',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Failed to delete reservations. Please try again.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush 