<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.customers.index', compact('users'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {

        User::create($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'Customer added successfully.');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::find( $id);
        $user->update($request->all());

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(User $User)
    {
        $User->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully.');
    }
}

