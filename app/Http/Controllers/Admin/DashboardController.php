<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; 
use App\Models\Van; 

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'activeBookings' => Booking::where('booking_status', 'active')->count(),
            'availableVans' => Van::where('availability', 1)->count(),
            'monthlyRevenue' => 5000.00, // Example static data
            'pendingBookings' => Booking::where('booking_status', 'pending confirmation')->count(),
        ];

        // Pass bookings for DataTable
        $bookings = Booking::where('booking_status', 'pending confirmation')->get();

        return view('admin.dashboard', compact('data', 'bookings'));
    }
}
