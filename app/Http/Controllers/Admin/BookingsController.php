<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;

use App\Mail\BookingReviewNotification;
use Illuminate\Support\Facades\Mail;


use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('van', 'customer')->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with('van', 'customer')->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'comment' => 'nullable|string|max:500',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->booking_status = $request->status;

        // Save the rejection comment if provided
        if ($request->status === 'rejected') {
            $booking->review_comment = $request->comment;
        }

        $booking->save();

        Mail::to($booking->user->email)->send(new BookingReviewNotification($booking, $request->status, $request->comment));

        return response()->json(['success' => true]);
    }

    public function getData()
    {
        $bookings = Booking::with(['user', 'van'])->select('bookings.*');

        return DataTables::of($bookings)
            ->addColumn('customer', function ($row) {
                return $row->user->name ?? 'N/A';
            })
            ->addColumn('van', function ($row) {
                return $row->van->name ?? 'N/A';
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('admin.bookings.show', $row->id) . '" class="text-blue-500">View</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}

