<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class TableController extends Controller
{
    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                return $this->getData($request);
            }
            
            return view('admin.pages.table.index');
        } catch (\Exception $e) {
            Log::error('Failed to load tables: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load tables.');
        }
    }

    public function getData(Request $request)
    {
        try {
            $query = Table::query();

            // Apply filters
            if ($request->filled('capacity_filter')) {
                $query->where('capacity', $request->capacity_filter);
            }

            if ($request->filled('status_filter')) {
                $query->where('is_active', $request->status_filter);
            }

            if ($request->filled('location_filter')) {
                $query->where('location', $request->location_filter);
            }

            return DataTables::of($query)
                ->addColumn('checkbox', function ($table) {
                    return '<input type="checkbox" class="form-check-input row-checkbox" value="' . $table->id . '">';
                })
                ->addColumn('table_number', function ($table) {
                    return $table->name;
                })
                ->addColumn('capacity', function ($table) {
                    return $table->capacity . ' seats';
                })
                ->addColumn('location', function ($table) {
                    $locations = [
                        'indoor' => 'bg-primary',
                        'outdoor' => 'bg-success',
                        'balcony' => 'bg-info',
                        'private' => 'bg-warning'
                    ];
                    $badge = $locations[$table->location] ?? 'bg-secondary';
                    return '<span class="badge ' . $badge . '">' . ucfirst($table->location) . '</span>';
                })
                ->addColumn('status', function ($table) {
                    $statusClass = $table->is_active ? 'success' : 'danger';
                    $statusText = $table->is_active ? 'Active' : 'Inactive';
                    return '<span class="badge bg-' . $statusClass . '">' . $statusText . '</span>';
                })
                ->addColumn('current_order', function ($table) {
                    // Check if table has active reservation
                    $activeReservation = $table->reservations()
                        ->where('status', '!=', 'cancelled')
                        ->where('status', '!=', 'completed')
                        ->where('reservation_date', '>=', now()->toDateString())
                        ->first();

                    if ($activeReservation) {
                        return '<span class="badge bg-warning">Reserved</span>';
                    }

                    return '<span class="badge bg-success">Available</span>';
                })
                ->addColumn('actions', function ($table) {
                    $actions = '<div class="btn-group" role="group">';
                    $actions .= '<a href="' . route('admin.tables.show', $table->id) . '" class="btn btn-sm btn-info" title="View"><i class="ri-eye-line"></i></a>';
                    $actions .= '<a href="' . route('admin.tables.edit', $table->id) . '" class="btn btn-sm btn-primary" title="Edit"><i class="ri-edit-line"></i></a>';
                    $actions .= '<button type="button" class="btn btn-sm btn-warning toggle-status" data-id="' . $table->id . '" data-status="' . $table->is_active . '" title="Toggle Status"><i class="ri-toggle-line"></i></button>';
                    $actions .= '<button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $table->id . '" data-name="' . $table->name . '" title="Delete"><i class="ri-delete-bin-line"></i></button>';
                    $actions .= '</div>';
                    return $actions;
                })
                ->editColumn('created_at', function ($table) {
                    return $table->created_at->format('M d, Y H:i');
                })
                ->rawColumns(['checkbox', 'location', 'status', 'current_order', 'actions'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('Failed to get tables data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load data'], 500);
        }
    }

    public function create()
    {
        try {
            return view('admin.pages.table.create');
        } catch (\Exception $e) {
            Log::error('Failed to load create form: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load create form.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:tables',
                'capacity' => 'required|integer|min:1|max:20',
                'location' => 'required|in:indoor,outdoor,balcony,private',
                'description' => 'nullable|string|max:1000',
                'is_active' => 'boolean'
            ]);

            $data = $validated;
            $data['is_active'] = $request->has('is_active');

            Table::create($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Table created successfully!'
                ]);
            }

            return redirect()->route('admin.tables.index')
                ->with('success', 'Table created successfully!');
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
            Log::error('Failed to create table: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create table. Please try again.'
                ], 500);
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create table. Please try again.');
        }
    }

    public function show($id)
    {
        try {
            $table = Table::with(['reservations.customer'])->findOrFail($id);
            return view('admin.pages.table.show', compact('table'));
        } catch (\Exception $e) {
            Log::error('Failed to load table: ' . $e->getMessage());
            return redirect()->route('admin.tables.index')
                ->with('error', 'Table not found.');
        }
    }

    public function edit($id)
    {
        try {
            $table = Table::findOrFail($id);
            return view('admin.pages.table.edit', compact('table'));
        } catch (\Exception $e) {
            Log::error('Failed to load edit form: ' . $e->getMessage());
            return redirect()->route('admin.tables.index')
                ->with('error', 'Table not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:tables,name,' . $id,
                'capacity' => 'required|integer|min:1|max:20',
                'location' => 'required|in:indoor,outdoor,balcony,private',
                'description' => 'nullable|string|max:1000',
                'is_active' => 'boolean'
            ]);

            $table = Table::findOrFail($id);
            $data = $validated;
            $data['is_active'] = $request->has('is_active');

            $table->update($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Table updated successfully!'
                ]);
            }

            return redirect()->route('admin.tables.index')
                ->with('success', 'Table updated successfully!');
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
            Log::error('Failed to update table: ' . $e->getMessage());
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update table. Please try again.'
                ], 500);
            }
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update table. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $table = Table::findOrFail($id);

            // Check if table has associated reservations
            if ($table->reservations()->count() > 0) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot delete table. It has associated reservations.'
                    ], 422);
                }
                return redirect()->route('admin.tables.index')
                    ->with('error', 'Cannot delete table. It has associated reservations.');
            }

            $table->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Table deleted successfully!'
                ]);
            }

            return redirect()->route('admin.tables.index')
                ->with('success', 'Table deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to delete table: ' . $e->getMessage());
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete table.'
                ], 500);
            }
            return redirect()->route('admin.tables.index')
                ->with('error', 'Failed to delete table.');
        }
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:tables,id'
            ]);

            $tables = Table::whereIn('id', $request->ids)->get();
            $deletedCount = 0;
            
            foreach ($tables as $table) {
                if ($table->reservations()->count() === 0) {
                    $table->delete();
                    $deletedCount++;
                }
            }

            return response()->json([
                'success' => true,
                'message' => $deletedCount . ' table(s) deleted successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to bulk delete tables: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete tables.'
            ], 500);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $table = Table::findOrFail($id);
            $table->update(['is_active' => !$table->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully!',
                'new_status' => $table->is_active
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to toggle table status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status.'
            ], 500);
        }
    }
}
