<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            return view('admin.pages.menu.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Failed to load menu items: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load menu items.');
        }
    }

    public function getData()
    {
        try {
            $menus = Menu::with('category')->select('menus.*');
            
            return DataTables::of($menus)
                ->addColumn('checkbox', function ($menu) {
                    return '<input type="checkbox" class="menu-checkbox" value="' . $menu->id . '">';
                })
                ->addColumn('category_name', function ($menu) {
                    return $menu->category ? $menu->category->name : 'N/A';
                })
                ->addColumn('price_formatted', function ($menu) {
                    return '$' . number_format($menu->price, 2);
                })
                ->addColumn('status', function ($menu) {
                    if (!$menu->is_available) {
                        return '<span class="badge bg-danger">Unavailable</span>';
                    }
                    return '<span class="badge bg-success">Available</span>';
                })
                ->addColumn('features', function ($menu) {
                    $features = [];
                    if ($menu->is_vegetarian) $features[] = '<span class="badge bg-success">Vegetarian</span>';
                    if ($menu->is_spicy) $features[] = '<span class="badge bg-warning">Spicy</span>';
                    return implode(' ', $features);
                })
                ->addColumn('action', function ($menu) {
                    return '<div class="btn-group" role="group">
                                <a href="' . route('admin.menu.edit', $menu->id) . '" class="btn btn-sm btn-warning">
                                    <i class="ri-edit-line"></i> Edit
                                </a>
                                <a href="' . route('admin.menu.show', $menu->id) . '" class="btn btn-sm btn-info">
                                    <i class="ri-eye-line"></i> View
                                </a>
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $menu->id . '">
                                    <i class="ri-delete-bin-line"></i> Delete
                                </button>
                            </div>';
                })
                ->rawColumns(['checkbox', 'status', 'features', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Failed to fetch menu data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch menu data.'], 500);
        }
    }

    public function create()
    {
        try {
            $categories = Category::where('is_active', true)->get();
            return view('admin.pages.menu.create', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Failed to load create form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load create form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'snonym' => 'nullable|string',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_vegetarian' => 'boolean',
                'is_spicy' => 'boolean',
                'is_available' => 'boolean',
                'ingredients' => 'nullable|array',
                'nutritional_info' => 'nullable|array',
                'preparation_time' => 'nullable|integer|min:0'
            ]);

            $data = $request->all();
            $data['slug'] = $this->generateUniqueSlug($request->name);
            $data['is_vegetarian'] = $request->has('is_vegetarian');
            $data['is_spicy'] = $request->has('is_spicy');
            $data['is_available'] = $request->has('is_available');

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/menu', $filename);
                $data['image'] = Storage::url($path);
            }

            Menu::create($data);

            return redirect()->route('admin.menu.index')
                ->with('success', 'Menu item created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            Log::error('Failed to create menu item: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create menu item. Please try again.');
        }
    }

    public function show($id)
    {
        try {
            $menu = Menu::with('category')->findOrFail($id);
            return view('admin.pages.menu.show', compact('menu'));
        } catch (\Exception $e) {
            return redirect()->route('admin.menu.index')
                ->with('error', 'Menu item not found.');
        }
    }

    public function edit($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            $categories = Category::where('is_active', true)->get();
            return view('admin.pages.menu.edit', compact('menu', 'categories'));
        } catch (\Exception $e) {
            return redirect()->route('admin.menu.index')
                ->with('error', 'Menu item not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:menus,name,' . $id,
                'category_id' => 'required|exists:categories,id',
                'snonym' => 'nullable|string',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'is_vegetarian' => 'boolean',
                'is_spicy' => 'boolean',
                'is_available' => 'boolean',
                'ingredients' => 'nullable|array',
                'nutritional_info' => 'nullable|array',
                'preparation_time' => 'nullable|integer|min:0'
            ]);

            $menu = Menu::findOrFail($id);
            $data = $request->all();
            $data['is_vegetarian'] = $request->has('is_vegetarian');
            $data['is_spicy'] = $request->has('is_spicy');
            $data['is_available'] = $request->has('is_available');

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($menu->image) {
                    $oldImage = str_replace('/storage', 'public', $menu->image);
                    Storage::delete($oldImage);
                }

                $image = $request->file('image');
                $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/menu', $filename);
                $data['image'] = Storage::url($path);
            }

            $menu->update($data);

            return redirect()->route('admin.menu.index')
                ->with('success', 'Menu item updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            Log::error('Failed to update menu item: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update menu item. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);

            // Check if menu has associated order details
            if ($menu->orderDetails()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete menu item. It has associated orders.'
                ], 422);
            }

            // Delete image if exists
            if ($menu->image) {
                $oldImage = str_replace('/storage', 'public', $menu->image);
                Storage::delete($oldImage);
            }

            $menu->delete();

            return response()->json([
                'success' => true,
                'message' => 'Menu item deleted successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to delete menu item: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete menu item. Please try again.'
            ], 500);
        }
    }

    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $uniqueSlug = $slug;
        $count = 1;

        while (Menu::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $slug . '-' . $count;
            $count++;
        }

        return $uniqueSlug;
    }
} 