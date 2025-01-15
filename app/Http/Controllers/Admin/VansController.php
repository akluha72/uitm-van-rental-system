<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Van;
use Illuminate\Http\Request;

class VansController extends Controller
{
    public function index()
    {
        $vans = Van::all();
        return view('admin.vans.index', compact('vans'));
    }

    public function create()
    {
        return view('admin.vans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'registration_number' => 'required',
            'capacity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        Van::create($request->all());
        return redirect()->route('admin.vans.index')->with('success', 'Van added successfully.');
    }

    public function edit(Van $van)
    {
        return view('admin.vans.edit', compact('van'));
    }

    public function update(Request $request, Van $van)
    {
        $request->validate([
            'name' => 'required',
            'registration_number' => 'required',
            'capacity' => 'required|integer',
            'price' => 'required|numeric',
        ]);

        $van->update($request->all());
        return redirect()->route('admin.vans.index')->with('success', 'Van updated successfully.');
    }

    public function destroy(Van $van)
    {
        $van->delete();
        return redirect()->route('admin.vans.index')->with('success', 'Van deleted successfully.');
    }
}

