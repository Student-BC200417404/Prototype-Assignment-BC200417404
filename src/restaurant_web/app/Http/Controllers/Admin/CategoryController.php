<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'display_order' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ]);

        try {
            $category = Category::create($request->all());
            return $this->success('Category created successfully.', $category, 201);
        } catch (\Exception $e) {
            $this->logError($e, $request); // Log the error
            return $this->error('Failed to create category.', 500);
        }
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'display_order' => 'nullable|integer',
            'is_active' => 'required|boolean',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());
        return response()->json($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete(); // Soft delete
        return response()->json(['success' => 'Category deleted successfully.']);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }
} 