<?php
namespace App\Http\Controllers;

use App\Models\Van;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;


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
        // dd($request);
        $validatedData = $request->validate([
            'user_id' => 'required',
            'van_id' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'license' => 'required|mimes:pdf|max:2048',
            'terms' => 'accepted',
        ]);

        // Store the uploaded PDF
        $filePath = $request->file('license')->store('licenses', 'public');

        // Save other booking details into the database (example)
        Booking::create([
            'user_id' => $validatedData['user_id'],
            'van_id' => $validatedData['van_id'],
            'start_date' => $validatedData['startDate'],
            'end_date' => $validatedData['endDate'],
            'total_amount' => 700.00,
            'payment_status' => 'paid'
            // 'license_path' => $filePath,
            // Add other fields here
        ]);

        return redirect()->back()->with('success', 'Booking confirmed!');
    }
}
