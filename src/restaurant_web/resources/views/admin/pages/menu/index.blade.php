@extends('admin.layout.app')

@section('content')
<div class="container">
    <h2>Menu Management</h2>
    <button class="btn btn-primary" id="addMenu">Add Menu Item</button>
    <table class="table" id="menuTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Add Menu Modal -->
<div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="menuModalLabel">Add Menu Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="menuForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="discount_price">Discount Price</label>
                        <input type="number" class="form-control" id="discount_price" name="discount_price" placeholder="Optional">
                    </div>
                    <div class="form-group">
                        <label for="image">Image URL</label>
                        <input type="text" class="form-control" id="image" name="image" placeholder="Optional">
                    </div>
                    <div class="form-group">
                        <label for="is_vegetarian">Vegetarian</label>
                        <select class="form-control" id="is_vegetarian" name="is_vegetarian">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="is_spicy">Spicy</label>
                        <select class="form-control" id="is_spicy" name="is_spicy">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="is_available">Available</label>
                        <select class="form-control" id="is_available" name="is_available">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ingredients">Ingredients (JSON format)</label>
                        <textarea class="form-control" id="ingredients" name="ingredients" placeholder='["ingredient1", "ingredient2"]'></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nutritional_info">Nutritional Info (JSON format)</label>
                        <textarea class="form-control" id="nutritional_info" name="nutritional_info" placeholder='{"calories": 200, "fat": 10}'></textarea>
                    </div>
                    <div class="form-group">
                        <label for="preparation_time">Preparation Time (in minutes)</label>
                        <input type="number" class="form-control" id="preparation_time" name="preparation_time" placeholder="Optional">
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
$(document).ready(function() {
    var table = $('#menuTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.menu.data') }}",
        columns: [
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'price', name: 'price' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    $('#addMenu').click(function() {
        $('#menuModal').modal('show');
        $('#menuForm')[0].reset();
        $('#menuModalLabel').text('Add Menu Item');
    });

    $('#menuForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('admin.menu.store') }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(data) {
                $('#menuModal').modal('hide');
                table.ajax.reload();
                alert('Menu item added successfully!');
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

    // Handle edit and delete actions here
});
</script>
@endpush