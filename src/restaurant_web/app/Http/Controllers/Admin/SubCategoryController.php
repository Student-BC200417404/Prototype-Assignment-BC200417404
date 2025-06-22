<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->getData($request);
            }
            
            $categories = Category::where('is_active', 1)->get();
            return view('admin.pages.subcategory.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Failed to load subcategories: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load subcategories.');
        }
    }

    public function getData(Request $request)
    {
        try {
            $query = SubCategory::with('category');

            // Apply filters
            if ($request->filled('category_filter')) {
                $query->where('category_id', $request->category_filter);
            }

            if ($request->filled('status_filter')) {
                $query->where('is_active', $request->status_filter);
            }

            return DataTables::of($query)
                ->addColumn('checkbox', function ($subcategory) {
                    return '<input type="checkbox" class="form-check-input row-checkbox" value="' . $subcategory->id . '">';
                })
                ->addColumn('category_name', function ($subcategory) {
                    return $subcategory->category ? $subcategory->category->name : 'N/A';
                })
                ->addColumn('status', function ($subcategory) {
                    $statusClass = $subcategory->is_active ? 'success' : 'danger';
                    $statusText = $subcategory->is_active ? 'Active' : 'Inactive';
                    return '<span class="badge bg-' . $statusClass . '">' . $statusText . '</span>';
                })
                ->addColumn('actions', function ($subcategory) {
                    $actions = '<div class="btn-group" role="group">';
                    $actions .= '<a href="' . route('admin.subcategories.show', $subcategory->id) . '" class="btn btn-sm btn-info" title="View"><i class="ri-eye-line"></i></a>';
                    $actions .= '<a href="' . route('admin.subcategories.edit', $subcategory->id) . '" class="btn btn-sm btn-primary" title="Edit"><i class="ri-edit-line"></i></a>';
                    $actions .= '<button type="button" class="btn btn-sm btn-warning toggle-status" data-id="' . $subcategory->id . '" data-status="' . $subcategory->is_active . '" title="Toggle Status"><i class="ri-toggle-line"></i></button>';
                    $actions .= '<button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $subcategory->id . '" data-name="' . $subcategory->name . '" title="Delete"><i class="ri-delete-bin-line"></i></button>';
                    $actions .= '</div>';
                    return $actions;
                })
                ->editColumn('description', function ($subcategory) {
                    return Str::limit($subcategory->description, 50);
                })
                ->editColumn('created_at', function ($subcategory) {
                    return $subcategory->created_at->format('M d, Y H:i');
                })
                ->rawColumns(['checkbox', 'status', 'actions'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Failed to get subcategories data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load data'], 500);
        }
    }

    public function create()
    {
        try {
            $categories = Category::where('is_active', 1)->get();
            return view('admin.pages.subcategory.create', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Failed to load create form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load create form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:sub_categories,name',
                'description' => 'nullable|string|max:1000',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'display_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean'
            ]);

            $data = $validated;
            $data['slug'] = Str::slug($request->name);
            $data['is_active'] = $request->has('is_active');

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/subcategories', $imageName);
                $data['image'] = $imageName;
            }

            SubCategory::create($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'SubCategory created successfully!'
                ]);
            }

            return redirect()->route('admin.subcategories.index')
                ->with('success', 'SubCategory created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            Log::error('Failed to create subcategory: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create subcategory. Please try again.'
                ], 500);
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create subcategory. Please try again.');
        }
    }

    public function show($id)
    {
        try {
            $subcategory = SubCategory::with('category')->findOrFail($id);
            return view('admin.pages.subcategory.show', compact('subcategory'));
        } catch (\Exception $e) {
            Log::error('Failed to load subcategory: ' . $e->getMessage());
            return redirect()->route('admin.subcategories.index')
                ->with('error', 'SubCategory not found.');
        }
    }

    public function edit($id)
    {
        try {
            $subcategory = SubCategory::findOrFail($id);
            $categories = Category::where('is_active', 1)->get();
            return view('admin.pages.subcategory.edit', compact('subcategory', 'categories'));
        } catch (\Exception $e) {
            Log::error('Failed to load edit form: ' . $e->getMessage());
            return redirect()->route('admin.subcategories.index')
                ->with('error', 'SubCategory not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $subcategory = SubCategory::findOrFail($id);
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255', Rule::unique('sub_categories')->ignore($id)],
                'description' => 'nullable|string|max:1000',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'display_order' => 'nullable|integer|min:0',
                'is_active' => 'boolean'
            ]);

            $data = $validated;
            $data['slug'] = Str::slug($request->name);
            $data['is_active'] = $request->has('is_active');

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($subcategory->image) {
                    Storage::delete('public/subcategories/' . $subcategory->image);
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/subcategories', $imageName);
                $data['image'] = $imageName;
            }

            $subcategory->update($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'SubCategory updated successfully!'
                ]);
            }

            return redirect()->route('admin.subcategories.index')
                ->with('success', 'SubCategory updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            Log::error('Failed to update subcategory: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update subcategory. Please try again.'
                ], 500);
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update subcategory. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $subcategory = SubCategory::findOrFail($id);
            
            // Delete image if exists
            if ($subcategory->image) {
                Storage::delete('public/subcategories/' . $subcategory->image);
            }
            
            $subcategory->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'SubCategory deleted successfully!'
                ]);
            }

            return redirect()->route('admin.subcategories.index')
                ->with('success', 'SubCategory deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to delete subcategory: ' . $e->getMessage());
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete subcategory.'
                ], 500);
            }
            return redirect()->route('admin.subcategories.index')
                ->with('error', 'Failed to delete subcategory.');
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:sub_categories,id'
            ]);

            $subcategories = SubCategory::whereIn('id', $request->ids)->get();
            
            foreach ($subcategories as $subcategory) {
                if ($subcategory->image) {
                    Storage::delete('public/subcategories/' . $subcategory->image);
                }
                $subcategory->delete();
            }

            return response()->json([
                'success' => true,
                'message' => count($request->ids) . ' subcategory(ies) deleted successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to bulk delete subcategories: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete subcategories.'
            ], 500);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $subcategory = SubCategory::findOrFail($id);
            $subcategory->update(['is_active' => !$subcategory->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'new_status' => $subcategory->is_active
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to toggle subcategory status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.'
            ], 500);
        }
    }

    public function checkName(Request $request)
    {
        $name = $request->input('name');
        $excludeId = $request->input('exclude_id');
        $query = \App\Models\SubCategory::where('name', $name);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        $exists = $query->exists();
        return response()->json(['available' => !$exists]);
    }
} 