<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
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
}
