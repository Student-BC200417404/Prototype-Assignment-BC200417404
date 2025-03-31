<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index');
    }

    public function pending()
    {
        return view('admin.orders.pending');
    }

    public function completed()
    {
        return view('admin.orders.completed');
    }

    public function show($id)
    {
        return view('admin.orders.show');
    }

    public function updateStatus(Request $request, $id)
    {
        // Add status update logic
    }
} 