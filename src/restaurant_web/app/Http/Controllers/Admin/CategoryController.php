<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.pages.category.index');
    }
    public function create(){
        return view('admin.pages.category.create');
    }
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::query();

            return DataTables::of($categories)
                ->addColumn('action', function ($category) {
                    return '<button class="btn btn-warning edit" data-id="' . $category->id . '">Edit</button>
                            <button class="btn btn-danger delete" data-id="' . $category->id . '">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|unique:categories|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'display_order' => 'nullable|integer',
                'is_active' => 'required|boolean',
            ]);

            $slug = $this->generateUniqueSlug($request->name);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('categories', 'public');
            }
            
            $category = Category::create(array_merge($request->all(), ['slug' => $slug, 'image' => $imagePath]));
            return $this->success('Category created successfully.', $category, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return $this->error($e->getMessage(), 422); // Use 422 for validation errors
        } catch (\Exception $e) {
            $this->logError($e, $request);
            return $this->error($e->getMessage(), 500);
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

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());
        return response()->json(['success' => true, 'message' => 'Category updated successfully.']);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }
} 