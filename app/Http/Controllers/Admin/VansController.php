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

    public function show(Van $van)
    {
        return response()->json($van); // Return van details as JSON
    }

    public function create()
    {
        return view('admin.vans.create');
    }

    public function store(Request $request)
    {

        try {
            Van::create($request->all());
            return redirect()->route('admin.vans.index')->with('success', 'Van added successfully.');
        } catch (\Exception $e) {
            dd("error ", $e);
        }
    }

    public function edit(Van $van)
    {
        return view('admin.vans.edit', compact('van'));
    }

    public function update(Request $request, Van $van)
    {

        try {
            $van->update($request->all());
            return redirect()->route('admin.vans.index')->with('success', 'Van updated successfully.');

        } catch (\Exception $e) {
            dd("error stored data");
        }
    }

    public function destroy(Van $van)
    {
        $van->delete();
        return redirect()->route('admin.vans.index')->with('success', 'Van deleted successfully.');
    }
}

