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
    /**
     * Log error
     */
    private function logError($error, $context = [])
    {
        Log::error($error->getMessage(), [
            'file' => $error->getFile(),
            'line' => $error->getLine(),
            'trace' => $error->getTraceAsString(),
            'context' => $context
        ]);
    }

    public function index()
    {
        try {
            $categories = Category::all();
            return view('admin.pages.menu.index', compact('categories'));
        } catch (\Exception $e) {
            $this->logError($e, request());
            return redirect()->back()->with('error', 'Failed to load menu items.');
        }
    }

    public function getData()
    {
        try {
            $menus = Menu::with('category')->select('menus.*');
            
            return datatables()->of($menus)
                ->addColumn('action', function ($menu) {
                    return '';
                })
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            $this->logError($e, request());
            return $this->error('Failed to fetch menu data.');
        }
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.pages.menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
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

            $menu = new Menu();
            $menu->fill($request->all());

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/menu', $filename);
                $menu->image = Storage::url($path);
            }

            $menu->save();

            return $this->success('Menu item created successfully.', $menu);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Exception $e) {
            $this->logError($e, request());
            return $this->error('Failed to create menu item.');
        }
    }

    public function edit(Menu $menu)
    {
        try {
            $categories = Category::all();
            return view('admin.pages.menu.edit', compact('menu', 'categories'));
        } catch (\Exception $e) {
            $this->logError($e, request());
            return redirect()->back()->with('error', 'Failed to load menu item.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:menus,name,' . $id,
                'category_id' => 'required|exists:categories,id',
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
            $menu->fill($request->all());

            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($menu->image) {
                    $oldImage = str_replace('/storage', 'public', $menu->image);
                    Storage::delete($oldImage);
                }

                $image = $request->file('image');
                $filename = time() . '_' . Str::slug($request->name) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('public/menu', $filename);
                $menu->image = Storage::url($path);
            }

            $menu->save();

            return $this->success('Menu item updated successfully.', $menu);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->error('Validation failed', 422, $e->errors());
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error('Menu item not found.', 404);
        } catch (\Exception $e) {
            $this->logError($e, request());
            return $this->error('Failed to update menu item.');
        }
    }

    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);

            if ($menu->image) {
                $oldImage = str_replace('/storage', 'public', $menu->image);
                Storage::delete($oldImage);
            }

            $menu->delete();

            return $this->success('Menu item deleted successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->error('Menu item not found.', 404);
        } catch (\Exception $e) {
            $this->logError($e, request());
            return $this->error('Failed to delete menu item.');
        }
    }

    public function show($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            return view('admin.pages.menu.show', compact('menu'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('admin.menu.index')->with('error', 'Menu item not found.');
        }
    }
} 