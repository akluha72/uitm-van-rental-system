<?php
namespace App\Http\Controllers;

use App\Models\Van;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class BookingController extends Controller
{
    public function show(Van $van)
    {
        return view('booking', compact('van'));
    }

    public function checkAvailability(Request $request)
    {
        $vanId = $request->input('van_id');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $overlappingBookings = Booking::where('van_id', $vanId)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();

        if ($overlappingBookings) {
            return response()->json(['available' => false, 'message' => 'Selected dates are not available.']);
        }

        return response()->json(['available' => true, 'message' => 'Dates are available.']);
    }

    public function submitBooking(Request $request)
    {
        try {

            if ($request->hasFile('license')) {
                $filePath = $request->file('license')->store('licenses', 'public');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No license file was uploaded.',
                ], 400);
            }

            // Update the user's license path in the users table
            $user = User::find($request['user_id']);
            if ($user) {
                $user->update([
                    'license_path' => $filePath,
                ]);
            }

            // Determine booking type based on the duration
            $startDate = \Carbon\Carbon::parse($request['start_date']);
            $endDate = \Carbon\Carbon::parse($request['end_date']);
            $durationInMonths = $startDate->diffInMonths($endDate);

            $bookingType = $durationInMonths > 1 ? 'long-term' : 'short-term';

            // Save booking details into the database
            Booking::create([
                'user_id' => $request['user_id'],
                'van_id' => $request['van_id'],
                'start_date' => $request['start_date'],
                'end_date' => $request['end_date'],
                'total_amount' => $request['total_amount'],
                'payment_status' => 'paid',
                'booking_status' => 'pending confirmation',
                'booking_type' => $bookingType,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking submitted successfully.',
                'redirect_url' => route('payment'),
            ]);


        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Booking Submission Error: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during the booking process. Please try again later. from backend',
            ], 500);
        }
    }

    public function showPayment(Request $request)
    {
        return view('payment'); // Ensure 'fpx.blade.php' exists in resources/views
    }
}
