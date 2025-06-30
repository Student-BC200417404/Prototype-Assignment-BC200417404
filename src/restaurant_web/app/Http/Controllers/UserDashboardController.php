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
        $customer = $user->customer;
        
        // If no customer profile, show empty dashboard
        if (!$customer) {
            $kpis = [
                'total_orders' => 0,
                'total_spent' => 0,
                'total_reservations' => 0,
            ];
            $recent_orders = collect();
            $recent_reservations = collect();
        } else {
            // KPIs for the stat cards
            $kpis = [
                'total_orders' => Order::where('customer_id', $customer->id)->count(),
                'total_spent' => Order::where('customer_id', $customer->id)->where('status', 'Completed')->sum('total'),
                'total_reservations' => Reservation::where('customer_id', $customer->id)->count(),
            ];
            // Data for the recent activity tables
            $recent_orders = Order::where('customer_id', $customer->id)->latest()->take(5)->get();
            $recent_reservations = Reservation::where('customer_id', $customer->id)
                ->latest('reservation_time')
                ->take(5)
                ->get();
        }
        return view('pages.user.dashboard', compact('user', 'customer', 'kpis', 'recent_orders', 'recent_reservations'));
    }

    /**
     * Show the user's profile page.
     */
    public function profile()
    {
        $user = Auth::user();
        $customer = $user->customer;
        return view('pages.user.profile', compact('user', 'customer'));
    }

    /**
     * Show the user's orders page.
     */
    public function orders()
    {
        $user = Auth::user();
        $customer = $user->customer;
        $orders = $customer ? Order::where('customer_id', $customer->id)->latest()->paginate(10) : collect();
        return view('pages.user.orders', compact('orders', 'customer'));
    }

    /**
     * Show the user's reservations page.
     */
    public function reservations()
    {
        $user = Auth::user();
        $customer = $user->customer;
        $reservations = $customer ? Reservation::where('customer_id', $customer->id)
            ->latest('reservation_time')
            ->paginate(10) : collect();
        return view('pages.user.reservations', compact('reservations', 'customer'));
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