<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        return view('admin.reservations.index');
    }

    public function pending()
    {
        return view('admin.reservations.pending');
    }

    public function create()
    {
        return view('admin.reservations.create');
    }

    public function store(Request $request)
    {
        // Add validation and store logic
    }

    public function updateStatus(Request $request, $id)
    {
        // Add status update logic
    }
} 