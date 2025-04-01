<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu; // Assuming you have a Menu model
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    public function index()
    {
        return view('admin.pages.menu.index');
    }

    public function getData()
    {
        $menus = Menu::query();
        return DataTables::of($menus)
            ->addColumn('action', function ($menu) {
                return '<button class="btn btn-warning edit" data-id="' . $menu->id . '">Edit</button>
                        <button class="btn btn-danger delete" data-id="' . $menu->id . '">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.pages.menu.create');
    }

    public function store(Request $request)
    {
        $menu = Menu::create($request->all());
        return response()->json($menu);
    }

    public function edit($id)
    {
        return view('admin.pages.menu.edit');
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $menu->update($request->all());
        return response()->json($menu);
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete(); // Soft delete
        return response()->json(['success' => 'Menu item deleted successfully.']);
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