<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Customer;
use App\Models\Table;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReservationController extends Controller
{
    public function index()
    {
        return view('admin.pages.reservation.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $reservations = Reservation::with(['customer', 'table'])->select('reservations.*');

            return DataTables::of($reservations)
                ->addColumn('customer_name', function ($reservation) {
                    return $reservation->customer ? $reservation->customer->first_name . ' ' . $reservation->customer->last_name : 'N/A';
                })
                ->addColumn('table_name', function ($reservation) {
                    return $reservation->table ? $reservation->table->name : 'N/A';
                })
                ->addColumn('status', function ($reservation) {
                    $badges = [
                        'pending' => 'bg-warning',
                        'confirmed' => 'bg-success',
                        'seated' => 'bg-info',
                        'completed' => 'bg-primary',
                        'cancelled' => 'bg-danger',
                        'no-show' => 'bg-secondary'
                    ];
                    $badge = $badges[$reservation->status] ?? 'bg-secondary';
                    return '<span class="badge ' . $badge . '">' . ucfirst($reservation->status) . '</span>';
                })
                ->addColumn('reservation_date', function ($reservation) {
                    return $reservation->reservation_date->format('M d, Y');
                })
                ->addColumn('reservation_time', function ($reservation) {
                    return $reservation->reservation_time;
                })
                ->addColumn('party_size', function ($reservation) {
                    return $reservation->party_size . ' people';
                })
                ->addColumn('action', function ($reservation) {
                    return '<div class="btn-group" role="group">
                                <a href="' . route('admin.reservations.show', $reservation->id) . '" class="btn btn-sm btn-info">
                                    <i class="ri-eye-line"></i> View
                                </a>
                                <a href="' . route('admin.reservations.edit', $reservation->id) . '" class="btn btn-sm btn-warning">
                                    <i class="ri-edit-line"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $reservation->id . '">
                                    <i class="ri-delete-bin-line"></i> Delete
                                </button>
                            </div>';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function create()
    {
        $customers = Customer::all();
        $tables = Table::where('is_active', true)->get();
        return view('admin.pages.reservation.create', compact('customers', 'tables'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'table_id' => 'nullable|exists:tables,id',
                'reservation_date' => 'required|date|after_or_equal:today',
                'reservation_time' => 'required|date_format:H:i',
                'party_size' => 'required|integer|min:1|max:20',
                'status' => 'required|in:pending,confirmed,seated,completed,cancelled,no-show',
                'special_requests' => 'nullable|string',
                'contact_phone' => 'nullable|string|max:20',
                'contact_email' => 'nullable|email',
            ]);

            // Check for table availability
            if ($request->table_id) {
                $conflictingReservation = Reservation::where('table_id', $request->table_id)
                    ->where('reservation_date', $request->reservation_date)
                    ->where('reservation_time', $request->reservation_time)
                    ->where('status', '!=', 'cancelled')
                    ->where('status', '!=', 'completed')
                    ->first();

                if ($conflictingReservation) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'The selected table is not available at this time.');
                }
            }

            Reservation::create($request->all());

            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservation created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create reservation. Please try again.');
        }
    }

    public function show($id)
    {
        try {
            $reservation = Reservation::with(['customer', 'table', 'order'])->findOrFail($id);
            return view('admin.pages.reservation.show', compact('reservation'));
        } catch (\Exception $e) {
            return redirect()->route('admin.reservations.index')
                ->with('error', 'Reservation not found.');
        }
    }

    public function edit($id)
    {
        try {
            $reservation = Reservation::with(['customer', 'table'])->findOrFail($id);
            $customers = Customer::all();
            $tables = Table::where('is_active', true)->get();
            return view('admin.pages.reservation.edit', compact('reservation', 'customers', 'tables'));
        } catch (\Exception $e) {
            return redirect()->route('admin.reservations.index')
                ->with('error', 'Reservation not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $reservation = Reservation::findOrFail($id);

            $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'table_id' => 'nullable|exists:tables,id',
                'reservation_date' => 'required|date',
                'reservation_time' => 'required|date_format:H:i',
                'party_size' => 'required|integer|min:1|max:20',
                'status' => 'required|in:pending,confirmed,seated,completed,cancelled,no-show',
                'special_requests' => 'nullable|string',
                'contact_phone' => 'nullable|string|max:20',
                'contact_email' => 'nullable|email',
            ]);

            // Check for table availability (excluding current reservation)
            if ($request->table_id) {
                $conflictingReservation = Reservation::where('table_id', $request->table_id)
                    ->where('reservation_date', $request->reservation_date)
                    ->where('reservation_time', $request->reservation_time)
                    ->where('status', '!=', 'cancelled')
                    ->where('status', '!=', 'completed')
                    ->where('id', '!=', $id)
                    ->first();

                if ($conflictingReservation) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'The selected table is not available at this time.');
                }
            }

            $reservation->update($request->all());

            return redirect()->route('admin.reservations.index')
                ->with('success', 'Reservation updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update reservation. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);

            // Check if reservation has associated order
            if ($reservation->order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete reservation. It has an associated order.'
                ], 422);
            }

            $reservation->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reservation deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete reservation. Please try again.'
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,confirmed,seated,completed,cancelled,no-show',
            ]);

            $reservation = Reservation::findOrFail($id);
            $reservation->update([
                'status' => $request->status,
                'seated_at' => $request->status === 'seated' ? now() : null,
                'completed_at' => $request->status === 'completed' ? now() : null,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Reservation status updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update reservation status. Please try again.'
            ], 500);
        }
    }

    public function pending()
    {
        return view('admin.pages.reservation.pending');
    }

    public function completed()
    {
        return view('admin.pages.reservation.completed');
    }

    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:reservations,id'
            ]);

            $reservations = Reservation::whereIn('id', $request->ids);
            
            // Check if any reservations have associated orders
            $reservationsWithOrders = $reservations->whereHas('order')->count();
            if ($reservationsWithOrders > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Some reservations have associated orders and cannot be deleted.'
                ], 422);
            }

            $reservations->delete();

            return response()->json([
                'success' => true,
                'message' => 'Selected reservations deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete reservations. Please try again.'
            ], 500);
        }
    }

    public function bulkStatus(Request $request)
    {
        try {
            $request->validate([
                'ids' => 'required|array',
                'ids.*' => 'exists:reservations,id',
                'status' => 'required|in:pending,confirmed,seated,completed,cancelled,no-show'
            ]);

            $reservations = Reservation::whereIn('id', $request->ids);
            
            $updateData = ['status' => $request->status];
            
            if ($request->status === 'seated') {
                $updateData['seated_at'] = now();
            } elseif ($request->status === 'completed') {
                $updateData['completed_at'] = now();
            }

            $reservations->update($updateData);

            return response()->json([
                'success' => true,
                'message' => 'Selected reservations status updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update reservations status. Please try again.'
            ], 500);
        }
    }
} 