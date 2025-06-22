<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.pages.user.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('role', '!=', 'customer')->select('users.*');

            return DataTables::of($users)
                ->addColumn('checkbox', function ($user) {
                    return '<input type="checkbox" class="form-check-input row-checkbox" value="' . $user->id . '">';
                })
                ->addColumn('role_badge', function ($user) {
                    $badges = [
                        'admin' => 'bg-danger',
                        'manager' => 'bg-warning',
                        'staff' => 'bg-info',
                        'waiter' => 'bg-primary',
                        'chef' => 'bg-success'
                    ];
                    $badge = $badges[$user->role] ?? 'bg-secondary';
                    return '<span class="badge ' . $badge . '">' . ucfirst($user->role) . '</span>';
                })
                ->addColumn('status', function ($user) {
                    return $user->is_active ? 
                        '<span class="badge bg-success">Active</span>' : 
                        '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('email_verified', function ($user) {
                    return $user->email_verified_at ? 
                        '<span class="badge bg-success">Verified</span>' : 
                        '<span class="badge bg-warning">Unverified</span>';
                })
                ->addColumn('last_login', function ($user) {
                    return $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never';
                })
                ->addColumn('actions', function ($user) {
                    return '<div class="btn-group" role="group">
                                <a href="' . route('admin.users.show', $user->id) . '" class="btn btn-sm btn-info">
                                    <i class="ri-eye-line"></i> View
                                </a>
                                <a href="' . route('admin.users.edit', $user->id) . '" class="btn btn-sm btn-warning">
                                    <i class="ri-edit-line"></i> Edit
                                </a>
                                <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $user->id . '">
                                    <i class="ri-delete-bin-line"></i> Delete
                                </button>
                            </div>';
                })
                ->rawColumns(['checkbox', 'role_badge', 'status', 'email_verified', 'actions'])
                ->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function create()
    {
        return view('admin.pages.user.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:admin,manager,staff,waiter,chef',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'is_active' => 'boolean',
                'email_verified_at' => 'nullable|date',
            ]);

            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            $data['is_active'] = $request->has('is_active');
            $data['email_verified_at'] = $request->has('email_verified_at') ? now() : null;

            User::create($data);

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create user. Please try again.');
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.pages.user.show', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'User not found.');
        }
    }

    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
            return view('admin.pages.user.edit', compact('user'));
        } catch (\Exception $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'User not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'password' => 'nullable|string|min:8|confirmed',
                'role' => 'required|in:admin,manager,staff,waiter,chef',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
                'is_active' => 'boolean',
                'email_verified_at' => 'nullable|date',
            ]);

            $data = $request->except(['password', 'password_confirmation']);
            $data['is_active'] = $request->has('is_active');
            $data['email_verified_at'] = $request->has('email_verified_at') ? now() : null;

            // Update password if provided
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update user. Please try again.');
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Prevent deleting own account
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account.'
                ], 422);
            }

            // Check if user has associated data
            if ($user->role === 'customer' && $user->customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete user. They have associated customer data.'
                ], 422);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user. Please try again.'
            ], 500);
        }
    }

    public function toggleStatus($id)
    {
        try {
            $user = User::findOrFail($id);

            // Prevent deactivating own account
            if ($user->id === auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot deactivate your own account.'
                ], 422);
            }

            $user->update([
                'is_active' => !$user->is_active
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully!',
                'is_active' => $user->is_active
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user status. Please try again.'
            ], 500);
        }
    }
}
