<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index()
    {
        return view('admin.pages.customer.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $customers = Customer::with('user')->select('customers.*');

            return DataTables::of($customers)
                ->addColumn('full_name', function ($customer) {
                    return $customer->first_name . ' ' . $customer->last_name;
                })
                ->addColumn('user_status', function ($customer) {
                    if ($customer->user) {
                        return $customer->user->is_active ? 
                            '<span class="badge bg-success">Active</span>' : 
                            '<span class="badge bg-danger">Inactive</span>';
                    }
                    return '<span class="badge bg-secondary">No Account</span>';
                })
                ->addColumn('total_orders', function ($customer) {
                    return $customer->orders()->count();
                })
                ->addColumn('total_spent', function ($customer) {
                    return '$' . number_format($customer->orders()->sum('total'), 2);
                })
                ->addColumn('action', function ($customer) {
                    return '<div class="btn-group" role="group">
                                <a href="' . route('admin.customers.show', $customer->id) . '" class="btn btn-sm btn-info">
                                    <i class="ri-eye-line"></i> View
                                </a>
                                <a href="' . route('admin.customers.edit', $customer->id) . '" class="btn btn-sm btn-warning">
                                    <i class="ri-edit-line"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $customer->id . '">
                                    <i class="ri-delete-bin-line"></i> Delete
                                </button>
                            </div>';
                })
                ->rawColumns(['user_status', 'action'])
                ->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function create()
    {
        return view('admin.pages.customer.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers,email|unique:users,email',
                'phone' => 'required|string|max:20',
                'address' => 'nullable|string',
                'date_of_birth' => 'nullable|date|before:today',
                'create_user_account' => 'boolean',
                'password' => 'required_if:create_user_account,1|nullable|string|min:8',
            ]);

            // Create user account if requested
            $userId = null;
            if ($request->has('create_user_account')) {
                $user = User::create([
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'customer',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);
                $userId = $user->id;
            }

            Customer::create([
                'user_id' => $userId,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
            ]);

            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create customer. Please try again.');
        }
    }

    public function show($id)
    {
        try {
            $customer = Customer::with(['user', 'orders.orderDetails.menu'])->findOrFail($id);
            return view('admin.pages.customer.show', compact('customer'));
        } catch (\Exception $e) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Customer not found.');
        }
    }

    public function edit($id)
    {
        try {
            $customer = Customer::with('user')->findOrFail($id);
            return view('admin.pages.customer.edit', compact('customer'));
        } catch (\Exception $e) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Customer not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $customer = Customer::findOrFail($id);

            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:customers,email,' . $id . '|unique:users,email,' . ($customer->user_id ?? 'NULL'),
                'phone' => 'required|string|max:20',
                'address' => 'nullable|string',
                'date_of_birth' => 'nullable|date|before:today',
                'create_user_account' => 'boolean',
                'password' => 'nullable|string|min:8',
            ]);

            // Handle user account creation if requested
            if ($request->has('create_user_account') && !$customer->user_id) {
                $user = User::create([
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'customer',
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]);
                $customer->user_id = $user->id;
            }

            // Update user account if exists
            if ($customer->user_id && $request->password) {
                $customer->user->update([
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            } elseif ($customer->user_id) {
                $customer->user->update([
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                ]);
            }

            $customer->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'date_of_birth' => $request->date_of_birth,
            ]);

            return redirect()->route('admin.customers.index')
                ->with('success', 'Customer updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update customer. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);

            // Check if customer has associated orders
            if ($customer->orders()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete customer. They have associated orders.'
                ], 422);
            }

            // Delete associated user account if exists
            if ($customer->user_id) {
                $customer->user->delete();
            }

            $customer->delete();

            return response()->json([
                'success' => true,
                'message' => 'Customer deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete customer. Please try again.'
            ], 500);
        }
    }
}
