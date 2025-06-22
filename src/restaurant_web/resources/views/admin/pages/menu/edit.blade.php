@extends('admin.layout.app')

@section('title', 'Edit Menu Item')

@section('content')
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Edit Menu Item</h6>
        <ul class="d-flex align-items-center gap-2">
            <li class="fw-medium">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                    Dashboard
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">
                <a href="{{ route('admin.menu.index') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                    Menu Items
                </a>
            </li>
            <li>-</li>
            <li class="fw-medium">Edit</li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Edit Menu Item: {{ $menu->name }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data" data-ajax="true">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $menu->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
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

                        <div class="form-group mb-3">
                            <label for="snonym" class="form-label">Synonym</label>
                            <input type="text" class="form-control @error('snonym') is-invalid @enderror" 
                                   id="snonym" name="snonym" value="{{ old('snonym', $menu->snonym) }}">
                            @error('snonym')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3">{{ old('description', $menu->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                               id="price" name="price" value="{{ old('price', $menu->price) }}" 
                                               step="0.01" min="0" required>
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="discount_price" class="form-label">Discount Price</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control @error('discount_price') is-invalid @enderror" 
                                               id="discount_price" name="discount_price" value="{{ old('discount_price', $menu->discount_price) }}" 
                                               step="0.01" min="0">
                                    </div>
                                    @error('discount_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="preparation_time" class="form-label">Preparation Time (minutes)</label>
                                    <input type="number" class="form-control @error('preparation_time') is-invalid @enderror" 
                                           id="preparation_time" name="preparation_time" value="{{ old('preparation_time', $menu->preparation_time) }}" 
                                           min="0">
                                    @error('preparation_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="display_order" class="form-label">Display Order</label>
                                    <input type="number" class="form-control @error('display_order') is-invalid @enderror" 
                                           id="display_order" name="display_order" value="{{ old('display_order', $menu->display_order) }}" 
                                           min="0">
                                    @error('display_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="ingredients" class="form-label">Ingredients</label>
                            <textarea class="form-control @error('ingredients') is-invalid @enderror" 
                                      id="ingredients" name="ingredients" rows="3" 
                                      placeholder="Enter ingredients separated by commas">{{ old('ingredients', $menu->ingredients) }}</textarea>
                            @error('ingredients')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="nutritional_info" class="form-label">Nutritional Information</label>
                            <textarea class="form-control @error('nutritional_info') is-invalid @enderror" 
                                      id="nutritional_info" name="nutritional_info" rows="3" 
                                      placeholder="Enter nutritional information (e.g., Calories: 200, Fat: 10g)">{{ old('nutritional_info', $menu->nutritional_info) }}</textarea>
                            @error('nutritional_info')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="image" class="form-label">Menu Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Recommended size: 800x600px, Max size: 2MB</div>
                        </div>

                        @if($menu->image)
                            <div class="current-image mb-3">
                                <label class="form-label">Current Image</label>
                                <img src="{{ $menu->image }}" alt="Current Menu Image" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        @endif

                        <div class="image-preview mb-3" id="imagePreview" style="display: none;">
                            <label class="form-label">New Image Preview</label>
                            <img src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Features</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="is_vegetarian" 
                                           name="is_vegetarian" value="1" 
                                           {{ old('is_vegetarian', $menu->is_vegetarian) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_vegetarian">
                                        Vegetarian
                                    </label>
                                </div>
                                
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="is_spicy" 
                                           name="is_spicy" value="1" 
                                           {{ old('is_spicy', $menu->is_spicy) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_spicy">
                                        Spicy
                                    </label>
                                </div>
                                
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="is_available" 
                                           name="is_available" value="1" 
                                           {{ old('is_available', $menu->is_available) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_available">
                                        Available
                                    </label>
                                </div>
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_featured" 
                                           name="is_featured" value="1" 
                                           {{ old('is_featured', $menu->is_featured) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Featured Item
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.menu.index') }}" class="btn btn-secondary">
                        <i class="ri-arrow-left-line"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i> Update Menu Item
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script>
$(document).ready(function() {
    // Image preview
    $('#image').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview img').attr('src', e.target.result);
                $('#imagePreview').show();
            }
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').hide();
        }
    });

    // Auto-generate slug from name
    $('#name').on('input', function() {
        const name = $(this).val();
        if (name) {
            const slug = name.toLowerCase()
                .replace(/[^a-z0-9 -]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            $('#slug').val(slug);
        }
    });

    // Initialize select2 for category
    $('#category_id').select2({
        placeholder: 'Select Category',
        allowClear: true
    });
});
</script>
@endpush 