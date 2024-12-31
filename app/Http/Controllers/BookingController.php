<?php
namespace App\Http\Controllers;

use App\Models\Van;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function show(Van $van)
    {
        return view('booking', compact('van'));
    }

    public function store(Van $van) {
        return $van;
    }
}
