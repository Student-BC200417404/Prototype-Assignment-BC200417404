<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Menu;

class WebController extends Controller
{
    //
     public function index()
    {
        // Fetch categories for the "Our Main Dishes" section (e.g., 4 featured categories)
        $featured_categories = Category::where('is_active', true)->take(4)->get();

        // Fetch all active categories for the tabbed menu
        $menu_categories = Category::where('is_active', true)->get();

        // Eager load menus for the first active category to show by default
        $initial_category = Category::where('is_active', true)->first();
        if ($initial_category) {
            $initial_category->load('menus');
        }

        return view('pages.home', compact('featured_categories', 'menu_categories', 'initial_category'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function menu()
    {
        $categories = Category::where('is_active', true)->with('menus')->get();
        return view('pages.menu', compact('categories'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function handleContactForm(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // Here you would typically send an email or save to the database
        // For now, we'll just redirect back with a success message.

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    public function login()
    {
        return view('auth.login');
    }

    /**
     * Handle reservation form submission from the home page.
     */
    public function handleReservationForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|string',
            'person' => 'required|string',
        ]);

        try {
            // Split name into first and last (simple split)
            $nameParts = explode(' ', trim($validated['name']), 2);
            $firstName = $nameParts[0];
            $lastName = $nameParts[1] ?? '';

            // Check if customer exists by email
            $customer = Customer::where('email', $validated['email'])->first();

            if (!$customer) {
                // Create new user (inactive, default password)
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => bcrypt('default_password'), // Set a secure default or random password
                    'role' => 'customer',
                    'is_active' => false,
                ]);

                // Create customer profile
                $customer = Customer::create([
                    'user_id' => $user->id,
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'phone' => $validated['phone'],
                    'email' => $validated['email'],
                ]);
            }

            // Parse number of persons
            $personMap = [
                '1_person' => 1,
                '5_person' => 5,
                '10_person' => 10,
                '15_person' => 15,
                '20_person' => 20,
            ];
            $numberOfGuests = $personMap[$validated['person']] ?? 1;

            // Parse time (convert to 24h format if needed)
            $timeMap = [
                '6_30pm' => '18:30:00',
                '7_00pm' => '19:00:00',
                '7_30pm' => '19:30:00',
                '8_00pm' => '20:00:00',
                '8_30pm' => '20:30:00',
                '9_00pm' => '21:00:00',
            ];
            $reservationTime = $timeMap[$validated['time']] ?? '18:30:00';

            // Create reservation
            $reservation = Reservation::create([
                'customer_id' => $customer->id,
                'reservation_date' => $validated['date'],
                'reservation_time' => $reservationTime,
                'number_of_guests' => $numberOfGuests,
                'status' => 'pending',
            ]);

            return redirect()->back()->with('success', 'Your reservation request has been received! We will contact you soon.');
        } catch (\Exception $e) {
            // Log error for debugging
            \Log::error('Reservation form error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->withInput()->with('error', 'An error occurred while processing your reservation. Please try again or contact support.');
        }
    }
}
