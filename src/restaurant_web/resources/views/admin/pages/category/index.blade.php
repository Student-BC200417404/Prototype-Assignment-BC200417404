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
            <li class="fw-medium">List</li>
        </ul>
    </div>


    <div class="card basic-data-table">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">List</h5>
                <a class="btn btn-primary" href="{{ route('admin.categories.create') }}">Add Category</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table bordered-table mb-0" id="categoryTable" data-page-length='10'>
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Image</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated by DataTables -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="categoryForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Image URL</label>
                        <input type="text" class="form-control" id="image" name="image" placeholder="Optional">
                    </div>
                    <div class="form-group">
                        <label for="display_order">Display Order</label>
                        <input type="number" class="form-control" id="display_order" name="display_order"
                            placeholder="Optional">
                    </div>
                    <div class="form-group">
                        <label for="is_active">Active</label>
                        <select class="form-control" id="is_active" name="is_active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editCategoryForm">
                <div class="modal-body">
                    <input type="hidden" id="editCategoryId" name="id">
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="editDescription">Description</label>
                        <textarea class="form-control" id="editDescription" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editImage">Image URL</label>
                        <input type="text" class="form-control" id="editImage" name="image" placeholder="Optional">
                    </div>
                    <div class="form-group">
                        <label for="editDisplayOrder">Display Order</label>
                        <input type="number" class="form-control" id="editDisplayOrder" name="display_order" placeholder="Optional">
                    </div>
                    <div class="form-group">
                        <label for="editIsActive">Active</label>
                        <select class="form-control" id="editIsActive" name="is_active">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

@endsection

@push('custom-scripts')
<script>
    $(document).ready(function () {
        // Initialize DataTable with server-side processing and fixed header
        var table = $('#categoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.categories.data') }}", // Ensure this route is correct
                type: 'GET',
                dataType: 'json'
            },
            columns: [
                { data: 'name', name: 'name' },
                { data: 'image', name: 'image' },
                { 
                    data: 'action', 
                    name: 'action', 
                    orderable: false, 
                    searchable: false,
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-sm btn-primary edit-category" data-id="${row.id}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-category" data-id="${row.id}">Delete</button>
                        `;
                    }
                }
            ],
            fixedHeader: true // Enable fixed header
        });

        $('#categoryForm').on('submit', function (e) {
            e.preventDefault();
            // Add your AJAX call to save the category here
        });

        // Handle edit button click
        $(document).on('click', '.edit-category', function() {
            console.log('Edit button clicked'); // Debug log
            const categoryId = $(this).data('id');
            // Fetch category data and populate the modal
            $.ajax({
                url: `/admin/categories/${categoryId}/edit`,
                type: 'GET',
                success: function(data) {
                    $('#editCategoryId').val(data.id);
                    $('#editName').val(data.name);
                    $('#editDescription').val(data.description);
                    $('#editImage').val(data.image);
                    $('#editDisplayOrder').val(data.display_order);
                    $('#editIsActive').val(data.is_active);
                    $('#editCategoryModal').modal('show');
                }
            });
        });

        // Handle edit form submission
        $('#editCategoryForm').on('submit', function(e) {
            e.preventDefault();
            const categoryId = $('#editCategoryId').val();
            $.ajax({
                url: `/admin/categories/${categoryId}`,
                type: 'PUT',
                data: $(this).serialize(),
                success: function(data) {
                    $('#editCategoryModal').modal('hide');
                    table.ajax.reload(); // Reload the DataTable
                    Swal.fire({
                        title: 'Success!',
                        text: 'Category updated successfully.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        // Handle delete button click
        $(document).on('click', '.delete-category', function() {
            console.log('Delete button clicked'); // Debug log
            const categoryId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/categories/${categoryId}`,
                        type: 'DELETE',
                        success: function(data) {
                            table.ajax.reload(); // Reload the DataTable
                            Swal.fire(
                                'Deleted!',
                                'Your category has been deleted.',
                                'success'
                            );
                        },
                        error: function(xhr) {
                            const response = xhr.responseJSON;
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
