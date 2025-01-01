<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Van;

class LandingPageController extends Controller
{
    public function show()
    {
        // Fetch van data from the database
        $vans = Van::all();

        // Pass the data to the landing view
        return view('landing', compact('vans'));
    }
}
