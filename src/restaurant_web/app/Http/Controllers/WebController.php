<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebController extends Controller
{
    //
     public function index()
    {
        return view('home');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function menu()
    {
        return view('pages.menu');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function login()
    {
        return view('auth.login');
    }
}
