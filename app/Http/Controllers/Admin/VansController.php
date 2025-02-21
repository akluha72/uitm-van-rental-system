<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Van;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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
            $data = $request->all();
    
            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('vans', 'public');
                $data['image'] = $imagePath;
            }
    
            Van::create($data);
    
            Log::info('Van successfully stored.', ['data' => $data]);
    
            return redirect()->route('admin.vans.index')->with('success', 'Van added successfully.');
        } catch (\Exception $e) {
            Log::error('Error storing van.', [
                'error' => $e->getMessage(),
                'stack' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
    
            // return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }
    
    

    public function edit(Van $van)
    {
        return view('admin.vans.edit', compact('van'));
    }

    public function update(Request $request, Van $van)
    {
    
        try {
            $data = $request->all();
    
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($van->image) {
                    \Storage::disk('public')->delete($van->image);
                }
    
                $imagePath = $request->file('image')->store('vans', 'public');
                $data['image'] = $imagePath;
            }
    
            $van->update($data);
    
            return redirect()->route('admin.vans.index')->with('success', 'Van updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Something went wrong: ' . $e->getMessage()]);
        }
    }
    

    public function destroy(Van $van)
    {
        $van->delete();
        return redirect()->route('admin.vans.index')->with('success', 'Van deleted successfully.');
    }
}

