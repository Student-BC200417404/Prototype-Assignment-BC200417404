@extends('admin.layout.app')
@section('title', 'Users')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Users Management</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Users</li>
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
                                <h4 class="card-title mb-0">All Users</h4>
                            </div>
                            <div class="col-md-6 text-end">
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                    <i class="ri-add-line align-middle me-1"></i>
                                    Add New User
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <div class="row mb-3">
                            <div class="col-md-3">
                                <select class="form-select" id="role-filter">
                                    <option value="">All Roles</option>
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                    <option value="staff">Staff</option>
                                    <option value="customer">Customer</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" id="status-filter">
                                    <option value="">All Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control" id="date-filter" placeholder="Registration Date">
                            </div>
                            <div class="col-md-3 text-end">
                                <button type="button" class="btn btn-outline-danger" id="bulk-delete-btn" style="display: none;">
                                    <i class="ri-delete-bin-line align-middle me-1"></i>
                                    Delete Selected
                                </button>
                            </div>
                        </div>

                        <!-- DataTable -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="users-table">
                                <thead>
                                    <tr>
                                        <th width="30">
                                            <input type="checkbox" class="form-check-input" id="select-all">
                                        </th>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Last Login</th>
                                        <th>Status</th>
                                        <th>Registered</th>
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
                <p>Are you sure you want to delete this user? This action cannot be undone.</p>
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
    // Initialize DataTable
    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("admin.users.data") }}',
            data: function(d) {
                d.role_filter = $('#role-filter').val();
                d.status_filter = $('#status-filter').val();
                d.date_filter = $('#date-filter').val();
            }
        },
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'role', name: 'role'},
            {data: 'last_login', name: 'last_login'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false}
        ],
        order: [[1, 'desc']],
        pageLength: 25,
        responsive: true,
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries per page",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>'
        }
    });

    // Filters
    $('#role-filter, #status-filter').on('change', function() {
        table.draw();
    });

    $('#date-filter').on('change', function() {
        table.draw();
    });

    // Select all checkbox
    $('#select-all').on('change', function() {
        $('.row-checkbox').prop('checked', $(this).prop('checked'));
        updateBulkDeleteButton();
    });

    // Individual row checkbox
    $(document).on('change', '.row-checkbox', function() {
        updateBulkDeleteButton();
        updateSelectAllCheckbox();
    });

    // Update bulk delete button visibility
    function updateBulkDeleteButton() {
        var checkedCount = $('.row-checkbox:checked').length;
        if (checkedCount > 0) {
            $('#bulk-delete-btn').show().text('Delete Selected (' + checkedCount + ')');
        } else {
            $('#bulk-delete-btn').hide();
        }
    }

    // Update select all checkbox
    function updateSelectAllCheckbox() {
        var totalCheckboxes = $('.row-checkbox').length;
        var checkedCheckboxes = $('.row-checkbox:checked').length;
        
        if (checkedCheckboxes === 0) {
            $('#select-all').prop('indeterminate', false).prop('checked', false);
        } else if (checkedCheckboxes === totalCheckboxes) {
            $('#select-all').prop('indeterminate', false).prop('checked', true);
        } else {
            $('#select-all').prop('indeterminate', true);
        }
    }

    // Bulk delete
    $('#bulk-delete-btn').on('click', function() {
        var selectedIds = [];
        $('.row-checkbox:checked').each(function() {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            Swal.fire('Warning', 'Please select at least one user to delete.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete ' + selectedIds.length + ' user(s). This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("admin.users.bulk-delete") }}',
                    type: 'POST',
                    data: {
                        ids: selectedIds,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Deleted!', response.message, 'success');
                            table.draw();
                            $('#select-all').prop('checked', false);
                            updateBulkDeleteButton();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'An error occurred while deleting users.', 'error');
                    }
                });
            }
        });
    });

    // Individual delete
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var name = $(this).data('name');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete user "' + name + '". This action cannot be undone!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/admin/users/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Deleted!', response.message, 'success');
                            table.draw();
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'An error occurred while deleting the user.', 'error');
                    }
                });
            }
        });
    });

    // Toggle status
    $(document).on('click', '.toggle-status', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var currentStatus = $(this).data('status');

        $.ajax({
            url: '/admin/users/' + id + '/toggle-status',
            type: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire('Success!', response.message, 'success');
                    table.draw();
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'An error occurred while updating status.', 'error');
            }
        });
    });
});
</script>
@endpush 