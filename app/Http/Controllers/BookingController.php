<?php
namespace App\Http\Controllers;

use App\Models\Van;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;


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
}
