<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomersController extends Controller
{
    public function index()
    {
        $customers = User::all();
        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        $customer = User::with('bookings')->findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }
}

