<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Reservation;

class UserDashboardController extends Controller
{
    /**
     * Show the user dashboard with recent activity.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // KPIs for the stat cards
        $kpis = [
            'total_orders' => Order::where('customer_id', $user->id)->count(),
            'total_spent' => Order::where('customer_id', $user->id)->where('status', 'Completed')->sum('total'),
            'total_reservations' => Reservation::where('customer_id', $user->id)->count(),
        ];

        // Data for the recent activity tables
        $recent_orders = Order::where('customer_id', $user->id)->latest()->take(5)->get();
        
        $recent_reservations = Reservation::where('customer_id', $user->id)
            ->latest('reservation_time')
            ->take(5)
            ->get();

        return view('pages.user.dashboard', compact('user', 'kpis', 'recent_orders', 'recent_reservations'));
    }

    /**
     * Show the user's profile page.
     */
    public function profile()
    {
        return view('pages.user.profile', ['user' => Auth::user()]);
    }

    /**
     * Show the user's orders page.
     */
    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('customer_id', $user->id)->latest()->paginate(10);
        return view('pages.user.orders', compact('orders'));
    }

    /**
     * Show the user's reservations page.
     */
    public function reservations()
    {
        $user = Auth::user();
        $reservations = Reservation::where('customer_id', $user->id)
            ->latest('reservation_time')
            ->paginate(10);
        return view('pages.user.reservations', compact('reservations'));
    }

    /**
     * Show the change password page.
     */
    public function changePassword()
    {
        return view('pages.user.change-password');
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user->update($request->all());

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect()->route('user.change-password')->with('success', 'Password changed successfully.');
    }
} 