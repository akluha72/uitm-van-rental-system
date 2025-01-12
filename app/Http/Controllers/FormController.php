<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Van;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function getVanDetails(Request $request): JsonResponse
    {
        $vanId = $request->input('vanId');
        $vanDetails = Van::where('id', $vanId)->first();

        if (!$vanDetails) {
            return response()->json(['error' => 'Van not found'], 404);
        }

        return response()->json($vanDetails);
    }

    public function getUnavailableDates(Request $request): JsonResponse
    {
        $vanId = $request->input('vanId');

        // Fetch all bookings for the given van ID
        $bookingRecord = Booking::where('van_id', $vanId)->get(['start_date', 'end_date']);

        if ($bookingRecord->isEmpty()) {
            return response()->json(['message' => 'No unavailable dates for this van'], 200);
        }


        return response()->json($bookingRecord);
    }

    public function getVanPrice($vanId)
    {
        $van = Van::find($vanId);

        if (!$van) {
            return response()->json([
                'success' => false,
                'message' => 'Van not found.',
            ]);
        }

        return response()->json([
            'success' => true,
            'price' => $van->rental_rate,
        ]);
    }


}
