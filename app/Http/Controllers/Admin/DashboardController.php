<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking; 

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'activeBookings' => Booking::where('booking_status', 'active')->count(),
            'availableVans' => 10, // Example static data
            'monthlyRevenue' => 5000, // Example static data
            'pendingBookings' => Booking::where('booking_status', 'pending confirmation')->count(),
        ];

        // Pass bookings for DataTable
        $bookings = Booking::where('booking_status', 'pending confirmation')->get();

        return view('admin.dashboard', compact('data', 'bookings'));
    }
}
