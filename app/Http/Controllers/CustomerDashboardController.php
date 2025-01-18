<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        // Fetch necessary data for the dashboard
        $userId = auth()->id();

        // Active bookings count
        $activeBookingsCount = Booking::where('user_id', $userId)
            ->where('booking_status', 'confirmed')
            ->count();

        // Closest payment due date
        $closestPaymentDue = Booking::where('user_id', $userId)
            ->where('payment_status', 'pending')
            ->where('end_date', '>=', now()) // Ensure the due date is in the future or today
            ->orderBy('end_date', 'asc') // Sort by the nearest start date
            ->first();

        // Amount paid and due for each booking
        $bookings = Booking::where('user_id', $userId)
            ->get(['id', 'booking_reference', 'amount_paid', 'start_date', 'end_date', 'payment_status']);

        // Current bookings
        $currentBookings = Booking::with('van')
            ->where('user_id', $userId)
            ->whereIn('booking_status', ['pending confirmation', 'confirmed', 'active'])
            ->orderBy('start_date', 'asc')
            ->paginate(10);

        // Booking history
        $bookingHistory = Booking::with('van')
            ->where('user_id', $userId)
            ->whereIn('booking_status', ['completed', 'cancelled', 'rejected'])
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        $duePayments = Booking::where('user_id', $userId)
            ->where('payment_status', 'pending') // Filter only pending payments
            ->get()
            ->sum(function ($booking) {
                return $booking->total_amount - $booking->amount_paid; // Calculate amount_due dynamically
            });

        // dd($currentBookings);
        // Pass data to the view
        return view('dashboard', [
            'activeBookingsCount' => $activeBookingsCount,
            'currentBookings' => $currentBookings,
            'bookingHistory' => $bookingHistory,
            'bookings' => $bookings,
            'closestPaymentDue' => $closestPaymentDue,
            'duePayments' => $duePayments
        ]);
    }

}
