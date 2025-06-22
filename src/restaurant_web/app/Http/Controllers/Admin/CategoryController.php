<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            return view('admin.pages.crud.category.index');
        } catch (\Exception $e) {
            $this->logError($e, request());
            return redirect()->back()->with('error', 'Failed to load categories.');
        }
    }

    public function getData()
    {
        try {
            $categories = Category::withCount('menus')->select('categories.*');
            
            return DataTables::of($categories)
                ->addColumn('image_preview', function ($category) {
                    if ($category->image) {
                        return '<img src="' . asset('storage/' . $category->image) . '" alt="Category Image" class="img-thumbnail" style="max-height: 50px;">';
                    }
                    return '<span class="text-muted">No Image</span>';
                })
                ->addColumn('status', function ($category) {
                    if ($category->is_active) {
                        return '<span class="badge bg-success">Active</span>';
                    }
                    return '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('menus_count', function ($category) {
                    return $category->menus_count ?? 0;
                })
                ->addColumn('created_at_formatted', function ($category) {
                    return $category->created_at->format('M d, Y');
                })
                ->addColumn('action', function ($category) {
                    return '<div class="btn-group" role="group">
                                <a href="' . route('admin.categories.show', $category->id) . '" class="btn btn-sm btn-info" title="View">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a href="' . route('admin.categories.edit', $category->id) . '" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="ri-edit-line"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger delete-btn" 
                                        data-id="' . $category->id . '" data-name="' . $category->name . '" title="Delete">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>';
                })
                ->rawColumns(['image_preview', 'status', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            $this->logError($e, request());
            return $this->error('Failed to fetch categories data.', 500);
        }
    }

    public function create()
    {
        try {
            return view('admin.pages.crud.category.create');
        } catch (\Exception $e) {
            $this->logError($e, request());
            return redirect()->back()->with('error', 'Failed to load create form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name',
                'snonym' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'display_order' => 'nullable|integer|min:0|max:999',
                'is_active' => 'boolean'
            ]);

            $data = $validated;
            $data['slug'] = $this->generateUniqueSlug($request->name);
            $data['is_active'] = $request->has('is_active');

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/categories', $filename);
                $data['image'] = str_replace('public/', '', $path);
            }

            $category = Category::create($data);

            if ($request->ajax()) {
                return $this->success('Category created successfully!', null, 201);
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return $this->error('Validation failed.', 422, $e->errors());
            }
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            $this->logError($e, request());
            if ($request->ajax()) {
                return $this->error('Failed to create category. Please try again.', 500);
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create category. Please try again.');
        }
    }

    public function show($id)
    {
        try {
            $category = Category::withCount('menus')->findOrFail($id);
            return view('admin.pages.crud.category.show', compact('category'));
        } catch (\Exception $e) {
            $this->logError($e, request());
            return redirect()->route('admin.categories.index')
                ->with('error', 'Category not found.');
        }
    }

    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
            return view('admin.pages.crud.category.edit', compact('category'));
        } catch (\Exception $e) {
            $this->logError($e, request());
            return redirect()->route('admin.categories.index')
                ->with('error', 'Category not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($id)],
                'snonym' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'display_order' => 'nullable|integer|min:0|max:999',
                'is_active' => 'boolean'
            ]);

            $data = $validated;
            $data['is_active'] = $request->has('is_active');

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($category->image) {
                    Storage::delete('public/' . $category->image);
                }

                $image = $request->file('image');
                $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/categories', $filename);
                $data['image'] = str_replace('public/', '', $path);
            }

            $category->update($data);

            if ($request->ajax()) {
                return $this->success('Category updated successfully!');
            }

            return redirect()->route('admin.categories.index')
                ->with('success', 'Category updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return $this->error('Validation failed.', 422, $e->errors());
            }
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            $this->logError($e, request());
            if ($request->ajax()) {
                return $this->error('Failed to update category. Please try again.', 500);
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update category. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            // Check if category has associated menu items
            if ($category->menus()->count() > 0) {
                return $this->error('Cannot delete category. It has associated menu items.', 422);
            }

            // Delete image if exists
            if ($category->image) {
                Storage::delete('public/' . $category->image);
            }

            $category->delete();

            return $this->success('Category deleted successfully!');

        } catch (\Exception $e) {
            $this->logError($e, request());
            return $this->error('Failed to delete category. Please try again.', 500);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update(['is_active' => !$category->is_active]);

            return $this->success('Category status updated successfully!', ['new_status' => $category->is_active]);
        } catch (\Exception $e) {
            $this->logError($e, request());
            return $this->error('Failed to update status.', 500);
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:categories,id'
            ]);

            $categories = Category::whereIn('id', $request->ids);
            
            // Check for dependencies
            $categoriesWithMenus = $categories->whereHas('menus')->count();
            if ($categoriesWithMenus > 0) {
                return $this->error('Some categories have associated menu items and cannot be deleted.', 422);
            }

            // Delete images
            $categories->get()->each(function ($category) {
                if ($category->image) {
                    Storage::delete('public/' . $category->image);
                }
            });

            $deleted = $categories->delete();

            return $this->success("Successfully deleted {$deleted} categories.");

        } catch (\Exception $e) {
            $this->logError($e, request());
            return $this->error('Failed to delete categories.', 500);
        }
    }

    public function bulkStatus(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array|min:1',
                'ids.*' => 'integer|exists:categories,id',
                'status' => 'required|boolean'
            ]);

            $updated = Category::whereIn('id', $request->ids)
                ->update(['is_active' => $request->status]);

            return $this->success("Successfully updated {$updated} categories.");

        } catch (\Exception $e) {
            $this->logError($e, request());
            return $this->error('Failed to update categories.', 500);
        }
    }

    public function checkName(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255'
            ]);

            $exists = Category::where('name', $request->name)->exists();

            return $this->success('Name check completed.', [
                'exists' => $exists,
                'message' => $exists ? 'Category name already exists.' : 'Category name is available.'
            ]);
        } catch (\Exception $e) {
            $this->logError($e, request());
            return $this->error('Error checking category name.', 500);
        }
    }

    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $uniqueSlug = $slug;
        $count = 1;

        while (Category::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $slug . '-' . $count;
            $count++;
        }

        return $uniqueSlug;
    }
} 