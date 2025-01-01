<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Van;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingForm extends Controller
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
}
